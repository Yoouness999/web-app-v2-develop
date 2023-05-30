<?php

namespace App\Api\v3;

use App\Api\v3\ApiHelper;
use App\Invoice;

class ApiInvoice
{

    public static function get($params = [])
    {
        return ApiHelper::get(Invoice::query(), $params);
    }
}