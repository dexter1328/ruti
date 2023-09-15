<?php

namespace App\Http\Controllers\Vendor;

use Auth;
use App\User;
use App\Orders;
use App\Vendor;
use App\Setting;
use App\Products;
use App\W2bOrder;
use App\OrderItems;
use App\RewardPoint;
use App\VendorStore;
use App\CustomerWallet;
use App\OrderedProduct;
use App\CancelledOrders;
use App\ProductVariants;
use App\Traits\Permission;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
	use Permission;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function __construct()
	{
		$this->middleware('auth:vendor');
		$this->middleware(function ($request, $next) {
			if(!$this->hasVendorPermission(Auth::user())){
				return redirect('vendor/home');
			}
			return $next($request);
		});
	}

	public function index()
	{
		$op = OrderedProduct::join('w2b_orders', 'ordered_products.order_id', 'w2b_orders.order_id')
        ->join('users', 'w2b_orders.user_id', 'users.id')
        ->where('ordered_products.vendor_id', Auth::user()->id)
        ->where('ordered_products.seller_type', 'vendor')
        ->groupBy('ordered_products.order_id')

        ->select('ordered_products.*', 'w2b_orders.is_paid as is_paid', 'users.first_name as user_name', 'users.id as user_id', DB::raw('SUM(ordered_products.total_price) as o_total_price'))
        ->get();
        // $orders = DB::table('ordered_products')
        // ->select('w2b_orders.*', 'ordered_products.status as item_status')
        // ->join('w2b_orders', 'ordered_products.order_id', '=', 'w2b_orders.order_id')
        // ->where('ordered_products.vendor_id', Auth::user()->id)
        // ->get();

        // dd($orders);



        // dd($op);
		return view('vendor.orders.index',compact('op'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
    public function view_details($id)
	{
        $od = OrderedProduct::join('w2b_orders', 'ordered_products.order_id', 'w2b_orders.order_id')
        ->join('users', 'w2b_orders.user_id', 'users.id')
        ->where('ordered_products.vendor_id', !empty(auth()->user()->parent_id)?auth()->user()->parent_id:auth()->id())
        ->where('w2b_orders.order_id', $id)
        ->select('ordered_products.*')
        ->get();
        $grand_total = OrderedProduct::where('order_id', $id)
        ->where('vendor_id', !empty(auth()->user()->parent_id)?auth()->user()->parent_id:auth()->id())
        ->sum('total_price');
        // dd($hello);
        $order1 = OrderedProduct::join('w2b_orders', 'ordered_products.order_id', 'w2b_orders.order_id')
        ->join('users', 'w2b_orders.user_id', 'users.id')
        ->join('states', 'states.id', 'users.state')
        ->join('cities', 'cities.id', 'users.city')
        ->where('ordered_products.vendor_id', !empty(auth()->user()->parent_id)?auth()->user()->parent_id:auth()->id())
        ->where('w2b_orders.order_id', $id)
        ->select('ordered_products.*',
         'users.first_name as user_fname','users.last_name as user_lname',
         'users.address as user_address',
         'users.mobile as user_phone',
         'states.name as state_name',
         'cities.name as city_name')
        ->first();

        //  dd($od);

		return view('vendor.orders.view_details',compact('od','order1','grand_total'));
	}

    public function shippingDetails($orderId, $productSku)
    {
        // dd($orderId.' and '.$productSku);
        // $product =  OrderedProduct::where('order_id', $orderId)->where('sku', $productSku)->first();
        // dd($product);
        return view('vendor.orders.ship_detail',compact('orderId','productSku'));
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
            return redirect()->route('vendor.orders.view_details', ['orderId' => $orderId]);
    }


	public function create()
	{
		$vendor_stores= VendorStore::where('vendor_id','=',Auth::user()->id)->get();
		$users = User::all();
		$products = Products::all();
		return view('vendor/orders/create',compact('vendor_stores','users','products'));
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request)
	{
		if($request->date)
		{
			$date = date("Y-m-d", strtotime($request->input('date')));
		}else{
			$date = '';
		}
		// print_r($date);die();
		$request->validate([
			'vendor_id'=>'required',
			'store_id'=>'required',
			'customer_id'=>'required',
			'type'=>'required',
			'order_status'=>'required',
			'product_id'=>'required'
		]);

		$order = new Orders;
		$order->vendor_id = Auth::user()->id;
		$order->store_id = $request->input('store_id');
		$order->customer_id = $request->input('customer_id');
		$order->type = $request->input('type');
		$order->pickup_date = $date;
		$order->pickup_time = $request->input('time');
		$order->order_status = $request->input('order_status');
		$order->created_by = Auth::user()->id;
		// print_r($order->toArray());die();
		$order->save();

		foreach($request->product_id as $product)
		{
			$products = ProductVariants::where('product_id',$product)->get();
			// print_r($products->toArray());
			foreach($products as $value)
			{
				$order_items = new OrderItems;
				$order_items->order_id =$order->id;
				$order_items->product_id = $value['product_id'];
				$order_items->customer_id = $order->customer_id;
				$order_items->quantity = 1;
				$order_items->price = $value['price'];
				$order_items->discount = $value['discount'];
				$order_items->barcode_tag = $value['barcode'];
				$order_items->created_by =Auth::user()->id;
				$order_items->save();
				// print_r($order_items->toArray());
			}
		}

		return redirect('/vendor/orders')->with('success',"Order successfully saved.");
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function view_order($id)
	{
		$order_items = OrderItems::leftjoin('product_variants','product_variants.id','=','order_items.product_variant_id')
						->select('order_items.id',
							'order_items.price',
							'order_items.quantity',
							'order_items.barcode_tag',
							'order_items.discount',
							'order_items.created_at',
							'orders.type',
							'orders.total_price',
							'orders.tax',
							'orders.promo_code',
							'orders.item_total',
							'orders.id as order_id',
							'orders.order_status',
							'users.first_name',
							'users.last_name',
							'users.email',
							'users.address',
							'users.mobile',
							'product_images.image',
							'products.title',
							'vendor_stores.name as store',
							'customer_reward_useds.reward_point',
							'customer_reward_useds.gems_point',
							'customer_reward_useds.coin_point'
						)
							->leftjoin('users','users.id','=','order_items.customer_id')
							->leftjoin('product_images','product_images.variant_id','=','order_items.product_variant_id')
							->leftjoin('products','products.id','=','product_variants.product_id')
							->leftjoin('orders','orders.id','=','order_items.order_id')
							->leftjoin('vendor_stores','vendor_stores.id','=','orders.store_id')
							->leftjoin('customer_reward_useds','customer_reward_useds.order_id','order_items.order_id')
							->where('order_items.order_id',$id)
							->get();
		// print_r($order_items->toArray());die();

		/*$gem_setting = Setting::where('key','reward_gems_exchagne_rate')->first();
		$coin_setting = Setting::where('key','reward_coins_exchagne_rate')->first();*/
		$gem_setting = RewardPoint::select('reward_point_exchange_rate as value')->where('reward_type','invite')->first();
		$coin_setting = RewardPoint::select('reward_point_exchange_rate as value')->where('reward_type','transaction')->first();

		return view('vendor/orders/show',compact('order_items','gem_setting','coin_setting'));
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$vendors= Vendor::all();
		$users = User::all();
		$order = Orders::findOrFail($id);
		$vendor_stores = VendorStore::all();
		$order_items = OrderItems::where('order_id',$id)->first();
		$products = Products::all();
		return view('vendor/orders/edit',compact('vendors','users','order','vendor_stores','order_items','products'));
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, $id)
	{
		$request->validate([
			'vendor_id'=>'required',
			'store_id'=>'required',
			'customer_id'=>'required',
			'type'=>'required',
			'order_status'=>'required',
		]);

		if($request->date)
		{
			$date = date("Y-m-d", strtotime($request->input('date')));
		}else{
			$date = '';
		}
		$data = array(
				'vendor_id' => $request->input('vendor_id'),
				'store_id' => $request->input('store_id'),
				'customer_id' => $request->input('customer_id'),
				'type' => $request->input('type'),
				'pickup_date' => $date,
				'pickup_time' => $request->input('time'),
				'order_status' => $request->input('order_status'),
				'updated_by' =>Auth::user()->id
			);
		Orders::where('id',$id)->update($data);
		foreach($request->product_id as $product)
		{
			$products = ProductVariants::where('product_id',$product)->get();
			// print_r($products->toArray());
			foreach($products as $value)
			{
				$order_items = new OrderItems;
				$order_items->order_id =$id;
				$order_items->product_id = $value['product_id'];
				$order_items->quantity = 1;
				$order_items->price = $value['price'];
				$order_items->discount = $value['discount'];
				$order_items->barcode_tag = $value['barcode'];
				$order_items->created_by =Auth::user()->id;
				$order_items->save();
			}
		}

		return redirect('/vendor/orders')->with('success',"Order successfully updated.");
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy($id)
	{
		Orders::where('id',$id)->delete();
		return redirect('/vendor/orders')->with('success',"Order successfully deleted.");
	}

	public function inshop_order()
	{
		$store_ids = getVendorStore();
		$orders = Orders::join('vendors','vendors.id','=','orders.vendor_id')
								->join('vendor_stores','vendor_stores.id','=','orders.store_id')
								->join('users','users.id','=','orders.customer_id')
								->select('vendors.name as owner_name','vendor_stores.name as store_name','orders.id','orders.order_status','orders.pickup_date','orders.pickup_time','orders.type','users.first_name')
								->where('orders.type','inshop')
								->where('orders.order_status','pending')
								->whereIn('orders.store_id', $store_ids)
								->orderBy('orders.id','DESC')
								->get();

		return view('vendor/orders/inshop_order',compact('orders'));
	}

	public function inshop_order_view($id)
	{
		$order_items = OrderItems::leftjoin('product_variants','product_variants.id','=','order_items.product_variant_id')
					->select('order_items.id',
							'order_items.price',
							'order_items.quantity',
							'order_items.barcode_tag',
							'order_items.discount',
							'order_items.created_at',
							'orders.type',
							'orders.id as order_id',
							'orders.order_status',
							'orders.total_price',
							'orders.tax',
							'orders.promo_code',
							'orders.item_total',
							'users.first_name',
							'users.last_name',
							'users.email',
							'users.address',
							'users.mobile',
							'product_images.image',
							'products.title',
							'vendor_stores.name as store',
							'customer_reward_useds.reward_point',
							'customer_reward_useds.gems_point',
							'customer_reward_useds.coin_point'
						)
					->leftjoin('users','users.id','=','order_items.customer_id')
					->leftjoin('product_images','product_images.variant_id','=','order_items.product_variant_id')
					->leftjoin('orders','orders.id','=','order_items.order_id')
					->leftjoin('vendor_stores','vendor_stores.id','=','orders.store_id')
					->leftjoin('products','products.id','=','product_variants.product_id')
					->leftjoin('customer_reward_useds','customer_reward_useds.order_id','order_items.order_id')
					->where('order_items.order_id',$id)
					->get();

		/*$gem_setting = Setting::where('key','reward_gems_exchagne_rate')->first();
		$coin_setting = Setting::where('key','reward_coins_exchagne_rate')->first();*/
		$gem_setting = RewardPoint::select('reward_point_exchange_rate as value')->where('reward_type','invite')->first();
		$coin_setting = RewardPoint::select('reward_point_exchange_rate as value')->where('reward_type','transaction')->first();

		return view('vendor/orders/inshop_order_view',compact('order_items','gem_setting','coin_setting'));
	}

	public function pickup_order()
	{
		$store_ids = getVendorStore();
		$orders = Orders::join('vendors','vendors.id','=',
									'orders.vendor_id')
								->join('vendor_stores','vendor_stores.id','=','orders.store_id')
								->join('users','users.id','=','orders.customer_id')
								->select('vendors.name as owner_name','vendor_stores.name as store_name','orders.id','orders.order_status','orders.pickup_date','orders.pickup_time','orders.type','users.first_name')
								->where('vendors.parent_id','=',0)
								->where('orders.type','pickup')
								->where('orders.order_status','=','pending')
								->whereIn('orders.store_id', $store_ids)
								->orderBy('orders.id','DESC')
								->get();

		return view('vendor/orders/pickup_order',compact('orders'));
	}

	public function pickup_order_view($id)
	{
		$order_items = OrderItems::leftjoin('product_variants','product_variants.id','=','order_items.product_variant_id')
					->select('order_items.id',
							'order_items.price',
							'order_items.quantity',
							'order_items.barcode_tag',
							'order_items.discount',
							'order_items.created_at',
							'orders.type',
							'orders.id as order_id',
							'orders.total_price',
							'orders.tax',
							'orders.item_total',
							'orders.promo_code',
							'orders.order_status',
							'users.first_name',
							'users.last_name',
							'users.email',
							'users.address',
							'users.mobile',
							'product_images.image',
							'products.title',
							'vendor_stores.name as store',
							'customer_reward_useds.reward_point',
							'customer_reward_useds.gems_point',
							'customer_reward_useds.coin_point'
						)
					->leftjoin('users','users.id','=','order_items.customer_id')
					->leftjoin('product_images','product_images.variant_id','=','order_items.product_variant_id')
					->leftjoin('orders','orders.id','=','order_items.order_id')
					->leftjoin('vendor_stores','vendor_stores.id','=','orders.store_id')
					->leftjoin('products','products.id','=','product_variants.product_id')
					->leftjoin('customer_reward_useds','customer_reward_useds.order_id','order_items.order_id')
					->where('order_items.order_id',$id)
					->get();
		/*$gem_setting = Setting::where('key','reward_gems_exchagne_rate')->first();
		$coin_setting = Setting::where('key','reward_coins_exchagne_rate')->first();*/
		$gem_setting = RewardPoint::select('reward_point_exchange_rate as value')->where('reward_type','invite')->first();
		$coin_setting = RewardPoint::select('reward_point_exchange_rate as value')->where('reward_type','transaction')->first();

		return view('vendor/orders/pickup_order_view',compact('order_items','gem_setting','coin_setting'));
	}

	public function pickupInshopChangeStatus(Request $request,$id){

		$orders = Orders::where('id',$id)->first();
		$orders->status = $request->status_change;
		$orders->save();

		if($request->status_change = 'cancelled')
		{
			$user = User::where('id',$orders->customer_id)->first();

			// customer wallet amount
			$customer_wallet = new CustomerWallet;
			$customer_wallet->customer_id = $user->id;
			$customer_wallet->amount = $orders->total_price;
			$customer_wallet->closing_amount = $user->wallet_amount;
			$customer_wallet->type = 'refund';
			$customer_wallet->save();

			$user->wallet_amount = $user->wallet_amount+$orders->total_price;
			$user->save();
		}
		if($request->btnsubmit == 'pickup'){

			return redirect('/vendor/orders/pickup_order_view/'.$id)->with('success',"Order status changed.");
		}else{
			return redirect('/vendor/orders/inshop_order_view/'.$id)->with('success',"Order status changed.");
		}

	}
}
