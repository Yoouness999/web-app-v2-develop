<?php namespace App\Contracts;

/**
 * Interface PayableInterface
 *
 * Used for the Api::makePayment process
 *
 * @package App\Contracts
 */
interface PayableInterface {
    /**
     * Must implements a price method
     *
     * @return mixed
     */
    public function getPrice();

    /**
     * Must have an id
     * @return mixed
     */
    public function getId();


    /**
     * Must return a ref
     *
     * @return mixed
     */
    public function getRef();

    /**
     * Payable interface must have a save
     *
     * @return mixed
     */
    public function save();
}
