<?php

namespace App\Http\Controllers\Supplier;

use App\SuppliersOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Permission;
use Auth;
use App\Orders;
use App\CancelledOrders;
use App\OrderItems;
use App\Setting;
use App\RewardPoint;

class CancelledOrdersController extends Controller
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
				return redirect('supplier/home');
			}
			return $next($request);
		});
	}

	public function index()
	{
		$cancelled_orders = SuppliersOrder::where('supplier_id', !empty(auth()->user()->parent_id)?auth()->user()->parent_id:auth()->id())
            ->with(['user', 'supplier', 'w2bOrder'])->latest('id')->where('status', 'cancelled')->get();

		return view('supplier/orders_cancel/index',compact('cancelled_orders'));
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
		//
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

		return view('supplier/orders_cancel/show',compact('order_items','gem_setting','coin_setting'));
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
		//
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy($id)
	{
		//
	}
}