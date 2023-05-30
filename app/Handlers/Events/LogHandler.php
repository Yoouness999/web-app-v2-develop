<?php namespace App\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Log;

class LogHandler {

	/**
	 * Create the event handler.
	 *
	 */
	public function __construct()
	{
		//
	}

	public function onLog($event){
		Log::info($event);
	}

	/**
	 * Handle the event.
	 *
	 * @param  Events  $event
	 * @return void
	 */
	public function handle($event)
	{
		//
	}

	/**
	 * Register the listeners for the subscriber.
	 *
	 * @param  Illuminate\Events\Dispatcher  $events
	 * @return void
	 */
	public function subscribe($events)
	{
		$events->listen('App\Events\UserSubscribe', 'LogHandler@onLog');
		$events->listen('App\Events\UserUpdated', 'LogHandler@onLog');
	}

}
