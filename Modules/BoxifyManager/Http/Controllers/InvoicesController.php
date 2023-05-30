<?php namespace Modules\Boxifymanager\Http\Controllers;

use App\Invoice;
use App\User;
use Arxmin\helpers\DatacrudHelper;
use Arxmin\helpers\DatagridHelper;
use DataFilter;
use Input;

class InvoicesController extends BaseController {

	public function anyIndex(){

		$title = 'Invoices manager';
		$filter = DataFilter::source(Invoice::orderBy('updated_at'));
		//simple where with exact match
		$filter->add('id', 'Search by ID', 'text')->clause('where')->operator('=');
		$filter->submit('search');
		$filter->reset('reset');

		$grid = DatagridHelper::source($filter);

		$grid->title = '';

		$grid->add('<a href="invoices/crud?modify={{ $id }}">{{ $id }}</a>', trans("id"));
		$grid->add('<a href="invoices/crud?modify={{ $id }}">{{ $number }}</a>', trans("N°"));
		$grid->add('<a href="invoices/crud?download={{ $id }}&action=download" target="_blank"><i class="fa fa-download"></i></a>', trans("Download"));
		$grid->add('<a href="'.moduleUrl('users/crud?modify=').'{{ $user_id }}" target="_blank">{{ $user_id }}</a>', trans("User"));
		$grid->add('{{ $status }}', trans("Status"));
		$grid->add('{{ $title }}', trans("Title"));
		$grid->add('{{ $created_at }}', trans("Created date"));
		$grid->addActions(moduleUrl("invoices/crud"), trans("Actions"));

		return $this->viewMake('boxifymanager::invoices-index', get_defined_vars());
	}


	public function anyCrud(){

		if (request()->has('show')) {
			$source = Invoice::find(request()->get('show'));
		} elseif (request()->has('modify')) {
			$source = Invoice::find(request()->get('modify'));
		} elseif (request()->has('download')) {

			$invoice = Invoice::find(request()->get('download'));

            $user = User::find($invoice->user_id);

            $aInvoice = array_merge([
                'id' => $invoice->id,
                'number' => $invoice->number,
                'orderId' => $invoice->title,
                'date' => $invoice->created_at->format('d/m/Y'),
                'type' => $invoice->type,
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
            ], $user->getBillingAddress());

            return $this->viewMake('layouts.invoice', get_defined_vars());
		} elseif (request()->has('delete')) {
			$source = Invoice::find(request()->get('delete'));
			$source->delete();
			return redirect(moduleUrl('invoices'));
		} else {
			$source = new Invoice;
		}

		$title = '';

		$form = DatacrudHelper::source($source);

		foreach ($source->getFillable() as $key) {
			$form->add($key, trans($key), 'text');
		}

        $form->add('payment_date', trans("Expiration date"), 'datetime');
        $form->add('created_at', trans("Created at"), 'datetime');
        $form->add('updated_at', trans("Updated at"), 'datetime');
        $form->add('payment_schedule', trans("Expiration date"), 'date');

		$form->link(moduleUrl('invoices'), trans("Back"), "TR")->back();

		return $this->viewMake('arxmin::shared.datacrud', get_defined_vars());
	}

}
