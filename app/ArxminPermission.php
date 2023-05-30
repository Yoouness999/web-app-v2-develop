<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Api\ApiToken;
use Datetime;
use App\Api\ApiApp;

class ArxminPermission extends Model
{
    protected $fillable = [
        'slug'
    ];
}
