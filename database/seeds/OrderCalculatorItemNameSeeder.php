<?php

use App\OrderCalculatorItem;
use App\OrderCalculatorItemTranslation;
use Illuminate\Database\Seeder;

/**
 * OrderCalculatorItemNameSeeder
 *
 * composer dump-autoload
 * php artisan db:seed --class=OrderCalculatorItemNameSeeder
 */
class OrderCalculatorItemNameSeeder extends Seeder
{
    public function run()
    {
        $plans = OrderCalculatorItem::all();

        $items = include_once __DIR__ . '/sources/items.type.php';

        foreach ($items as $slug => $item) {
            $calculatorItem = $plans->where('slug', $slug)->first();

            if ($calculatorItem) {
                $calculatorItem->translate('en')->name = $item['en'];
                $calculatorItem->translate('fr')->name = $item['fr'];
                $calculatorItem->translate('nl')->name = $item['nl'];
                $calculatorItem->save();
            } else {
                $calculatorItem = OrderCalculatorItem::create([
                   'slug' => $slug,
                   'order_calculator_category_id' => 1,
                   'area_m2' => $item['area_m2'],
                   'volume_m3' => $item['volume_m3'],
                    'en' => ['name' => $item['en']],
                    'fr' => ['name' => $item['fr']],
                    'nl' => ['name' => $item['nl']],
                ]);
                $calculatorItem->save();
            }
        }
    }
}
