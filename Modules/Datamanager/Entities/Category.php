<?php namespace Modules\Datamanager\Entities;


use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'ref',
        'lang',
        'parent_id',
    ];

    public function posts(){
        return $this->belongsToMany(Post::class);
    }
}
