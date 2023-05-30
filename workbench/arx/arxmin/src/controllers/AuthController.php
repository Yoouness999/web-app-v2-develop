<?php

namespace Arxmin\controllers;

use Arxmin\requests\LoginRequest;
use Illuminate\Http\Response;
use View, Auth;

class AuthController extends BaseController {


    public $layout = "arxmin::layouts.html";

    public function __construct()
    {
        parent::__construct();
        $this->auth = Arxmin::getAuth();
    }

    /**
     * Login process
     *
     * @return View
     */
    public function getLogin(){
        return view('arxmin::auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request|Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postLogin(LoginRequest $request)
    {
        global $auth;

        # Check if user is in the DB

        $auth = $this->auth->attempt($request->only(['email','password']), $request->get('remember'));

        if ($auth) {
            # Redirect to the first element of the dynamic arx menu
            $menu = Arxmin::getMenu();

            return redirect($menu[0]['link']);
        }

        return redirect('arxmin/login')->withErrors(['login' => "error"]);
    }

    /**
     * Logout
     */
    public function getLogout()
    {
        Auth::logout();
        return redirect('/arxmin/login');
    }
}
