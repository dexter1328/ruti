<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Permission;
use App\ProductReview;
use App\User;
use App\Country;
use App\State;
use App\City;
use App\Orders;
use App\Vendor;
use App\VendorPaidModule;
use Auth;
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
		$store_ids = getVendorStore();
		$customers = User::join('orders','orders.customer_id','users.id')
					->select('users.id as user_id','users.first_name','users.email','users.dob','users.mobile','users.status','orders.id',DB::raw('COUNT(orders.customer_id) as count','orders.id as order_id'))
					//->whereIn('users.id',$order)
					->whereIn('orders.store_id', $store_ids)
					->groupBy('users.id')
					->get();
		
		//print_r($customers);die();
		$vendor_paid_module = VendorPaidModule::where('module_code','customer_contact_info')
						->where('vendor_id',Auth::user()->id)
						->first();

		return view('vendor/customers/index',compact('customers','vendor_paid_module'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$countries = Country::all();
		return view('vendor/customers/create',compact('countries'));
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
			'password'=>'required',
			'address'=>'required',
			'city'=>'required',
			'state'=>'required',
			'country'=>'required',
			'lat'=>'required',
			'long'=>'required',
			'pincode'=>'required',
			'dob'=>'required',
			'mobile'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/',
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
		$user->anniversary_date = date("Y-m-d", strtotime($request->input('anniversary_date')));
		$user->mobile = $request->input('mobile');
		$user->receive_newsletter = $request->input('receive_newsletter');
		$user->terms_conditions = $request->input('terms_conditions');
		$user->status = $request->input('status');
		$user->save();
		return redirect('/vendor/customer')->with('success',"Customer Successfully Saved.");
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		$store_ids = getVendorStore();
		$orders = Orders::select('order_no','created_at','id')->where('customer_id',$id)->whereIn('orders.store_id', $store_ids)->get();

		echo json_encode($orders);
		
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

	/**
	* Show the form for editing the specified resource.
	* @param App\User customer
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(User $customer)
	{
		$countries = Country::all();
		return view('vendor/customers/edit',compact('customer','countries'));
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
			'lat'=>'required',
			'long'=>'required',
			'pincode'=>'required',
			'dob'=>'required',
			'anniversary_date'=>'required',
			'mobile'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/',
			'terms_conditions'=>'required',
			'status'=>'required',
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
					'anniversary_date' => date("Y-m-d", strtotime($request->input('anniversary_date'))),
					'mobile' => $request->input('mobile'),
					'receive_newsletter' => $request->input('receive_newsletter'),
					'terms_conditions' => $request->input('terms_conditions'),
					'status' => $request->input('status')
				);
		User::where('id',$id)->update($data);
		return redirect('/vendor/customer')->with('success',"Customer Successfully Updated.");
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
		return redirect('/vendor/customer')->with('success',"Customer Successfully Deleted.");
	}

	public function view($id)
	{
        $user = User::select('users.first_name',
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
			->where('products.vendor_id',Auth::user()->id)
			//->get();
			->paginate(5);

        /*$orders = Orders::join('order_items','order_items.order_id','=','orders.id')
        			->leftjoin('product_variants','product_variants.id','order_items.product_variant_id')
        			->leftjoin('products','products.id','product_variants.product_id')
        			->leftjoin('vendor_stores','vendor_stores.id','orders.store_id')
                    ->leftjoin('product_reviews','product_reviews.product_id','order_items.product_variant_id')
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
                    ->where('orders.vendor_id',Auth::user()->id)
                    ->get();*/
        $vendor_paid_module = VendorPaidModule::where('module_name','customer_contact_info')
						->where('vendor_id',Auth::user()->id)
						->first();
        return view('/vendor/customers/show', compact('user', 'product_reviews','vendor_paid_module'));
	}
}
