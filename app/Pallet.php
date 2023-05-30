<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Pallet extends Model
{
    protected $table = 'pallet';

    protected $fillable = [
       'created_at',
       'updated_at',
       'zone_id',
       'qr_code'
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

    /**
     * Pallet belongs to zone
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}