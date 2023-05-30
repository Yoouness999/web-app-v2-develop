<?php namespace App\Contracts;

use App\Exceptions\PaymentErrorException;
use App\User;

/**
 * Interface PaymentProviderInterface
 *
 * Methods that must implements any PaymentProvider interface
 *
 * @package App\Contracts
 */
interface PaymentProviderContract {
    /**
     * Must return the instanciated Client
     *
     * @return mixed
     */
    static function getClient();

    /**
     * Must handle the user info and amount payment
     *
     * @param User $user
     * @param $amount
     * @param null $reference
     * @return mixed
     */
    public function makePayment(User $user, $amount, $reference = null);
}