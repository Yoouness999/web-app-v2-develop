<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'slug',
        'user_id',
        'detail_json'
    ];

    /**
     * Extends toArray method for the Api
     *
     * @return array
     */
    public function toArrayApi()
    {
        $data = $this->toArray();

        return $data;
    }
}
