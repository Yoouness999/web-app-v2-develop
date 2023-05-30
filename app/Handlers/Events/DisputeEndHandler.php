<?php namespace App\Handlers\Events;

use App\Events\DisputeEndEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class DisputeEndHandler {

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
	 * @param  DisputeEndEvent  $event
	 * @return void
	 */
	public function handle(DisputeEndEvent $event)
	{
		//
	}

}
