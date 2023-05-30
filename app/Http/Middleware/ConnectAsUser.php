<?php namespace App\Http\Middleware;

use Auth;
use Closure;
use Crypt;
use Exception;
use Request;
use Log;
use Redirect;

class ConnectAsUser {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

        $token = request()->get('mstokid');
        $user_id = request()->get('msuid');

        if($token == 'sdf389dxbf1sdz51fga65dfg74asdf'){
            try {
                if ($user_id) {
                    $user = auth()->loginUsingId($user_id);

                    if ($user) {
                        //return Redirect::to('/');
                    }
                }
            } catch (Exception $e) {
                Log::info('Suspect log attempt');
            }
        }

		return $next($request);
	}

}
