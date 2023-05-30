<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'App\Console\Commands\Inspire',
		'App\Console\Commands\AjoutFactureOdoo',
		'App\Console\Commands\ModifFactureOdoo',
		'App\Console\Commands\VerifFactureOdoo',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
        $this->load(__DIR__.'/Commands');

		$schedule->command('inspire')
				 ->hourly();
		$schedule->command('odoo:ajout')
				 ->everyTenMinutes()
				 ->withoutOverlapping();
		/*$schedule->command('odoo:verif')
				 ->withoutOverlapping()
				 ->dailyAt("00:00");*/
	}

}
