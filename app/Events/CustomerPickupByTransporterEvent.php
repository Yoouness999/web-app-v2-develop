<?php namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;

class CustomerPickupByTransporterEvent extends Event {

	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

}
