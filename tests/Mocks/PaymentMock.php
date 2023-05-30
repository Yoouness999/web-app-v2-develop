<?php

class PaymentMock
{
    /**
     * Payment success format
     */
    public static function success($data = []){
        return (object)['data' => $data];
    }

    /**
     * Payment error format
     */
    public static function error($data = []){
        return (object)['errors' => $data];
    }
}