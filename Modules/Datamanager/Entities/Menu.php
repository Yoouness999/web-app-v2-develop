<?php namespace Modules\Datamanager\Entities;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'uri',
        'url',
        'post_id',
        'status',
        'ref',
        'lang',
        'primary',
        'parent_id'
    ];

    protected $guarded = [];
}
