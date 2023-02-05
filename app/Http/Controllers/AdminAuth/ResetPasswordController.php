<?php

namespace App\Http\Controllers\AdminAuth;

use DB;
Use Redirect;
use App\Admin;

use App\Http\Controllers\Controller;
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
    public $redirectTo = '/admin/home';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.guest');
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
        return view('admin.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        $this->validate($request, [
            'email'  => 'exists:admin_password_resets,email',
            'password' => 'required|confirmed|min:8', 
            'password_confirmation' => 'required'
        ]);

        $token = $request->token;
        $admin_reset =  DB::table('admin_password_resets')
                ->where('email',$request->email)
                ->where('token',$request->token)
                ->first();

        if(!empty($admin_reset)){
            $admin = Admin::where("email", $request->email)->first();
            $admin->update(["password" => bcrypt($request->password)]);

            DB::table('admin_password_resets')
                ->where('email',$request->email)
                ->where('token',$request->token)->delete();
            
            $this->guard()->login($admin);
            return Redirect::to('admin/home');
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
        return Password::broker('admins');
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
