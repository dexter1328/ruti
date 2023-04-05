<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Stripe\Stripe;
use App\Traits\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\OrderedProduct;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

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

    /**
     * @throws Exception
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = DB::table('w2b_products');

            return DataTables::of($query)
                ->addIndexColumn()
                ->toJson();
        }

        // $products = DB::table('w2b_products')->take(30)->get();
        return view('admin.wb_products.index');
    }
    public function order()
    {
        // dd('abc');
        $orders = DB::table('w2b_orders')
        ->join('users', 'w2b_orders.user_id', '=', 'users.id')
        ->select('w2b_orders.*','users.first_name','users.last_name')
        ->where('w2b_orders.is_paid','yes')
        ->get();
        return view('admin.wb_products.order',compact('orders'));
    }

    public function orderedProducts($id)
    {
        $products = OrderedProduct::where('order_id',$id)->get();

        return view('admin.wb_products.order_products',compact('products'));
    }
}
