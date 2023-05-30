<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class OrderCalculatorItem extends Model
{
    use Translatable;

    public $translatedAttributes = ['name'];

    protected $fillable = [
        'order_calculator_category_id',
        'slug',
        'area_m2',
        'volume_m3',
        'price',
        'image'
    ];

    protected $casts = [ 'volume_m3' => 'string' ];


    ////////////////////
    // Relationships
    ////////////////////

    public function category()
    {
        return $this->belongsTo(OrderCalculatorCategory::class);
    }

    /**
     * Extends toArray method for the Api
     *
     * @return array
     */
    public function toArrayApi($deep = 1)
    {
        $data = $this->toArray();
        
        $data['name'] = $this->name;

        if ($data['image']) {
            $data['image'] = url($data['image']);
        }

        return $data;
    }
}
