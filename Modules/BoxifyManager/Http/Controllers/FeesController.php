<?php namespace Modules\Boxifymanager\Http\Controllers;

use App\Api;
use App\Fee;
use App\Invoice;
use App\User;
use Braintree\Customer;
use Braintree\Transaction;
use Input;
use Lang;
use Pingpong\Modules\Routing\Controller;
use Request;

class FeesController extends Controller
{

    public function index()
    {
        return view('boxifymanager::index');
    }

    /**
     * Create a new Log
     */
    public function anyCreate()
    {
        global $user;
        \Eloquent::unguard();
        $data = Input::all();

        $name = Lang::get('fees.' . $data['ref'] . '.description');

        $data['name'] = $name;

        $fee = Fee::create($data);

        // Add fee to Braintree Account
        $user = User::find($data['user_id']);

        if ($user->hasBillingInfo()) {

            if($user->billing_env == "production"){


                $comment = s(__('invoice.description.fee'), ['fee' => $fee->toArray()]);

                $result = $user->chargeMoney(number_format(round($data['price'], 2), 2), $comment);

                $fee->save();

                $invoice = new Invoice();
                $invoice->type = Invoice::TYPE_FEE;

                $invoice->content = s(__("description.fee", 'invoice'), [
                    'fee' => $fee->toArray(),
                ]);

                $invoice->price = $data['price'];
                $invoice->content = $comment;
                $invoice->user_id = $user->id;
                $invoice->fee_id = $fee->id;

                if($result->lwError){
                    $invoice->status = Invoice::STATUS_UNPAID;
                } else {
                    $invoice->status = Invoice::STATUS_PAID;
                }

                $invoice->save();
                $invoice->generateNumber(true, true);
                $invoice->title = $invoice->number;
                $invoice->save();

            }
        }

        if (Request::isJson()) {
            return $fee->toArray();
        }

        return redirect(moduleUrl('users/crud?tab=fees&modify=' . $user->id))->with('notify', 'Log added');
    }

}
