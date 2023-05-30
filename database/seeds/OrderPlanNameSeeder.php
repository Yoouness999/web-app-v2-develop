<?php

use App\OrderPlan;
use App\OrderPlanTranslation;
use Illuminate\Database\Seeder;

/**
 * OrderPlanNameSeeder
 *
 * composer dump-autoload
 * php artisan db:seed --class=OrderPlanNameSeeder
 */
class OrderPlanNameSeeder extends Seeder
{
    public function run()
    {
        $langs = Config::get('app.locales');
        $plans = OrderPlan::all();

        foreach ($plans as $plan) {
            foreach ($langs as $lang => $dataLang) {
                $translation = $plan->translate($lang);

                if (!$translation) {
                    $translation = new OrderPlanTranslation();
                    $translation->order_plan_id = $plan->id;
                    $translation->locale = $lang;
                    $translation->name = round($plan->volume_m3, 2) . 'm3';
                }

                $translation->save();
            }
        }
    }
}
