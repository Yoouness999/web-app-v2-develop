<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UnavailableDate extends Model {

    protected $table = "unavailable_dates";

    protected $fillable = [
      "date"
    ];
}