<?php namespace App\Http\Controllers\Profile;

use App;
use App\Api;
use App\Http\Controllers\Controller;
use App\OrderQuestion;
use App\User;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Validator;
use View;
use Auth;

class ProfileController extends Controller
{
    /**
     * @var string
     */
    public $lang = 'en-US';

    /**
     * @var \App\User
     */
    public $user;

    /**
     * @var App\OrderPlan
     */
    protected $plan;
    protected $defaultPayment = false;


    public function __construct()
    {
        parent::__construct();
    }

    private function bootUser()
    {
        $user = auth()->user();
        $isAuth = auth()->check();

        if (!$isAuth) {
            $isAuth = Auth::check();
        }

        if ($isAuth) {
            $user = Auth::getUser();
        }

        $this->lang = App::getLocale() ?: 'fr';

        if (!$user) {
            return redirect('login')->withErrors(['login' => lg("errors.login")]);
        }

        $this->defaultPayment = $user->isInPaymentDefault() || $user->hasUnpaidInvoices();

        $answers = $user->getAnswers();

        // to views
        View::share('lang', $this->lang);
        View::share('isProfile', true);
        View::share('defaultPayment', $this->defaultPayment);
        View::share('userNotActive', !$user->active);
        View::share('lastOrderConfirmed', $user->isLastOrderConfirmed());

        // to JavaScript
        javascript()->namespace('__app')->set('locked', $this->defaultPayment ? 'billing' : (!$user->active ? 'informations' : false));
        javascript()->namespace('__app')->set('answers', $answers);

        $this->middleware('check.active', ['only' => ['anyManage']]);
        $this->middleware('check.hasplan', ['only' => ['anyManage']]);

        return $user;
    }

    /**
     * /account
     * - informations
     * - billing
     * - invoice
     * - password
     *
     * @param Request $request
     * @return \Illuminate\View\View
     * @throws \Exception
     */
    public function getAccount(Request $request)
    {
        javascript()->namespace('__app')->set('labels', array_merge(['adyen_error' => lg('account.adyen_error')], javascript()->namespace('__labels')->get()));

        $countries = Api::getCountries();

        $user = $this->bootUser();

        // 2. Billing
        $paymentInfo = [
            'card_number' => $user->billing_card_number,
            'card_name' => $user->billing_card_holder,
            'card_expiration_month' => $user->billing_card_month,
            'card_expiration_year' => $user->billing_card_year,
            'iban' => $user->getBillingIban(),
            'iban_owner' => $user->getBillingIbanOwnerName(),
            'balance' => 0
        ];

        $imageUrl = null;
        $balance = 0;

        if ($user->hasBillingInfo()) {
            $balance = $user->getBalanceAccount();
        }

        $months = [];
        $date = new \Datetime();
        for ($i = 1; $i <= 12; $i++) {
            $months[] = [
                'value' => $i,
                'label' => $date->setDate($date->format('Y'), $i, $date->format('j'))->format('F')
            ];
        }

        $startYear = intval($date->format('Y'));
        $endYear = $startYear + 30;

        // 3. Invoice
        $invoices = $user->getInvoices();

        if ($request->has('download')) {
            $aInvoice = $invoices[$request->get('download')];
            return $this->viewMake('layouts.invoice', get_defined_vars());
        }

        $successMessage = $request->session()->get('success');

        // 4. Password
        return $this->viewMake('profile.account', get_defined_vars());
    }

    /**
     * @param Request $request
     * @return string
     * @throws \Exception
     */
    public function postAccount(Request $request)
    {
        $user = $this->bootUser();
        $anchor = '';
        $message = '';

        if (!$user->active){
            return redirect('/profile/account')->withErrors(['email' => lg('order.review.account.email.error')]);
        }

        if ($this->defaultPayment && !count($request->all())) {
            return redirect('/profile/account');
        }

        if ($request->has('form_name')) {
            $inputs = $request->all();

            if (isset($inputs['email']) && $user->email === $inputs['email']) {
                unset($inputs['email']);
            }

            switch ($request->get('form_name')) {
                case 'informations':
                    $validator = Validator::make($inputs, [
                        'first_name' => 'required',
                        'last_name' => 'required',
                        'phone' => 'required|phone:AUTO',
                        'email' => 'email|unique:users',
                    ]);

                    if ($validator->fails()) {
                        return redirect('/profile/account')
                            ->withErrors($validator)
                            ->with('active', 'informations')
                            ->withInput($request->all());
                    }

                    // format data before saving
                    $userData = $request->except(['_token', 'form_name', 'submit', 'address_route', 'address_street_number', 'address_box', 'address_postal_code', 'address_locality', 'company_address_country']);

                    $user->phone = str_replace(' ', '', $inputs['phone']);
                    $user->street = $request->get('address_route');
                    $user->number = $request->get('address_street_number');
                    $user->box = $request->get('address_box');
                    $user->postalcode = $request->get('address_postal_code');
                    $user->city = $request->get('address_locality');
                    $user->billing_country = $request->get('billing_country');
                    $user->company_address_country = $request->get('company_address_country');

                    $user->update($userData);
                    $user->save();
                    break;

                case 'billing':
                    $anchor = '#billing';
                    $validator = Validator::make($inputs, [
                        'payment_type' => 'required|in:credit_card,sepa',
                    ]);

                    if ($validator->fails()) {
                        \Log::info('Error billing update', $validator->errors()->toArray());

                        return redirect('/profile/account')
                            ->withErrors($validator)
                            ->with('active', 'billing')
                            ->withInput($request->all());
                    }

                    if ($request->has('payment_type')) {
                        $successful = false;
                        try {
                            if ($request->get('payment_type') == 'credit_card') {
                                $successful = $user->updateBillingInfo($request->get('adyen_card_encrypted_json'), $request->all());
                            } else {
                                $successful = $user->updateSepaBillingInfo($request->get('iban'), $request->get('iban_owner'));
                            }
                        } catch (App\Exceptions\ChallengeException $e) {
                            $url = App\Adyen::manageChallenge($e->getResult(), $user, $request);
                            $request->getSession()->save();

                            return redirect($url);
                        } catch (Exception $e) {
                            \Log::error('Update biiling info failed for USER:'.$user->id);
                            return redirect('/profile/account/#billing')->withErrors(['billing' => lg("common.card-encryption-error")]);
                        }
                        $message = 'There were an error when updating your payment info. Please contact the support';
                        if ($successful) {
                            $message = 'Payment information updated with success';
                        }
                    }
                    break;

                case 'invoice':
                    break;

                case 'password':
                    $validator = Validator::make($inputs, [
                        'password' => 'required|min:8|confirmed',
                        'password_current' => 'required',
                    ]);

                    $validator->after(function ($validator) use ($inputs, $user) {
                        if (!Hash::check($inputs['password_current'], $user->password)) {
                            $validator->errors()->add('password_current', lg('account.password.error.wrong_password'));
                        }
                    });

                    if ($validator->fails()) {
                        return redirect('/profile/account')
                            ->withErrors($validator)
                            ->with('active', 'password')
                            ->withInput($request->except(['password', 'password_confirm']));
                    }

                    $user->password = bcrypt($request->get('password'));
                    $user->save();

                    break;
            }
        }

        return redirect('/profile/account'.$anchor)->with('success', $message);
    }

