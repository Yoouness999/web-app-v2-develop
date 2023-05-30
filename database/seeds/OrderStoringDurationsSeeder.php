<?php

use App\OrderCalculatorCategory;
use App\OrderCalculatorCategoryTranslation;
use Illuminate\Database\Seeder;

/**
 * OrderStoringDurationsSeeder.php
 *
 * composer dump-autoload
 * php artisan db:seed --class=OrderStoringDurationsSeeder
 */
class OrderStoringDurationsSeeder extends Seeder
{
    public function run()
    {
        Eloquent::unguard();

        $orderStoringDurations = [
            1 => [
                'slug' => '-6_months',
                'discount_percentage' => 0,
                'month' => 0
            ],
            3 => [
                'slug' => '6_months',
                'discount_percentage' => 5,
                'month' => 6
            ],
            4 => [
                'slug' => '12_months',
                'discount_percentage' => 15,
                'month' => 12
            ],
        ];

        foreach($orderStoringDurations as $id => $item){
            $orderStoringDuration = \App\OrderStoringDuration::findOrNew($id);
            $orderStoringDuration->update($item);
            $orderStoringDuration->save();
        }
    }
}
