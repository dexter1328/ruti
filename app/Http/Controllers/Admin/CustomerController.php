<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Country;
use App\State;
use App\City;
use App\Orders;
use App\ProductReview;
use App\CustomerRewardPoint;
use App\CustomerRewardUsed;
use App\Traits\Permission;
use App\LogActivity;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerSignup;
use DB;

class CustomerController extends Controller
{
	use Permission;
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
		
		$customers = User::leftjoin('orders','orders.customer_id','users.id')
					->select('users.id as user_id','users.first_name','users.email','users.dob','users.mobile','users.status','orders.id',DB::raw('COUNT(orders.customer_id) as count','orders.id as order_id'))
					->groupBy('users.id')
					->get();
		
		return view('admin/customers/index',compact('customers'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$countries = Country::all();
		return view('admin/customers/create',compact('countries'));
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
			'first_name'=>'required',
			'last_name'=>'required',
			'email' => 'required|email|unique:users',
			'password'=>'required|min:6',
			'address'=>'required',
			'city'=>'required',
			'state'=>'required',
			'country'=>'required',
			'pincode'=>'required|numeric',
			'dob'=>'required',
			'mobile' =>'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
			'terms_conditions'=>'required',
			'status'=>'required',
		], [
			'pincode.required' => 'The zip code field is required.'
		]);

		$user = new User;
		$user->first_name = $request->input('first_name');
		$user->last_name = $request->input('last_name');
		$user->email = $request->input('email');
		$user->password = bcrypt($request->input('password'));
		$user->address = $request->input('address');
		$user->city = $request->input('city');
		$user->state = $request->input('state');
		$user->country = $request->input('country');
		$user->lat = $request->input('lat');
		$user->long = $request->input('long');
		$user->pincode = $request->input('pincode');
		$user->dob = date("Y-m-d", strtotime($request->input('dob')));
		$user->anniversary_date = ($request->input('anniversary_date')!='' ? date("Y-m-d", strtotime($request->input('anniversary_date'))) : NULL);
		$user->mobile = $request->input('mobile');
		$user->receive_newsletter = $request->input('receive_newsletter');
		$user->terms_conditions = $request->input('terms_conditions');
		$user->status = $request->input('status');
		$user->save();

		//$name = $user->first_name.' '.$user->last_name;
		$name = $user->first_name;
		Mail::to($user->email)->send(new CustomerSignup($user->email,$name));

