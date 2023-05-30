<?php namespace App;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Region extends Model {

    public $translatedAttributes = ['name'];

    protected $fillable = [
        'name',
    ];

    use Translatable;

    /**
     * Region has many areas
     */
    public function areas(){
        return $this->hasMany(Area::class);
    }

	/**
	 * Get default region
	 */
	public static function getDefaultRegion() {
		return Self::limit(1)->first();
	}
}
