<?php

namespace App\Http\Controllers\W2bCustomerAuth;

use App\User;
use Exception;
use App\WbWishlist;
use App\W2bCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    public $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('w2bcustomer.guest', ['except' => 'logout']);
    }


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $wb_wishlist = null;

        if (Auth::guard('w2bcustomer')->user()) {
            $wb_wishlist = WbWishlist::where('user_id', Auth::guard('w2bcustomer')->user()->id)
            ->get();
        }
        $categories = W2bCategory::with('childrens')->get();
        return view('w2b_customers.auth.login',compact('wb_wishlist','categories'));
    }
    public function authFacebook()
    {
        # code...
        return Socialite::driver('facebook')->redirect();
    }
    public function fbCallback()
    {
        # code...
        try {

            $user = Socialite::driver('facebook')->user();
            // dd($user);

            $finduser = User::where('social_id', $user->id)->first();

            if($finduser){

                Auth::guard('w2bcustomer')->login($finduser);

                return redirect()->intended('/');

            }else{
                $newUser = User::updateOrCreate(['email' => $user->email],[
                        'first_name' => $user->name,
                        'social_id'=> $user->id,
                        'social_type'=> 'facebook',
                        'password' => encrypt('123456dummy')
                    ]);

                    Auth::guard('w2bcustomer')->login($newUser);

                return redirect()->intended('/');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }



    public function authGoogle()
    {
        # code...
        return Socialite::driver('google')->redirect();
    }
    public function googleCallback()
    {

        # code...
        try {

            $user = Socialite::driver('google')->user();
            $user1 = $user->user;
            //  dd($user1['picture']);
            // dd('11223');

            $finduser = User::where('social_id', $user->id)->first();
            // dd($finduser);

            if($finduser){

                Auth::guard('w2bcustomer')->login($finduser);

                return redirect()->intended('/');

            }else{
                $newUser = User::updateOrCreate(['email' => $user->email],[
                        'first_name' => $user->name,
                        // 'image' => $user1['picture'],
                        'social_id'=> $user->id,
                        'social_type'=> 'google',
                        'password' => encrypt('123456dummy')
                    ]);

                    Auth::guard('w2bcustomer')->login($newUser);

                return redirect()->intended('/');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }



    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('w2bcustomer');
    }

    public function logout(Request $request)
    {
        Auth::guard('w2bcustomer')->logout();
        return redirect('/');
    }

}
