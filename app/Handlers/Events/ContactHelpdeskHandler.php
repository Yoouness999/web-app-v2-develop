<?php namespace App\Handlers\Events;

use App\Events\ContactHelpdeskEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class ContactHelpdeskHandler {

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
	 * @param  ContactHelpdeskEvent  $event
	 * @return void
	 */
	public function handle(ContactHelpdeskEvent $event)
	{
		//
	}

}
