<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Taxe extends Model {

    protected $fillable = [
        'country_id',
        'value_percentage'
    ];

    public function country(){
        return $this->belongsTo('App\Countries');
    }
}
