<?php namespace App\Handlers\Events;

use App\Events\PaymentErrorNotificationEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class PaymentErrorNotificationHandler {

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
	 * @param  PaymentErrorNotificationEvent  $event
	 * @return void
	 */
	public function handle(PaymentErrorNotificationEvent $event)
	{
		//
	}

}