    /**
     * /manage
     * - stocked
     * - in transit
     * - at home
     * @return \Illuminate\View\View
     */
    public function anyManage()
    {
        if ($this->defaultPayment) {
            return redirect('/profile/account');
        }



        $questions = OrderQuestion::where('visible', true)->orderBy('sequence')->get()->map(function ($item) {
            $item->answers = $item->getAllAnswers('delivery')->map(function ($answer) {
                $answer->target = $answer->getQuestionTargetId();
                return $answer;
            });
            return $item;
        });


        // to JavaScript
        javascript()->namespace('__labels')->set(lg('manager'));
        javascript()->namespace('__app')->set('cities', lg('cities'));
        javascript()->namespace('__app')->set('questions', $questions);

        return $this->viewMake('profile.manage', get_defined_vars());
    }

    /**
     * Get Sponsorship
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function getSponsorship(Request $request)
    {
        if ($this->defaultPayment) {
            return redirect('/profile/account');
        }

        $user = $this->bootUser();

        $sponsorship_link = $user->getInviteLink();

        $results = session('results', []);
        $exists = array_where($results, function ($key, $value) {
            return array_key_exists('already_invited', $value);
        });

        if ($email = $request->get('resendMail')) {
            event(new App\Events\UserInviteFriendEvent($user, $email, true));
        }

        $godfather = $user->godfather;

        /**
         * Filter only already invited user
         */
        $resultsAlreadyInvited = collect($results)->filter(function($item){
            return isset($item['already_invited']);
        })->toArray();

        $invites = $user->invites;

        return $this->viewMake('profile.sponsorship', get_defined_vars());
    }

    public function postSponsorship(Request $request)
    {
        $this->validate($request, [
           'invitations' => 'required',
        ]);

        $results = [];

        foreach ($request->get('invitations') as $invitation) {
            /**
             * @see \App\Handlers\Events\UserInviteFriendHandler
             */
            $results[$invitation['email']] = event(new App\Events\UserInviteFriendEvent($this->bootUser(), $invitation['email']));
            $results[$invitation['email']] = array_pop($results[$invitation['email']]);
        }

        $request->session()->flash('results', $results);

        return redirect()->back();
    }

    /**
     * Login page
     *
     * @return \Illuminate\View\View
     */
    public function anyLogin()
    {
        return $this->viewMake('auth.login', get_defined_vars());
    }

    /**
     * Manager page
     *
     * @return \Illuminate\View\View
     */
    public function anyManager()
    {
        javascript()->namespace('__app')->set('labels', lg('manager'));
        javascript()->namespace('__app')->set('cities', lg('cities'));
        javascript()->namespace('__app')->set('types', lg('types'));
        javascript()->namespace('__app')->set('insurances', lg('manager.insurances'));
        javascript()->namespace('__app')->set('storing_durations', lg('manager.storing_durations'));

        // Put min pickup date
        javascript()->namespace('__app')->set('minPickupDate', date('Y-m-d', strtotime('+2 days')));

        return $this->viewMake('user.manager', get_defined_vars());
    }

    /**
     * Signup page
     *
     * @return \Illuminate\View\View
     */
    public function anySignup()
    {
        return $this->viewMake('auth.register', get_defined_vars());
    }

    /**
     * Resend validation
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postValidation()
    {
        /**
         * @var $user User
         */
        $user = auth()->user();

        $user->sendMailConfirmation();

        return redirect()->back();
    }

}
