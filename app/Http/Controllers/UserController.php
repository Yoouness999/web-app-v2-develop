<?php namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Lang;
use Hash;
use Config;

class UserController extends Controller
{
    protected $layout = "layouts.default";

    /**
     * Index page
     *
     * @return View [type] [description]
     */
    public function anyIndex()
    {
        // For now it's information that is called => need to check with Ilan
        return $this->anyInformation();
    }

    /**
     * Information page
     *
     * @return View [type] [description]
     */
    public function anyInformation()
    {
        $user = auth()->user();

        if (request()->has('first_name')) {
            $user->first_name = request()->get('first_name');
            $user->last_name = request()->get('last_name');
            $user->phone = request()->get('phone');
            $user->save();

            $this->notify(lg("Data saved"));
        }

        return $this->viewMake('user.information', get_defined_vars());
    }

    /**
     * Billing page
     *
     * @return View [type] [description]
     */
    public function anyBilling()
    {
        /**
         * @var $user \App\User
         */
        $user = auth()->user();
        $error = null;

        if (request()->has('card_name')) {
            try {
                if (request()->get('payment_type') == 'credit_card') {
                    $result = $user->updateBillingInfo(request()->get('adyen_card_encrypted_json'));
                } else {
                    $result = $user->updateSepaBillingInfo(request()->get('iban'), request()->get('iban_owner'));
                }

                return $this->viewMake('user.confirm', get_defined_vars());
            } catch (Exception $e) {
                \Log::error($e);
                $error = lg("common.card-encryption-error");
            }
        }

        $paymentInfo = [
            'card_number' => $user->getBillingCardNumber(),
            'card_name' => $user->getBillingCardHolderName(),
            'card_expiration_month' => $user->getBillingCardExpirationMonth(),
            'card_expiration_year' => $user->getBillingCardExpirationYear(),
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

        $startYear = $date->format('Y');
        $endYear = $startYear + 30;

        return $this->viewMake('user.billing', get_defined_vars());
    }

    /**
     * Invoices page
     *
     * @param User $user
     * @param Request $request
     * @return View [type] [description]
     */
    public function anyInvoices(Request $request)
    {
        $user = auth()->user();
        $invoices = $user->getInvoices();

        if ($request->has('download')) {
            $aInvoice = $invoices[$request->get('download')];
            return $this->viewMake('layouts.invoice', get_defined_vars());
        }

        return $this->viewMake('user.invoices', get_defined_vars());
    }

    /**
     * Manager page
     *
     * @TODO - remove this is favor to ProfileController@yield('subcontent')
     * @return View
     */
    public function anyManager()
    {
        javascript()->namespace('__app')->set('labels', Lang::get('manager'));
        javascript()->namespace('__app')->set('cities', Lang::get('cities'));
        javascript()->namespace('__app')->set('types', Lang::get('types'));

        // Put min pickup date
        javascript()->namespace('__app')->set('minPickupDate', date('Y-m-d', strtotime('+2 days')));

        return $this->viewMake('user.manager', get_defined_vars());
    }

    /**
     * Password page
     * @param Request $request
     * @return View
     */
    public function anyPassword(Request $request)
    {
        $user = auth()->user();

        if (request()->has(['password_current', 'password'])) {
            # Check if current password is correct
            if (Hash::check($request->get('password_current'), $user->password)) {
                if ($request->get('password') == $request->get('password_confirm')) {
                    $user->password = bcrypt($request->get('password'));
                    $user->save();
                    $notification = ['type' => 'success', 'msg' => lg("Password saved")];
                } else {
                    $notification = ['type' => 'danger', 'msg' => lg("Password confirmation didn't match", 'error')];
                }
            } else {
                $notification = ['type' => 'danger', 'msg' => lg("Current password didn't match", 'error')];
            }
        }

        return $this->viewMake('user.password', get_defined_vars());
    }

    /**
     * Pickup page
     *
     * @return View
     */
    public function anyPickup()
    {
        /**
         * @var $user User
         */
        $user = auth()->user();

        javascript()->namespace('__app')->set('labels', Lang::get('pickup'));
        javascript()->namespace('__app')->set('cities', Lang::get('cities'));

        // Put min pickup date
        javascript()->namespace('__app')->set('minPickupDate', date('Y-m-d', strtotime('+2 days')));

        // Add billing info if is already defined
        $paymentInfo = [
            'card_number' => $user->getBillingCardNumber(),
            'card_name' => $user->getBillingCardHolderName(),
            'card_expiration_month' => $user->getBillingCardExpirationMonth(),
            'card_expiration_year' => $user->getBillingCardExpirationYear(),
            'iban' => $user->getBillingIban(),
            'iban_owner' => $user->getBillingIbanOwnerName(),
            'balance' => 0
        ];

        javascript()->namespace('__app')->set('billingInfo', $paymentInfo);

        // Put minimum postalcode
        javascript()->namespace('__app')->set('formData', [
            'payment_type' => 'credit_card',
            'postalcode' => $user->postalcode,
            'street' => null,
            'pickup_option' => 'direct'
        ]);

        javascript()->namespace('__app')->set('adyenClientEncryptionPublicKey', Config::get('adyen.client_encryption_public_key'));
        javascript()->namespace('__app')->set('adyenGenerationtime', date('c'));

        return $this->viewMake('user.pickup', get_defined_vars());
    }
}
