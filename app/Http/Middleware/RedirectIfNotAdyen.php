<?php namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;

/**
 * Class RedirectIfNotAdyen
 *
 * Add a middleware if billing type is not adyen and time to change expired
 *
 * @package App\Http\Middleware
 */
class RedirectIfNotAdyen {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($this->auth->check())
		{
            /**
             * @var $user User
             * @feature
             */
		    $user = $this->auth->user();

            if($user->billing_type && $user->billing_type !== User::BILLING_TYPE_ADYEN && env('DATE_SWITCH', strtotime('2 days')) < strtotime('-3 months')) {
                $request->session()->put('billing_expired', true);
                return new RedirectResponse(url('/user/billing'));
            }
		}

		return $next($request);
	}

}
