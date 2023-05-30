<?php

return array(
    "follow_up_pickup" => [
        'price' => '19',
        'description' => "Follow up (second) pickup charge (if you need more than one pick up)"
    ],
    "delivery" =>[
        'price' => '29',
        'description' => "Delivery charge fee (per trip)"
    ],
    "stored_box" => [
        'price' => '35',
        'description' => "Purchase price per box ordered but not shipped back and stored"
    ],
    "destruction_fee" => [
        'price' => '10',
        'description' => "Destruction fee (per box)"
    ],
    'one_time_administration_fee' => [
        'price' => '10',
        'description' => "One-time delinquent account admin fee (levied on 14th day past due)"
    ],
    'monthly_time_administration_fee' => [
        'price' => '10',
        'description' => "Monthly delinquent account admin fee (levied from 30th day past due onward)"
    ],
    'no_show' => [
        'price' => '35',
        'description' => "No show at delivery or pickup appointment "
    ],
    'inability_access' => [
        'price' => '19',
        'description' => "Inability to access the delivery address "
    ],
    '2_attempt_fee' => [
        'price' => 15,
        'description' => "one-time delinquent account admin fee (levied on 7th day past due)"
    ],
    '3_attempt_fee' => [
        'price' => 15,
        'description' => "one-time delinquent account admin fee (levied on 14th day past due)"
    ],
    '4_attempt_fee' => [
        'price' => 15,
        'description' => "one-time delinquent account admin fee (levied on 21st day past due)"
    ],
    '5_attempt_fee' => [
        'price' => 20,
        'description' => "one-time delinquent account admin fee (levied 1 month past due)"
    ],
    '6_attempt_fee' => [
        'price' => 20,
        'description' => "one-time delinquent account admin fee (levied on 28th day past due)"
    ],
    '%6_attempt_fee' => [
        'price' => 65,
        'description' => "monthly administration fee for an account in default of payment"
    ]
);
