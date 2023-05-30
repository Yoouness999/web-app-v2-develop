<?php /** @noinspection SlowArrayOperationsInLoopInspection */

namespace App\Http\Controllers;

use App\Api;
use App\Area;
use App\BookingItemStatusHistory;
use App\Events\ItemPickupAskEvent;
use App\Events\PickupConfirmationEvent;
use App\Http\Requests;

use App\Http\Requests\PickupCreateRequest;
use App\Http\Requests\RescheduleCreateRequest;
use App\Item;
use App\Order;
use App\OrderPlan;
use App\OrderPlanRegion;
use App\OrderStoringDuration;
use App\Pickup;
use App\Services\PaymentNotification;
use Auth;
use Config;
use Cookie;
use Exception;
use Log;
use Illuminate\Http\Request;
use Response;
use Session;
use SoapClient;
use SSH;
use Validator;

class ApiController extends Controller
{
    protected $payment_notification;
    protected $mailchimp;
    protected $layout = "layouts.default";

    /**
     * Constructor
     *
     * inject dependencies for testing
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->mailchimp = app()->make(\Mailchimp::class);
        $this->payment_notification = app()->make(PaymentNotification::class);
    }

    /**
     * Add User in the mailchimp beta list
     */
    public function anyBetaSubscribe()
    {
        $result = false;

        try {
            $result = $this->mailchimp->lists->subscribe('678c03113a', ['email' => request()->get('email')], null, null, false);

            return ['success'];

        } catch (\Mailchimp_List_AlreadySubscribed $e) {
            Throw $e;
        } catch (\Mailchimp_Error $e) {
            Throw $e;
        }
    }

    /**
     * Check coupon code
     */
    public function anyCheckCoupon()
    {
        global $isAuth, $user;

        if (!$isAuth) {
            $isAuth = Auth::check();
        }

        if ($isAuth) {
            $user = Auth::getUser();
        }

        if (!$user) {
            return Api::responseError(['user' => lg("User is not logged")], 500, lg("User is not logged"));
        }

        $correct = Api::checkCoupon(request()->get('code'));

        if ($correct) {
            return Api::responseJson(['value' => $correct, 'percentage' => boolval(preg_match('/\%/i', $correct))], 200, lg('Correct ID'));
        }

        return Api::responseJson(['code' => lg('Not valid ID')], 500, lg('Not valid ID'));
    }

    /**
     * Check available schedules for a specific address
     * TODO-HM : where it is used?
     */
    public function anyCheckSchedules()
    {
        if (!request()->has('postalcode')) {
            return Api::responseErrors([['postalcode' => 'postal code is not defined']], 500, 'missing input');
        }

        $data = Api::getUnavailableDates();

        // disables date +1
        //$data[] = ['date' => date('Y-m-d 00:00:00', strtotime('+1 days'))];

        // Disable days => until february
        /*$days = Date::daysDifference('today', '2016-01-31');

        foreach(range(0, $days) as  $key){
            $data[] = [
                'date' => date('Y-m-d 00:00:00', strtotime('+'.$key. ' days'))
            ];
        }*/

        $query = Item::select(['postalcode', 'pickup_date'])->whereIn('status', [Item::STATUS_IN_TRANSIT, Item::STATUS_DELIVERED])->where('pickup_date', '>', date('Y-m-d H:i:s'));

        if (request()->has('latitude') && request()->has('longitude')) {
            /**
             * Calculate the diff in km
             *
             * @see http://www.geodutienne.be/documents/fgs/sf_latlo.pdf
             */
            $lat = request()->get('latitude');
            $lng = request()->get('longitude');
            $diffInKm = 5;
            $diffLat = abs(1 / (111.11 * $diffInKm));
            $diffLgt = abs($diffLat * cos($lat));

            $query = $query->whereNotBetween('latitude', [$lat - $diffLat, $lat + $diffLat])->whereNotBetween('longitude', [$lng - $diffLgt, $lng + $diffLgt]);
        } else {
            $query = $query->where('postalcode', '!=', request()->get('postalcode'));
        }

        // Disable hours when there is already a pickup
        $items = $query->groupBy('pickup_date')->get();

        // Disable hours when there is already a pickup in an other postal code
        foreach ($items as $item) {
            $data[] = ['date' => $item->pickup_date];
        }

        return Api::response(['unavailables' => $data]);
    }

