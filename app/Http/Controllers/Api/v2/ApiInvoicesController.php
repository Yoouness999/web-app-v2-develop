<?php
namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v2\ApiHelper;
use App\Api\v2\ApiInvoice;
use App\Invoice;
use App\User;

class ApiInvoicesController extends Controller {
	/**
	 * Get invoices.
	 *
	 * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
	 * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
	 * @param int $page (optionnal) Current page for pagination.
	 * @param int $items_by_page (optionnal) Items by page for pagination.
	 * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
	 */
	public function get(Request $request) {
		$params = ApiHelper::getParamsFromRequest($request);

        /*if (isset($params['order'], $params['order']['attribute']) && $params['order']['attribute'] == 'number') {
            $params['order']['attribute'] = 'id';
        }*/

		$data = ApiInvoice::get($params);
		return ApiHelper::response($data);
	}

	/**
	 * Add an invoice.
	 *
	 * @param string $number (required) Number.
	 * @param string $title (optionnal) Title.
	 * @param string $content (optionnal) Content.
	 * @param string $price (optionnal) Type.
	 * @param string $user_id (optionnal) Reference.
	 * @param string $item_id (optionnal) Price.
	 * @param string $pickup_id (optionnal) Pickup.
	 * @param string $fee_id (optionnal) Fee.
	 * @param string $status (optionnal) Status: paid, unpaid.
	 * @param boolean $attempt (optionnal) Attempt : 1 or 0.
	 * @param string $payment_date (optionnal) Payment date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $payment_schedule (optionnal) Payment schedule.
	 * @param string $billing_ref (optionnal) Billing reference.
	 * @param string $billing_type (optionnal) Billing type: fee...
	 * @param string $billing_id (required) Billing.
	 * @param boolean $billing_exempted (required) Billing exempted: 1 or 0.
	 * @param string $type (optionnal) Type
	 * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
	 */
	public function add(Request $request) {
		$item = ApiInvoice::add($request->all());

		return ApiHelper::response($item);
	}

    /**
     * Delete an invoice
     *
     * @param int $id (required) Id.
     * @return array
     */
    public function delete(Request $request) {
        $item = ApiInvoice::delete($request->get('id'));

        return ApiHelper::response($item);
    }

	/**
	 * Save an invoice.
	 *
	 * @param int $id (required) Id.
	 * @param string $number (optionnal) Number.
	 * @param string $title (optionnal) Title.
	 * @param string $content (optionnal) Content.
	 * @param string $price (optionnal) Type.
	 * @param string $user_id (optionnal) Reference.
	 * @param string $item_id (optionnal) Price.
	 * @param string $pickup_id (optionnal) Pickup.
	 * @param string $fee_id (optionnal) Fee.
	 * @param string $status (optionnal) Status: paid, unpaid.
	 * @param boolean $attempt (optionnal) Attempt : 1 or 0.
	 * @param string $payment_date (optionnal) Payment date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $payment_schedule (optionnal) Payment schedule.
	 * @param string $billing_ref (optionnal) Billing reference.
	 * @param string $billing_type (optionnal) Billing type: fee...
	 * @param string $billing_id (optionnal) Billing.
	 * @param boolean $billing_exempted (optionnal) Billing exempted: 1 or 0.
	 * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
	 */
	public function save(Request $request) {
		$params = $request->all();
		$id = $params['id'];
		unset($params['id']);

		$item = ApiInvoice::save($id, $params);

		return ApiHelper::response($item);
	}

	public function pdf(Request $request)
    {
		$params = $request->all();
		$id = $params['id'];
        $invoice = Invoice::find($id);

        if ($invoice) {
            $user = User::find($invoice->user_id);

            $aInvoice = [
                'id' => $invoice->id,
                'number' => $invoice->number,
                'orderId' => $invoice->title,
                'date' => $invoice->created_at->format('d/m/Y'),
                'type' => $invoice->type,
                'fee_id' => $invoice->fee_id,
                'status' => $invoice->status,
                'billing_exempted' => $invoice->billing_exempted,
                'devise' => 'EUR',
                'payment' => '',
                'paymentImage' => '',
                'price' => round($invoice->price, 2),
                'amount' => round($invoice->price, 2),
                'invoice_url' => ('?action=download&id=' . $invoice->id),
                'created_at' => $invoice->createdAt,
                'title' => $invoice->title,
                'content' => $invoice->content,
                'customer' => $user->name,
                'billing_to' => $user->billing_to ?: $user->name,
                'billing_address' => $user->billing_to ? $user->billing_address : $user->address,
                'billing_vat' => $user->billing_to ? $user->billing_vat : '',
				'billing_number' => $user->billing_to ? $user->billing_number : $user->number,
				'billing_city' => $user->billing_to ? $user->billing_city : $user->city,
				'billing_street' => $user->billing_to ? $user->billing_street : $user->street,
				'billing_box' => $user->billing_to ? $user->billing_box : $user->box,
				'billing_postalcode' => $user->billing_to ? $user->billing_postalcode : $user->postalcode,
                'format' => $invoice->format,
                'no_vat_price' => $invoice->no_vat_price,
                'no_vat_content' => $invoice->no_vat_content,
			];

            $aInvoice = array_merge($aInvoice, $user->getBillingAddress());
            $forcePrint = true;

            return $this->viewMake('layouts.invoice', get_defined_vars());
        }

        app()->abort(404);
    }
}
