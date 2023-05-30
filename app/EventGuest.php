<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventGuest extends Model {

    protected $table = "events_guests";

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
		'user_id',
		'user_type',
		'accept',
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
