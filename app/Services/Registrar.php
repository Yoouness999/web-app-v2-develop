<?php namespace App\Services;

use App;
use App\Api;
use App\Events\RegisterEvent;
use App\User;
use Mail;
use Session;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract
{

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    public function create(array $data)
    {
        // Generate activation code
        $data['activation_code'] = str_random(60) . md5($data['email']);

        foreach ($data as $item) {
            if (preg_match('/<script\b[^>]*>(.*?)<\/script>/is', $item)) {
                \Log::info('XSS attack detected by'. \Request::getClientIp());
                die('XSS Detected, Your Ip '.\Request::getClientIp().' is logged and will be send to the Federal Computer Crime Unit');
            }
        }

        $user = User::create([
            'name' => $data['first_name'] . ' ' . $data['last_name'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'lang' => App::getLocale(),
            'password' => bcrypt($data['password']),
            'activation_code' => $data['activation_code'],
        ]);

        if ($user) {

            // check if there is an invitation_code
            if(Session::get('invitation_code')){
                $invitation_code = Session::get('invitation_code');
                $godfather_id = base64_decode($invitation_code);

                // check if user exist in the Database
                if (User::find(base64_decode($invitation_code))) {
                    $user->godfather_id = $godfather_id;
                }
            }

            // Add remove oauth_id
            if(Session::get('oauth_id')){
                $user->oauth_id = Session::get('oauth_id');
                Session::remove('oauth_id');
            }

            // Generate an invitation code
            $user->invitation_code = base64_encode($user->id);
            $user->save();
            //$user->sendMailConfirmation();
            event(new RegisterEvent($user));

            Session::flash('new_user', '1');
        }

        return $user;
    }

}
