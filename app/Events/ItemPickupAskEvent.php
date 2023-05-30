<?php namespace App\Events;

use App\Events\Event;

use App\Pickup;
use Illuminate\Queue\SerializesModels;

class ItemPickupAskEvent extends Event {

	use SerializesModels;
    /**
     * @var Pickup
     */
    public $pickup;

    /**
     * Create a new event instance.
     *
     * @param \App\Pickup $pickup
     */
	public function __construct(Pickup $pickup)
	{
        $this->pickup = $pickup;
        $this->user = $pickup->user;
        $this->items = $pickup->itemsRecords()->get();
    }
}
