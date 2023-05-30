<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $table = 'zone';

    protected $fillable = [
        'qrcode',
        'line',
        'rack',
        'space',
        'level',
        'warehouse_id',
        'created_at',
        'updated_at',
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
     * Zone belongs to warehouse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}