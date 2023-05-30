<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = [
        'ref',
        'name',
        'country',
        'city',
        'number',
        'street',
        'latitude',
        'longitude',
        'created_at',
        'updated_at',
    ];

    /**
     * Extends toArray method for the Api
     *
     * @return array
     */
    public function toArrayApi()
    {
        $data = $this->toArray();

        return $data;
    }
}
