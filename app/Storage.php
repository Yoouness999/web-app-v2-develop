<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $table = 'storages';

    protected $fillable = [
        'qrcode',
        'type',
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
     * Storage belongs to warehouse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
