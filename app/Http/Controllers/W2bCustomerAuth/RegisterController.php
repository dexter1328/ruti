<?php

namespace App\Http\Controllers\W2bCustomerAuth;

use App\User;
use Exception;
use Validator;
use App\W2bCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required',
			'last_name' => 'required',
			'email' => 'required|email|unique:users',
			'mobile'=>'required',
            'password' => 'required|min:6|confirmed',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
			'social_id' => 'unique:users'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Vendor
     */
    protected function create(array $data)
    {
        $imageName = time().'.'.$data['image']->extension();
        $data['image']->move(public_path('user_photo'), $imageName);
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'image' => $imageName,
            'password' => bcrypt($data['password']),
        ]);
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

            $finduser = User::where('social_id', $user->id)->first();

            if($finduser){

                Auth::guard('w2bcustomer')->login($finduser, true);

                return redirect()->intended('/');

            }else{
                $newUser = User::updateOrCreate(['email' => $user->email],[
                        'first_name' => $user->name,
                        'social_id'=> $user->id,
                        'social_type'=> 'facebook',
                        'password' => encrypt('123456dummy')
                    ]);

                    Auth::guard('w2bcustomer')->login($newUser, true);

                return redirect()->intended('/');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $wb_wishlist = null;

        if (Auth::guard('w2bcustomer')->user()) {
            $wb_wishlist = WbWishlist::where('user_id', Auth::guard('w2bcustomer')->user()->id)
            ->get();
        }
        $categories = W2bCategory::with('childrens')->get();
        $categories2 = W2bCategory::inRandomOrder()
        ->whereNotIn('category1', ['others','other'])
        ->paginate(6);
        return view('w2b_customers.auth.register',compact('wb_wishlist','categories','categories2'));
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('w2bcustomer');
    }
}
