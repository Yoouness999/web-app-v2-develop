<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Arxmin\models\Arxmin;
use Illuminate\Http\Request;

class RedirectController extends Controller {

	/**
	 * Redirect scan id to the correct link
	 *
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function anyScan($id)
	{
		$user = auth()->user();
		$arxminAuth = Arxmin::getAuth();
		$isAuth = $arxminAuth->check();

		// Check if user is an admin
		if ($isAuth) {
			return redirect('/arxmin/modules/boxifymanager/items/scan/' . $id);
		}

		return redirect('/user/manager/?box=' . $id);
	}


    /**
     * Activate User Account
     *
     * @param $code
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function activateAccount($code)
    {
        /**
         * @var $user User
         */
        $user = User::where('activation_code', $code)->first();

        if ($user && $user->accountIsActive($code)) {
            \Session::flash('message', lg('Success, your account has been activated.', 'auth'));
            return redirect('profile');
        }

        \Session::flash('message', lg('Your account couldn\'t be activated, please try again'));

        return redirect('/');
    }

    /**
     * Redirect invitation process
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function anyInvitation($code = null, Request $request){

        if (!$code && $request->has('invitation_code')) {
            $code = $request->get('invitation_code');
            $user = auth()->user();

            if ($user && !$user->godfather) {

            }
        }

        if ($code) {
            return redirect('/')->withCookie(cookie('invitation_code', $code, 36000, '/'));
        }

        return redirect('/')->with('error');
	}

}
