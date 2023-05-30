<?php namespace App\Handlers\Events;

use App\Api;
use App\Coupon;
use App\Events\UserInviteFriendEvent;

use App\Invite;
use App\User;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class UserInviteFriendHandler {

    /**
     * Handle the event.
     *
     * @param  UserInviteFriendEvent $event
     * @return Invite|array
     * @throws \Exception
     */
	public function handle(UserInviteFriendEvent $event)
	{
        $email = $event->getEmail();
        $user = $event->getUser();

        # Check if user have an invitation code or generate a new one
        $user->getInvitationCode();

        # Check if user is not already a customer
        $invitedUser = User::where('email', $email)->first();

        if($invitedUser){
            return [
                'already_user' => true
            ];
        }

        # Check if we have already invited by the user else will return the existed one
        $invite = Invite::where('email', $email)->where('token', $user->getInvitationCode())->first();

        if (!$invite) {

            # Generate a coupon code
            $coupon = Coupon::create([
                'code' => Coupon::generateCode(),
                'promo_applied' => config('project.godson_coupon_discount'),
                'promo_type' => Coupon::PROMO_TYPE_INVITATION,
                'quantity' => 1
            ]);

            $data = [
                'godfather_id' => $user->id,
                'coupon_id' => $coupon->id,
                'token' => (string) $user->getInvitationCode(),
                'email' => $email,
                'used' => 0,
                'status' => Invite::STATUS_INVITED
            ];

            $invite = Invite::create($data);

            $data = \DM()->getBySlug('/mail/invitation', ['format' => 'array'], $user->lang);

            $dataMail = [
                'user' => $user->toArray(),
                'invite' => $invite->toArray(),
                'email' => $email,
                'code' => $coupon->code,
                'link' => $invite->link(),
                'pickup_link' => url('order'),
            ];

            $content = shortcode($data['content'], $dataMail);
            $subject = shortcode($data['title'], $dataMail);

            Api::sendUserNotification($content, $email, $subject, $subject);

            return $invite;

        } else {
            return $invite;
        }
	}

    /**
     * Send an email
     */
    public function sendEmail(){

	}
}
