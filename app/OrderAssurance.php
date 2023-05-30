<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class OrderAssurance extends Model {

	use Translatable;

	public $translatedAttributes = ['name'];

    protected $table = "order_assurances";

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
		'price_per_month',
		'on_demand',
    ];

    public function getPricePerMonth()
    {
        return $this->price_per_month;
    }

    /**
     * Extends toArray method for the Api
     *
     * @return array
     */
    public function toArrayApi($deep = 1)
    {
        $data = $this->toArray();

        return $data;
    }
}
