<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class HistoricalCategoriesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $items = trans('historicals_categories');

        \App\HistoricalCategory::getQuery()->delete();

        foreach ($items as $slug => $cat) {

            $historicalCatEntity = \App\HistoricalCategory::where('slug', $slug)->first();

            if (!$historicalCatEntity) {
                \App\HistoricalCategory::create([
                    'slug' => $slug,
                    'name' => $cat['name'],
                    'icon' => $cat['icon'],
                    'color' => $cat['color']
                ]);
            }
        }
    }

}
