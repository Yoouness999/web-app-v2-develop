<?php

namespace App\Http\Controllers;

use App;
use App\Api;
use App\Api\v2\ApiUser;
use App\Area;
use App\Events\RegisterEvent;
use App\OrderPlanRegion;
use App\Services\PaymentNotification;
use Cookie;
use Illuminate\Http\Request;
use App\OrderAssurance;
use App\OrderCalculatorItem;
use App\OrderCalculatorCategory;
use App\OrderPlan;
use App\OrderPlanCategory;
use App\OrderPlanAsset;
use App\OrderQuestion;
use App\OrderStoringDuration;
use App\Order;
use App\User;
use App\Pickup;
use Illuminate\Support\MessageBag;
use Session;
use Datetime;
use Auth;
use Validator;
use View;

/**
 * Class OrderController
 *
 * @steps :
 *
 * @see OrderController::getStorage() -> Step 1
 * @see OrderController::postStorage() -> Step 1 :
 * @see OrderController::getCalcultator() -> Step 2
 * @see OrderController::postCalculator() -> Step 2
 * @see OrderController::getAppointment() => step 3
 * @see OrderController::postAppointment() => step 3
 * @see OrderController::getBilling() => Step 4
 * @see OrderController::postBilling() => Step 4
 * @see OrderController::getReview() => Step 5
 * @see OrderController::postReview() => Step 5
 * @see OrderController::getConfirmation() => Step 6
 *
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{
    protected $payment_notification;

    public function __construct()
    {
        parent::__construct();

        // to views
        View::share('lang', $this->lang);
        View::share('isProfile', true);

        // to JavaScript
        javascript()->namespace('__app')->set('csrf_token', csrf_token());

        $this->payment_notification = app()->make(PaymentNotification::class);
    }

    /**
     * Step 3 : Appointment
     */
    public function getAppointment(Request $request)
    {
        /**
         * @var $order Order
         */
        $order = Order::retrieve();

        if (!$order->isValid(3)) {
            return redirect($order->getRedirectUrlWhenInvalid(4));
        }

        $this->payment_notification->sendToSlack(
            "#2 Services specified \r\nId: " . $request->getSession()->getId() . "\r\ndev: Step 2 Get services",
            $order->toArrayForSlack()
        );

        $floor = 0;
        if($order->services) {
            foreach($order->services as $service) {
                if($service['slug'] == 'floors') {
                    $floor = $service['value'];
                }
            }
        }
        $unavailableDates = collect(Api::getUnavailableDates(null, $floor, $order->plan->volume_m3))->pluck('date');

        javascript()->namespace('__app')->set('unavailableDates', $unavailableDates);

        $storingDurations = OrderStoringDuration::get()->sortBy('month');
        $dropoffTimeSlots = [];
        $pickupTimeSlots = [];

        if ($order->dropoff_date_from) {
            $from = clone($order->dropoff_date_from);
            $from->setTime(0, 0, 0);

            $to = clone($from);
            $to->modify('+1 day');

            $dropoffTimeSlots = Pickup::getTimeSlots($from, $to);
        }

        if ($order->pickup_date_from) {
            $from = clone($order->pickup_date_from);
            $from->setTime(0, 0, 0);

            $to = clone($from);
            $to->modify('+1 day');

            $pickupTimeSlots = Pickup::getTimeSlots($from, $to);
        }

        /**
         * @var $user User
         */
        if ($this->user) {
            if (!$order->address_route) {
                $order->address_route = $this->user->street;
            }

            if (!$order->address_street_number) {
                $order->address_street_number = $this->user->number;
            }

            if (!$order->address_box) {
                $order->address_box = $this->user->box;
            }

            if (!$order->address_postal_code) {
                $order->address_postal_code = $this->user->postalcode;
            }

            if (!$order->address_locality) {
                $order->address_locality = $this->user->city;
            }

            // Prefill storing_duration and block unavailable durations
            if ($this->user->order_storing_duration_id) {
                $this->user->storing_duration = OrderStoringDuration::find($this->user->order_storing_duration_id);

                if (!$order->storingDuration) {
                    $order->storingDuration = $this->user->storing_duration;
                }
            }

            $order->saveSession();
        }

        $showDropOff = false;
        if (count($order->items)) {
            $showDropOff = collect($order->items)->reject(function ($item) {
                return $item['CalculatorItem']->slug != 'boxify_box';
            })->count();
        }

        return $this->viewMake('order.appointment', compact('storingDurations', 'dropoffTimeSlots', 'pickupTimeSlots', 'showDropOff', 'order', 'unavailableDates'));
    }

    /**
     * Step 4 : Billing
     */
    public function getBilling(Request $request)
    {
        /**
         * @var $order Order
         */
        $order = Order::retrieve();

        if (!$order->isValid(4)) {
            return redirect($order->getRedirectUrlWhenInvalid(4));
        }

        $this->payment_notification->sendToSlack(
            "#3 Appointment planned\r\nId: " . $request->getSession()->getId() . "\r\ndev: Step 3 Get Appointement",
            $order->toArrayForSlack()
        );

        javascript()->namespace('__app')->set('labels', array_merge(['adyen_error' => lg('account.adyen_error')], javascript()->namespace('__labels')->get()));

        // Prefill
        if ($this->user) {
            if (!$order->iban && !$order->card_number) {
                if ($this->user->billing_iban) {
                    $order->iban = $this->user->billing_iban;
                    $order->iban_owner = $this->user->first_name . ' ' . $this->user->last_name;
                } elseif ($this->user->getBillingCardNumber()) {
                    $order->card_number = $this->user->getBillingCardNumber();
                    $order->expiration_month = $this->user->billing_card_month;
                    $order->expiration_year = $this->user->billing_card_year;
                    $order->activation_code = $this->user->activation_code;
                }

                $order->saveSession();

            }
        }

        return $this->viewMake('order.billing', get_defined_vars());
    }

    /**
     * Step 1 bis : Find the right plan (calculator)
     */
    public function getCalculator(Request $request)
    {
        /**
         * @var $currentPlan OrderPlan
         */
        $currentPlan = null;
        $currentVolume = 0;
        $postalCode = null;
        /**
         * @var $storingDuration OrderStoringDuration
         */
        $storingDuration = null;

        // 1. came to calculator "fresh" (without login or selecting a plan) or after selecting a plan
        /**
         * @var $order Order
         */
        $order = Order::retrieve();

        // 2. came to calculator logged
        /**
         * @var $user User
         */
        if ($user = $this->user) {
            $currentPlan = $user->plan;

            if ($currentPlan) {
                $currentVolume = $currentPlan->volume_m3;
            }

            if ($user->postalcode) {
                $postalCode = $user->postalcode;
            }
        }

        if ($order) {
            if ($order->plan) {
                $currentPlan = $order->plan;
                $currentVolume = $currentPlan->volume_m3;
            }

            // if items -> this is a new order, set current volume to null
            if ($order->items) {
                $currentPlan = null;
                $currentVolume = 0;

                // if user and has plan -> this is a new additional order, reset volume to current plan volume
                if ($user) {
                    $currentPlan = $user->plan;

                    if ($currentPlan) {
                        $currentVolume = $currentPlan->volume_m3;
                    }
                }
            }

            if ($order->address_postal_code) {
                $postalCode = $order->address_postal_code;
            }
        }

        if ($request->has('postal_code')) {
            $postalCode = $request->get('postal_code');
        }

        if (!$postalCode) {
            return redirect('/');
        }

        if ($postalCode) {
            if (Area::where('zip_code', $postalCode)->first()) {
                if ($order) {
                    // update current order postal code
                    $order->address_postal_code = $postalCode;

                    $order->saveSession();
                }
            } else {
                flash()->error(lg("common.zip_code not in the list"));
                $errors = new MessageBag(['postal_code' => lg("common.zip_code not in the list")]);
            }
        }

        if ($request->has('storing_duration')) {
            $storingDuration = OrderStoringDuration::find($request->get('storing_duration'));

            if ($storingDuration) {
                if ($order) {
                    // update current order storing duration
                    $order->storingDuration = $storingDuration;

                    $order->saveSession();
                }
            }
        }

        $storingDurations = OrderStoringDuration::get()->sortBy('month');

        /**
         * @var $storageSuppliesCategory OrderCalculatorCategory
         */
        $storageSuppliesCategory = OrderCalculatorCategory::where('slug', 'storage_supplies')->first();
        $categories = OrderCalculatorCategory::where('slug', '!=', 'storage_supplies')->get();

        return $this->viewMake('order.calculator', compact('storingDurations', 'storageSuppliesCategory', 'categories', 'order', 'postalCode', 'currentPlan', 'currentVolume', 'storingDuration'));
    }

    /**
     * Step 6 : Get confirmation page (end of process)
     *
     * @url /order/confirmation
     */
    public function getConfirmation(App\OrderBooking $orderBooking, Request $request)
    {
        /**
         * Check if we should apply the invitation code
         */
        /*if ($invitation = \Cookie::get('invitation_code')) {
            /**
             * @var $user User
             */
          //  $user = auth()->user();
        /*    Api::applyInvitationCode($user, $invitation);
        }*/

        $order = Order::retrieve();

        $this->payment_notification->sendToSlack(
            "#5 New customer engaged :fire: :fire: :fire: \r\nId: " . $request->getSession()->getId(),
            $order->toArrayForSlack()
        );

        if (Session::get('new_user') === '1') {
            Session::forget('new_user');
            $user = auth()->user();
            $user->sendMailConfirmation();
        }


        $lines = json_decode($orderBooking->total_description);
        $total = $orderBooking->total_price_to_invoice;

        if ($orderBooking->company_vat_number && $orderBooking->company_address_country) {
            $countries = Api::getCountries();
        }

        $request->getSession()->forget("order");
        $request->getSession()->save();

        return $this->viewMake('order.confirmation', get_defined_vars());
    }

    /**
     * Step 5 : Review
     */
    public function getReview(Request $request)
    {
        /**
         * @var $order Order
         */
        $order = Order::retrieve();

        if (!$order->isValid(5)) {
            return redirect($order->getRedirectUrlWhenInvalid(5));
        }

        $this->payment_notification->sendToSlack(
            "#4 Payment method specified\r\nId: " . $request->getSession()->getId() . "\r\ndev: Step 4 Get Billing Info",
            $order->toArrayForSlack()
        );

        // @note Retrieve error from facebook connect
        if ($request->getSession()->exists('process')) {
            if ($request->getSession()->get('errors')) {
                if ($request->getSession()->get('process') == 'login') {
                    $request->getSession()->flash('login.errors', $request->getSession()->get('errors')->toArray());
                } else {
                    $request->getSession()->flash('register.errors', $request->getSession()->get('errors')->toArray());
                }
            }

            $request->getSession()->forget('process');
        }

        $hasInvitationCoupon = null;
        $invitationDiscount = null;

        $storageSuppliesCategory = OrderCalculatorCategory::where('slug', 'storage_supplies')->first();
        $assurances = OrderAssurance::all();
        $countries = Api::getCountries();

        $user = auth()->user();
        if ($user) {
            $insurance = array_except($this->user->insurance ?? [], ['created_at', 'updated_at']);

            if ($insurance) {
                $order->assurance = $insurance;

                $order->saveSession();
            }

            $register = [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'phone' => $user->phone,
                'email' => $user->email,
            ];

            /**
             * Check if user can apply for a Coupon Code or not
             *
             * @var $user User
             */
            /*if ($user->canApplyInvitationCode()) {
                $hasInvitationCoupon = true;
                $invitationDiscountType = config('project.godson_coupon_discount_type');
                $invitationDiscount = "-" . config('project.godson_coupon_discount') . $invitationDiscountType;
            }*/
        }



        return $this->viewMake('order.review', get_defined_vars());
    }

    /**
     * Step 1 : Pick up a storage plan
     */
    public function getStorage(Request $request)
    {

        if ($this->user && $this->user->isInPaymentDefault()) {
            return redirect('/profile/account');
        }

        $postalCode = null;

        // 1. came to storage "fresh" (without login or selecting a plan) or after selecting a plan
        /**
         * @var $order Order
         */
        $order = Order::retrieve();

        $this->payment_notification->sendToSlack(sprintf('%s search by postal code (%s) initiated', $request->getSession()->getId(), $request->get('postal_code')));

        // 2. came to storage logged
        /**
         * @var $user User
         */
        if ($user = $this->user) {
            if ($user->postalcode) {
                $postalCode = $user->postalcode;
            }
        }

        if ($order->address_postal_code) {
            $postalCode = $order->address_postal_code;
        }

        if ($request->has('postal_code')) {
            $postalCode = $request->get('postal_code');
        }

        if ($postalCode) {
            if (Area::where('zip_code', $postalCode)->first()) {
                if ($order) {
                    // update current order postal code
                    $order->address_postal_code = $postalCode;

                    $order->saveSession();
                }
            } else {
                flash()->error(lg("common.zip_code not in the list"));
                $errors = new MessageBag(['postal_code' => lg("common.zip_code not in the list")]);
            }
        }

        $categories = OrderPlanCategory::all();
        $assets = OrderPlanAsset::all();

        $storingDurations = OrderStoringDuration::get()->sortBy('month');
        $storageSuppliesCategory = OrderCalculatorCategory::where('slug', 'storage_supplies')->first();

        return $this->viewMake('order.storage', compact('categories', 'assets', 'storingDurations', 'storageSuppliesCategory', 'order', 'postalCode'));
    }

    public function getTimeSlots(Request $request)
    {
        $from = new Datetime($request->get('date'));
        $from->setTime(0, 0, 0);

        $to = clone($from);
        $to->modify('+1 day');

        $timeSlots = Pickup::getTimeSlots($from, $to);
        $data = [];

        foreach ($timeSlots as $timeSlot) {
            $data[] = [
                'value' => $timeSlot['from']->format('Y-m-d H:i:s') . '_' . $timeSlot['to']->format('Y-m-d H:i:s'),
                'label' => $timeSlot['from']->format('H:i') . ' - ' . $timeSlot['to']->format('H:i')
            ];
        }

        return $data;
    }

    public function postAppointment(Request $request)
    {
        /**
         * @var $order Order
         */
        $order = Order::retrieve();

        if (!$order->isValid(3)) {
            return redirect($order->getRedirectUrlWhenInvalid(4));
        }

        // Verify postal code
        if ($request->has('address_postal_code')) {
            $area = Area::where('zip_code', $request->get('address_postal_code'))->first();

            if (!$area) {
                return redirect('/order/appointment')->withErrors(['address_postal_code' => lg('common.zip_code not in the list')]);
            }
        }

        $order->storingDuration = OrderStoringDuration::find($request->get('storing_duration'));

        $order->address_full = $request->get('address_full');
        $order->address_route = $request->get('address_route');
        $order->address_street_number = $request->get('address_street_number');
        $order->address_locality = $request->get('address_locality');
        $order->address_postal_code = $request->get('address_postal_code');
        $order->address_country = $request->get('address_country');
        $order->address_box = $request->get('address_box');

        // @note We need address_full to validate this step
        if (!$order->address_full) {
            $order->address_full = implode('', [
                $order->address_route, ', ',
                $order->address_street_number, ' ',
                $order->address_box, ' - ',
                $order->address_postal_code, ' ',
                $order->address_locality, ' - ',
                $order->address_country,
            ]);
        }

        $order->wait_fill_boxes = $request->get('wait_fill_boxes') == 'yes';

        if ($request->get('dropoff_time')) {
            list($dropoff_date_from, $dropoff_date_to) = explode('_', $request->get('dropoff_time'));
            $order->dropoff_date_from = new Datetime($dropoff_date_from);
            $order->dropoff_date_to = new Datetime($dropoff_date_to);
        }

        if (!$order->wait_fill_boxes) {
            list($pickup_date_from, $pickup_date_to) = explode('_', $request->get('pickup_time'));
            $order->pickup_date_from = new Datetime($pickup_date_from);
            $order->pickup_date_to = new Datetime($pickup_date_to);
        }

        $order->saveSession();

        if ($request->getSession()->get('resume')) {
            return redirect('/order/review');
        }

        return redirect('/order/billing');
    }

    public function postBilling(Request $request)
    {
        /**
         * @var $order Order
         */
        $order = Order::retrieve();

        if (!$order->isValid(4)) {
            return redirect($order->getRedirectUrlWhenInvalid(4));
        }

        if ($request->get('keep_payment')) {
            $order->keep_payment = true;
        } else {
            $order->keep_payment = false;
            // cleanup
            $order->card_number = '';
            $order->card_number_part = '';
            $order->adyen_card_encrypted_json = '';
            $order->iban = '';
            $order->iban_owner = '';

            $payment_type = $request->get('payment_type');

            if ($payment_type === "sepa") {
                if (!$request->has('iban') || !$request->has('iban_owner')) {
                    return redirect('order/billing')->with('error', lg('common.card-encryption-error'));
                }

                // bank card
                $order->iban = $request->get('iban');
                $order->iban_owner = $request->get('iban_owner');
            } else {
                if (!$request->has('adyen_card_encrypted_json')) {
                    return redirect('order/billing')->with('error', lg('common.card-encryption-error'));
                }

                $order->setCardNumber($request->get('card_number_part'));

                // credit card
                $order->card_number_part = $request->get('card_number_part');
                $order->adyen_card_encrypted_json = $request->get('adyen_card_encrypted_json');
            }
        }

        $order->saveSession();

        if ($request->getSession()->get('resume')) {
            return redirect('/order/review');
        }

        return redirect('/order/review');
    }

    public function postCalculator(Request $request)
    {
        /**
         * @var $order Order
         */
        $order = Order::retrieve();

        if ($request->has('items')) {
            $order->items = [];
            $order->setItems($request->get('items'));
        }

        if ($request->has('storing_duration')) {
            $order->storingDuration = OrderStoringDuration::find($request->get('storing_duration'));
        }

        if ($request->has('plan')) {
            $plan = OrderPlan::find($request->get('plan'));
            $order->plan = $plan;
        }

        $order->isComingFromCalculator = true;

        $order->saveSession();

        if ($request->getSession()->exists('resume')) {
            return redirect('/order/review');
        }

        if ($order->plan && $order->plan->isContactOnly()) {
            return redirect('page/contact');
        }

        return redirect('/order/services');
    }

    /**
     * Post review
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postReview(Request $request)
    {
        /**
         * @var $order Order
         */
        $order = Order::retrieve();

        if (!$order->isValid(5)) {
            return redirect($order->getRedirectUrlWhenInvalid(5));
        }

        // company
        if ($request->get('company_vat_number')) {
            $order->business = true;
            $order->company_name = $request->get('company_name');
            $order->company_vat_number = preg_replace('/[^A-Z0-9]/', '', strtoupper($request->get('company_vat_number')));
            $order->company_address_full = $request->get('company_address_full');
            $order->company_address_route = $request->get('company_address_route');
            $order->company_address_street_number = $request->get('company_address_street_number');
            $order->company_address_locality = $request->get('company_address_locality');
            $order->company_address_postal_code = $request->get('company_address_postal_code');
            $order->company_address_country = $request->get('company_address_country');
            $order->company_address_box = $request->get('company_address_box');
        } else {
            $order->business = false;
            $order->billing_address_full = $request->get('company_address_full');
            $order->billing_address_route = $request->get('company_address_route');
            $order->billing_address_street_number = $request->get('company_address_street_number');
            $order->billing_address_locality = $request->get('company_address_locality');
            $order->billing_address_postal_code = $request->get('company_address_postal_code');
            $order->billing_address_country = $request->get('company_address_country');
            $order->billing_address_box = $request->get('company_address_box');
        }

        $order->comments = $request->get('comments');
        $order->assurance = OrderAssurance::find($request->get('assurance'));

        if ($request->get('how_did_your_hear_about_us_comment')) {
            $order->how_did_your_hear_about_us = $request->get('how_did_your_hear_about_us_comment');
        } else {
            $labels = lg('order.review.how-did-your-hear-about-us.options');

            if (array_key_exists($request->get('how_did_your_hear_about_us'), $labels)) {
                $order->how_did_your_hear_about_us = $labels[$request->get('how_did_your_hear_about_us')];
            } else {
                $order->how_did_your_hear_about_us = $request->get('how_did_your_hear_about_us');
            }
        }

        if ($request->has('coupon')) {
            $order->promo_code = $request->get('coupon');
        }

        $order->saveSession();

        // @note "redirect" is used to save data before going to a previous step
        if ($request->has('redirect')) {
            $request->getSession()->put('resume', true);
            return redirect($request->get('redirect'));
        }

        // @note "process" is used to login or register
        if ($request->has('process')) {
            if ($request->get('process') === 'login') {
                $inputs = $request->get('login');

                $validator = Validator::make($inputs, [
                    'email' => 'required|email',
                    'password' => 'required',
                ]);

                $validator->after(function ($validator) use ($inputs) {
                    if (!Auth::attempt(['email' => $inputs['email'], 'password' => $inputs['password']])) {
                        $validator->errors()->add('email', lg('order.review.account.login.error'));
                    }
                });

                if ($validator->fails()) {
                    $errors = $validator->messages()->getMessages();
                    return redirect('/order/review')
                        ->with('login.errors', $errors)
                        ->withInput($request->except(['password']));
                }

                if (Auth::check()) {
                    return redirect('/order/review');
                }

                // @note This should never happen...
                return redirect('/order/review')
                    ->withInput($request->except(['password']));
            } elseif ($request->get('process') == 'register') {
                $inputs = $request->get('register');

                $validator = Validator::make($inputs, [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'phone' => 'required|phone:AUTO',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:8|confirmed',
                    'password_confirmation' => 'required|min:8',
                ]);

                $validator->after(function ($validator) use ($inputs) {
                    if (!User::isEmailAvailable($inputs['email'])) {
                        $validator->errors()->add('email', lg('order.review.account.email.error'));
                    }
                });

                if ($validator->fails()) {
                    $errors = $validator->messages()->getMessages();
                    return redirect('/order/review')
                        ->with('register.errors', $errors)
                        ->with('register.keys', array_keys($errors))
                        ->withInput($request->except(['password']));
                }

                // format data before saving
                $inputs['phone'] = str_replace(' ', '', $inputs['phone']);

                // Create a new account and login
                $user = ApiUser::add($inputs);
                Auth::login($user);

                event(new RegisterEvent($user));

                $request->getSession()->put('new_user', '1');

                if (!Auth::check()) {
                    return redirect('/order/review');
                }

                // @note This should never happen...
                return redirect('/order/review')
                    ->withInput($request->except(['password', 'password_confirmation']));
            }
        }

        /**
         * If user is authenticated
         */
        if (Auth::check()) {

            $inputs = $request->except(['register', 'login']);

            $user = Auth::getUser();

            $validator = Validator::make($inputs, [
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required|phone:AUTO',
                'email' => 'required|email',
                'gdpr' => 'required',
            ]);

            try {
                /**
                 * Add NEW GDPR compliance
                 *
                 * @see http://pm2.cherrypulp.com/projects/543?modal=Task-12414-543
                 */
                $user->agree = 1;
                $user->agree_date = date('Y-m-d H:i:s');
                $user->save();

                // Validate email unicity
                // if the user want to change his email, we have to make sure that it is available
                // if the email is the same as previously, we let it pass
                $validator->after(function ($validator) use ($inputs, $user) {
                    if (!User::isEmailAvailable($inputs['email'], [$user->id])) {
                        $validator->errors()->add('email', lg('order.review.account.email.error'));
                    }
                });

                if ($validator->fails()) {
                    $errors = $validator->messages()->getMessages();

                    return redirect('/order/review')
                        ->with('common.errors', $errors)
                        ->with('common.keys', array_keys($errors))
                        ->withInput($request->except(['password']));
                }

                /**
                 * Update user data
                 */
                $userData = $request->only([
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                ]);

                $user->update($userData);

                $order->user = $user;
                $booking = $order->save();

            } catch (App\Exceptions\ChallengeException $e) {
                $url = App\Adyen::manageChallenge($e->getResult(), $user, $request);
                $request->getSession()->save();
                return redirect($url);
            } catch (App\Exceptions\PaymentErrorException $e) {
                \Log::error($e);
                return redirect('/order/billing')->with('error', $e->getMessage());
            } catch (App\Exceptions\BillingErrorException $e) {
                \Log::info('Error in billing', [$request->all(), $order]);
                \Log::error($e);
                return redirect('/order/billing')->with('error', $e->getMessage());
            } catch (\Exception $e) {
                \Log::info('Error in global', [$request->all(), $order]);
                \Log::error($e);
                return redirect('/order/review')->with('common.errors', ['order' => $e->getMessage()]);
            }

            return redirect()->action([OrderController::class, 'getConfirmation'], ['orderBooking' => $booking->id]);
        }

        // @note This should never happen...
        return redirect('/order/review')
            ->withInput($request->except(['password']));
    }

    public function postServices(Request $request)
    {
        /**
         * @var $order Order
         */
        $order = Order::retrieve();

        if (!$order->isValid(2)) {
            return redirect($order->getRedirectUrlWhenInvalid(4));
        }

        // Set the postal code
        $order->address_postal_code = $request->get('postal_code', session('postal_code', null));

        $order->setServices($request->get('answers'));

        $order->saveSession();

        if ($request->getSession()->exists('resume')) {
            return redirect('/order/review');
        }

        return redirect('/order/appointment');
    }

    public function postStorage(Request $request)
    {
       /**
         * @var $order Order
         */
        $order = Order::retrieve();

        if ($request->has('items')) {
            $order->setItems($request->get('items'));
        }

        if ($request->has('plan')) {
            $plan = OrderPlan::find($request->get('plan'));

            $order->plan = $plan;
            $order->storingDuration = OrderStoringDuration::find($request->get('storing_duration'));
            $order->isComingFromCalculator = false;

            // reset items
            if (!$request->has('items')) {
                $order->items = [];
            }

            if ($plan->isContactOnly()) {

                return redirect('page/contact');
            }
        }

        // cleanup
        $order->wait_fill_boxes = false;

        $order->saveSession();

        if ($request->getSession()->exists('resume')) {

            return redirect('/order/review');
        }

        return redirect('/order/services');
    }

    /**
     * Step 2 : Let's get some details (Services)
     */
    public function getServices(Request $request)
    {

        /**
         * @var $order Order
         */
        $order = Order::retrieve();

        if (!$order->isValid(2)) {
            return redirect($order->getRedirectUrlWhenInvalid(4));
        }

        $this->payment_notification->sendToSlack(
            "#1 Storage specified\r\nId: " . $request->getSession()->getId() . "\r\dev: Step 1 Get storage  ",
            $order->toArrayForSlack()
        );

        $questions = OrderQuestion::where('visible', true)->orderBy('sequence')->get();

        return $this->viewMake('order.services', compact('questions', 'order'));
    }

    /**
     * Find the correct price regarding the info in the calculator
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function postStorageFindPrice(Request $request)
    {
        $items = [];
        $price = 0;
        $priceWithDiscount = false;
        $storingDuration = OrderStoringDuration::find($request->get('storing_duration'));
        /**
         * @var $user User
         */
        $user = $this->user;
        $volume = $currentVolume = $newVolume = 0;
        $currentPlan = null;

        if (strpos($request->server('HTTP_REFERER'), 'order/calculator')) {
            /**
             * @var $order Order
             */
            $order = Order::retrieve();
            $order->isComingFromCalculator = true;
        }

        // Get user selected plan
        if ($user) {
            $currentVolume = $newVolume = $user->getVolumePlan();
            $currentPlan = $user->plan;
        }

        // If "volume_current" is given, select a corresponding plan
        // ex. "volume_current" = (existing plan volume or null) + calculator volume(s)
        if ($request->has('volume_current') && $request->get('volume_current') > 0) {
            $currentVolume = $newVolume = $request->get('volume_current');
            $currentPlan = OrderPlan::getByVolume($currentVolume);
        }

        // Select a plan or calculate one from given items
        if ($request->has('plan')) {
            // Get a specific plan from ID and add it to current volume
            $plan = OrderPlan::find($request->get('plan'));
            $newVolume = $currentVolume + $plan->volume_m3;
        } else {
            // Calculate volume from the given items and select a related plan
            $plan = null;

            if ($request->has('items')) {
                foreach ($request->get('items') as $itemId => $quantity) {
                    if ($quantity > 0) {
                        $item = OrderCalculatorItem::find($itemId);
                        $item->quantity = $quantity;
                        $items[] = $item;

                        $newVolume += $item->volume_m3 * $quantity;
                    }
                }
            }
        }

        // Get the new matching plan
        //Minimum plan must be 3m3
        if($newVolume < 3) {
            $newVolume = 3;
        }
        $plan = OrderPlan::getByVolume($newVolume);
        $price = $plan->price_per_month;
        $volume = $plan->volume_m3;

        // Update price by region
        if ($request->has('postal_code')) {
            $area = Area::where('zip_code', $request->get('postal_code'))->first();

            if ($area) {
                $orderPlanRegion = OrderPlanRegion::where('region_id', $area->region_id)->where('order_plan_id', $plan->id)->first();

                if ($orderPlanRegion) {
                    $price = $orderPlanRegion->price_per_month;
                }

                // Update current plan for given postal code"
                if ($currentPlan) {
                    $currentPlanRegion = OrderPlanRegion::where('region_id', $area->region_id)->where('order_plan_id', $currentPlan->id)->first();

                    if ($currentPlanRegion) {
                        $currentPlan = $currentPlanRegion;
                    }
                }
            }
        }

        $assets = [];

        if ($plan) {
            $assets = $plan->assets()->count() ? $plan->assets->toArray() : OrderPlanAsset::getDefaultAssets()->toArray();
        }

        $discount = $storingDuration->discount_percentage;
        if($user && $user->old_pricing) {
            $discount = $storingDuration->old_discount_percentage;
        }
        if ($storingDuration && $discount > 0) {
            $priceWithDiscount = number_format($price * (1 - ($discount / 100)), 2);
        }

        return $this->viewMake('order.storage-resume', compact('items', 'plan', 'volume', 'price', 'priceWithDiscount', 'currentPlan', 'currentVolume', 'newVolume', 'storingDuration', 'assets'));
    }

    /**
     * Remove plan from the current session order.
     * @param Request $request
     * @return array
     */
    public function postStorageRemovePlanFromSession(Request $request)
    {
        $order = Order::retrieve();

        $order->plan = null;
        $order->saveSession();

        return Api::response(['success' => true]);
    }

}
