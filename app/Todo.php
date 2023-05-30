<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model {
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
		'assigned_id',
		'type',
		'completed',
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