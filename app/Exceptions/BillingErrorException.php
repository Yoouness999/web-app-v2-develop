<?php namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Class PaymentErrorException
 *
 * Any PaymentProvider must return a PaymentErrorException
 *
 * @package App\Exceptions
 */
class BillingErrorException extends Exception
{
    public function __construct($message = '', $code = 500, Throwable $previous = null){

        if (empty($message)) {
            $message = lg('validation.custom.payment.error');
        }

        parent::__construct($message, $code, $previous);
    }
}
