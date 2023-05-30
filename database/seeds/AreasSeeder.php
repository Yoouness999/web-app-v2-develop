<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AreasSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $cities = trans('cities');
        
        \App\Area::truncate();

        foreach ($cities as $zipCode => $name) {
            \App\Area::create([
                'slug' => str_slug($name),
                'zip_code' => $zipCode,
            ]);
        }
    }

}
