<?php

namespace App\Http\Controllers\VendorAuth;

use DB;
use Str;
use App\Vendor;
use App\Notifications\VendorResetPassword;

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
        $this->middleware('vendor.guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('vendor.auth.passwords.email');
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
                'required', 'email', 'exists:vendors'
            ],
        ]);

        $vendor = Vendor::where('email', $data['email'])->first();

        $existPasswordReset = DB::table('vendor_password_resets')->where('email', $vendor->email)->exists();

        if($existPasswordReset){
            DB::table('vendor_password_resets')->where('email', $vendor->email)
            ->update(['token' => Str::random(60), 'created_at' => date('Y-m-d H:i:s')]);
        }else{
            $passwordReset = VendorPasswordReset::updateOrCreate(
                ['email' => $vendor->email],
                [
                    'email' => $vendor->email,
                    'token' => Str::random(60),
                    'id' => null, // Explicitly set id to null to allow it to be auto-generated
                ]
            );
        }

        $passwordReset = DB::table('vendor_password_resets')->where('email', $vendor->email)->first();

        if ($vendor && $passwordReset)
            $vendor->notify(
                new VendorResetPassword($passwordReset->token)
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
        return Password::broker('vendors');
    }
}
