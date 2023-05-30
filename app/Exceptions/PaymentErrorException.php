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
class PaymentErrorException extends Exception
{
    private $result;

    public function __construct($message = '', $result = null, $code = 500, Throwable $previous = null){

        $this->result = $result;

        if (empty($message)) {
            $message = lg('validation.custom.payment.error');
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return mixed|null
     */
    public function getResult()
    {
        return $this->result;
    }
}
