<?php

namespace App\Http\Controllers\Admin;

use App\W2bOrder;
use Stripe\Stripe;
use App\W2bProduct;
use App\OrderedProduct;
use App\Traits\Permission;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\ProductReviewMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        $orders = OrderedProduct::join('w2b_orders', 'ordered_products.order_id', 'w2b_orders.order_id')
        ->join('users', 'w2b_orders.user_id', 'users.id')
        ->where('ordered_products.vendor_id', 1)
        ->groupBy('ordered_products.order_id')
        ->orderBy('ordered_products.id', 'DESC')
        ->select('ordered_products.*', 'w2b_orders.is_paid as is_paid', 'users.first_name as user_name', 'users.id as user_id', DB::raw('SUM(ordered_products.total_price) as o_total_price'))
        ->get();

        // dd($orders);
        return view('admin.wb_products.order',compact('orders'));
    }

    public function orderedProducts($id)
    {
        $od = OrderedProduct::join('w2b_orders', 'ordered_products.order_id', 'w2b_orders.order_id')
        ->join('users', 'w2b_orders.user_id', 'users.id')
        ->where('ordered_products.vendor_id', 1)
        ->where('w2b_orders.order_id', $id)
        ->select('ordered_products.*')
        ->get();
        $grand_total = OrderedProduct::where('order_id', $id)
        ->where('vendor_id', 1)
        ->sum('total_price');
        // dd($hello);
        $order1 = OrderedProduct::join('w2b_orders', 'ordered_products.order_id', 'w2b_orders.order_id')
        ->join('users', 'w2b_orders.user_id', 'users.id')
        ->join('states', 'states.id', 'users.state')
        ->join('cities', 'cities.id', 'users.city')
        ->where('ordered_products.vendor_id', 1)
        ->where('w2b_orders.order_id', $id)
        ->select('ordered_products.*',
         'users.first_name as user_fname','users.last_name as user_lname',
         'users.address as user_address',
         'users.mobile as user_phone',
         'states.name as state_name',
         'cities.name as city_name')
        ->first();
        // dd($products);
        return view('admin.wb_products.order_products',compact('od','grand_total','order1'));
    }


    public function orderStatus($orderId, $sku, $status)
    {
        $product = OrderedProduct::where('order_id', $orderId)
            ->where('sku', $sku)
            ->update(['status' => $status]);

        // Check if the updated status is 'delivered'
        if ($status === 'delivered') {
            // Get the order details
            $order = OrderedProduct::join('w2b_orders', 'ordered_products.order_id', 'w2b_orders.order_id')
            ->join('users', 'w2b_orders.user_id', 'users.id')
            ->join('w2b_products', 'ordered_products.sku', 'w2b_products.sku')
            ->where('ordered_products.order_id', $orderId)
            ->where('ordered_products.sku', $sku)
            ->select('users.email', 'users.first_name', 'users.last_name','w2b_products.title','ordered_products.price','w2b_products.slug')
            ->first();
            $details = [
                'name' => $order->first_name.' '.$order->last_name,
                'product_title' => $order->title,
                'product_sku' => $sku,
                'order_no' => $orderId,
                'price' => $order->price,
                'slug' => $order->slug
            ];

            // Send an email to the seller
            Mail::to($order->email)->send(new ProductReviewMail($details));

            // You can also perform additional actions here if needed
        }

        return 'success';
    }


    public function shippingDetails($orderId, $productSku)
    {
        // dd($orderId.' and '.$productSku);
        // $product =  OrderedProduct::where('order_id', $orderId)->where('sku', $productSku)->first();
        // dd($product);
        return view('admin.wb_products.ship_detail',compact('orderId','productSku'));
    }

    public function postShippingDetails(Request $request, $orderId, $productSku)
    {
        $request->validate([
            'tracking_no' => 'required',
            'tracking_link' => 'required'
        ]);

        $order = OrderedProduct::where('order_id', $orderId)
                  ->where('sku', $productSku)
                  ->first();

            if (!$order) {
                return abort(404); // Or handle the case when the order is not found
            }

            // Update the tracking information
            $order->update([
                'tracking_no' => $request->input('tracking_no'),
                'tracking_link' => $request->input('tracking_link')
            ]);

            session()->flash('success', 'Tracking information updated successfully');

            // Redirect back to the previous page
            return redirect()->route('admin.wborderedproducts', ['orderId' => $orderId]);
    }


}
