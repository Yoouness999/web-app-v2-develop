<?php


namespace App\Traits;


use App\Events\UserInviteFriendEvent;
use App\Invite;
use App\User;

trait CanInvites
{
    /**
     * Generate a unique ID
     *
     */
    public function generateInviteCode()
    {
        $invitation_code = base64_encode($this->id);

        $this->invitation_code = $invitation_code;

        $this->save();

        return $this->invitation_code;
    }

    /**
     * @param $code
     */
    public static function getByInviteCode($code){
        return static::where('invitation_code', $code)->first();
    }

    /**
     * Generate the invite link
     */
    public function getInviteLink()
    {
        return route('invitation', ['code' => $this->getInvitationCode()]);
    }

    /**
     * Get the current invitation code
     */
    public function getInvitationCode(){
        if (!$this->invitation_code) {
            $this->generateInviteCode();
        }

        return $this->invitation_code;
    }

    /**
     * @return mixed
     */
    public function invites()
    {
        return $this->hasMany(Invite::class, 'user_id');
    }
}
