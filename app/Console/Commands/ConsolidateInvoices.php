<?php namespace App\Commands;


use App\Invoice;

class ConsolidateInvoices extends Command
{

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {


    }

    public function __consolidate2017(){

        $oldInvoices = \DB::connection("old")->table("invoices")->get();

        $oldInvoicesData = [];

        foreach ($oldInvoices as $i) {
            $oldInvoicesData[$i->id] = $i;
        }

        // Check invoices of 2017 and fix them
        $invoices = Invoice::query()->where('id', '<', 355)->get();

        $logs = [];

        foreach ($invoices as $invoice) {
            if (preg_match('/18\/W/i', $invoice->number)) {
                if (isset($oldInvoicesData[$invoice->id])) {

                    $oldNumber = $oldInvoicesData[$invoice->id]->number;

                    if (preg_match('/(.*)\/W(.*)/', $oldNumber, $matches)) {

                        $oldNumber = $matches[1] . '/W' . str_pad($matches[2], 4, '0', STR_PAD_LEFT);
                        $logs[] = $invoice->number . ' renamed in ' . $oldNumber;
                        $invoice->number = $oldNumber;

                        if (isset($_GET['confirm'])) {
                            $invoice->save();
                        }

                    } else {
                        $logs[] = $invoice->number . ' not recognised in ' . $oldNumber;
                    }
                }
            }
        }

        ddd($logs, $oldInvoicesData, $invoices->toArray());
    }

}
