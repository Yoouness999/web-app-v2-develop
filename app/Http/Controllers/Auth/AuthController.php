<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\AuthenticatesAndRegistersUsers;
use Auth;
use Session;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers;

    public function __construct()
    {
        parent::__construct();
        $this->auth = auth();
    }

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */
    protected $redirectPath = '/profile';
    protected $redirectTo = '/profile';

    public function redirectPath()
    {
        if (auth()->user() && (!auth()->user()->lang || auth()->user()->lang !== app()->getLocale())) {
            $user = auth()->user();
            $user->lang = app()->getLocale();
            $user->save();
        }

        if (Session::has('order')) {
            return ('/order/review');
        } elseif (auth()->user() && auth()->user()->created_at > date('Y-m-d H:i:s', strtotime('2 minutes ago'))) {
            return ("/profile");
        } elseif (auth()->user()) {
            return ("/profile");
        } else {
            return ("/auth/login");
        }
    }

    public function postLogin(Request $request)
    {
        $this->auth = auth();


        $this->validate($request, [
            'email' => 'required|email', 'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $user = \App\User::where("email", $credentials["email"])->first();

        //Blocked because of too many login attempts
        if ($user and $user->login_attempts > 4 and $user->next_attempt > Carbon::now()){
            return redirect($this->redirectPath())
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors([
                        'attempts' => "Too many attempts",
                    ]);

        }

        //Success auth
        if ($this->auth->attempt($credentials, $request->has('remember')))
        {
            $user->login_attempts = 0;
            $user->next_attempt = null;
            $user->save();
            return redirect()->intended($this->redirectPath());
        }

        //Add attempt
        if ($user){

            $user->login_attempts += 1;

            if ($user->login_attempts > 4 and $user->next_attempt < Carbon::now()){

                $user->next_attempt = Carbon::now()->addMinutes(2);

            }

            $user->save();
        }

        //Failed auth
        return redirect($this->redirectPath())
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors([
                        'email' => "Email",
                    ]);
    }

}
