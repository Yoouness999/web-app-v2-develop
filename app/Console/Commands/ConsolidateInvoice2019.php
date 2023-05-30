<?php namespace App\Commands;


use App\Invoice;

class ConsolidateInvoice2019 extends Command{

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
        $invoices = Invoice::where('created_at', '>', '2019-01-01 00:00:00')->where('created_at', '<', '2020-01-01 00:00:00')->where('type', '!=', Invoice::TYPE_CREDIT_NOTE)->orderBy('id', 'asc')->get();

        $data = [];

        $i = 1;

        foreach ($invoices as $invoice) {

            $data[] = [
                'id' => $invoice->id,
                'old_numerotation' => $invoice->number,
                'new_numerotation' => "19/W".str_pad($i, 4,"0", STR_PAD_LEFT)
            ];

            if (isset($_GET['confirm'])) {
                $invoice->number = "19/W".str_pad($i, 4,"0", STR_PAD_LEFT);
                $invoice->save();
            }

            $i++;
        }

        cp_html_table($data, true, true);
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		//
	}

}
