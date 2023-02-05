<?php

namespace App\Http\Controllers\AdminAuth;

use DB;
use Str;
use App\Admin;
use App\Notifications\AdminResetPassword;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('admin.auth.passwords.email');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $data = $request->all();
        $this->validate($request, [
            'email' => [
                'required', 'email', 'exists:admins'
            ],
        ]);

        $admin = Admin::where('email', $data['email'])->first();

        $existPasswordReset = DB::table('admin_password_resets')->where('email', $admin->email)->exists();

        if($existPasswordReset){
            DB::table('admin_password_resets')->where('email', $admin->email)
            ->update(['token' => Str::random(60), 'created_at' => date('Y-m-d H:i:s')]);
        }else{
            DB::table('admin_password_resets')->insert([
                ['email' => $admin->email, 'token' => Str::random(60), 'created_at' => date('Y-m-d H:i:s')],
            ]);
        }

        $passwordReset = DB::table('admin_password_resets')->where('email', $admin->email)->first();
        
        if ($admin && $passwordReset)
            $admin->notify(
                new AdminResetPassword($passwordReset->token)
            );

        return back()->with('status', "We have e-mailed your password reset link!");
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
}
