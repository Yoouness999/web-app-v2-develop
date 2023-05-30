<?php

use App\OrderPlan;
use App\OrderPlanTranslation;
use Illuminate\Database\Seeder;

/**
 * OrderPlanNameSeeder
 *
 * composer dump-autoload
 * php artisan db:seed --class=RegionsAndPlansSeeder
 */
class RegionsAndPlansSeeder extends Seeder
{
    /**
     * Get price list from Spreadsheet
     *
     */
    public function run()
    {

        Eloquent::unguard();

        $regions = include_once __DIR__.'/sources/regions.php';

        foreach ($regions as $key => $value) {

            $region = \App\Region::findOrNew($key);
            $region->name = $value['name'];
            $region->save();

            echo $region->id . " saved \n";

            foreach ($value['postcodes'] as $postcode) {

                $postcode = \App\Area::where('zip_code', $postcode)->first();

                if ($postcode) {
                    $postcode->region_id = $region->id;
                    $postcode->save();
                }
            }

            /**
             * Generate a pricing that is increasing the price
             */

            $plans = OrderPlan::all();

            foreach ($plans as $plan){
                $orderPlanRegion = \App\OrderPlanRegion::firstOrCreate([
                    'order_plan_id' => $plan->id,
                    'region_id' => $region->id,
                    'price_per_month' => $plan->price_per_month + $region->id
                ]);

                echo $orderPlanRegion->id . " saved \n";
            }
        }
    }
}
