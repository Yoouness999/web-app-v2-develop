<?php

use App\OrderPlan;
use App\OrderPlanTranslation;
use Illuminate\Database\Seeder;

/**
 * OrderPlanNameSeeder
 *
 * composer dump-autoload
 * php artisan db:seed --class=OrderPlanHiddenSeeder
 */
class OrderPlanHiddenSeeder extends Seeder
{
    /**
     * Get price list from Spreadsheet
     *
     * @see : https://docs.google.com/spreadsheets/d/1pwYOdRDjjhmTrJ3lLaEmecohkdxjmbEGliRtUJo5_rA/edit#gid=0
     */
    public function run()
    {
        $data = \Arx\classes\Arr::csvToArray('https://docs.google.com/spreadsheets/d/e/2PACX-1vTsWeUmK3HvMMTAcgvcjpvVybQfz9Or-TkSEBCvpqR3DYmF84Yr5V9u-QsAv9eY4_2buFu16cV4izAN/pub?gid=0&single=true&output=csv', ['delimiter' => ',']);

        foreach ($data as $key => $value){
            if ($key < 3) {
                continue;
            }

            // check if slug already exists
            $orderPlan = OrderPlan::where('slug', $value[0])->first();

            if (!$orderPlan) {
                $orderPlan = OrderPlan::firstOrCreate([
                    'slug' => $value[0],
                    'volume_m3' => str_replace(",", ".", $value[1]),
                    'price_per_month' => str_replace(",", ".", $value[2]),
                    'order_plan_category_id' => $value[4],
                    'visible' => 0
                ]);

                echo "OrderPlan #".$orderPlan->id . " created \n";
            } else {

                $orderPlan->update([
                    'slug' => $value[0],
                    'volume_m3' => str_replace(",", ".", $value[1]),
                    'price_per_month' => str_replace(",", ".", $value[2]),
                    'order_plan_category_id' => $value[4],
                    'visible' => 0
                ]);

                echo "OrderPlan #".$orderPlan->id . " updated \n";
            }
        }
    }
}
