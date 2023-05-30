<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoricalCategory extends Model {

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'created_at',
        'updated_at'
    ];
	
	/**
     * Get the historicals for the category.
     */
    public function historicals() {
        return $this->hasMany(Historical::class);
    }
	
	/**
     * Extends toArray method for the Api
     *
     * @return array
     */
    public function toArrayApi($deep = 1) {
        $data = $this->toArray();

		$data['historicals'] = $this->historicals()->get();

        return $data;
    }
}
