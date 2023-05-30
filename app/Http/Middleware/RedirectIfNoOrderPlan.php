<?php namespace App\Http\Middleware;

use App\Invoice;
use App\User;
use App\Item;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;

class RedirectIfNoOrderPlan
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

            // Check if user have invoice with paid status
            $invoicePaid = $user->invoices()->whereIn('status', [Invoice::STATUS_PAID, Invoice::STATUS_QUEUED])->count();
			
			// Check if user have items in storage
			$items = $user->items()->where('status', Item::STATUS_STORED)
				->orWhere('status', Item::STATUS_DELIVERED)
				->orWhere('status', Item::STATUS_IN_TRANSIT)
				->count();

            if (!$invoicePaid && !$items) {
                return new RedirectResponse(url('/order'));
            }
        }

        return $next($request);
    }

}
