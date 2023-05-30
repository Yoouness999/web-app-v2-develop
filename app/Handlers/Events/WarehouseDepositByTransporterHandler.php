<?php namespace App\Handlers\Events;

use App\Events\WarehouseDepositByTransporterEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class WarehouseDepositByTransporterHandler {

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  WarehouseDepositByTransporterEvent  $event
	 * @return void
	 */
	public function handle(WarehouseDepositByTransporterEvent $event)
	{
		//
	}

}
