<?php

namespace App;

use App\Traits\TranslatableExtended;
use Illuminate\Database\Eloquent\Model;
use Modules\Datamanager\Traits\ModelFilesHandlingTrait;

class OrderPlan extends Model
{
    use modelFilesHandlingTrait;

    static $currentPath = 'files';
    public static $filepath = null;

    public $translatedAttributes = ['name'];

    use TranslatableExtended;

    protected $fillable = [
        "order_plan_category_id",
        "slug",
        "name",
        "volume_m3",
        "price_per_month",
        "image",
        "visible",
    ];

    protected $casts = [
        'price_per_month' => "float",
        "visible" => "boolean"
    ];

    ////////////////////
    // Relationships
    ////////////////////

    public static function getByVolume($volume, $visibleOnly = false)
    {
        if ($visibleOnly) {
            $plan = self::where('volume_m3', '>=', $volume)->where('visible', "1")->orderby('volume_m3', 'asc')->first();
        } else {
            $plan = self::where('volume_m3', '>=', $volume)->where('price_per_month', '!=', 0)->orderby('volume_m3', 'asc')->first();
        }

        /* If none plan found, get the bigger one */
        if (!$plan) {
            $plan = self::orderby('volume_m3', 'desc')->first();
        }

        return $plan;
    }

    public function getPricePerMonth()
    {
        return $this->price_per_month;
    }

    public function getPricePerPostalcode($postalCode){

        $price = $this->getPricePerMonth();

        $area = Area::where('zip_code', $postalCode)->first();

        if ($area) {

            $orderPlanRegion = OrderPlanRegion::where('region_id', $area->region_id)->where('order_plan_id', $this->id)->first();

            if ($orderPlanRegion) {
                $price = $orderPlanRegion->price_per_month;
            }
        }

        return $price;
    }

    public function isContactOnly()
    {
        return $this->volume_m3 > 30;
    }

    ////////////////////
    // Util
    ////////////////////

    /* Find plan fitting a volume */

    /**
     * Extends toArray method for the Api
     *
     * @return array
     */
    public function toArrayApi($deep = 1)
    {
        $data = $this->toArray();
        $data['name'] = $this->getName();
        return $data;
    }

    /* Redirect to contact form for plan with a volume too big */

    public function toArray()
    {
        $data = parent::toArray();
        $data['assets'] = $this->assets()->get()->toArray();

        /*if (!$data['assets']) {
            $data['assets'] = OrderPlanAsset::where('default', 1)->toArray();
        }*/

        $data['translations'] = $this->geTranslationsByLocal();

        if (array_key_exists('image', $data) && $data['image']) {
            $data['image'] = url($data['image']);
        }

        return $data;
    }

    public function assets()
    {
        return $this->belongsToMany(OrderPlanAsset::class, 'order_plan_asset_relations');
    }

    /**
     * Get the name if not defined => get the volume
     */
    public function getName()
    {
        return $this->name ?: $this->volume_m3 . 'm3';
    }
}
