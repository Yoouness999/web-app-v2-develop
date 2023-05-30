<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class OrderCalculatorCategory extends Model
{
    use Translatable;

    public $translatedAttributes = ['name'];

    protected $fillable = [
        "slug",
        "name",
        "image",
    ];

    ////////////////////
    // Relationships
    ////////////////////

    public function items()
    {
        return $this->hasMany(OrderCalculatorItem::class);
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

    public function toArray()
    {

        $data = parent::toArray();

        if ($data['image']) {
            $data['image'] = url($data['image']);
        }

        return $data;

    }
}
