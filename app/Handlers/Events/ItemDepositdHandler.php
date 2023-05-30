<?php namespace App\Handlers\Events;

use App\Events\ItemDepositEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class ItemDepositdHandler {

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
	 * @param  ItemDepositEvent  $event
	 * @return void
	 */
	public function handle(ItemDepositEvent $event)
	{
		//
	}

}
