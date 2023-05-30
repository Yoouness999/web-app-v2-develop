<?php namespace App\Handlers\Events;

use App\Events\PaymentErrorEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class PaymentErrorHandler {

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
	 * @param  PaymentErrorEvent  $event
	 * @return void
	 */
	public function handle(PaymentErrorEvent $event)
	{
		//
	}

}
