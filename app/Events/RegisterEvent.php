<?php namespace App\Events;

use App\Events\Event;

use App\User;
use Illuminate\Queue\SerializesModels;

class RegisterEvent extends Event {

	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 */
	public function __construct(User $user)
	{
		$this->user = $user;
	}

}