    /**
     * Return the list of availables cities
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function anyCities()
    {
        $toReturn = [];
        $areas = Area::query()->get();
        foreach ($areas as $area) {
            $toReturn[$area->zip_code] = $area->name;
        }

        return Api::response($toReturn);
    }

    /**
     * Get User Items
     */
    public function anyItems($status = null)
    {
        $user = auth()->user();
        $isAuth = auth()->check();

        if (!$isAuth) {
            $isAuth = Auth::check();
        }

        if ($isAuth) {
            $user = Auth::getUser();
        }

        $items = $user->items();

        if ($status) {
            $items->where('status', $status);
        }

        return Api::response($items->get()->toArray());
    }

    /**
     * @param Request $request
     * @return array
     */
    public function anyPlans(Request $request)
    {
        $data = OrderPlan::where('visible', '=', 1)->select(['id', 'slug', 'price_per_month', 'visible'])->get()->toArray();

        # Check adapt plan regarded to postal code (@see OrderPlanRegion)
        if ($postal_code = $request->get('postal_code')) {

            if (Area::where('zip_code', $postal_code)->first()) {
                \Session::put('postal_code', $postal_code);

                $area = Area::where('zip_code', $postal_code)->first();

                $order = \Session::get('order') ?: new Order();
                $order->address_postal_code = $postal_code;
                Session::put('order', $order);

                if ($area) {
                    foreach ($data as $key => $plan) {
                        $orderPlanRegion = OrderPlanRegion::where('region_id', $area->region_id)->where('order_plan_id', $plan['id'])->first();

                        if ($orderPlanRegion) {
                            $data[$key]['price_per_month'] = floatval($orderPlanRegion->price_per_month);
                        }
                    }
                }

            } else {
                return Api::responseErrors(['postal_code' => lg("common.zip_code not in the list")], 400);
            }
        }

        return Api::response($data);
    }

    /**
     * Add a pickup schedule request
     *
     */
    public function anySchedule()
    {
        $valid = \Validator::make(Request::all(), ['address' => 'required', 'addinfo' => 'min:1', 'delivery_instructions' => 'min:1', 'postcode' => 'required', 'pickup_date' => 'required', 'items' => 'required',]);

        if (!$valid->valid()) {
            return Api::responseErrors($valid->errors()->toArray());
        }
    }

    /**
     * Run server sync from bitbucket
     */
    public function anySync()
    {
        SSH::into('production')->run(['cd /home/boxify/web/' . (LEVEL_ENV == 3 ? "www" : "demo"), 'git pull',], function ($line) {
            echo $line . PHP_EOL . "\n";
        });
    }

    /**
     * Check if the tva number is ok
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyTva()
    {

        $result = Api::response('error_tva');

        $number = request()->get('number');

        $number = str_replace([' ', '-', '.'], '', $number);

        $country_iso = strtolower(substr($number, 0, 2));

        $iso = $country_iso;
        $number = substr($number, 2);

        try {
            $client = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl", ['cache_wsdl' => WSDL_CACHE_NONE]);

            $response = $client->checkVatApprox(['countryCode' => $iso, 'vatNumber' => $number]);

            if ($response->valid) {
                $result['data'] = $response;
                $result['msg'] = 'valid';
                $result['status'] = 200;
            } else {
                $result['data'] = $response;
                $result['msg'] = 'invalid';
                $result['status'] = 200;
            }

        } catch (Exception $e) {
            Api::handleError($e);
        }

        return Response::json($result, $result['status']);
    }

    /**
     * Return the list of availables items
     */
    public function anyTypes()
    {
        return Api::response(Api::getTypes());
    }

    /**
     * Return user
     */
    public function anyUser()
    {
        $user = auth()->user();
        $isAuth = auth()->check();

        if (!$isAuth) {
            $isAuth = Auth::check();
        }

        if ($isAuth) {
            $user = Auth::getUser();
        }

        if (!$user) {
            return Api::responseError(['user' => lg("User is not logged")], 500, lg("User is not logged"));
        }

        return Api::response($user->toArray());
    }

    /**
     * Store or get session
     *
     * @param Request $request
     * @return Order
     */
    public function postOrder(Request $request)
    {
        /**
         * @var $order Order
         */
        $order = Session::get('order', new Order());

        $tosave = false;

        if ($postal_code = $request->get('postal_code')) {
            $order->address_postal_code = $postal_code;
            $tosave = true;
        }

        if ($id = $request->get('storing_duration')) {
            $storingDuration = OrderStoringDuration::find($id);

            if ($storingDuration) {
                $order->storingDuration = $storingDuration;
                $tosave = true;
            }
        }

        if ($items = $request->get('items')) {
            $order->setItems($items);
            $tosave = true;
        }

        if ($tosave) {
            $order->saveSession();
        }

        return $order;
    }

