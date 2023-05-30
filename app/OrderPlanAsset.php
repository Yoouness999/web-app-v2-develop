<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class OrderPlanAsset extends Model {

	use Translatable;

	public $translatedAttributes = ['name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'name'
    ];

    public static function getDefaultAssets()
    {
        return self::query()->where('default', 1)->get();
    }

    public function toArray()
    {
        $data = parent::toArray();
        $data['name'] = $this->name;
        return $data;
    }

    /**
     * Extends toArray method for the Api
     *
     * @return array
     */
    public function toArrayApi($deep = 1) {
        $data = $this->toArray();

        return $data;
    }
}
