<?php

use App\OrderPlanAsset;
use App\OrderPlanAssetTranslation;
use Illuminate\Database\Seeder;

/**
 * OrderPlanAssetNameSeeder
 *
 * composer dump-autoload
 * php artisan db:seed --class=OrderPlanAssetNameSeeder
 */

class OrderPlanAssetNameSeeder extends Seeder {
    public function run() {
		$langs = Config::get('app.locales');

		foreach ($langs as $lang => $dataLang) {

			$labels = Lang::get('order.storage.assets', [], $lang);

			foreach ($labels as $slug => $name) {

				$asset = OrderPlanAsset::where('slug', $slug)->first();

				if ($asset) {
					$translation = $asset->translate($lang);

					if (!$translation) {
						$translation = new OrderPlanAssetTranslation();
						$translation->order_plan_asset_id = $asset->id;
						$translation->locale = $lang;
                        $translation->name = $name;
                        $translation->save();
					}
				}
			}
		}
    }
}
