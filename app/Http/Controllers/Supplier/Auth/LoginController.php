<?php

namespace App\Http\Controllers\Supplier\Auth;

use App\Helpers\LogActivity as Helper;
use App\Mail\StoreMainVendorMail;
use App\Mail\VendorOTPMail;
use App\StoresVendor;
use App\Vendor;
use App\VendorStoreHours;
use App\VendorStorePermission;
use App\WbWishlist;
use Carbon\Carbon;
use Hash;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
    public $redirectTo = '/supplier/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('vendor.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return Renderable
     */
    public function showLoginForm()
    {
        $wb_wishlist = null;

        if (Auth::guard('w2bcustomer')->user()) {
            $wb_wishlist = WbWishlist::where('user_id', Auth::guard('w2bcustomer')->user()->id)->get();
        }
        return view('supplier.auth.login',compact('wb_wishlist'));
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('vendor');
    }

    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['status' => 'active']);
    }

    public function login(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];
        $user = Vendor::supplier()->where($this->username(), $request->{$this->username()})->first();

        if(!empty($user)){
            if ($user && Hash::check($request->password, $user->password)) {
                if($user->parent_id!=0){
                    $parent_user = Vendor::supplier()->where('id',$user->parent_id)->first();
                    $parent_status = $parent_user->status;
                }else{
                    $parent_status = 'active';
                }
                if($user->status == 'active' && $parent_status == 'active')
                {
                    if($user->parent_id !=0)
                    {
                        // store hours condition
                        $store_vendor = StoresVendor::where('vendor_id',$user->id)->first();
                        if(!empty($store_vendor))
                        {
                            date('w'); //gets day of week as number(0=sunday,1=monday...,6=sat)

                            if(date('w') == 1){
                                $day = 'monday';
                            }else if(date('w') == 2){
                                $day = 'tuesday';
                            }else if(date('w') == 3){
                                $day = 'wednesday';
                            }else if(date('w') == 4){
                                $day = 'thursday';
                            }else if(date('w') == 5){
                                $day = 'friday';
                            }else if(date('w') == 6){
                                $day = 'saturday';
                            }else if(date('w') == 7){
                                $day = 'sunday';
                            }

                            $current_date = date("H:i");

                            $supplier_store_hours = VendorStoreHours::where('week_day',$day)
                                ->where('store_id',$store_vendor->store_id)
                                ->whereRaw('TIME(daystart_time) <= "'.$current_date.'"')
                                ->whereRaw('TIME(dayend_time) >= "'.$current_date.'"')
                                ->first();

                            if(!empty($supplier_store_hours)) {
                                //  login;direct
                                Auth::guard('vendor')->loginUsingId($user->id);
                                DB::table('vendor_otps')->where('email',$user->email)->delete();
                                Helper::addToLog('Supplier Login',$user->id);

                                return redirect('supplier/home');

                                // $token = Str::random(60);
                                // $this->sendOTP($user->email, $token);
                                // return Redirect::to('supplier/submit-otp/'.$token);

                            }else{
                                // mail to that parent supplier
                                /*$email = $parent_user->email;
                                Mail::to($email)->send(new VendorStoreHoursMail($request->email));*/
                                $curr_date = date('m/d/Y');
                                $store_permission = VendorStorePermission::where('vendor_id',$user->id)
                                    ->where('store_id',$store_vendor->store_id)
                                    ->where('to','<=',$curr_date)
                                    ->whereDate('from','>=',$curr_date)
                                    ->whereDate('status','=','active')
                                    ->first();

                                if(!empty($store_permission)) {
                                    //  login;direct
                                    Auth::guard('vendor')->loginUsingId($user->id);
                                    DB::table('vendor_otps')->where('email',$user->email)->delete();
                                    Helper::addToLog('Supplier Login',$user->id);

                                    return redirect('supplier/home');

                                    // $token = Str::random(60);
                                    // $this->sendOTP($user->email, $token);
                                    // return Redirect::to('supplier/submit-otp/'.$token);

                                }else{
                                    $email = $parent_user->email;
                                    $name = $user->name;
                                    Mail::to($email)->send(new StoreMainVendorMail($name));
                                    $errors = [$this->username() => trans('Store is currently closed. You cannot access application after store hours. Contact your administrator for more information.')];
                                }
                                // print_r($store_permission->toArray());die();
                            }
                        }else{
                            $errors = [$this->username() => trans('You Can not assign the store.')];
                        }
                    }else{
                        //  login;direct
                        Auth::guard('vendor')->loginUsingId($user->id);
                        DB::table('vendor_otps')->where('email',$user->email)->delete();
                        Helper::addToLog('Supplier Login',$user->id);

                        return redirect('supplier/home');

                        // $token = Str::random(60);
                        // $this->sendOTP($user->email, $token);
                        // return Redirect::to('supplier/submit-otp/'.$token);
                    }
                } else {
                    $errors = [$this->username() => trans('Your account is inactive. Please contact your admin.')];
                }
            } else {
                $errors = [$this->username() => trans('These credentials do not match our records.')];
            }
        } else {
            $errors = [$this->username() => trans('These credentials do not match our records.')];
        }
        return redirect('/supplier/login')->withErrors($errors);
    }

    private function sendOTP($email, $token)
    {
        $existOTP = DB::table('vendor_otps')->where('email', $email)->exists();
        $otp = rand(1000,9999);
        $created_at = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
        if($existOTP){
            DB::table('vendor_otps')->where('email', $email)
                ->update(['token' => $token, 'otp' => $otp, 'created_at' => $created_at]);
        }else{
            DB::table('vendor_otps')->insert([
                ['email' => $email, 'token' => $token, 'otp' => $otp, 'created_at' => $created_at],
            ]);
        }
        Mail::to($email)->send(new VendorOTPMail($otp));
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
        $vendor_otp = DB::table('vendor_otps')->where('token', $token)->first();

        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $vendor_otp->created_at);
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
        $time_diff = $to->diff($from)->format('%I:%S');

        if(empty($request->all())){
            return view('supplier/auth/otp', compact('vendor_otp', 'time_diff'));
        }else{

            $validator = Validator::make($request->all(), [
                'otp' => 'required|numeric|digits:4'
            ]);

            if($validator->fails()){
                $errors = $validator->errors();
                return Redirect::back()->withErrors($errors);
            }

            $chk_vendor_otp = DB::table('vendor_otps')->select('vendors.id', 'vendor_otps.created_at')
                ->join('vendors', 'vendors.email', '=', 'vendor_otps.email')
                ->where('vendor_otps.token', $token)
                ->where('vendor_otps.otp', $request->otp)
                ->first();

            if(!empty($chk_vendor_otp))
            {
                $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $chk_vendor_otp->created_at);
                $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
                $diff_in_minutes = $to->diffInMinutes($from);

                if($diff_in_minutes <= 15)
                {
                    Auth::guard('vendor')->loginUsingId($chk_vendor_otp->id);
                    DB::table('vendor_otps')->where('email',$vendor_otp->email)->delete();
                    Helper::addToLog('Supplier Login',$chk_vendor_otp->id);
                    return redirect('supplier/home');
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
        return '/supplier/login';
    }

}
