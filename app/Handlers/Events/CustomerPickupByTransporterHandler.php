<?php namespace App\Handlers\Events;

use App\Events\CustomerPickupByTransporterEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class CustomerPickupByTransporterHandler {

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
	 * @param  CustomerPickupByTransporterEvent  $event
	 * @return void
	 */
	public function handle(CustomerPickupByTransporterEvent $event)
	{
		//
	}

}
