<?php
/**
 * Adyen
 *
 * Expose Adyen payment methods
 */

namespace App;

use Adyen\AdyenException;
use Adyen\Client;
use Adyen\Contract;
use Adyen\Environment;
use Adyen\Service\Modification;
use Adyen\Service\Payment;
use Adyen\Service\Payout;
use Adyen\Service\Recurring;
use App\Contracts\PaymentProviderContract;
use App\Exceptions\ChallengeException;
use Config;
use Exception;
use App\Http\Controllers\PageController;
use Countries\Countries;

class Adyen implements PaymentProviderContract
{
    /**
     * Different possible result code
     *
     * @see https://docs.adyen.com/api-explorer/#/Payment/v30/authorise
     */
    const RESULT_CODE_Authorised = "Authorised";
    const RESULT_CODE_Refused = "Refused";
    const RESULT_CODE_ChallengeShopper = "ChallengeShopper";
    const RESULT_CODE_IdentifyShopper = "IdentifyShopper";
    const RESULT_CODE_RedirectShopper = "RedirectShopper";
    const RESULT_CODE_Received = "Received";
    const RESULT_CODE_Cancelled = "Cancelled";
    const RESULT_CODE_Pending = "Pending";
    const RESULT_CODE_Error = "Error";

    public static $last_error = [];
    public static $last_request = [];

