<?php
namespace App\Api\v2;

use App\Api;
use App\Api\v2\ApiHelper;
use App\Fee;
use App\Invoice;
use App\User;
use Exception;

//TODO-HM: check where used and correct for attaemp if nneded
class ApiFee {
	public static function get($params = []) {
		return ApiHelper::get(Fee::query(), $params);
	}

    /**
     * Add a fee
     *
     * @param array $params
     * @return Invoice
     */
	public static function add($params = []) {
		$fee = Fee::create($params);

		$fee->save();

        $user = User::find($params['user_id']);

        $comment = shortcode(lg('invoice.description.fee'), ['fee' => $fee->toArray()]);

        $invoice = new Invoice();
        $invoice->type = Invoice::TYPE_FEE;
        if ($user->isIban()) {
            $invoice->billing_method = 'sepa';
        } else {
            $invoice->billing_method = 'creditcard';
        }
        
        $invoice->content = shortcode(lg("description.fee", 'invoice'), [
            'fee' => $fee->toArray(),
        ]);

        $invoice->price = $params['price'];
        $invoice->content = $comment;
        $invoice->user_id = $user->id;
        $invoice->fee_id = $fee->id;
        $invoice->save();
        $invoice->total = $invoice->price + $invoice->no_vat_price;
        if ($invoice->total < 0) {
            $invoice->total = 0;
        }
        $invoice->save();
        
        if ($user->hasBillingInfo()) {

            try {

                Api::makePayment($user, $invoice);
				$invoice->payment_date = date('Y-m-d H:i:s');

            } catch (Exception $e) {
                $invoice->attempt = 1;
                $invoice->last_attempt_at = date('Y-m-d H:i:s');
            }

        } else {
            $invoice->status = Invoice::STATUS_UNPAID;
        }

        $invoice->save();

        $invoice->generateNumber();

		return $invoice;
	}
}
