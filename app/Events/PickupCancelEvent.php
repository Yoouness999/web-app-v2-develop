<?php namespace App\Events;

use App\Events\Event;

use App\Pickup;
use Illuminate\Queue\SerializesModels;

class PickupCancelEvent extends Event {

	use SerializesModels;
    /**
     * @var array
     */
    public $ids;
    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param array $ids
     */
	public function __construct(Pickup $pickup)
	{
        $this->pickup = $pickup;
    }
}
