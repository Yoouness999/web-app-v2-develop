<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;
use Lang;

class OrderCalculatorCategoryTranslation extends Model {
    public $timestamps = false;
    protected $fillable = ['name'];
    protected $table = "order_calculator_category_translations";
}
