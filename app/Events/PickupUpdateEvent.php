<?php namespace App\Events;

use App\Events\Event;

use App\Invoice;
use App\Pickup;
use App\User;
use Illuminate\Queue\SerializesModels;

/**
 * Class PickupUpdateEvent
 *
 * @see PickupUpdateHandler
 * @package App\Events
 */
class PickupUpdateEvent extends Event {

	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @param Pickup $pickup
	 */
	public function __construct(Pickup $oldPickup, Pickup $newPickup = null, $dateUpdated = false)
	{
		$this->newPickup = $newPickup;
		$this->oldPickup = $oldPickup;
		$this->dateUpdated = $dateUpdated;
	}

}
