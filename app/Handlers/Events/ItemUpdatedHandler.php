<?php namespace App\Handlers\Events;

use App\Events\ItemUpdatedEvent;

use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

/**
 * Class ItemUpdatedHandler
 *
 * Triggered when the item has been updated
 *
 * @package App\Handlers\Events
 */
class ItemUpdatedHandler {

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
	 * @param  ItemUpdatedEvent  $event
	 * @return void
	 */
	public function handle(ItemUpdatedEvent $event)
	{
        $item = $event->getItem();

        /**
         * @var $user User
         */
        $user = $item->user;

        if ($user) {
            $user->recalculatePlan();
        }
	}

}