    /**
     * @param User $user
     * @param      $card_encrypted_json
     * @param      $reference
     * @param      $price
     *
     * @return array|mixed
     * @throws AdyenException
     * @throws ChallengeException
     */
    public static function createShopperContract(User $user, $card_encrypted_json, $reference = null,  $price = 0)
    {
        $client = self::getClient();
        $service = new Payment($client);
        $recurring = ['contract' => Contract::RECURRING];

        # Delete all previous payment details
        /*try {
            Adyen::deleteRecurringDetails($user);
        } catch (Exception $e) {

        }*/
        //dd(\URL::current(), strpos(\URL::current(), "testee"));
        \Session::put("urlRedirectAfterAdyen", \URL::current());
        \Session::save();

        //dd(\URL::current());

        if (!$reference) {
            $reference = self::getDefaultReference('card', $user);
        }

        $request = [
            'merchantAccount' => Config::get('adyen.merchant_account'),
            'amount' => [
                'value' => round($price * 100), // Fee is minimum 1€
                'currency' => 'EUR'
            ],
            'reference' => $reference,
            'recurring' => $recurring,
            'additionalData' => [
                'card.encrypted.json' => $card_encrypted_json
            ],
            'shopperEmail' => $user->email,
            'shopperReference' => $user->id,
            'channel' => 'web',
            'allow3DS2' => True,
            //'treeDSAuthenticationOnly' => False,
            'threeDS2RequestData' => [
                'deviceChannel' => "browser",
                //'threeDSCompInd' => 'N',
                'notificationURL' => url('') . '/redirecting',
            ]
        ];

        if ($user->billing_city
            && $user->billing_country
            && $user->billing_number
            && $user->billing_postalcode
            && $user->billing_street) {
            $countries = new Countries();
            $result = $countries->getCountry($user->billing_country);
            $billingCountry = 'ZZ';
            if ($result != null && isset($result['iso2'])) {
                $billingCountry = $result['iso2'];
            }
            $request['billingAddress'] = [
                'city' => $user->billing_city,
                'country' => $billingCountry,
                'houseNumberOrName' => $user->billing_number,
                'postalCode' => $user->billing_postalcode,
                'street' => $user->billing_street
            ];
        }

        if (self::getIp() != "not found"){
            $request['shopperIP'] = self::getIP();
        }

        if ($user->created_at && $user->updated_at){
            $request['accountInfo'] = [
                'accountChangeDate' => str_replace(" ", "T",$user->updated_at),
                'accountCreationDate' => str_replace(" ", "T",$user->created_at)
            ];
        }

        $head = apache_request_headers();
        if (isset($head["Accept"])
            && isset($_COOKIE["colorDepth"])
            && isset($_COOKIE["javaEnabled"])
            && isset($_COOKIE["language"])
            && isset($_COOKIE["screenHeight"])
            && isset($_COOKIE["screenWidth"])
            && isset($_COOKIE["timeZoneOffset"])
            && isset($head["User-Agent"])) {

            $request['browserInfo'] = [
                "acceptHeader" => $head["Accept"],
                "colorDepth" => $_COOKIE["colorDepth"],
                "javaEnabled" => $_COOKIE["javaEnabled"],
                "language" => $_COOKIE["language"],
                "screenHeight" => $_COOKIE["screenHeight"],
                "screenWidth" => $_COOKIE["screenWidth"],
                "timeZoneOffset" => $_COOKIE["timeZoneOffset"],
                "userAgent" => $head["User-Agent"]
            ];

            \Session::put("browserInfo", $request['browserInfo']);

        }

        if (isset($_COOKIE["fingerprint"]) && $_COOKIE["fingerprint"] != ""){
            $request['deviceFingerprint'] = $_COOKIE["fingerprint"];
        }

        # Check if user has already a RecurringDetailReference
        /*$currentPaymentDetail = self::getCurrentPayment($user);

        if ($currentPaymentDetail) {
            $request['shopperInteraction'] = "ContAuth";
            $request['selectedRecurringDetailReference'] = $currentPaymentDetail['recurringDetailReference'];
        }*/

        // used for debuging
        self::$last_error = null;
        self::$last_request = $request;

        $result = null;

        try {
            $result = $service->authorise($request);
        } catch (Exception $exception) {
            \Log::error($exception);
            $result['resultCode'] = Adyen::RESULT_CODE_Refused;
        }

        //Si le result code est IdentifyShopper, on envoie une requête à Adyen pour get la fingerprint pour l'authentification 3DS2
        if (isset($result['resultCode']) && $result['resultCode'] == self::RESULT_CODE_IdentifyShopper) {

            //L'iframe renvoyait jamais rien pendant les tests --> on considère d'office que ça a fail

            /*$dataObj = [
                'threeDSServerTransID' => $result['additionalData']['threeds2.threeDSServerTransID'],
                'threeDSMethodNotificarionURL' => url('') . '/challenge'
            ];
            $encodedcReq = rtrim(str_replace("+", "-", str_replace("/", "_", base64_encode(json_encode($dataObj)))), '=');

            $token = $result['additionalData']['threeds2.threeDS2Token'];
            \Session::put("token", $token);
            \Session::put("mailAdyen", $user->email);
            \Session::put("encodedJSON", $encodedcReq);
            \Session::put("redirectTo", $result["additionalData"]["threeds2.threeDSMethodURL"]);
            \Session::save();

            header("Location: /challenge");*/

            $request = [
                'merchantAccount' => Config::get('adyen.merchant_account'),
                'threeDS2Token' => $result['additionalData']['threeds2.threeDS2Token'],
                'threeDS2RequestData' => [
                    'threeDSCompInd' => 'N'
                ]
            ];

            $result = null;

            try {
                $result = $service->authorise3DS2($request);
            } catch (Exception $exception) {
                \Log::error($exception);
                $result['resultCode'] = Adyen::RESULT_CODE_Refused;
            }

        }

        if(Adyen::hasChallenge($result))
        {
            throw new ChallengeException($result);
        }

        \Log::info('Adyen createShopperContract', $result);

        if (self::isSuccess($result)) {
            $user->status = User::STATUS_ACTIVE;
            $user->billing_card_id = $user->getBillingCardId(true);
            $user->billing_card_number = $user->getBillingCardNumber();
            $user->billing_card_holder = $user->getBillingCardHolderName();
            $user->billing_card_month = $user->getBillingCardExpirationMonth();
            $user->billing_card_year = $user->getBillingCardExpirationYear();
            $user->billing_status = User::BILLING_STATUS_PAID;
            $user->billing_type = User::BILLING_TYPE_ADYEN;
            $user->billing_env = $client->getConfig()->get('environment') == Environment::TEST ? 'sandbox' : 'production';
            $user->billing_method = User::BILLING_METHOD_CREDITCARD;
            $user->billing_iban = "";
            $user->billing_iban_owner = "";
            $user->save();
        }

        return $result;
    }

    public static function hasChallenge($result)
    {
        if (isset($result['resultCode']) && $result['resultCode'] == self::RESULT_CODE_ChallengeShopper) {
            return true;
        }

        if (isset($result['resultCode']) && $result['resultCode'] == self::RESULT_CODE_RedirectShopper) {
            return true;
        }
    }

