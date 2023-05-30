<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class OrderPlanTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
}
