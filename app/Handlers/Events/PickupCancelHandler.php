<?php namespace App\Handlers\Events;

use App\Api;
use App\Events\PickupCancelEvent;

use App\Invoice;
use App\Item;
use App\Pickup;
use App\User;
use Carbon\Carbon;
use Exceptions\AccessException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Support\Facades\Log;

class PickupCancelHandler
{

    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  PickupCancelEvent $event
     * @return array
     * @throws AccessException
     */
    public function handle(PickupCancelEvent $event)
    {
        $pickup = $event->pickup;
        $user = $pickup->user;

        $today = Carbon::today();
        $today->setTime(0, 0);

        $pickupDate = Carbon::createFromFormat('Y-m-d H:i:s', $pickup->pickup_date);
        $pickupDate->setTime(0, 0);

        $daysDiff = $today->diffInDays($pickupDate);
        
        $volume = ($pickup->volume_m3) ? $pickup->volume_m3 : 0;
        $rescheduleFeePercentage = 0;
        if ($daysDiff <= 1) {
            $rescheduleFeePercentage = 100;
        } elseif (($volume > 0 && $volume <= 6 && $daysDiff <= 2) ||
            ($volume > 6 && $volume <= 10 && $daysDiff <= 3) ||
            ($volume > 10 && $volume <= 15 && $daysDiff <= 4) ||
            ($volume > 15 && $daysDiff <= 7)) {
            $rescheduleFeePercentage = 50;
        }

        $dataToBind = [
            'first_name' => $user->first_name,
            'pickup_date' => date('d/m/Y', strtotime($pickup->pickup_date)),
            'pickup_address' => $pickup->address,
            'url' => ROOT_URL
        ];

        $emailTitle = lg('email.template.order.cancel.title', null, [], $user->lang);
        $emailContent = shortcode(lg('email.template.order.cancel.content', null, [], $user->lang), $dataToBind, ['nl2br' => false]);

        Api::sendUserNotification($emailContent, $user['email'], $emailTitle);
        Api::sendAdminNotification($emailContent, 'order@boxify.be', $emailTitle . ' [USER#'.$user->id.']');
        $supportEmailContent = "Hello Support Team,<p> For cancelled booking #".$pickup->id." (user #". $user->id."), ".$rescheduleFeePercentage."% cancellation fee is applicable.</p>";
        $supportEmailContent .= "<p>Please calculate the refund accordingly.</p>";
        $supportEmailContent .= "<p>From - System</p>";
        Api::sendAdminNotification($supportEmailContent, 'order@boxify.be', "[Boxify - System] Cancellation fee calculation" . ' [BOOKING#'.$pickup->id.']');
    }
}
