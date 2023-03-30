<?php

namespace App\Http\Controllers\W2bCustomerAuth;

use App\W2bCategory;
use App\WbWishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;

class LoginController extends Controller
{
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
     * @return Response
     */
    public function showLoginForm()
    {
        $wb_wishlist = null;

        if (Auth::guard('w2bcustomer')->user()) {
            $wb_wishlist = WbWishlist::where('user_id', Auth::guard('w2bcustomer')->user()->id)->get();
        }
        $categories = W2bCategory::with('childrens')->get();
        return view('w2b_customers.auth.login',compact('wb_wishlist','categories'));
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
}
