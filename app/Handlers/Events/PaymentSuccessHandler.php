<?php namespace App\Handlers\Events;

use App\Events\PaymentSuccessEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class PaymentSuccessHandler {

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
	 * @param  PaymentSuccessEvent  $event
	 * @return void
	 */
	public function handle(PaymentSuccessEvent $event)
	{
		//
	}

}
