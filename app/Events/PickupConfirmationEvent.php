<?php namespace App\Events;

use App\Events\Event;

use App\Handlers\Events\PickupConfirmationHandler;
use App\Pickup;
use App\User;
use Illuminate\Queue\SerializesModels;

/**
 * Class PickupConfirmationEvent
 * @package App\Events
 * @see PickupConfirmationHandler
 */
class PickupConfirmationEvent extends Event {

	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @param Pickup $pickup
	 * @param User $user
	 */
	public function __construct(Pickup $pickup)
	{
		$this->pickup = $pickup;
		$this->user = $pickup->user;
		$this->items = $pickup->items;
	}

}