    public static function manageChallenge(array $result, User $user, $request)
    {
        //Si le result code est ChallengeShopper, le client doit être redirigé vers adyen pour l'authentification 3DS2
        if (isset($result['resultCode']) && $result['resultCode'] == self::RESULT_CODE_ChallengeShopper) {

            $cReqData = [
                'threeDSServerTransID' => $result['additionalData']['threeds2.threeDS2ResponseData.threeDSServerTransID'],
                'acsTransID' => $result['additionalData']['threeds2.threeDS2ResponseData.acsTransID'],
                'messageVersion' => $result['additionalData']['threeds2.threeDS2ResponseData.messageVersion'],
                'challengeWindowSize' => '05',
                'messageType' => 'CReq',
            ];
            $encodedcReq = rtrim(str_replace("+", "-", str_replace("/", "_", base64_encode(json_encode($cReqData)))), '=');

            $request->getSession()->put("encodedcReq", $encodedcReq);
            $token = $result['additionalData']['threeds2.threeDS2Token'];
            $request->getSession()->put("token", $token);
            $request->getSession()->put("redirectTo", $result["additionalData"]["threeds2.threeDS2ResponseData.acsURL"]);
            $request->getSession()->put("mailAdyen", $user->email);
            $request->getSession()->save();

            return "/challenge";
        }

        //Si le result code est RedirectShopper, le client doit être redirigé vers sa banque pour l'authentification 3DS1
        if (isset($result['resultCode']) && $result['resultCode'] == self::RESULT_CODE_RedirectShopper) {

            $request->getSession()->put("PaReq", $result["paRequest"]);
            $request->getSession()->put("MD", $result["md"]);
            $request->getSession()->put("TermUrl", url('')."/redirecting");
            $request->getSession()->put("redirectTo", $result["issuerUrl"]);
            $request->getSession()->put("mailAdyen", $user->email);
            $request->getSession()->save();

            return "/challenge";
        }
    }

    public static function getResult3DS2(User $user, $transStatus)
    {
        $client = self::getClient();
        $service = new Payment($client);
        $token3DS2 = \Session::get('token');

        $request = [
            'merchantAccount' => Config::get('adyen.merchant_account'),
            'threeDS2Result' => ['transStatus' => $transStatus],
            'threeDS2Token' => $token3DS2
        ];

        if (\SESSION::has('browserInfo')){

            $bi = \SESSION::get('browserInfo');

            $request['browserInfo'] = [
                "acceptHeader" => $bi['acceptHeader'],
                "colorDepth" => $bi["colorDepth"],
                "javaEnabled" => $bi["javaEnabled"],
                "language" => $bi["language"],
                "screenHeight" => $bi["screenHeight"],
                "screenWidth" => $bi["screenWidth"],
                "timeZoneOffset" => $bi["timeZoneOffset"],
                "userAgent" => $bi["userAgent"]
            ];

        }


        $result = null;

        try {
            $result = $service->authorise3DS2($request);
        } catch (Exception $exception) {
            \Log::error($exception);
            $result['resultCode'] = Adyen::RESULT_CODE_Refused;
        }

        if (self::isSuccess($result)) {
            $user->status = User::STATUS_ACTIVE;
            $user->billing_card_id = $user->getBillingCardId(true);
            $user->billing_card_number = $user->getBillingCardNumber();
            $user->billing_card_holder = $user->getBillingCardHolderName();
            $user->billing_card_month = $user->getBillingCardExpirationMonth();
            $user->billing_card_year = $user->getBillingCardExpirationYear();
            $user->billing_status = User::BILLING_STATUS_PAID;
            $user->billing_type = User::BILLING_TYPE_ADYEN;
            $user->billing_env = $client->getConfig()->get('environment') == Environment::TEST ? 'sandbox' : 'production';
            $user->billing_method = User::BILLING_METHOD_CREDITCARD;
            $user->billing_iban = "";
            $user->billing_iban_owner = "";
            $user->save();
        }

        return $result;
    }

    public static function getResult3DS1(User $user, $md, $paResponse)
    {
        $client = self::getClient();
        $service = new Payment($client);

        $request = [
            'merchantAccount' => Config::get('adyen.merchant_account'),
            'md' => $md,
            'paResponse' => $paResponse,
        ];

        if (self::getIp() != "not found"){
            $request['shopperIP'] = self::getIP();
        }

        if (\SESSION::has('browserInfo')){

            $bi = \SESSION::get('browserInfo');

            $request['browserInfo'] = [
                "acceptHeader" => $bi['acceptHeader'],
                "colorDepth" => $bi["colorDepth"],
                "javaEnabled" => $bi["javaEnabled"],
                "language" => $bi["language"],
                "screenHeight" => $bi["screenHeight"],
                "screenWidth" => $bi["screenWidth"],
                "timeZoneOffset" => $bi["timeZoneOffset"],
                "userAgent" => $bi["userAgent"]
            ];

        }


        $result = null;

        try {
            $result = $service->authorise3D($request);
        } catch (Exception $exception) {
            \Log::error($exception);
            $result['resultCode'] = Adyen::RESULT_CODE_Refused;
        }

        if (self::isSuccess($result)) {
            $user->status = User::STATUS_ACTIVE;
            $user->billing_card_id = $user->getBillingCardId(true);
            $user->billing_card_number = $user->getBillingCardNumber();
            $user->billing_card_holder = $user->getBillingCardHolderName();
            $user->billing_card_month = $user->getBillingCardExpirationMonth();
            $user->billing_card_year = $user->getBillingCardExpirationYear();
            $user->billing_status = User::BILLING_STATUS_PAID;
            $user->billing_type = User::BILLING_TYPE_ADYEN;
            $user->billing_env = $client->getConfig()->get('environment') == Environment::TEST ? 'sandbox' : 'production';
            $user->billing_method = User::BILLING_METHOD_CREDITCARD;
            $user->billing_iban = "";
            $user->billing_iban_owner = "";
            $user->save();
        }

        return $result;
    }

