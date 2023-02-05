<?php

namespace App\Http\Controllers\Admin;

use App\W2bOrder;
use Stripe\Stripe;
use App\OrderedProduct;
use App\Traits\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WbProductController extends Controller
{
    use Permission;

	private $stripe_secret;

	public function __construct()
	{
		$this->middleware('auth:admin');
		$this->middleware(function ($request, $next) {
			if(!$this->hasPermission(Auth::user())){
				return redirect('admin/home');
			}
			return $next($request);
		});

		$this->stripe_secret = config('services.stripe.secret');
		Stripe::setApiKey($this->stripe_secret);
	}

    public function index()
    {
        // dd('abc');
        $products = DB::table('w2b_products')->get();
        return view('admin.wb_products.index',compact('products'));
    }
    public function order()
    {
        // dd('abc');
        $orders = DB::table('w2b_orders')
        ->join('users', 'w2b_orders.user_id', '=', 'users.id')
        ->select('w2b_orders.*','users.first_name','users.last_name')
        ->where('w2b_orders.is_paid','yes')
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.wb_products.order',compact('orders'));
    }

    public function orderedProducts($id)
    {
        $products = OrderedProduct::where('order_id',$id)->get();

        return view('admin.wb_products.order_products',compact('products'));
    }

    public function orderStatus($id, $status)
    {
        // dd('122');
        # code...
        W2bOrder::where('id' , $id)->update(['status'=> $status]);
        return 'sucess';
    }

}