		return redirect('/admin/customer')->with('success',"Customer has been saved.");
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		$orders = Orders::select('order_no','created_at','id')->where('customer_id',$id)->get();
		echo json_encode($orders);
	}

	/**
	* Show the form for editing the specified resource.
	* @param App\User customer
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(User $customer)
	{
		$countries = Country::all();
		return view('admin/customers/edit',compact('customer','countries'));
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
			'first_name'=>'required',
			'last_name'=>'required',
			'email' => 'required|unique:users,email,' . $id,
			'address'=>'required',
			'city'=>'required',
			'state'=>'required',
			'country'=>'required',
			'pincode'=>'required',
			'dob'=>'required',
			'mobile' =>'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
			'terms_conditions'=>'required',
			'status'=>'required',
		], [
			'pincode.required' => 'The zip code field is required.'
		]);

		$data =	array('first_name' => $request->input('first_name'),
					'last_name' => $request->input('last_name'),
					'email' => $request->input('email'),
					'address' => $request->input('address'),
					'city' => $request->input('city'),
					'state' => $request->input('state'),
					'country' => $request->input('country'),
					'lat' => $request->input('lat'),
					'long' => $request->input('long'),
					'pincode' => $request->input('pincode'),
					'dob' => date("Y-m-d", strtotime($request->input('dob'))),
					'anniversary_date' =>($request->input('anniversary_date')!='' ? date("Y-m-d", strtotime($request->input('anniversary_date'))) : NULL),
					'mobile' => $request->input('mobile'),
					'receive_newsletter' => $request->input('receive_newsletter'),
					'terms_conditions' => $request->input('terms_conditions'),
					'status' => $request->input('status')
				);
		User::where('id',$id)->update($data);
		return redirect('/admin/customer')->with('success',"Customer has been updated.");
	}

	/**
	* Remove the specified resource from storage.
	* @param App\User customer
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(User $customer)
	{
		$customer->delete();
		return redirect('/admin/customer')->with('success',"Customer has been deleted.");
	}

	public function customerStatus($id)
	{
		$user = User::find($id);
		if($user->status == 'active'){
			User::where('id',$id)->update(array('status' => 'deactive'));
			echo json_encode('deactive');
		}else{
			User::where('id',$id)->update(array('status' => 'active'));
			echo json_encode('active');
		}
	}

	public function view($id)
	{
        $user = User::select(
				'users.first_name',
	            'users.last_name',
	            'users.id as user_id',
	            'users.mobile',
	            'users.status',
	            'users.email',
	            'users.image',
	            'users.created_at',
	            'users.address',
	            'users.pincode',
	            'countries.name as country',
	            'states.name as state',
	            'cities.name as city',
	            DB::raw("( SELECT SUM(customer_reward_points.total_point) FROM customer_reward_points WHERE (customer_reward_points.user_id = '".$id."')) as point"),
	            DB::raw("( SELECT SUM(customer_reward_useds.reward_point) FROM customer_reward_useds WHERE (customer_reward_useds.user_id = '".$id."')) as used_point")
			)
			->leftjoin('countries','countries.id','users.country')
			->leftjoin('states','states.id','users.state')
			->leftjoin('cities','cities.id','users.city')
			->leftjoin('customer_reward_points','customer_reward_points.user_id','users.id')
			->leftjoin('customer_reward_useds','customer_reward_useds.user_id','users.id')
	        ->where('users.id',$id)
	        ->first();
				
		$product_reviews = ProductReview::select(
				'product_reviews.comment',
				'product_reviews.rating',
				'product_variants.price',
				'products.id',
				'products.title',
				'vendor_stores.name'
			)
			->join('product_variants','product_variants.id','product_reviews.product_id')
			->join('products','products.id','product_variants.product_id')
			->join('vendor_stores','vendor_stores.id','products.store_id')
			->where('product_reviews.customer_id',$id)
			//->get();
			->paginate(5);

        /*$orders = Orders::join('order_items','order_items.order_id','=','orders.id')
        			->join('product_variants','product_variants.id','order_items.product_variant_id')
        			->join('products','products.id','product_variants.product_id')
        			->join('vendor_stores','vendor_stores.id','orders.store_id')
                    ->join('product_reviews','product_reviews.product_id','order_items.product_variant_id')
                    ->select(
                    	'orders.id',
                    	'products.title',
                    	'order_items.quantity',
                    	'order_items.price',
                    	'vendor_stores.name',
                    	'product_reviews.comment',
                    	'product_reviews.rating'
     				)
                    ->where('orders.customer_id',$id)
                    ->get();*/

        return view('/admin/customers/show', compact('user', 'product_reviews'));
	}

	public function incentives()
	{
		// die('incentives');
		$customers = [];
		$tier1_customers = [];
		/*
		$tier1 = User::select(
				'users.*',
				DB::raw('COUNT(orders.id) as order_count')
			)
			->join('user_subscriptions', 'user_subscriptions.user_id', 'users.id')
			->join('orders', 'orders.customer_id', 'users.id')
			->where('user_subscriptions.membership_code', 'bougie')
			->where('orders.total_price', '>=', 150)
			->where('orders.order_status', 'completed')
			->having('order_count', '>=', 2)
			->get();
		*/
		$tier2_customers = [];
		/*
		$tier2 = User::select(
				'users.*',
				DB::raw('COUNT(orders.id) as order_count')
			)
			->join('user_subscriptions', 'user_subscriptions.user_id', 'users.id')
			->join('orders', 'orders.customer_id', 'users.id')
			->where('user_subscriptions.membership_code', 'classic')
			->where('orders.total_price', '>=', 100)
			->where('orders.order_status', 'completed')
			->having('order_count', '>=', 2)
			->get();
		*/
		$tier3_customers = [];
		/*
		$tier3 = User::select(
				'users.*',
				DB::raw('COUNT(orders.id) as order_count')
			)
			->leftjoin('user_subscriptions', 'user_subscriptions.user_id', 'users.id')
			->join('orders', 'orders.customer_id', 'users.id')
			->where(function ($query) {
				$query->where('user_subscriptions.status', 'inactive')
					->orWhereNull('user_subscriptions.id');
			})
			->where('orders.total_price', '>=', 100)
			->where('orders.order_status', 'completed')
			->having('order_count', '>=', 2)
			->groupBy('users.id')
			->get();
		*/
		/*$customers = User::leftjoin('orders','orders.customer_id','users.id')
					->select('users.id as user_id','users.first_name','users.email','users.dob','users.mobile','users.status','orders.id',DB::raw('COUNT(orders.customer_id) as count','orders.id as order_id'))
					->groupBy('users.id')
					->get();*/
		return view('/admin/customers/incentive', compact('customers'));
	}

}
