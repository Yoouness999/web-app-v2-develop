<?php namespace App\Events;

use App\Events\Event;

use App\Item;
use Illuminate\Queue\SerializesModels;

class ItemUpdate extends Event {

	use SerializesModels;


	public $item;

	/**
	 * Create a new event instance.
	 *
	 * @param Item $item
	 * @param $new
	 */
	public function __construct($item, $new)
	{
		$this->item = $item;
		$this->user = $item->user;
		$this->new = $new;
	}

}
