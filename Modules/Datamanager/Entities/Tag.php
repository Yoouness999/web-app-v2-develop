<?php namespace Modules\Datamanager\Entities;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'ref',
        'lang',
    ];

    public function posts(){
        return $this->belongsToMany(Post::class);
    }
}