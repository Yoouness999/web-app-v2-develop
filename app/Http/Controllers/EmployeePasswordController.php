<?php namespace App\Http\Controllers;

use App\Api\ApiToken;
use App\ArxminUser;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployeePasswordController extends Controller {
    /**
     * Display the password reset view for the given token.
     *
     * @param  string  $token
     * @return Response
     */
    public function getReset(Request $request)
    {
        $this->checkToken($request);
        $token = $request->get('token');

        return view('auth.reset', ['formAction' => '/employee/reset'])->with('token', $token);
    }

    public function checkToken(Request $request)
    {
        $token = $request->get('token');

        if (is_null($token) || !ArxminUser::where('remember_token', $token)->exists()) {
            throw new NotFoundHttpException;
        }
    }

    /**
     * Reset the given user's password.
     *
     * @param  Request  $request
     * @return Response
     */
    public function postReset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $this->checkToken($request);

        $user = ArxminUser::where('email', $request->get('email'))->where('remember_token', $request->get('token'))->first();

        if ($user) {
            $user->password = bcrypt($request->get('password'));
            $user->save();

            return redirect('/')->with(['user' => 'User updated']);
        }

        return redirect()->back()->withErrors(['user' => 'Employee not found or token invalid']);
    }
}
