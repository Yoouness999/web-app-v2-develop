<?php namespace Modules\Labelmanager\Database\Seeders;

use App;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Labelmanager\Entities\Label;

class LabelManagerDatabaseSeeder extends Seeder {


	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$lang = App::getLocale();

		$label = new Label();
		$label->ref = "hello world";
		$label->{$lang} = "Hello World !";
		$label->save();
	}

}