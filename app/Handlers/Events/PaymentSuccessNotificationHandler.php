<?php namespace App\Handlers\Events;

use App\Events\PaymentSuccessNotificationEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class PaymentSuccessNotificationHandler {

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
	 * @param  PaymentSuccessNotificationEvent  $event
	 * @return void
	 */
	public function handle(PaymentSuccessNotificationEvent $event)
	{
		//
	}

}
