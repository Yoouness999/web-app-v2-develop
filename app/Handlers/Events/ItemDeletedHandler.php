<?php namespace App\Handlers\Events;

use App\Events\ItemDeleted;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class ItemDeletedHandler implements ShouldBeQueued {

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
	 * @param  ItemDeleted  $event
	 * @return void
	 */
	public function handle(ItemDeleted $event)
	{
		//
	}

}
