<?php

use App\OrderCalculatorCategory;
use App\OrderCalculatorCategoryTranslation;
use Illuminate\Database\Seeder;

/**
 * OrderCalculatorCategoryNameSeeder
 *
 * composer dump-autoload
 * php artisan db:seed --class=OrderCalculatorCategoryNameSeeder
 */

class OrderCalculatorCategoryNameSeeder extends Seeder {

    public function run() {
		$langs = Config::get('app.locales');
		$plans = OrderCalculatorCategory::all();

		foreach ($langs as $lang => $dataLang) {
			$labels = Lang::get('order.calculator.categories', [], $lang);

			foreach ($labels as $slug => $name) {
				$category = $plans->where('slug', $slug)->first();

				if ($category) {
					$translation = $category->translate($lang);

					if (!$translation) {
						$translation = new OrderCalculatorCategoryTranslation();
						$translation->order_calculator_category_id = $category->id;
						$translation->locale = $lang;
					}

					$translation->name = $name;
					$translation->save();
				}
			}
		}
    }
}
