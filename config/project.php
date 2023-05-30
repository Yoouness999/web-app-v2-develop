<?php

/**
 * Keep project configuration in one place so it's easier to change some params for the customer
 */
return array(
    "name" => "Boxify",
    "admin_name" => "<b>Boxify</b> <sup>beta</sup>",
    "godfather_coupon_discount" => "10",
    "godfather_coupon_discount_type" => "%",
    "godson_coupon_discount" => "10",
    "godson_coupon_discount_type" => "%",
    "adyen_switch_date" => env('ADYEN_SWITCH_DATE', "2018-04-16"),
    "busy_dates" => [
        "2018-05-21",
        "2018-07-21",
        "2018-08-15",
        "2018-11-01",
        "2018-11-11",
        "2018-12-25",
        "2019-01-01",
        "2019-04-22",
        "2019-05-01",
        "2019-05-30",
        "2019-06-10",
        "2019-07-21",
        "2019-08-15",
        "2019-11-01",
        "2019-11-11",
        "2019-12-25",
    ],
    "pricing_dates" => [
        "regular-days" => [
            "range1" => 20, // + 7 days
            "range2" => 40, // 5-6 days
            "range3" => 60, // 2-4 days
            "range4" => 80, // 1-2 days
            "range5" => 250, // 0 days
        ],
        "busy-days" => [
            "range1" => 40, // + 7 days
            "range2" => 80, // 5-6 days
            "range3" => 120, // 2-4 days
            "range4" => 160, // 1-2 days
            "range5" => 350, // 0 days
        ],
    ],
    "payment_attempts" => [ // /!\ See also PaymentAttemptHandler => cannot be automatized !!!
        '0 day',
        '7 days',
        '14 days',
        '21 days',
        '-1 month',
    ]
);
