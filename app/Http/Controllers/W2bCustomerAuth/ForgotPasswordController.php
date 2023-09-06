<?php

namespace App\Http\Controllers\W2bCustomerAuth;

use DB;
use Str;
use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use App\Notifications\W2bCustomerResetPassword;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

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
        $this->middleware('w2bcustomer.guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('w2b_customers.auth.passwords.email');
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
                'required', 'email', 'exists:users'
            ],
        ]);

        $user = User::where('email', $data['email'])->first();

        $existPasswordReset = DB::table('password_resets')->where('email', $user->email)->exists();

        if($existPasswordReset){
            DB::table('password_resets')->where('email', $user->email)
            ->update(['token' => Str::random(60), 'created_at' => date('Y-m-d H:i:s')]);
        }else{
            DB::table('password_resets')->insert([
                ['email' => $user->email, 'token' => Str::random(60), 'created_at' => date('Y-m-d H:i:s')],
            ]);
        }

        $passwordReset = DB::table('password_resets')->where('email', $user->email)->first();

        if ($user && $passwordReset)
            $user->notify(
                new W2bCustomerResetPassword($passwordReset->token)
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
        return Password::broker('w2bcustomers');
    }
}
