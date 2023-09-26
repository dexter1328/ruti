<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Permission;
use App\Traits\AppNotification;
use Auth;
use App\OrderItems;
use App\Orders;
use App\User;
use App\Setting;
use App\OrderReturn;
use App\CustomerWallet;
use App\ProductVariants;
use App\UserDevice;
use App\RewardPoint;

class OrderReturnController extends Controller
{
	use Permission;
	use AppNotification;

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function __construct()
	{
		$this->middleware('auth:admin');
		$this->middleware(function ($request, $next) {
			if(!$this->hasPermission(Auth::user())){
				return redirect('admin/home');
			}
			return $next($request);
		});
	}

	public function index()
	{
		$return_orders = OrderItems::select('vendors.name as owner_name','vendor_stores.name as store_name','order_items.id','users.first_name','orders.order_no')
								->join('orders','orders.id','=','order_items.order_id')
								->join('vendors','vendors.id','=','orders.vendor_id')
								->join('vendor_stores','vendor_stores.id','=','orders.store_id')
								->join('users','users.id','=','order_items.customer_id')
								->where('order_items.status','return')
								// ->orWhere('order_items.status','return_request')
								->get();

		// print_r($return_orders->toArray());die();
		return view('admin/orders_returns/index',compact('return_orders'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		//
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request)
	{
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
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
							'order_items.status',
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
					->where('order_items.id',$id)
					->first();
		/*$gem_setting = Setting::where('key','reward_gems_exchagne_rate')->first();
		$coin_setting = Setting::where('key','reward_coins_exchagne_rate')->first();*/
		$gem_setting = RewardPoint::select('reward_point_exchange_rate as value')->where('reward_type','invite')->first();
		$coin_setting = RewardPoint::select('reward_point_exchange_rate as value')->where('reward_type','transaction')->first();

		return view('admin/orders_returns/show',compact('order_items','gem_setting','coin_setting'));
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		//
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
		$order_items = OrderItems::where('id',$id)->first();
		$order_items->status = 'return';
		$order_items->save();

		$quantity = $order_items->quantity;

		$product_variants = ProductVariants::where('id',$order_items->product_variant_id)->first();
		ProductVariants::where('id',$order_items->product_variant_id)
			->update(array('quantity'=>$product_variants->quantity+$order_items->quantity));
		$order = Orders::where('id',$order_items->order_id)->first();

		$user = User::where('id',$order->customer_id)->first();

		// customer wallet amount
		$customer_wallet = new CustomerWallet;
		$customer_wallet->customer_id = $user->id;
		$customer_wallet->amount = $order->total_price;
		$customer_wallet->closing_amount = $user->wallet_amount;
		$customer_wallet->type = 'refund';
		$customer_wallet->save();

		$user->wallet_amount = $user->wallet_amount+$order->total_price;
		$user->save();


		//customer notification
			$id = $id;
			$type = 'return_order';
		    $title = 'Order';
		    $message = 'Your order has been returned';
		    $devices = UserDevice::where('user_id',$order->customer_id)->where('user_type','customer')->get();
		    $this->sendNotification($title, $message, $devices, $type, $id);

		     //vendor notification
		    $id = $id;
			$type = 'return_order';
		    $title = 'Order';
		    $message = 'order has been returned';
		    $devices = UserDevice::where('user_id',$order->vendor_id)->where('user_type','vendor')->get();
		    $this->sendVendorNotification($title, $message, $devices, $type, $id);

		//refund money
		return redirect('/admin/order/return/request')->with('success',"Order has been returned.");
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy($id)
	{


	}

	public function orderReturnRequest()
	{
		$return_orders = OrderItems::select('vendors.name as owner_name','vendor_stores.name as store_name','order_items.id','users.first_name','orders.order_no')
								->join('orders','orders.id','=','order_items.order_id')
								->join('vendors','vendors.id','=','orders.vendor_id')
								->join('vendor_stores','vendor_stores.id','=','orders.store_id')
								->join('users','users.id','=','order_items.customer_id')
								->where('order_items.status','return_request')
								->get();

		return view('admin/orders_returns/return_request',compact('return_orders'));
	}

	public function orderReturnRequestShow($id)
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
							'order_items.status',
							'users.first_name',
							'orders.total_price',
							'orders.tax',
							'orders.item_total',
							'orders.promo_code',
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
					->where('order_items.id',$id)
					->first();

		/*$gem_setting = Setting::where('key','reward_gems_exchagne_rate')->first();
		$coin_setting = Setting::where('key','reward_coins_exchagne_rate')->first();*/
		$gem_setting = RewardPoint::select('reward_point_exchange_rate as value')->where('reward_type','invite')->first();
		$coin_setting = RewardPoint::select('reward_point_exchange_rate as value')->where('reward_type','transaction')->first();

		return view('admin/orders_returns/return_request_view',compact('order_items','gem_setting','coin_setting'));
	}
}
