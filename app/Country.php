<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $table = "countries";

    protected $fillable = [
        'slug'
    ];

    public function taxe()
    {
        return $this->hasOne('App\Taxe');
    }

    public function toArray()
    {
        $data = parent::toArray();
        $data['tax'] = $this->taxe->value_percentage;

        $countries = \Lang::get('countries');

        if (isset($countries[$data['slug']], $countries[$data['slug']]['name'])) {
            $data['name'] = $countries[$data['slug']]['name'];
        } else {
            $data['name'] = $data['slug'];
        }

        return $data;
    }
}
