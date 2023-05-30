<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\Registrar;
use App\User;
use Auth;
use Session;
use Hash;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class OauthController extends Controller
{

    /**
     * Connect to the provider
     *
     * @param $provider
     * @return mixed
     */
    public function getConnect($provider)
    {
        Session::put('process', 'login');
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Connect to the provider
     *
     * @param $provider
     * @return mixed
     */
    public function getRegister($provider)
    {
        Session::put('process', 'register');
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Redirect and register user after an oauth redirect
     *
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function anyRedirect($provider)
    {
        try {
            /**
             * @var $user User
             */
            $user = Socialite::driver($provider)->fields(['id', 'first_name', 'last_name', 'email'])->user();

            if (isset($user['email'])) {
                # Check if user is in the DB
                $oUser = User::withTrashed()->where('email', $user['email'])->first();
            } else {
                $oUser = User::withTrashed()->where('oauth_id', $user['id'])->first();
                if (!$oUser) {
                    Session::put('oauth_id', $user['id']);
                    return \Redirect::to('signup?error=oauth_email_missing');
                }
            }

            // @note Session "process" is reset in order review (cfr. OrderController -> getReview())
            if (!$oUser && Session::get('process') == 'register') {
                // Create user using the registrar
                $registrar = new Registrar();

                $data = [
                    'email' => @$user['email'] ?: $user['id'],
                    'first_name' => @$user['first_name'],
                    'last_name' => @$user['last_name'],
                    'password' => $user->token,
                ];

                $oUser = $registrar->create($data);

                /**
                 * Add GDPR compliance
                 *
                 * @see http://pm2.cherrypulp.com/projects/543?modal=Task-12414-543
                 */
                $oUser->agree = 1;
                $oUser->agree_date = date('Y-m-d H:i:s');
                $oUser->save();
            } elseif ($oUser && $oUser->trashed()) {
                $oUser->restore();
            } elseif(!$oUser) {
                return redirect('/order');
            }

            Auth::loginUsingId($oUser->id);

            if (Session::has('order')) {
                return redirect('/order/review');
            }

            return \Redirect::to('profile');
        } catch (\Exception $exception) {
            $message = 'ERROR';

            if ($exception->getResponse()) {
                $response = json_decode($exception->getResponse()->getBody()->getContents());
                $message = $response->error->message;
            }

            if (Session::has('order')) {
                return redirect('/order/review')->withErrors(['facebook' => $message]);
            }

            return \Redirect::to('profile')->withErrors(['facebook' => $message]);
        }
    }
}
