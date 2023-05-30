<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CountriesAndTaxesSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

        $countries = trans('countries');

        foreach ($countries as $slug => $country){
            $countryEntity = \App\Country::where('slug', $slug)->first();

            if ($countryEntity) {
                $taxe = \App\Taxe::where('country_id', $countryEntity->id)->first();

                if ($taxe) {
                    $taxe->value_percentage = $country['tax'];
                    $taxe->save();
                } else {
                    $taxe = \App\Taxe::create([
                        'country_id' => $countryEntity->id,
                        'value_percentage' => $country['tax']
                    ]);
                }
            } else {
                $countryEntity = \App\Country::create(['slug' => $slug]);

                $taxe = \App\Taxe::create([
                    'country_id' => $countryEntity->id,
                    'value_percentage' => $country['tax']
                ]);
            }

            echo $countryEntity. ' '.$taxe->value_percentage."\n";
        }
	}

}
