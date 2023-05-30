<?php namespace App\Handlers\Events;

use App\Events\WarehousePickupByTransporterEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class WarehousePickupByTransporterHandler {

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
	 * @param  WarehousePickupByTransporterEvent  $event
	 * @return void
	 */
	public function handle(WarehousePickupByTransporterEvent $event)
	{
		//
	}

}
