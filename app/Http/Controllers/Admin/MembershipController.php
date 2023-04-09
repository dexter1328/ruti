<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Stripe;
use App\Membership;
use App\MembershipItem;
use App\Traits\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MembershipController extends Controller
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
		\Stripe\Stripe::setApiKey($this->stripe_secret);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	/*public function index()
	{
		$memberships  = Membership::all();
		return view('admin/memberships/index',compact('memberships'));
	}*/

	public function membershipList($type)
	{
		if($type == 'vendor'){

			$memberships = Membership::select(['memberships.*', 'membership_items.price'])
				->join('membership_items', 'membership_items.membership_id', 'memberships.id')
				->where('memberships.type', $type)
				->WhereNull('membership_items.license')
				->where(function($query){
					$query->where('membership_items.billing_period', 'month')
						->orWhereNull('membership_items.billing_period');
				})
				->where('code', '!=', 'one_time_setup_fee')
				->get();
		} else {
			$memberships = Membership::select(['memberships.*', 'membership_items.price'])
				->leftjoin('membership_items', 'membership_items.membership_id', 'memberships.id')
				->where('memberships.type', $type)
				->WhereNull('membership_items.license')
				->where(function($query){
					$query->where('membership_items.billing_period', 'month')
						->orWhereNull('membership_items.billing_period');
				})
				->where('code', '!=', 'one_time_setup_fee')
				->get();
		}

		return view('admin/memberships/index',compact('type', 'memberships'));
	}


	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create($type)
	{
		if($type == 'customer') {
			$membership_types = customer_membership_types();
		}elseif ($type == 'vendor') {
			$membership_types = vendor_membership_types();
		}elseif ($type == 'supplier') {
			$membership_types = supplier_membership_types();
		}elseif ($type == 'supplier_ruti_fullfill') {
			$membership_types = supplier_ruti_fullfill();
		}
		return view('admin/memberships/create', compact('type', 'membership_types'));
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request)
	{

		$request->validate([
			'membership_type' => 'required|unique:memberships,code',
			'name' => 'required',
			'price' => 'required|numeric'
		],[
			'membership_type.unique' => 'The membership type has already been inserted.'
		]);


		if($request->membership_type == 'one_time_setup_fee'){

			$prices = [];
		}else{

			$prices = [$request->price, $request->price * 12];
		}

		$product = \Stripe\Product::create([
			'name' => $request->name,
			'description' => $request->description,
		]);
		$product_id = $product->id;

		$membership = new Membership;
		$membership->stripe_product_id = $product_id;
		$membership->code = $request->membership_type;
		$membership->name = $request->name;
		$membership->description = $request->description;
		$membership->type = $request->type;
		$membership->created_by = Auth::user()->id;
		$membership->save();

		if(empty($prices)){

			$price = \Stripe\Price::create([
				'product' => $product_id,
				'unit_amount' => $request->price * 100,
				'currency' => 'usd',
			]);

			$membership_item = new MembershipItem;
			$membership_item->membership_id = $membership->id;
			$membership_item->stripe_price_id = $price->id;
			$membership_item->price = $request->price;
			$membership_item->save();
		}else{

			foreach ($prices as $key => $value) {

				$interval = ($key == 0 ? 'month' : 'year');
				$price = \Stripe\Price::create([
					'product' => $product_id,
					'unit_amount' => $value * 100,
					'currency' => 'usd',
					'recurring' => [
						'interval' => $interval,
					],
				]);

				$membership_item = new MembershipItem;
				$membership_item->membership_id = $membership->id;
				$membership_item->stripe_price_id = $price->id;
				$membership_item->billing_period = $interval;
				$membership_item->price = $value;
				$membership_item->save();
			}
		}

		return redirect('/admin/membership/list/'.$request->type)->with('success',"Membership has been saved.");
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		$membership = Membership::find($id);
		if($membership->status == 'active'){
			Membership::where('id',$id)->update(array('status' => 'deactive'));
			echo json_encode('deactive');
		}else{
			Membership::where('id',$id)->update(array('status' => 'active'));
			echo json_encode('active');
		}
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(Request $request, $id)
	{
		$membership = Membership::select('memberships.*', 'membership_items.price')
			->leftjoin('membership_items', 'membership_items.membership_id', 'memberships.id')
			->where('memberships.id', $id)
			->where(function($query){
				$query->where('membership_items.billing_period', 'month')
					->orWhereNull('membership_items.billing_period');
			})
			->first();
		$features = [];
		if($membership->type == 'customer'){
			$features = customer_membership_features();
		}elseif($membership->type == 'vendor'){
			$features = vendor_membership_features();
		}

		return view('/admin/memberships/edit',compact('membership', 'features'));
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
		//echo '<pre>'; print_r($request->all()); exit();
		$membership = Membership::findOrFail($id);
		$membership->description = $request->features;
		$membership->updated_by = Auth::user()->id;
		$membership->save();

		if($membership->type == 'supplier'){

			$prices = [$request->price, $request->price * 12];


				$membership_items = MembershipItem::where('membership_id',$id)->get();

				foreach($membership_items as $key => $membership_item){
					$stripe = new \Stripe\StripeClient(
						env('STRIPE_SECRET')
					  );
					  $stripe->prices->update(
						$membership_item->stripe_price_id,
						['metadata' => ['order_id' => '6735']]
					  );
					$membership_item->price = $key == 0? $request->price:$request->price*12;
					$membership_item->update();
				}



				// $membership_item = MembershipItem::where('membership_id',$id)->get();
				// $stripe = new \Stripe\StripeClient(
				// 	env('STRIPE_SECRET')
				//   );
				//   $stripe->prices->update(
				// 	$membership_item->stripe_price_id
				//   );
				// $membership_item->price =$request->price* 100;
				// $membership_item->update();
			// }
		}

		return redirect('/admin/membership/list/'.$request->type)->with('success',"Membership has been updated.");
	}

	/**
	* Remove the specified resource from storage.
	* @param \App\Membership
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(Membership $membership)
	{
		$membership->delete();
		return redirect('/admin/membership')->with('success',"Membership has been deleted.");
	}
}
