<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\AdminOTPMail;
use Illuminate\Support\Facades\Mail;
use Hash;
use App\Admin;
use App\AdminRole;
use App\VendorOtp;
use App\Helpers\LogActivity as Helper;
use Redirect;
use Carbon\Carbon;
use Str;
use DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

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
        $this->middleware('admin.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {

        return Auth::guard('admin');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['status' => 'active']);
    }

    public function login(Request $request)
    {
        // echo'hello';exit();
        $errors = [$this->username() => trans('auth.failed')];

        // Load user from database
        $user = Admin::where($this->username(), $request->{$this->username()})->first();

        if(!empty($user)){
            if($user->id != 1){
                $role = AdminRole::where('id', $user->role_id)->first();
                if($role->status == 'deactive'){
                    $user->status = 'deactive';
                }
            }
            // Check if user was successfully loaded, that the password matches
            if (\Hash::check($request->password, $user->password)) {

                // Check if user status
                if ($user && \Hash::check($request->password, $user->password) && $user->status != 'active') {

                    $errors = [$this->username() => trans('Your account is inactive. Please contact your admin.')];
                }elseif($user && \Hash::check($request->password, $user->password) && $user->status == 'active'){
                    $token = Str::random(60);
                    $this->sendOTP($user->email, $token);
                    return Redirect::to('admin/submit-otp/'.$token);
                    // Auth::guard('admin')->loginUsingId($user->id);
                    return redirect('admin/home');
                }
            }else{
                $errors = [$this->username() => trans('These credentials do not match our records.')];
            }

            return redirect('/admin/login')->withErrors($errors);
        }else{
            return redirect('/admin/login')->withErrors($errors);
        }
    }

    private function sendOTP($email, $token)
    {
        $existOTP = DB::table('admin_otps')->where('email', $email)->exists();
        $otp = rand(1000,9999);
        $created_at = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
        if($existOTP){
            DB::table('admin_otps')->where('email', $email)
            ->update(['token' => $token, 'otp' => $otp, 'created_at' => $created_at]);
        }else{
            DB::table('admin_otps')->insert([
                ['email' => $email, 'token' => $token, 'otp' => $otp, 'created_at' => $created_at],
            ]);
        }
        Mail::to($email)->send(new AdminOTPMail($otp));
    }

    public function resendOtpMail(Request $request)
    {
        if(!empty($request->all())){
            $email = $request->email;
            $token = $request->token;
            $this->sendOTP($email, $token);
            echo json_encode('OTP has been sent. please check your email inbox.');exit();
        }
    }

    public function submitOTP(Request $request, $token)
    {
        $admin_otp = DB::table('admin_otps')->where('token', $token)->first();

        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $admin_otp->created_at);
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
        $time_diff = $to->diff($from)->format('%I:%S');

        if(empty($request->all())){
            return view('admin/auth/otp', compact('admin_otp', 'time_diff'));
        }else{

            $validator = Validator::make($request->all(), [
                'otp' => 'required|numeric|digits:4'
            ]);

            if($validator->fails()){
                $errors = $validator->errors();
                return Redirect::back()->withErrors($errors);
            }

            $chk_admin_otp = DB::table('admin_otps')->select('admins.id', 'admin_otps.created_at')
                ->join('admins', 'admins.email', '=', 'admin_otps.email')
                ->where('admin_otps.token', $token)
                ->where('admin_otps.otp', $request->otp)
                ->first();

            if(!empty($chk_admin_otp))
            {
                $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $chk_admin_otp->created_at);
                $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
                $diff_in_minutes = $to->diffInMinutes($from);

                if($diff_in_minutes <= 15)
                {
                    Auth::guard('admin')->loginUsingId($chk_admin_otp->id);
                    DB::table('admin_otps')->where('email',$admin_otp->email)->delete();
                    return redirect('admin/home');
                }else{
                    $errors = ['errors'=>'OTP has been expired.'];
                    return Redirect::back()->withErrors($errors);
                }

            }else{
                $errors = ['errors'=>'Invalid OTP.'];
                return Redirect::back()->withErrors($errors);
            }
        }

    }

    public function logoutToPath() {
        return '/admin/login';
    }
}
