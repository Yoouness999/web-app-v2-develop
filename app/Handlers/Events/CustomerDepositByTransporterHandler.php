<?php namespace App\Handlers\Events;

use App\Events\CustomerDepositByTransporterEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class CustomerDepositByTransporterHandler {

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
	 * @param  CustomerDepositByTransporterEvent  $event
	 * @return void
	 */
	public function handle(CustomerDepositByTransporterEvent $event)
	{
		//
	}

}
