<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
		'location',
		'date',
		'notes',
    ];
	
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