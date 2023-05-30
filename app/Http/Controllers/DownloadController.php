<?php namespace App\Http\Controllers;

use App\Invoice;
use App\User;
use PDF;

class DownloadController extends Controller
{
    /**
     * Download the pdf
     *
     * @param $id
     */
    public function pdf($id)
    {
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

    public function pdfV2($id)
    {
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

            return $this->viewMake('layouts.invoice', get_defined_vars());

            $pdf = PDF::loadView('layouts.invoice', get_defined_vars());

            return $pdf->download('laratutorials.pdf');
        }

        app()->abort(404);
    }
}
