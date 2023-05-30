<?php

use App\OrderAssurance;
use App\OrderAssuranceTranslation;
use Illuminate\Database\Seeder;

/**
 * OrderAssuranceNameSeeder
 *
 * composer dump-autoload
 * php artisan db:seed --class=OrderAssuranceNameSeeder
 */

class OrderAssuranceNameSeeder extends Seeder {
    public function run() {
		$langs = Config::get('app.locales');
		$plans = OrderAssurance::all();
		
		foreach ($langs as $lang => $dataLang) {
			$labels = Lang::get('order.confirmation.assurance.items', [], $lang);
		
			foreach ($labels as $slug => $name) {
				$assurance = $plans->where('slug', $slug)->first();
				
				if ($assurance) {
					$translation = $assurance->translate($lang);
					
					if (!$translation) {
						$translation = new OrderAssuranceTranslation();
						$translation->order_assurance_id = $assurance->id;
						$translation->locale = $lang;
					}
					
					$translation->name = $name;
					$translation->save();
				}
			}
		}
    }
}