    public static function getClient()
    {
        $client = new Client();
        $client->setUsername(Config::get('adyen.username'));
        $client->setPassword(Config::get('adyen.password'));
        $client->setApplicationName(Config::get('adyen.application_name'));

        if (Config::get('adyen.test_environment')) {
            $client->setEnvironment(Environment::TEST);
        } else {
            $client->setEnvironment(Environment::LIVE);
        }

        return $client;
    }

    /**
     * Delete old recurring details of the user
     *
     * @param User $user
     * @return mixed
     */
    public static function deleteRecurringDetails(User $user)
    {

        $response = Adyen::getRecurringContract($user, true);

        try {

            if (isset($response['shopperReference'])) {
                $service = self::getRecurringService();
                $data = $service->disable([
                    'merchantAccount' => Config::get('adyen.merchant_account'),
                    "shopperReference" => $response['shopperReference'],
                ]);
            }

        } catch (Exception $e) {
            \Log::info("Error when try to disable recurring details");
            \Log::error($e);
            Api::sendAdminNotification("Error delete Recurring Details " . $e->getMessage());
            return false;
        }

        return $data;
    }

    /**
     * Get recurring contract informations
     *
     * Use request cache
     * @param User $user
     * @param bool $forceCache
     * @return mixed
     */
    public static function getRecurringContract(User $user, $forceCache = false)
    {
        $cache = app('request')->input('adyen_recurring_contracts');

        if (isset($cache[$user->id]) && !$forceCache) {
            return $cache[$user->id];
        }

        $client = self::getClient();
        $service = new Recurring($client);
        $recurring = ['contract' => Contract::RECURRING];

        $request = [
            'merchantAccount' => Config::get('adyen.merchant_account'),
            'shopperReference' => $user->id,
            'recurring' => $recurring
        ];

        $result = $service->listRecurringDetails($request);

        if (!isset($result['resultCode'])) {
            $result['resultCode'] = 'Validate';
        }

        $cache[$user->id] = $result;
        app('request')->merge(['adyen_recurring_contracts' => $cache]);

        return $result;
    }

    /**
     * Get current payment
     * @param $user
     * @return null
     */
    public static function getCurrentPayment($user){
        $result = self::getRecurringContract($user, true);

        if ($result['details'] && isset($result['details'][0], $result['details'][0]['RecurringDetail'])) {
            $detail = $result['details'][0]['RecurringDetail'];
            return $detail;
        }

        return null;
    }

    public static function getRecurringService()
    {
        $client = self::getClient();
        $service = new Recurring($client);
        return $service;
    }

    /**
     * @param $key ("card"|"sepa"|"recurring")
     * @param User $user
     * @return string
     */
    public static function getDefaultReference($key, User $user)
    {
        return $key . '-' . $user->id . '-' . time();
    }

    /**
     * Handle different cases of success (handle pending status too !)
     *
     * @see https://docs.adyen.com/api-explorer/#/Payment/v30/authorise
     * @param $result
     * @return bool
     */
    public static function isSuccess($result)
    {
        if (isset($result['resultCode']) && in_array($result['resultCode'], [
                self::RESULT_CODE_Authorised,
                self::RESULT_CODE_Pending,
                self::RESULT_CODE_Received
            ])) {
            return true;
        }

        return false;
    }

    public static function isReceived($result){

    }

