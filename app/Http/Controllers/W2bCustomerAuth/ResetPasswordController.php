<?php

namespace App\Http\Controllers\W2bCustomerAuth;

use DB;
Use Redirect;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('w2bcustomer.guest');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Http\Response
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('w2b_customers.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {

        $this->validate($request, [
            'email'  => 'exists:password_resets,email',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required'
        ]);

        $token = $request->token;
        $user_reset =  DB::table('password_resets')
                ->where('email',$request->email)
                ->where('token',$request->token)
                ->first();

        if(!empty($user_reset)){
            $user = User::where("email", $request->email)->first();
            $user->update(["password" => bcrypt($request->password)]);

            DB::table('password_resets')
                ->where('email',$request->email)
                ->where('token',$request->token)->delete();

            $this->guard()->login($user);
            return Redirect::to('/');
        }else{
            return Redirect::back()->withErrors(['This password reset token is invalid.', 'This password reset token is invalid.']);
        }
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('w2bcustomers');
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('w2bcustomer');
    }
}
