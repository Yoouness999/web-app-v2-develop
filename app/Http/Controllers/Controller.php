<?php namespace App\Http\Controllers;

use App;
use Auth;
use Config;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Request;
use Session;
use View;

abstract class Controller extends \Illuminate\Routing\Controller {

	use DispatchesJobs, ValidatesRequests;

    /**
     * @var \App\User
     */
    public $user = null;

    /**
     * @var null|string
     */
    public $lang = null;

    /**
     * Default Controller constructor
     *
     */
    public function __construct()
    {
        global $isAuth, $user;

        $this->setupLayout();

        if (!$isAuth) {
            $isAuth = Auth::check();
        }

        if ($isAuth) {
            $user = $this->user = Auth::getUser();
        }

        $this->lang = App::getLocale() ?: 'fr';

        \View::share('isAuth', $isAuth);
        \View::share('user', $this->user);

        //$menu = Lang::get('menu.navbar');
        $navigations = lg('menu');

        # Common shared variables available by default
        \View::share('navigations', $navigations);
        \View::share('languageActive', App::getLocale() ?: 'en');
        \View::share('languageItems', Config::get('app.locales', [
            'fr' => [
                'url'    => 'fr.boxify.be',
                'active' => false,
                'name'   => 'French',
            ],
            'nl' => [
                'url'    => 'nl.boxify.be',
                'active' => false,
                'name'   => 'Dutch',
            ],
            'en' => [
                'url'    => 'www.boxify.be',
                'active' => true,
                'name'   => 'English',
            ],
        ]));

        /**
         * Assign some variables common shared JS by default
         */
        javascript()->namespace('__app')->set([
            'lang' => $this->lang,
            'token' => csrf_token(),
        ]);

        if (Config::get('app.debug') || request()->get('debug')) {
            javascript()->namespace('__app')->set('debug', true);
        }

        // Set an invitation code session
        if (request()->has('invitation_code')) {
            Session::put('invitation_code', request()->get('invitation_code'));
        }

        /**
         * Add notifications
         */
        if (Session::has('notifications') || request()->has('notifications')) {
            $notifications = Session::get('notifications', request()->get('notifications'));
            javascript()->namespace('__app')->set('notifications', $notifications);
        }
    }

    /**
     * Notify user controller
     *
     * @param $msg
     */
    public function notify($msg, $type = 'warning'){
        View::share('notifications', ['type' => $type, 'msg' => $msg]);
    }

    /**
     * @deprecated use View Share instead !
     */
    public function setupLayout(){
        if (isset($this->layout) && !is_null($this->layout)) {
            $data = array();
            // Enter here data that have to be accessible everywhere
            $this->layout = View::make($this->layout, $data);
        }
    }

    public function viewMake($name, $data = []){
        return View::make($name, $data);
    }
}
