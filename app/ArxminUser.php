<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Api\ApiToken;
use Datetime;
use App\Api\ApiApp;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Passwords\CanResetPassword;

class ArxminUser extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, SoftDeletes, CanResetPassword;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'role'
    ];

    /**
     * Create a access token for the API
     */
    public function getApiAccessToken(ApiApp $app)
    {
        return $this->getApiToken($app, ApiToken::TYPE_ACCESS);
    }

    /**
     * Create a token for the API
     */
    public function getApiToken(ApiApp $app, $type)
    {
        $token = new ApiToken();
        $token->type = $type;
        $token->setToken();
        $token->app()->associate($app);
        $token->arxminUser()->associate($this);
        $token->save();

        return $token;
    }

    /**
     * Create a refresh token for the API
     */
    public function getApiRefreshToken(ApiApp $app)
    {
        return $this->getApiToken($app, ApiToken::TYPE_REFRESH);
    }

    /**
     * Get name attribute
     * @return string
     * @internal param $data
     */
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get transporter pickups
     */
    public function getPickups(Datetime $from, Datetime $to)
    {
        $dropoffs = $this->transporterPickups()
            ->where('dropoff_date_from', '<', $to)
            ->where('dropoff_date_to', '>=', $from)
            ->get();

        $pickups = $this->transporterPickups()
            ->where('pickup_date', '<', $to)
            ->where(function ($query) use ($from) {
                $query->where(function ($query) use ($from) {
                    $query->whereNull('pickup_date_to')
                        ->where('pickup_date', '>=', $from);
                })->orWhere(function ($query) use ($from) {
                    $query->whereNotNull('pickup_date_to')
                        ->where('pickup_date_to', '>=', $from);
                });
            })
            ->get();

        $deliveries = [];

        foreach ($dropoffs as $dropoff) {
            $deliveries[] = [
                'from' => $dropoff->dropoff_date_from,
                'to' => $dropoff->dropoff_date_to,
                'dropoff' => $dropoff
            ];
        }

        foreach ($pickups as $pickup) {
            $pickup_date_from = new Datetime($pickup->pickup_date);

            $deliveries[] = [
                'from' => $pickup_date_from,
                'to' => $pickup->pickup_date_to,
                'pickup' => $pickup
            ];
        }

        return $deliveries;
    }

    public function transporterPickups()
    {
        return $this->hasMany(Pickup::class, 'assigned_deliveryman_arxmin_user_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(ArxminPermission::class, 'arxmin_user_permissions');
    }

    public function resetPassword()
    {
        $remember_token = $this->refreshRememberToken();

        $title = lg("auth.We have e-mailed your password reset link!");

        $content = shortcode('[link url={link}]' . lg("emails.Click here to reset your password") . '[/link]', ['link' => url('/employee/reset?token=' . $remember_token)]);

        Api::sendUserNotification($content, $this->email, $title);

        return $remember_token;
    }

    /**
     * Refresh the remember token linked to user
     */
    public function refreshRememberToken()
    {
        $this->remember_token = str_random(60);
        $this->save();
        return $this->remember_token;
    }

    /**
     * Extends toArray method for the Api
     *
     * @return array
     */
    public function toArrayApi($deep = 1)
    {
        $data = $this->toArray();

        unset($data['password']);
        unset($data['remember_token']);

        // Get arxmin permissions
        $data['permissions'] = $this->permissions;

        return $data;
    }

    public function toArray()
    {
        $data = parent::toArray();
        $data['permissions'] = $this->permissions;
        return $data;
    }

    public function toArrayMinimal()
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'name' => $this->name
        ];
    }
}
