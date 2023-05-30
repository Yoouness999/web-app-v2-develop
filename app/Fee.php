<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model {

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'content',
        'user_id',
        'item_id',
        'type',
        'ref',
        'price',
        'nb',
        'status',
        'created_at',
        'updated_at'
    ];

}
