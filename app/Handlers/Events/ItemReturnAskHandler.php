<?php namespace App\Handlers\Events;

use App\Events\ItemReturnAskEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class ItemReturnAskHandler {

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
	 * @param  ItemReturnAskEvent  $event
	 * @return void
	 */
	public function handle(ItemReturnAskEvent $event)
	{
		//
	}

}
