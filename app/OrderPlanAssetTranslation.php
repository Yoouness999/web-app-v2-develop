<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;
use Lang;

class OrderPlanAssetTranslation extends Model {
    public $timestamps = false;
    protected $fillable = ['name'];
}
