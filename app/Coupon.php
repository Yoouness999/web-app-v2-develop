<?php namespace App;

use Illuminate\Database\Eloquent\Model;


class Coupon extends Model
{
    protected $fillable = [
        'code',
        'promo_applied',
        'promo_type',
        'from_date',
        'expiry_date',
        'quantity',
        'created_at',
        'updated_at',
    ];

    const PROMO_TYPE_INVITATION = 'invitation';
    const PROMO_TYPE_REDEEM = 'redeem';
    const PROMO_TYPE_PROMO = 'promo';

    public static $types = [
        self::PROMO_TYPE_REDEEM => 'Redeem',
        self::PROMO_TYPE_INVITATION => 'Invitation',
        self::PROMO_TYPE_PROMO => 'Promotion',
    ];

    /**
     * Generate a code that should be unique
     */
    public static function generateCode($prefix = '')
    {
        $code = '';

        do {
            $code = $prefix.str_random(6);
        } while ( !empty(Coupon::where('code', $code)->exists()) );

        return $code;
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        return self::$types;
    }

    /**
     * Get user related to a coupon
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'coupon_user', 'coupon_id', 'user_id');
    }

    public function toArray()
    {
        $data = parent::toArray();

        $data['users'] = $this->users;

        return $data;
    }

    /**
     * Extends toArray method for the Api
     *
     * @return array
     */
    public function toArrayApi($deep = 1)
    {
        $data = $this->toArray();

        $data['users'] = $this->users;

        return $data;
    }
}
