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
        'description' => "Administratieve kosten van niet-betaling na 7 dagen"
    ],
    '3_attempt_fee' => [
        'price' => 15,
        'description' => "Administratieve kosten van niet-betaling na 14 dagen"
    ],
    '4_attempt_fee' => [
        'price' => 15,
        'description' => "Administratieve kosten van niet-betaling na 21 dagen"
    ],
    '5_attempt_fee' => [
        'price' => 20,
        'description' => "administratieve kosten van niet-betaling na 1 maand"
    ],
    '6_attempt_fee' => [
        'price' => 20,
        'description' => "administratieve kosten van niet-betaling na 1 maand"
    ],
    '%6_attempt_fee' => [
        'price' => 65,
        'description' => "maandelijkse administratiekosten voor een account bij gebreke van betaling"
    ]
);