    /**
     * Pickup creation process
     *
     * @param PickupCreateRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function postPickup(PickupCreateRequest $request)
    {
        $user = auth()->user();
        $isAuth = auth()->check();

        if (!$isAuth) {
            $isAuth = Auth::check();
        }

        if ($isAuth) {
            $user = Auth::getUser();
        } else {
            return Api::responseError(['auth' => lg("User not logged", "errors")], 500);
        }

        $canPay = false;

        #1. Check payment validation if card_number is defined => we must update if not => use current billing user info
        try {
            if ($request->get('card_number')) {
                $canPay = $user->updateBillingInfo(['card_name' => $request['card_name'], 'card_number' => $request['card_number'], 'card_expiration_month' => $request['card_expiration_month'], 'card_expiration_year' => $request['card_expiration_year'], 'card_cvv' => $request['card_cvv'], 'card_promo' => $request['card_promo']]);

                if (!$canPay) {
                    trigger_error('Cannot update billing info');
                }

            } else {
                $canPay = $user->hasBillingInfo();
            }

        } catch (Exception $e) {
            Log::info('Error during pickup payment process');
            Log::error($e);
            Log::info('Payment card info', $request->all());

            return Api::responseJsonError(['errors' => ['billing' => lg("Payment error", "errors")]], 500);
        }

        # 2. Update user info with params from pickup
        $userData = $request->only(["first_name", "last_name", "postalcode", "city", "box", "number", "street", "latitude", "longitude", "phone", "business", "billing_address", "billing_box", "billing_city", "billing_number", "billing_postalcode", "billing_street", "billing_to", "billing_vat", "billing_address",]);

        // auto create name column for convenience
        $userData['name'] = $userData['first_name'] . ' ' . $userData['last_name'];

        // autopopulate billing address if not defined
        if (!$userData['billing_address']) {
            $userData['billing_to'] = $userData['name'];
            $userData['billing_box'] = $userData['box'];
            $userData['billing_city'] = $userData['city'];
            $userData['billing_number'] = $userData['number'];
            $userData['billing_postalcode'] = $userData['postalcode'];
            $userData['billing_street'] = $userData['street'];
        }

        $user->update($userData);


        #3. If user can pay => we can register pickup items :-)

        if ($canPay) {

            // Add pickup record mainly for stats
            $pickup = new Pickup();
            $data = $request->only($pickup->getFillable());

            $data['user_id'] = $user->id;

            $data['items'] = json_encode($request->get('items', []));
            $data['status'] = $pickup::STATUS_ORDERED;

            # Post pickup info // Only for stats records
            $pickup = $pickup->create($data);

            // Split the pickup into separate items rules
            $items = $request->get('items', []);
            $addedItems = [];
            foreach ($items as $type => $item) {
                if ($item['number'] > 0) {
                    $nbs = range(0, $item['number'] - 1);
                    foreach ($nbs as $key) {
                        $oItem = new Item();

                        // Populate Data in item record
                        $data = $request->only($oItem->getFillable());
                        $dataItem = array_only($item, $oItem->getFillable());
                        // Fix number overriding => this is the number of address not the count
                        $dataItem['number'] = $data['number'];
                        $data = array_merge($data, $dataItem);
                        $data['user_id'] = $user->id;
                        $data['type'] = $type;
                        $data['status'] = @$item['bulk_item'] ? Item::STATUS_DELIVERED : Item::STATUS_IN_TRANSIT;
                        $data['name'] = @$item['name'];
                        $data['bulk_item'] = @$item['bulk_item'];
                        $data['picture_option'] = @$item['picture_option'];
                        $data['pickup_option'] = @$data['pickup_option'];
                        $data['price'] = @$item['price'];

                        if (isset($item['lists'], $item['lists'][$key])) {
                            $data['name'] = $item['lists'][$key];
                        }

                        $oItem->pickup()->attach($pickup->id);

                        Log::info('Item inserted', $data);

                        $addedItems[] = $oItem->create($data);
                    }
                }
            }

            if ($pickup->id) {
                event(new PickupConfirmationEvent($pickup));


                // Validate the invitation flow
                if (Cookie::has('invitation_code')) {
                    Api::applyInvitationCode($user, Cookie::get('invitation_code'));
                }

                if ($request->has('promo_code')) {
                    Api::applyPromoCode($user, $request->get('promo_code'));
                }

                return Api::response($pickup->toArray());
            }
        }

        return Api::responseError(['data' => Request::all()], 400, lg("Cannot save pickup"));
    }
}
