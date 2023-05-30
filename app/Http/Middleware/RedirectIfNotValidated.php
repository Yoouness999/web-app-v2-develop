<?php namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;

class RedirectIfNotValidated
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->check()) {
            /**
             * @var $user User
             */
            $user = $this->auth->user();

            if (!$user->isActive()) {
                return new RedirectResponse(url('/profile/account'));
            }

            // Redirect if adyen is not configured
            if (date('Y-m-d') >= config('project.adyen_switch_date')) {
                if ($user && $user->isActive() && $user->hasLemonWayBillingInfo()) {
                    flash(lg("common.please change payment method"));
                    return new RedirectResponse(url('/profile/account/billing'));
                }
            }
        }

        return $next($request);
    }

}
