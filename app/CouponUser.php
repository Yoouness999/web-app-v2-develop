<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model
{
    protected $table = "coupon_user";

    protected $fillable = [
        'code',
        'user_id',
        'touse',
        'used',
        'promo_applied',
        'promo_type',
        'expiry_date',
        'quantity',
        'created_at',
        'updated_at',
    ];

    /**
     * Apply the promo to the user
     *
     * @param $price
     * @param bool $simulate
     * @return float
     */
    public function applyCoupon($price, $simulate = false)
    {

        if (!$this->coupon) {
            return $price;
        }

        if ($this->coupon->quantity == 0) {
            return $price;
        }

        $promo = $this->coupon->promo_applied;
        $promoAmount = str_replace('%', '', $promo);

        if (!$simulate) {

            $this->used = 1;
            $this->touse = 0;
            $this->save();

            if ($this->coupon->quantity !== -1) {
                $this->coupon->quantity = $this->coupon->quantity - 1;
                $this->coupon->save();
            }
        }

        $price = strpos($promo, '%') ? $price - ($price * ($promoAmount / 100)) : $price - $promoAmount;

        return round($price, 2);
    }

    public function coupon()
    {
        return $this->belongsTo('App\Coupon');
    }

    /**
     * Extends toArray method for the Api
     *
     * @return array
     */
    public function toArrayApi($deep = 1)
    {
        $data = $this->toArray();

        return $data;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
