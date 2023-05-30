<?php namespace App;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class AreaTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
}
