<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Historical extends Model {

    use SoftDeletes;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'historical_category_id',
        'title',
        'description',
        'created_at',
        'updated_at'
    ];

	/**
     * Get the category that owns the historical.
     */
    public function category()  {
        return $this->belongsTo(HistoricalCategory::class, 'historical_category_id');
    }

	/**
     * Extends toArray method for the Api
     *
     * @return array
     */
    public function toArrayApi($deep = 1) {
        $data = $this->toArray();
		$data['category'] = $this->category()->first();

        return $data;
    }
}
