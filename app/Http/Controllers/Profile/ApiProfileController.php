<?php /** @noinspection ALL */

namespace App\Http\Controllers\Profile;

use App\Api;
use App\Area;
use App\Events\ItemPickupAskEvent;
use App\Events\PickupCancelEvent;
use App\Events\PickupUpdateEvent;
use App\Events\UserInviteFriendEvent;
use App\Http\Controllers\Controller;
use App\Log;
use App\OrderAssurance;
use App\OrderPlanAsset;
use App\User;
use Carbon\Carbon;
use Exception;
use Exceptions\AccessException;
use Illuminate\Http\Request;
use App\Http\Requests\RescheduleCreateRequest;
use App\Item;
use App\OrderStoringDuration;
use App\Pickup;
use Auth;
use App\Order;
use App\Api\v2\ApiHelper;
use Datetime;

class ApiProfileController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function anyAnswers(Request $request)
    {
        if (!$request->has('id')) {
            return Api::responseErrors([
                ['id' => 'ID is not defined']
            ], 500, 'missing input');
        }

        $id = $request->get('id');
        $type = $request->get('type', 'user');

        if ($type == 'user') {
            $model = User::find($id);
        } else {
            $model = Pickup::find($id);
        }

        return Api::response($model->answers->toArray());
    }

    /**
     * @param Request $request
     * @return array|null
     * @internal param Item $item
     */
    public function anyCancelSchedule(Request $request)
    {
        $user = auth()->user();
        $isAuth = auth()->check();

        if (!$isAuth) {
            $isAuth = Auth::check();
        }

        if ($isAuth) {
            $user = Auth::getUser();
        }

        try {
            $pickupId = $request->get('pickupId');
            if (!$pickupId) {
                return Api::responseError(['error' => lg("Pickup Id is missing")]);
            }
            $pickup = Pickup::query()->where('id', '=', $pickupId)->first();
            $pickup->cancel();
            $data = event(new PickupCancelEvent($pickup));
        } catch (AccessException $e) {
            return Api::responseErrors(['access' => $e->getMessage()]);
        } catch (Exception $e) {
            return Api::responseErrors(['error' => $e->getMessage()]);
        }

        return Api::response($data);
    }

    /**
     * Check available schedules for a specific address
     * @return array
     */
    public function anyCheckSchedules()
    {
        if (!request()->has('postalcode')) {
            return Api::responseErrors([
                ['postalcode' => 'postal code is not defined']
            ], 500, 'missing input');
        }

        $data = Api::getUnavailableDates();

        // disables date +1
        $data[] = [
            'date' => date('Y-m-d 00:00:00', strtotime('+1 days'))
        ];

        $query = Item::select(['postalcode', 'pickup_date'])->whereIn('status', [Item::STATUS_IN_TRANSIT, Item::STATUS_DELIVERED])
            ->where('pickup_date', '>', date('Y-m-d H:i:s'));

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

            $query = $query
                ->whereNotBetween('latitude', [$lat - $diffLat, $lat + $diffLat])
                ->whereNotBetween('longitude', [$lng - $diffLgt, $lng + $diffLgt]);
        } else {
            $query = $query->where('postalcode', '!=', request()->get('postalcode'));
        }

        // Disable hours when there is already a pickup
        $items = $query->groupBy('pickup_date')->get();

        // Disable hours when there is already a pickup in an other postal code
        foreach ($items as $item) {
            $data[] = [
                'date' => $item->pickup_date
            ];
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
     * Return the current user's items
     * @param null $status
     * @return array|\Illuminate\Http\JsonResponse
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

        $items = array_map(function ($item) {
            return array_except($item, ['created_at', 'updated_at', 'deleted_at']);
        }, $items->get()->toArray());

        return Api::response($items);
    }

    /**
     * Return the current user plan
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function anyPlan()
    {
        $user = auth()->user();
        $isAuth = auth()->check();

        if (!$isAuth) {
            $isAuth = Auth::check();
        }

        if ($isAuth) {
            $user = Auth::getUser();
        }

        $plan = array_except($user->plan->toArray(), ['created_at', 'updated_at', 'deleted_at', 'visible']);
        $plan['assets'] = array_map(function ($asset) {
            return array_except($asset, ['created_at', 'updated_at', 'deleted_at', 'pivot']);
        }, $plan['assets']->toArray() ?: OrderPlanAsset::getDefaultAssets()->toArray());

        return Api::response($plan);
    }

    /**
     * Return the list of available item types
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function anyTypes()
    {
        return Api::response(Api::getTypes());
    }

    /**
     * Return the current user insurance
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function getInsurance()
    {
        $user = auth()->user();
        $isAuth = auth()->check();

        if (!$isAuth) {
            $isAuth = Auth::check();
        }

        if ($isAuth) {
            $user = Auth::getUser();
        }

        $plan = array_except($user->insurance->toArray(), ['created_at', 'updated_at', 'deleted_at']);

        return Api::response($plan);
    }

    /**
     * Return the current user
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function getUser()
    {
        $user = auth()->user();
        $isAuth = auth()->check();

        if (!$isAuth) {
            $isAuth = Auth::check();
        }

        if ($isAuth) {
            $user = Auth::getUser();
        }

        $plan = array_except($user->plan ?? [], ['created_at', 'updated_at', 'deleted_at']);

        $insurance = array_except($user->insurance ?? [], ['created_at', 'updated_at']);
        $storing_duration = OrderStoringDuration::find($user->order_storing_duration_id);

        $response = [
            'insurance' => $insurance,
            'plan' => null,
            'storing_duration' => $storing_duration,
        ];

        if ($plan) {
            $response['plan'] = array_merge($plan->toArray(), [
                'assets' => array_map(function ($asset) {
                    return array_except($asset, ['created_at', 'updated_at', 'deleted_at', 'pivot']);
                }, $plan['assets']->toArray()),
            ]);
        }

        return Api::response(array_merge(
            array_except($user->toArray(), ['created_at', 'updated_at', 'deleted_at']),
            $response
        ));
    }

    /**
     * Reschedule a pickup
     *
     * @param Request $request
     * @param Item $item
     * @return mixed
     */
    public function postGetBack(Request $request, Item $item, $apiMode = false)
    {
        $user = auth()->user();
        $isAuth = auth()->check();

        if (!$isAuth) {
            $isAuth = Auth::check();
        }

        if ($isAuth) {
            $user = Auth::getUser();
        }

        # Update items schedule date
        $ids = $request->get('itemsIds');

        if (!count($ids)) {
            return Api::responseError(['error' => lg("invalid itemsIds")]);
        }
        $answers = $request->get('answers');
        if (!$answers || !$answers['completed']) {
            return Api::responseError(['error' => lg("Answers are not complete")]);
        }


        $items = $user->items()->whereIn('id', $ids)->get();
        $orderCreated = false;
        $updatedItemIds = [];
        try {
            // Add pickup record mainly for stats
            $pickup = new Pickup();
            
            $data = $request->only($pickup->getFillable());
            $data['user_id'] = $user->id;
            $data['type'] = $pickup::TYPE_DELIVERY;
            $pickup = $pickup->create($data);
            $orderCreated = true;

            $pickupItems = [];
            $volume = 0;
            foreach ($items as $item) {
                $volume += $item->volume_m3;
                $pickupItems[] = $item->id;
                if ($item->updateStatus(Item::STATUS_ORDERED, $pickup->id)) {
                    $updatedItemIds = $item->id;
                }
            }
            $volume = round($volume, 2);
            $pickup->itemsRecords()->sync($pickupItems);
            $pickup->volume_m3 = $volume;
            if ($request->get('wait_fill_boxes')) {
                $pickup->type = Pickup::TYPE_DROP_OFF_DELIVERY;
            }

            $pickupItems = [];
            foreach ($items as $oItem) {
                $pickupItems[] = [
                    'id' => $oItem['id'],
                    'name' => $oItem['name'],
                    'type' => $oItem['type'],
                    'volume' => $oItem['volume_m3']
                ];
            }
            $pickup->items = json_encode($pickupItems);
            $pickup->status = Pickup::STATUS_ORDERED;
            $pickup->save();
            /**
             * Add Services infos the pickup process
             */
            $services = Order::populateServices($answers, $volume, 'delivery');
            if ($services) {
                foreach ($services as $service) {
                    $pickup->answers()->create([
                        'order_answer_id' => $service['Answer']->id,
                        'value' => $service['value'],
                        'price' => $service['price']
                    ]);
                }
            }
            
            $pickup->updateServices($services);

            /**
             * Send email notification and generate invoice
             *
             * @see ItemPickupAskHandler
             */
            $reponse = event(new ItemPickupAskEvent($pickup));
            \Log::info('Get back #' . $pickup->id, $reponse);
            return Api::response($items->toArray());
        } catch (Exception $ex) {
            \Log::error($ex);
            if ($orderCreated) {
                // Items should return to the old state
                foreach ($items as $item) {
                    if ($item->status == Item::STATUS_ORDERED && in_array($item->id, $updatedItemIds)) {
                        $item->updateStatusToPreviousOne($pickup->id);
                    }
                }
                $pickup->forceDelete();
            }
            
            return Api::response($items->toArray(), 500);
        }
    }

    public function postInsurance(Request $request)
    {
        if (!$request->has('insurance')) {
            return Api::responseError(['insurance' => lg('Param "Insurance" missing!')]);
        }

        $insurance = OrderAssurance::where('slug', $request->get('insurance'))->first();

        /**
         * @var $user User
         */
        $user = auth()->user();
        $isAuth = auth()->check();

        if (!$isAuth) {
            $isAuth = Auth::check();
        }

        if ($isAuth) {
            $user = Auth::getUser();
        }

        if ($insurance) {
            $user->order_assurance_id = $insurance->id;
            $user->save();
        }

        return Api::response($insurance->toArray());
    }

    /**
     * Reschedule a pickup
     *
     * @param Request $request
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function postReschedule(Request $request, Item $item)
    {
        $user = auth()->user();
        $isAuth = auth()->check();

        if (!$isAuth) {
            $isAuth = Auth::check();
        }

        if ($isAuth) {
            $user = Auth::getUser();
        }

        # Update items schedule date
        $ids = $request->get('itemsIds');

        if (!count($ids)) {
            return Api::responseError(['error' => lg("invalid itemsIds")]);
        }

        $answers = $request->get('answers');
        if (!$answers || !$answers['completed']) {
            return Api::responseError(['error' => lg("Answers are not complete")]);
        }

        $pickupId = $request->get('pickupId');
        if (!$pickupId) {
            return Api::responseError(['error' => lg("Pickup Id is missing")]);
        }
        $oldPickup = Pickup::query()->where('id', '=', $pickupId)->first();
        if (!$oldPickup) {
            return Api::responseError(['error' => lg("Invalid Pickup Id")]);
        }

        $items = $item->whereIn('id', $ids)->get();
        $updated = false;
        $dateUpdated = false;
        $createNew = false;
        $orderCreated = false;
        $pickup = null;
        $updatedItemIds = [];
        try {
            $street = $request->get('street');
            $box = $request->get('box');
            $number = $request->get('number');
            $postalcode = $request->get('postalcode');
            $city = $request->get('city');
            $add_infos = $request->get('add_infos');
            $type = ($request->get('wait_fill_boxes')) ? Pickup::TYPE_DROP_OFF_DELIVERY : Pickup::TYPE_DELIVERY;

            //Check if pickup date is modified
            $pickupDate = $request->get('pickup_date');
            $newDate = new Datetime($pickupDate);
            $newTime = $newDate->format('H:i:s');
            $newDate->setTime(0, 0, 0);

            $oldDate = new Datetime($oldPickup->pickup_date);
            $oldTime = $oldDate->format('H:i:s');
            $oldDate->setTime(0, 0, 0);
            
            //Identify what is updated and based on that decide to take a new order or update exiting one.
            if ($oldPickup->street != $street
                        || $oldPickup->number != $number
                        || $oldPickup->box != $box
                        || $oldPickup->postalcode != $postalcode
                        || $oldPickup->city != $city
                        || $oldPickup->add_infos != $add_infos
                        || $oldPickup->type != $type
                        || $oldTime != $newTime) {
                $updated = true;
            }

            if ($newDate->format('Y-m-d H:i:s') != $oldDate->format('Y-m-d H:i:s')) {
                $createNew = true;
                $updated = true;
                $dateUpdated = true;
            }

            //Check if items are modified
            if (!$createNew) {
                $oldItems = $oldPickup->itemsRecords()->get();
                $olditemIds = [];
                foreach ($oldItems as $oItem) {
                    $olditemIds[] = $oItem->id;
                }

                if (count($oldItems) != count($items)) {
                    $createNew = true;
                    $updated = true;
                } else {
                    foreach ($items as $item) {
                        if (!in_array($item->id, $olditemIds)) {
                            $createNew = true;
                            $updated = true;
                            break;
                        }
                    }
                }
            }

            //Check if answers are modified
            if (!$createNew) {
                $oldAnswers = [];
                $oldAns = $oldPickup->answers()->get();
                foreach ($oldAns as $oldAn) {
                    $anType = 'number';
                    if ($oldAn->value == 'yes' || $oldAn->value == 'no') {
                        $anType = 'boolean';
                    }

                    if (!isset($oldAnswers[$anType])) {
                        $oldAnswers[$anType] = [];
                    }
                    $oldAnswers[$anType][$oldAn->answer->order_question_parent_id] = $oldAn->value;
                }

                if (isset($answers['number']) && isset($answers['boolean'])
                    && count($answers['number']) == count($oldAnswers['number'])
                    && count($answers['boolean']) == count($oldAnswers['boolean'])) {
                        foreach ($oldAnswers['number'] as $questionId => $value) {
                            if ($answers['number'][$questionId] != $oldAnswers['number'][$questionId]) {
                                $createNew = true;
                                $updated = true;
                                break;
                            }
                        }
                        
                        if (!$createNew) {
                            foreach ($oldAnswers['boolean'] as $questionId => $value) {
                                if ($answers['boolean'][$questionId] != $oldAnswers['boolean'][$questionId]) {
                                    $createNew = true;
                                    $updated = true;
                                    break;
                                }
                            }
                        }
                } else {
                    $createNew = true;
                    $updated = true;
                }
            }

            if ($updated) {
                if ($createNew) {
                    $pickup = new Pickup();
                    $pickup->street = $street;
                    $pickup->status = Pickup::STATUS_ORDERED;
                    $pickup->box = $box;
                    $pickup->number = $number;
                    $pickup->postalcode = $postalcode;
                    $pickup->city = $city;
                    $pickup->add_infos = $add_infos;
                    $pickup->type = $type;
                    $pickup->pickup_date =  $pickupDate;
                    $pickup->ref_pickup_id = $oldPickup->id;
                    $pickup->user()->associate($user);
                    $pickup->save();
                    $orderCreated = true;
                    
                    //Update old order to canceled
                    $oldPickup->cancel();
                    $oldItems = $oldPickup->itemsRecords()->get();
                    foreach ($oldItems as $item) {
                        if ($item->status != Item::STATUS_ORDERED) {
                            $updatedItemIds[] = $item->id;
                        }
                    }

                    $pickupItems = [];
                    $volume = 0.00;
                    $items = $item->whereIn('id', $ids)->get();
                    foreach ($items as $item) {
                        $volume += $item->volume_m3;
                        $pickupItems[] = $item->id;
                        if ($item->updateStatus(Item::STATUS_ORDERED, $pickup->id)
                            && !in_array($item->id, $updatedItemIds)) {
                            $updatedItemIds[] = $item->id;
                        }
                    }
                    $volume = round($volume, 2);
                    $pickup->itemsRecords()->sync($pickupItems);
                    $pickup->volume_m3 = $volume;
        
                    $pickupItems = [];
                    foreach ($items as $oItem) {
                        $pickupItems[] = [
                            'id' => $oItem['id'],
                            'name' => $oItem['name'],
                            'type' => $oItem['type'],
                            'volume' => $oItem['volume_m3']
                        ];
                    }
                    $pickup->items = json_encode($pickupItems);
                    $pickup->save();
                    /**
                     * Add Services infos the pickup process
                     */
                    $services = Order::populateServices($answers, $volume, 'delivery');
                    if ($services) {
                        foreach ($services as $service) {
                            $pickup->answers()->create([
                                'order_answer_id' => $service['Answer']->id,
                                'value' => $service['value'],
                                'price' => $service['price']
                            ]);
                        }
                    }
                    
                    $pickup->updateServices($services);
                    
                    event(new PickupUpdateEvent($oldPickup, $pickup, $dateUpdated));
                } else {
                    $oldPickup->street = $street;
                    $oldPickup->box = $box;
                    $oldPickup->number = $number;
                    $oldPickup->postalcode = $postalcode;
                    $oldPickup->city = $city;
                    $oldPickup->add_infos = $add_infos;
                    $oldPickup->type = $type;
                    $oldPickup->pickup_date = $pickupDate;
                    $oldPickup->save();
                    event(new PickupUpdateEvent($oldPickup));
                }
            }
            return Api::response($items->toArray());
        } catch (Exception $ex) {
            \Log::error($ex);
            if ($orderCreated) {
                // Items should return to the old state
                foreach ($items as $item) {
                    if ($item->status == Item::STATUS_ORDERED && in_array($item->id, $updatedItemIds)) {
                        $item->updateStatusToPreviousOne($pickup->id);
                    }
                }
                $pickup->forceDelete();
            }
            
            return Api::response($items->toArray(), 500);
        }
    }

    /**
     *
     * @param Request $request
     * @return array
     */
    public function postServices(Request $request)
    {
        $inputs = $request->all();

        \Session::put('services', $inputs['services']);

        return Api::response(['status' => 'TODO']);
    }

    /**
     * Sponsoring
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSponsoring(Request $request)
    {

        foreach ($request->get('emails') as $email) {
            event(new UserInviteFriendEvent(auth()->user(), $email, true));
        }

        return redirect()->back()->with('success', true);
    }

    public function postStoringDuration(Request $request)
    {
        $user = auth()->user();
        $isAuth = auth()->check();

        if (!$isAuth) {
            $isAuth = Auth::check();
        }

        if ($isAuth) {
            $user = Auth::getUser();
        }

        if (!$request->has('storing_duration')) {
            return Api::responseError(['storing_duration' => lg('Param "Storing Duration is missing" missing!')]);
        }

        $params = $request->all();

        $storing_duration = OrderStoringDuration::where('slug', $params['storing_duration'])->first();

        if ($storing_duration) {

            $user->updateStoringDuration($storing_duration);

        }

        return Api::response($storing_duration->toArray());
    }

    /**
     * Return the list of availables storing durations
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function getStoringDurations()
    {
        $toReturn = [];
        $storingDurations = OrderStoringDuration::query()->get()->sortBy('month');
        foreach ($storingDurations as $storingDuration) {
            $toReturn[] = $storingDuration->slug;
        }

        return Api::response($toReturn);
    }

    public function getUnavailableDates(Request $request) {
		$data = Api::getUnavailableDates(null, $request->get('floor'), $request->get('volume'));
		return ApiHelper::response($data);
	}

    /**
     * Return the current user's deliveries
     * @param null $status
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function getPickups()
    {
        $user = auth()->user();
        $isAuth = auth()->check();

        if (!$isAuth) {
            $isAuth = Auth::check();
        }

        if ($isAuth) {
            $user = Auth::getUser();
        }

        $pickups = Pickup::query()->where('user_id', '=', $user->id)
                    ->whereNotIn('status', [Pickup::STATUS_CANCELED, Pickup::STATUS_COMPLETED, Pickup::STATUS_DONE]);
        
        $pickups = array_map(function ($item) {
            return array_except($item, ['created_at', 'updated_at', 'deleted_at']);
        }, $pickups->get()->toArray());

        return Api::response($pickups);
    }
}
