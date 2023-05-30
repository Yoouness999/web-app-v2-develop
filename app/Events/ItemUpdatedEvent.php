<?php namespace App\Events;

use App\Events\Event;

use App\Item;
use Illuminate\Queue\SerializesModels;

class ItemUpdatedEvent extends Event {

	use SerializesModels;
    /**
     * @var Item
     */
    private $item;

    /**
     * Create a new event instance.
     *
     * @param Item $item
     */
	public function __construct(Item $item)
	{

        $this->item = $item;
    }

    /**
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param Item $item
     */
    public function setItem($item)
    {
        $this->item = $item;
    }

}
