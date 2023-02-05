<?php

namespace App\Http\Controllers\VendorAuth;

use DB;
Use Redirect;
use App\Vendor;

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
    public $redirectTo = '/vendor/home';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('vendor.guest');
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
        return view('vendor.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        
        $this->validate($request, [
            'email'  => 'exists:vendor_password_resets,email',
            'password' => 'required|confirmed|min:8', 
            'password_confirmation' => 'required'
        ]);

        $token = $request->token;
        $vendor_reset =  DB::table('vendor_password_resets')
                ->where('email',$request->email)
                ->where('token',$request->token)
                ->first();

        if(!empty($vendor_reset)){
            $vendor = Vendor::where("email", $request->email)->first();
            $vendor->update(["password" => bcrypt($request->password)]);

            DB::table('vendor_password_resets')
                ->where('email',$request->email)
                ->where('token',$request->token)->delete();
            
            $this->guard()->login($vendor);
            return Redirect::to('vendor/home');
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
        return Password::broker('vendors');
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('vendor');
    }
}
