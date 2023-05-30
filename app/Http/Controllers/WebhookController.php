<?php namespace App\Http\Controllers;

use App\Api;
use App\Events\AdyenNotificationEvent;
use App\Handlers\Events\AdyenNotificationHandler;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Log;
use Exception;
use Illuminate\Http\Request;

class WebhookController extends Controller {

	/**
     * Handle adyen payment authorisation notification
	 *
	 * @return Response
	 */
	public function adyenNotification(Request $request)
	{
        \Log::info('Adyen Notification', $request->all());

        /**
         * @see AdyenNotificationHandler
         */
        try {
            event(new AdyenNotificationEvent($request->all()));
        } catch (Exception $e) {
            Log::error($e);
            Api::sendAdminNotification($e->getMessage(), 'product@boxify.be', 'Error payment Boxify');
        }

        return response()->json(["notificationResponse" => "[accepted]"]);
	}

}
