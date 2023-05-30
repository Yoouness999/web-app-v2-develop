<?php namespace App\Exceptions;

use Exception;

/**
 * Class PaymentErrorException
 *
 * Any PaymentProvider must return a PaymentErrorException
 *
 * @package App\Exceptions
 */
class ChallengeException extends Exception
{
    private array $result;

    public function __construct(array $result)
    {
        parent::__construct();
        $this->result = $result;
    }

    public function getResult(): array
    {
        return $this->result;
    }
}
