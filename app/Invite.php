<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{

    const STATUS_INVITED = 'invited';
    const STATUS_CLAIMED = 'claimed';
    const STATUS_EXPIRED = 'expired';
    const STATUS_ALREADY_CLAIMED = 'already_claimed';

    /**
     * @var array
     */
    protected $fillable = [
        "user_id",
        "token",
        "email",
        "used",
        "expiration_date",
        "status",
        "godfather_id",
        "coupon_id",
    ];

    /**
     * @var array
     */
    protected $dates = ['expiration_date'];

    /**
     * @param \App\Model|Model $claimer
     * @return bool
     */
    public function claim(Model $claimer)
    {
        $this->user()->associate($claimer);
        $this->used = 1;

        return $this->save();
    }

    /**
     * The email is not safe to rely on as user can change email
     *
     * => we store an user_id = user_id of the claimer instead
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function claimer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isAlreadyClaimed()
    {
        return $this->status === self::STATUS_ALREADY_CLAIMED;
    }

    /**
     * An invite is claimed if
     * @return bool
     */
    public function isClaimed()
    {
        return $this->status === self::STATUS_CLAIMED;
    }

    public function isExpired()
    {
        return $this->status === self::STATUS_EXPIRED;
    }

    /**
     * Link
     */
    public function link()
    {
        return url('invite').'/'. $this->token;
    }
}
