<?php namespace App\Events;

use App\Events\Event;

use App\Handlers\Events\AdyenNotificationHandler;
use Illuminate\Queue\SerializesModels;

/**
 * Class AdyenNotificationEvent
 *
 * @see AdyenNotificationHandler
 * @package App\Events
 */
class AdyenNotificationEvent extends Event {

	use SerializesModels;

    /**
     * @var array
     */
    public $data;

    /**
     * Create a new event instance.
     *
     * @param $data
     */
	public function __construct($data)
	{
		$this->data = $data;
	}
}