    /**
     * Initialize SEPA payment (order process)
     * @param \App\User $user
     * @param $iban
     * @param $owner
     * @param null $reference
     * @param int $price
     * @return array|mixed
     */
    public static function createShopperSepaContract(User $user, $iban, $owner, $reference = null, $price = 0)
    {
        $client = self::getClient();
        $service = new Payment($client);
        $captureService = new Modification($client);
        $recurring = ['contract' => Contract::RECURRING];

        # Delete all previous payment details
        try {
            Adyen::deleteRecurringDetails($user);
        } catch (Exception $e) {

        }

        if (!$reference) {
            $reference = self::getDefaultReference('sepa', $user);
        }

        $request = [
            'merchantAccount' => Config::get('adyen.merchant_account'),
            'amount' => [
                'value' => $price * 100,
                'currency' => 'EUR'
            ],
            'reference' => $reference,
            'recurring' => $recurring,
            'selectedBrand' => 'sepadirectdebit',
            'bankAccount' => [
                'iban' => $iban,
                'ownerName' => $owner,
                'countryCode' => substr($iban, 0, 2)
            ],
            'shopperEmail' => $user->email,
            'shopperReference' => $user->id
        ];

        try {
            $result = $service->authorise($request);
        } catch (AdyenException $e) {
            \Log::info('Sepa AdyenException');
            \Log::error($e);
            $result = ['resultCode' => 'Refused'];
        }

        if (self::isSuccess($result)) {
            $user->status = User::STATUS_ACTIVE;
            $user->billing_card_id = null;
            $user->billing_card_number = "";
            $user->billing_card_holder = "";
            $user->billing_card_month = "";
            $user->billing_card_year = "";
            $user->billing_status = User::BILLING_STATUS_PAID;
            $user->billing_type = User::BILLING_TYPE_ADYEN;
            $user->billing_env = $client->getConfig()->get('environment') == Environment::TEST ? 'sandbox' : 'production';
            $user->billing_method = User::BILLING_METHOD_SEPA;
            $user->billing_iban = $iban;
            $user->billing_iban_owner = $owner;
            $user->save();

            if ($price !== 0) {
                $captureResponse = $captureService->capture([
                    'merchantAccount' => Config::get('adyen.merchant_account'),
                    'modificationAmount' => [
                        "value" => $price * 100,
                        "currency" => "EUR"
                    ],
                    'originalReference' => $result['pspReference'],
                    'reference' => 'sepa-'.$user->id.'-'.time(),
                ]);
            }
        }

        return $result;
    }

    public static function getPaymentService()
    {
        $client = self::getClient();
        $service = new Payment($client);
        return $service;
    }

    public static function getPayoutService()
    {
        $client = self::getClient();
        $service = new Payout($client);
        return $service;
    }

    /**
     * Make payment
     *
     * @param \App\User $user
     * @param $amount
     * @param null $reference
     * @return array|mixed
     */
    public function makePayment(User $user, $amount, $reference = null)
    {
        return self::makeRecurringPayment($user, $amount, $reference);
    }

    /**
     * Make a payment (invoices cron task)
     *
     * @param \App\User $user
     * @param $amount string in EURO !
     * @param null $reference
     * @return array|mixed
     */
    public static function makeRecurringPayment(User $user, $amount, $reference)
    {
        $client = self::getClient();
        $service = new Payment($client);
        $recurring = ['contract' => Contract::RECURRING];

        $request = [
            'selectedRecurringDetailReference' => 'LATEST',
            'merchantAccount' => Config::get('adyen.merchant_account'),
            'amount' => [
                'value' => $amount * 100,
                'currency' => 'EUR'
            ],
            'reference' => $reference,
            'recurring' => $recurring,
            'shopperEmail' => $user->email,
            'shopperReference' => $user->id,
            'shopperInteraction' => 'ContAuth'
        ];

        # If it's iban => resend iban info to Adyen
        if ($user->isIban()) {

            unset($request['selectedRecurringDetailReference']);

            $request = array_merge($request, [
                'selectedBrand' => 'sepadirectdebit',
                'bankAccount' => [
                    'iban' => $user->billing_iban,
                    'ownerName' => $user->billing_iban_owner,
                    'countryCode' => substr($user->billing_iban, 0, 2)
                ]
            ]);
        }

        try {
            $result = $service->authorise($request);
        } catch (AdyenException $e) {
            \Log::info('Error makeRecurringPayment');
            \Log::error($e);
            $result = ['resultCode' => 'Refused'];
        }

        /**
         * Change payment status of user in case of Error/Success
         */
        if (!self::isSuccess($result) && $user->billing_status == User::BILLING_STATUS_PAID) {
            $user->billing_status = User::BILLING_STATUS_UNPAID;
            $user->save();
        } elseif ($user->billing_status == User::BILLING_STATUS_UNPAID) {
            $user->billing_status = User::BILLING_STATUS_PAID;
            $user->save();
        }

        return $result;
    }

    
    public static function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return "not found"; 
    }

}
