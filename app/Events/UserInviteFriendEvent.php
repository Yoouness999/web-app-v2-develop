<?php namespace App\Events;

use App\Events\Event;

use App\Handlers\Events\UserInviteFriendHandler;
use App\User;
use Illuminate\Queue\SerializesModels;

/**
 * Class UserInviteFriendEvent
 *
 * @see UserInviteFriendHandler
 * @package App\Events
 */
class UserInviteFriendEvent extends Event {

	use SerializesModels;
    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $email;
    /**
     * @var bool
     */
    private $resend;

    /**
     * Create a new event instance.
     *
     * @param $user
     * @param $email
     * @param bool $resend
     */
	public function __construct($user, $email, $resend = false)
	{

        $this->user = $user;
        $this->email = $email;
        $this->resend = $resend;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return bool
     */
    public function isResend()
    {
        return $this->resend;
    }

}
