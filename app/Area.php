<?php namespace App;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Area extends Model implements TranslatableContract
{
    public $translatedAttributes = ['name'];

    use Translatable;

    protected $fillable = [
        "slug",
        "zip_code",
        "area_id",
        "region_id",
    ];

    protected $translationForeignKey = 'area_id';


    /**
	 * Area belongs to a region
	 */
	public function region() {
		return $this->belongsTo(Region::class);
	}
}
