<?php

namespace App\Http\Controllers\Admin;

use App\W2bOrder;
use Stripe\Stripe;
use App\W2bProduct;
use App\OrderedProduct;
use App\Traits\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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

    public function index(Request $request)
    {
        //  dd('abc');
        // $products = DB::table('w2b_products')->get();
        // return view('admin.wb_products.index',compact('products'));
        if ($request->ajax()) {
            $data = W2bProduct::all();
            return DataTables::of($data)
                    ->addIndexColumn()

                    ->make(true);
        }

        return view('admin.wb_products.index');
    }
    public function order()
    {
        // dd('abc');
        $orders = DB::table('w2b_orders')
        ->join('users', 'w2b_orders.user_id', '=', 'users.id')
        ->join('ordered_products', 'ordered_products.order_id', '=', 'w2b_orders.order_id')
        ->where('w2b_orders.is_paid','yes')
        ->where('ordered_products.vendor_id',1)
        ->select('ordered_products.*','w2b_orders.order_notes','w2b_orders.status','users.first_name','users.last_name')
        ->orderBy('id', 'DESC')
        ->groupBy('ordered_products.order_id')
        ->get();

        // dd($orders);
        return view('admin.wb_products.order',compact('orders'));
    }

    public function orderedProducts($id)
    {
        $products = OrderedProduct::where('order_id',$id)
        ->where('vendor_id', 1)
        ->get();
        // dd($products);
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
