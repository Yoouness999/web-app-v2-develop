<?php

namespace App\Api\v2;

use App\Api;
use App\Api\v2\ApiHelper;
use App\Exceptions\PaymentErrorException;
use App\Invoice;
use App\User;
use Exception;

//TODO-HM: check where used and correct for attaemp if nneded
class ApiInvoice
{

    public static function add($params = [])
    {
        if (!isset($params['ref_invoice_id'])) {
            $params['type'] = Invoice::TYPE_SERVICES;
            $params['status'] = Invoice::STATUS_QUEUED;
        }

        $invoice = Invoice::create($params);
        $invoice->total = $invoice->price;
        $invoice->save();
        $invoice->generateNumber(true, false);

        /**
         * Store the credit_note_id ref if ref_invoice_id is mentionned
         */
        if (isset($params['ref_invoice_id'])) {

            $invoice->type = Invoice::TYPE_CREDIT_NOTE;
            $invoice->status = Invoice::STATUS_TO_REFUND;
            $invoice->save();

            $invoice->generateNumber(true, false);

            $invoiceBase = Invoice::find($params['ref_invoice_id']);

            if ($invoiceBase) {
                $invoiceBase->credit_note_id = $invoice->id;
                $invoiceBase->status = Invoice::STATUS_REFUNDED;
                $invoiceBase->save();
                $invoiceBase->generateNumber(true, false);
            }
        } else {
            $invoice->type = Invoice::TYPE_SERVICES;
            $user = $invoice->user;

            if ($user) {
                try {
                    Api::makePayment($invoice->user, $invoice);
                    $invoice->generateNumber(true, true);
                } catch (PaymentErrorException $e) {
                    $invoice->status = Invoice::STATUS_UNPAID;
                    $invoice->generateNumber(true, false);
                } catch (Exception $e) {
                    \Log::error('Error payment');
                    \Log::error($e);
                }
            }
        }

        return $invoice;
    }

    public static function delete($id)
    {
        $item = Invoice::find($id);
        $item->delete();
        return true;
    }

    public static function get($params = [])
    {
        return ApiHelper::get(Invoice::query(), $params);
    }

    public static function save($id, $params = [])
    {
        /**
         * @var $item Invoice
         */
        $item = Invoice::find($id);

        $item = $item->fill($params);
        if(!$item->number || $item->number == '') {
            $item->generateNumber(true, true);
        }
        $item->save();

        return $item;
    }
}
