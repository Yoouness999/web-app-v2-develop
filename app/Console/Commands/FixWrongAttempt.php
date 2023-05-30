<?php namespace App\Commands;

use App\Commands\Command;

use App\Invoice;
use Carbon\Carbon;

class FixWrongAttempt extends Command
{

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $data = [];

        $invoices = Invoice::where('attempt', '>', 0)->where('last_attempt_at', '>', "2018-06-01")->where('created_at', '>', '2018-06-07')->where('status', Invoice::STATUS_UNPAID)->get();

        /**
         * @var $invoice Invoice
         */
        foreach ($invoices as $invoice) {
            # Calculate the diff
            $currentDate = new Carbon();
            $diffMonths = $currentDate->diffInMonths($invoice->created_at);
            $diffDays = $currentDate->diffInDays($invoice->created_at);

            $fees = 0;
            $attempt = 1;

            // Count number of fees applied
            $fees_attempt = substr_count($invoice->content, 'admin fee') + substr_count($invoice->content, 'administration fee');

            if ($diffMonths > 0) {
                $fees = $diffMonths * 65;
                $attempt = 4 + $diffMonths;
            } else {
                if ($diffDays < 7 && $diffDays >= 3) {

                } elseif ($diffDays < 14 && $diffDays >= 7) {
                    $fees = 15;
                    $attempt = 2;
                } elseif ($diffDays < 21 && $diffDays >= 14) {
                    $fees = 30;
                    $attempt = 3;
                } elseif ($diffDays < 31 && $diffDays >= 21) {
                    $fees = 45;
                    $attempt = 4;
                }
            }

            $remove_fees = 0;

            if ($fees_attempt == 0) {
                $action = "Add fees +".$fees;
            } elseif ($fees_attempt == 1) {
                $action = "- remove old fees 15€".' add fees '.$fees;
                $remove_fees = 15;
            } elseif ($fees_attempt == 2) {
                $action = "- remove old fees 20€".' add fees '.$fees;
                $remove_fees = 20;
            } elseif ($fees_attempt == 3) {
                $action = "- remove old fees 30€".' add fees '.$fees;
                $remove_fees = 30;
            } elseif ($fees_attempt == 4) {
                $action = "- remove old fees 50€".' add fees '.$fees;
                $remove_fees = 50;
            }

            $item = [];
            $item['id'] = $invoice->id;
            $item['number'] = $invoice->number;
            $item['type'] = $invoice->billing_type;
            $item['user_id'] = $invoice->user_id;
            $item['created_at'] = $invoice->created_at;
            $item['last_attempt'] = $invoice->last_attempt_at;
            $item['content'] = $invoice->content;
            $item['status'] = $invoice->status;
            $item['diff_months'] = $diffMonths;
            $item['diff_days'] = $diffDays;
            $item['current_attempt'] = $invoice->attempt;
            $item['fees_number'] = $fees_attempt;
            $item['correct_attempt'] = $attempt;
            $item['current_price'] = $invoice->price;
            $item['fees_to_remove'] = $remove_fees;
            $item['correct_fees'] = $fees;

            $action = '<span style="color:red">!!To check manually!!</span>';

            $item['action'] = $action;

            $data[] = $item;
        }

        header('Content-type: text/html; charset=utf-8');
        cp_html_table($data, true, true);

        echo count($data);
    }

}
