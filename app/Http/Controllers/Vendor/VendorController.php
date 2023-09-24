<?php

namespace App\Http\Controllers\Vendor;

use DB;
use Auth;
use Schema;
use App\City;
use App\User;
use App\State;
use Exception;
use Validator;
use App\Orders;
use App\Vendor;
use App\Country;
use App\Category;
use App\Products;
use Carbon\Carbon;
use Stripe\Charge;
use Stripe\Stripe;
use App\Membership;
use App\UserDevice;
use Stripe\Product;
use App\VendorRoles;
use App\VendorStore;
use App\W2bCategory;
use Stripe\Customer;
use App\StoresVendor;
use App\ProductReview;
use App\SellerProduct;
use App\CustomerWallet;
use App\ProductVariants;
use App\WithdrawRequest;
use App\marketplaceOrder;
use App\MembershipCoupon;
use App\VendorPaidModule;
use App\Mail\WithdrawMail;
use App\StoreSubscription;
use App\Traits\Permission;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\StoreSubscriptionTemp;
use App\VendorStorePermission;
use App\Mail\AdminWithdrawMail;
use Stripe\Exception\CardException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Helpers\LogActivity as Helper;
use App\Mail\SupplierMarketplaceOrderMail;
use App\Mail\VendorMarketplaceOrderMail;
use Illuminate\Support\Facades\Config;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\RateLimitException;
use Stripe\Exception\ApiConnectionException;
use Stripe\Exception\AuthenticationException;
use Stripe\Exception\InvalidRequestException;
use Stripe\Payout;
use Stripe\Token;
use Stripe\Transfer;

class VendorController extends Controller
{
	use Permission;

	private $stripe_secret;
    private $stripe_key;

	public function __construct()
	{
		$this->middleware('auth:vendor');
		// $this->middleware(function ($request, $next) {
		// 	if(!$this->hasVendorPermission(Auth::user())){
		// 		return redirect('vendor/home');
		// 	}
		// 	return $next($request);
		// });
        $this->stripe_secret = config('services.stripe.secret');
        $this->stripe_key = config('services.stripe.key');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{

		// $vendors = Vendor::whereNotIn('id',[1])->where('parent_id','=',Auth::user()->id)->get();
		return view('supplier.suppliers.index');
	}

	public function view(request $request)
    {
    	$columns = array(
			0 => 'name',
			1 => 'phone_number',
			2 => 'email',
			3 => 'role',
			4 => 'action'
		);
		$totalData = Vendor::whereNotIn('id',[1])
				->where('parent_id','=',Auth::user()->id)->count();

        $totalFiltered = $totalData;

		$limit = $request->input('length');
		$start = $request->input('start');
		$order = $columns[$request->input('order.0.column')];
		$dir = $request->input('order.0.dir');


		if(empty($request->input('search.value'))){

			$vendors = Vendor::leftjoin('vendor_roles','vendor_roles.id','vendors.role_id')
				->select('vendors.name', 'vendors.pincode', 'vendors.mobile_number', 'vendors.email', 'vendors.id','vendors.status','vendors.parent_id','vendor_roles.role_name')
				->whereNotIn('vendors.id',[1])
				->where('vendors.parent_id','=',Auth::user()->id)
				->offset($start)
				->limit($limit)
				->orderBy($order,$dir)
				->get();

		}else{

			$search = $request->input('search.value');


			$vendors = Vendor::leftjoin('vendor_roles','vendor_roles.id','vendors.role_id')
				->select('vendors.name', 'vendors.pincode', 'vendors.mobile_number', 'vendors.email', 'vendors.id','vendors.status','vendors.parent_id','vendor_roles.role_name')
				->whereNotIn('vendors.id',[1])
				->where('vendors.parent_id','=',Auth::user()->id);

	        	$vendors = $vendors->where(function($query) use ($search){
				$query->where('vendors.name', 'LIKE',"%{$search}%")
					->orWhere('vendors.pincode', 'LIKE',"%{$search}%")
					->orWhere('vendors.email', 'LIKE',"%{$search}%")
					->orWhere('vendors.mobile_number', 'LIKE',"%{$search}%")
					->orWhere('vendor_roles.role_name', 'LIKE',"%{$search}%");
					//->orWhereRaw("GROUP_CONCAT(attribute_values.name) LIKE ". "%{$search}%");
			});
			//$products = $products->orHavingRaw('Find_In_Set("'.$search.'", attribute_value_names) > 0');

			$totalFiltered = $vendors;
			$totalFiltered = $totalFiltered->get()->count();

			$vendors = $vendors->offset($start)
				->limit($limit)
				->orderBy($order,$dir)
				->get();
		}

        $data = array();
		if($vendors->isNotEmpty())
		{
			foreach ($vendors as $key => $vendor)
			{
				// @if($admin->status=='active')color:#009933;@else color: #ff0000;@endif
				if($vendor->status == 'active')
				{
					$color = 'color:#009933;';
				}else{
					$color ='color:#ff0000;';
				}
				$cfm_msg = 'Are you sure?';

				// $url = "{{ url('/vendor/vendors/set-store-permission') }}/{{$vendor->id}}";
				$url = "vendors/set-store-permission/".$vendor->id;

				$nestedData['name'] = $vendor->name;
				$nestedData['pincode'] = $vendor->pincode;
				$nestedData['phone_no'] = $vendor->mobile_number;
				$nestedData['email'] = $vendor->email;
				$nestedData['role'] = ($vendor->role_name ? $vendor->role_name: '-');
				$nestedData['action'] = '<form id="deletefrm_'.$vendor->id.'" action="'.route('vendors.destroy', $vendor->id).'" method="POST" onsubmit="return confirm(\''.$cfm_msg.'\');">
											<input type="hidden" name="_token" value="'.csrf_token().'">
											<input type="hidden" name="_method" value="DELETE">
											<a href="'.route('vendors.edit', $vendor->id).'" data-toggle="tooltip" data-placement="bottom" title="Edit Vendor">
											<i class="icon-note icons"></i>
											</a>
											<a href="javascript:void(0);" onclick="deleteRow('.$vendor->id.')" data-toggle="tooltip" data-placement="bottom" title="Delete Vendor">
												<i class="icon-trash icons"></i>
											</a>

											<a href="'.$url.'">
									 			<i class="icon-basket-loaded icons" data-toggle="tooltip" data-placement="bottom" title="Set Store Permission"></i>
											</a>

											<a href="javascript:void(0);" onclick="changeStatus('.$vendor->id.')" >
										 		<i class="fa fa-circle status_'.$vendor->id.'" style="'.$color.'" id="active_'.$vendor->id.'" data-toggle="tooltip" data-placement="bottom" title="Change Status" ></i>
											</a>


										</form>';
				$data[] = $nestedData;
			}

		}

		$json_data = array(
			"draw"            => intval($request->input('draw')),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);exit();
    }
	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$countries = Country::all();
		$vendor_stores = VendorStore::where('vendor_id','=',Auth::user()->id)->get();
		$vendor_roles =VendorRoles::where('vendor_id',Auth::user()->id)->get();
		return view('vendor/vendors/create',compact('countries','vendor_stores','vendor_roles'));
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request)
	{

		$date = date('Y-m-d');
		$request->validate([
			'mobile_number'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/',
			'phone_number'=>'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
			'email' => 'required|email|unique:vendors',
			'password' => 'required|min:6',
    		'confirm_password' => 'required|min:6|same:password',
			'name'=>'required',
			'status'=>'required',
			'store_id' => 'required',
			'role_id' => 'required'
		 ],[
        	'email.unique' => 'The email has already been taken by you or some other vendor.'
        ]);

		$vendor_parent = Vendor::where('id',Auth::user()->id)->first();

		if($vendor_parent->parent_id == 0){
			$parent_id = $vendor_parent->id;
		}else{
			$parent_id = $vendor_parent->parent_id;
		}

		$vendor = new Vendor;
		$vendor->registered_date = $date;
		$vendor->address = $request->input('address');
		$vendor->country = $request->input('country');
		$vendor->state = $request->input('state');
		$vendor->city = $request->input('city');
		$vendor->pincode = $request->input('pincode');
		$vendor->name = $request->input('name');
		$vendor->phone_number = $request->input('phone_number');
		$vendor->mobile_number = $request->input('mobile_number');
		$vendor->email = $request->input('email');
		$vendor->password = bcrypt($request->input('password'));
		$vendor->role_id = $request->input('role_id');
		$vendor->parent_id = $parent_id;
		$vendor->status = $request->input('status');
		$vendor->created_by = Auth::user()->id;

		if ($files = $request->file('image')){
			$path = 'public/images/vendors';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);
			$vendor->image = $profileImage;
		}

		$vendor->save();

		if($request->has('store_id') && $request->store_id != '') {

			StoresVendor::updateOrCreate(
				['vendor_id' => $vendor->id],
				['store_id' => $request->store_id]
			);
		}

		return redirect('/vendor/vendors')->with('success',"Employee has been created.");
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		$vendor = Vendor::find($id);
		if($vendor->status == 'active'){
			Vendor::where('id',$id)->update(array('status' => 'deactive'));
			echo json_encode('deactive');
		}else{
			Vendor::where('id',$id)->update(array('status' => 'active'));
			echo json_encode('active');
		}
	}

	/**
	* Show the form for editing the specified resource.
	* @param App\Vendor $vendor
	* @return \Illuminate\Http\Response
	*/
	public function edit(Vendor $vendor)
	{
		$countries = Country::all();
		$vendor_roles =VendorRoles::where('vendor_id',Auth::user()->id)->get();
		$vendor_stores = VendorStore::where('vendor_id','=',Auth::user()->id)->get();
		$store_vendor = DB::table('stores_vendors')->where('vendor_id',$vendor->id)->first();
		return view('vendor/vendors/edit',compact('vendor','countries','vendor_roles','vendor_stores','store_vendor'));
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
			'mobile_number'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/',
			'phone_number'=>'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
			'name'=>'required',
			'email' => 'required|unique:vendors,email,' . $id,
			'status'=>'required',
			'store_id' => 'required',
			'role_id' => 'required'
		],[
        	'email.unique' => 'The email has already been taken by you or some other vendor.'
        ]);

		$data = array(
			'address' => $request->input('address'),
			'country' => $request->input('country'),
			'state' => $request->input('state'),
			'city' => $request->input('city'),
			'pincode' => $request->input('pincode'),
			'name' => $request->input('name'),
			'phone_number'=> $request->input('phone_number'),
			'mobile_number' => $request->input('mobile_number'),
			'email' => $request->input('email'),
			'role_id' => $request->input('role_id'),
			'status'    =>$request->input('status'),
			'updated_by' => Auth::user()->id
		);
		Vendor::where('id',$id)->update($data);

		if($request->has('store_id') && $request->store_id != '') {

			StoresVendor::updateOrCreate(
				['vendor_id' => $id],
				['store_id' => $request->store_id]
			);
		}

		return redirect('/vendor/vendors')->with('success',"Employee has been updated.");
	}

	/**
	* Remove the specified resource from storage.
	* @param App\Vendor $vendor
	* @return \Illuminate\Http\Response
	*/
	public function destroy(Vendor $vendor)
	{
		$vendor->delete();
		return redirect('/vendor/vendors')->with('success',"Employee has been deleted.");
	}

	public function profile()
	{
		$vendor = Auth::user();
		if($vendor->role_id){
			$vendor_role = VendorRoles::findOrFail($vendor->role_id);
			if(!empty($vendor_role)){
				$vendor->role_name = $vendor_role->role_name;
			}else{
				$vendor->role_name = 'Unknown';
			}
		}else{
			$vendor->role_name = 'Super Admin';
		}
		$countries = Country::all();
		//$data = $this->getChecklist();
		$cards = $this->retriveVendorCards();
		return view('vendor.vendors.profile',compact('vendor','countries'/*,'data'*/,'cards'));
	}

	public function editprofile(Request $request)
	{
		$vaildation_array = array(
				'name'=>'required',
				'email'=>'required|unique:vendors,email,' . Auth::user()->id,
				'address'=>'required',
				'country'=>'required',
				'state'=>'required',
				'city'=>'required',
				'pincode'=>'required',
				'mobile_number'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/',
				'phone_number'=>'nullable|regex:/^([0-9\s\-\+\(\)]*)$/'
			);
		if(Auth::user()->parent_id == 0){
			$vaildation_array['business_name'] = 'required';
			$vaildation_array['tax_id'] = 'required';
			$vaildation_array['bank_name'] = 'required';
			$vaildation_array['bank_account_number'] = 'required';
			$vaildation_array['bank_routing_number'] = 'required';
		}
		$vaildation_message_array = array(
			'pincode.required' => 'The zip code field is required.'
		);
		$request->validate($vaildation_array, $vaildation_message_array);

		$vendor = Vendor::find(Auth::user()->id);
		$vendor->name = $request->input('name');
		$vendor->email = $request->input('email');
		$vendor->phone_number = $request->input('phone_number');
		$vendor->mobile_number = $request->input('mobile_number');
		$vendor->address = $request->input('address');
		$vendor->country = $request->input('country');
		$vendor->state = $request->input('state');
		$vendor->city = $request->input('city');
		$vendor->pincode = $request->input('pincode');
		$vendor->business_name = $request->input('business_name');
		$vendor->tax_id = $request->input('tax_id');
		$vendor->bank_name = $request->input('bank_name');
		$vendor->bank_account_number = $request->input('bank_account_number');
		$vendor->bank_routing_number = $request->input('bank_routing_number');

		if ($files = $request->file('image')){
			$path = 'public/images/vendors/';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);
			$vendor->image = $profileImage;
		}

		$vendor->save();

		if($vendor->image != NULL || $vendor->image != ''){
			$this->__completeVendorChecklist(Auth::user()->id, 'signup_image_upload');
		}
		$this->__completeVendorChecklist(Auth::user()->id, 'add_vendor');

		return redirect('vendor/profile')->with('success',"Profile successfully updated.");
	}

	public function Dashboard(Request $request)
	{
        // dd('12');


		if($request->has('start') && $request->has('end') && $request->start !='' && $request->end != ''){
            // $date = explode('-',$request->daterange);
            $start_date = date('Y-m-d',strtotime($request->start));
            $end_date = date('Y-m-d',strtotime($request->end));
        }else{
            $start_date = date('Y-m-1');
            $end_date = date('Y-m-d');
        }

        $vendor_datas = Vendor::where('status','active')->where('parent_id',Auth::user()->id)->get();

        if(Auth::user()->parent_id == 0){
        	$vendorID = Auth::user()->id;
        }else{
        	$vendorID = Auth::user()->parent_id;
        }

        $vendor = Vendor::where('parent_id',$vendorID)
				->whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date])
				->count();

		$vendor_store = VendorStore::where('vendor_id', $vendorID)->get();

        $store = VendorStore::where('vendor_id',$vendorID)->whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date])->count();

       	$order = Orders::whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date])
			->where('order_status','completed')
			->where('vendor_id',$vendorID)
			->count();

        //$order_users = Orders::selectRaw('DISTINCT customer_id')->where('vendor_id',Auth::user()->id)->get()->pluck('customer_id')->toArray();
		$order_users = Orders::selectRaw('DISTINCT customer_id')
			->where('vendor_id',$vendorID)
			->get()
			->pluck('customer_id')
			->toArray();

        $user = User::whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date])
        ->whereIn('id',$order_users)->count();

        // sales graph
        $graph_sales = Orders::selectRaw('count(id) as total_price, Date(created_at) as sales_date')
            ->whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date])
            ->where('order_status','completed')
            ->where('vendor_id',$vendorID)
            ->groupBy('sales_date');

        if($request->vendor){
        	$graph_sales = $graph_sales->where('orders.vendor_id',$request->vendor);
        }

        if($request->store){
        	$graph_sales = $graph_sales->where('orders.store_id',$request->store);
        }

        $graph_sales = $graph_sales->get();

        $graph_sales = Arr::pluck($graph_sales, 'total_price', 'sales_date');

        $total_sales_graph_label = [];
        $total_sales_graph_data = [];

        $date = $start_date;
        while (strtotime($date) <= strtotime($end_date)) {

            $total_sales_graph_label[] = date ("d M", strtotime($date));
            if (array_key_exists($date, $graph_sales)){
                $total_sales_graph_data[] = (int)$graph_sales[$date];
            }else{
                $total_sales_graph_data[] = 0;
            }
            $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
        }

        // earning graph
        $graph_earning = Orders::selectRaw('sum(total_price) as total_price, Date(created_at) as sales_date')
            ->whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date])
            ->where('order_status','completed')
            ->where('vendor_id',$vendorID)
            ->groupBy('sales_date');

        if($request->vendor){
        	$graph_earning = $graph_earning->where('orders.vendor_id',$request->vendor);
        }

        if($request->store){
        	$graph_earning = $graph_earning->where('orders.store_id',$request->store);
        }
        $graph_earning = $graph_earning->get();

        $graph_earning = Arr::pluck($graph_earning, 'total_price', 'sales_date');

        $total_earning_graph_label = [];
        $total_earning_graph_data = [];

        $date = $start_date;
        while (strtotime($date) <= strtotime($end_date)) {

            $total_earning_graph_label[] = date ("d M", strtotime($date));
            if (array_key_exists($date, $graph_earning)){
                $total_earning_graph_data[] = (int)$graph_earning[$date];
            }else{
                $total_earning_graph_data[] = 0;
            }

            $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
        }

        // store graph
	    $store_graph = VendorStore::select('vendor_stores.name','vendor_stores.lat','vendor_stores.long')
			->leftjoin('orders','orders.store_id','=','vendor_stores.id')
	        ->where('order_status','=','completed')
	        ->whereBetween(DB::raw('DATE(orders.created_at)'), [$start_date, $end_date])
	        ->where('vendor_stores.vendor_id',$vendorID)
	        ->groupBy('orders.store_id')
	        ->limit(5);

	    if($request->vendor){
        	$store_graph = $store_graph->where('orders.vendor_id',$request->vendor);
        }

        if($request->store){
        	$store_graph = $store_graph->where('vendor_stores.id',$request->store);
        }

        $store_graph = $store_graph->get();

	    $total_store_graph = array();

        foreach($store_graph as $key)
        {
        	$total_store_graph[] = array('name'=>$key->name,'latLng'=>array($key->lat,$key->long));
        }

        //total store earn table
		$store_earn = VendorStore::selectRaw('sum(orders.total_price) as total_price,
				vendor_stores.name,
				vendor_stores.lat,
				vendor_stores.long,
				vendor_stores.image,
				vendors.name as vendor_name'
			)
			->leftjoin('orders','orders.store_id','=','vendor_stores.id')
			->join('vendors','vendors.id','vendor_stores.vendor_id')
	        ->where('order_status','=','completed')
	        ->where('vendor_stores.vendor_id',$vendorID)
	        ->whereBetween(DB::raw('DATE(orders.created_at)'), [$start_date, $end_date])
	        ->groupBy('orders.store_id')
	        ->orderBy('total_price', 'DESC')
	        ->limit(5);

		if($request->vendor){
        	$store_earn = $store_earn->where('orders.vendor_id',$request->vendor);
        }

        if($request->store){
        	$store_earn = $store_earn->where('vendor_stores.id',$request->store);
        }

		$store_earn = $store_earn->get();

		//customer_review
	    $customer_reviews =ProductReview::select(
	    		'products.title as product',
	    		'users.first_name as username',
	    		'product_reviews.comment',
	    		'product_reviews.rating',
	    		'product_reviews.created_at'
			)
	    	->join('product_variants','product_variants.id','=','product_reviews.product_id')
			->join('users','users.id','=','product_reviews.customer_id')
			->join('products','products.id','=','product_variants.product_id')
	    	->limit(5)
	    	->where('products.vendor_id',$vendorID)
	    	->whereBetween(DB::raw('DATE(product_reviews.created_at)'), [$start_date, $end_date]);

	    if($request->vendor){
        	$customer_reviews = $customer_reviews->where('products.vendor_id',$request->vendor);
        }

        if($request->store){
        	$customer_reviews = $customer_reviews->where('products.store_id',$request->store);
        }

		$customer_reviews = $customer_reviews->get();

	   	//recent order
	    $recent_orders = Orders::join('users','users.id','=','orders.customer_id')
	    					->join('vendor_stores','vendor_stores.id','=','orders.store_id')
	    					->select('orders.order_no','vendor_stores.name','orders.total_price','users.first_name','users.last_name','orders.created_at')
	    					->where('vendor_stores.vendor_id',$vendorID)
	    					->limit(5)
	    					->whereBetween(DB::raw('DATE(orders.created_at)'), [$start_date, $end_date]);

	    if($request->vendor){
        	$recent_orders = $recent_orders->where('orders.vendor_id',$request->vendor);
        }

        if($request->store){
        	$recent_orders = $recent_orders->where('orders.store_id',$request->store);
        }

        $recent_orders = $recent_orders->orderBy('orders.id','DESC')->get();

		$attribute_values = ProductVariants::join('attribute_values','attribute_values.id','=',
									'product_variants.attribute_value_id')
						->join('products','products.id','=','product_variants.product_id')
						->select('attribute_values.name','products.title','product_variants.id')
						->get();

		foreach($attribute_values as $attribute_value)
		{
			$product_title[] = array('id'=> $attribute_value->id ,'title' => $attribute_value->title .' '.$attribute_value->name);
		}

		// print_r($product_title);die();
		$category = Category::all();

		// categories
		$result = [];
		$categories = Category::select('id','name','parent')->where('status', 'enable')->get();
 		if($categories->isNotEmpty()){
			$ref   = [];
			$items = [];
			foreach ($categories as $key => $value) {

				$thisRef = &$ref[$value->id];

				$thisRef['id'] = $value->id;
				$thisRef['name'] = $value->name;
				$thisRef['parent'] = $value->parent;

				if($value->parent == 0) {
					$items[$value->id] = &$thisRef;
				} else {
					$ref[$value->parent]['child'][$value->id] = &$thisRef;
				}
			}
			$result = $this->getCategoriesDropDown('', $items);
		}

		//end categories
		// $vendor_store = VendorStore::where('vendor_id',Auth::user()->id)->get();

		$input = $request->all();
		return view('vendor.home',compact('start_date','end_date','vendor','store','order',
			'user','total_sales_graph_label', 'total_sales_graph_data','total_earning_graph_label',
			'total_earning_graph_data','total_store_graph','store_earn','customer_reviews',
			'recent_orders','vendor_datas','result','product_title','vendor_store','input'));

	}
    public function dashboard2()
    {
        // dd('12');
        return view('vendor.layout.main2');
    }

	protected function getCategoriesDropDown($prefix, $items)
	{
		$str = '';
		$span = '<span>—</span>';
		foreach($items as $key=>$value) {
			$str .= '<option value="'.$value['id'].'">'.$prefix.$value['name'].'</option>';
			if(array_key_exists('child',$value)) {
				$str .= $this->getCategoriesDropDown($prefix.$span, $value['child'],'child');
			}

		}
		return $str;
	}

	public function importVendor(Request $request)
	{
		$exists_emails = [];
		$this->validate($request, [
			'import_file'  => 'required|mimes:csv,txt'
        ]);

		$file = $request->file('import_file');
		$extension = $file->getClientOriginalExtension();

		if(strtolower($extension) == 'csv') {

	        $fileD = fopen($request->file('import_file'),"r");
	        $column = fgetcsv($fileD);
			$parentID = (Auth::user()->parent_id == 0) ? Auth::user()->id : Auth::user()->parent_id;

	        while(!feof($fileD)) {

	            $rowData=fgetcsv($fileD);
	            if(!empty($rowData)) {

					$name = $rowData[0];
					$email = $rowData[1];
					$password = $rowData[2];
					$phone_number = $rowData[3];
					$mobile_number = $rowData[4];
	             	$address = $rowData[5];
	                $country = $rowData[6];
	                $state = $rowData[7];
	                $city = $rowData[8];
	                $pincode = (int)$rowData[9];
	                $pincode = ($pincode == 0) ? NULL : $pincode;
	                $image = $rowData[10];

	                $email_exists = Vendor::where('email',$email)->exists();
					if($email_exists) {
						$exists_emails[] ='The '. $email.' has already been taken by you or some other vendor. ';
					} else {

						$country = DB::table('countries')->where('name','like','%'.$country.'%')->first();
						$countryID = (empty($country)) ? NULL : $country->id;

						$state = DB::table('states')->where('name','like','%'.$state.'%')->where('country_id',$countryID)->first();
						$stateID = (empty($state)) ? NULL : $state->id;

						$city = DB::table('cities')->where('name', 'like', '%' . $city . '%')->where('state_id',$stateID)->first();
						$cityID = (empty($city)) ? NULL : $city->id;

						$vendor = new Vendor;
						$vendor->name = $name;
						$vendor->email= $email;
						$vendor->parent_id = $parentID;
						$vendor->password = bcrypt($password);
						$vendor->phone_number = $phone_number;
						$vendor->mobile_number = $mobile_number;
						$vendor->address = $address;
						$vendor->country = $countryID;
						$vendor->state = $stateID;
						$vendor->city = $cityID;
						$vendor->pincode = $pincode;
						$vendor->status = 'active';

						if(trim($image)!='') {

							if (!filter_var($image, FILTER_VALIDATE_URL) === false) {

								$ext = pathinfo($image, PATHINFO_EXTENSION);
								$path = public_path('images/vendors');
								$image_name = date('YmdHis') . '.' . $ext;
								$new_image = $path . '/' . $image_name;

								if (!@copy($image, $new_image)) {

								}else{
									$vendor['image'] = $image_name;
								}

								/*if(!@file_put_contents($new_image, file_get_contents($image))) {

								}else{
									$vendor['image'] = $image_name;
								}*/
							}
						}
						$vendor->save();
					}
	            }
	        }
	        Helper::addToLog('Import Vendor',Auth::user()->id);
	       	return redirect('/vendor/vendors')->with('success-data', array('emails' => $exists_emails, 'message' => 'Vendor successfully imported.'));
	    }else{
	    	return redirect('/vendor/vendors')->with('error-data','The import file must be a file of type: csv.');
	    }
	}

	public function getImportPreview(Request $request)
	{
		// print_r($request->all());die();
		$file = $request->file('file');
		$extension = $file->getClientOriginalExtension();
		$data = [];
		if(strtolower($extension) == 'csv') {

	        $fileOpen = fopen($request->file('file'),"r");
	        $column = fgetcsv($fileOpen);
	        if(count($column) == 11) {

		        while(!feof($fileOpen)){

		            $rowData = fgetcsv($fileOpen);
		            if(!empty($rowData) && count($column) == count($rowData)) {

		            	$data[] = array(
		            		'name' => $rowData[0],
							'email' => $rowData[1],
							'phone_number' => $rowData[3],
							'mobile_number' => $rowData[4],
			             	'address' => $rowData[5],
			                'country' => $rowData[6],
			                'state' => $rowData[7],
			                'city' => $rowData[8],
			                'pincode' => $rowData[9],
			                'image' => $rowData[10]
		            	);
					}
				}
				echo json_encode(array('error' => '', 'data' => $data));exit();
			} else {
				echo json_encode(array('error' => "Your uploaded CSV column does not match with the sample CSV", 'data' => null));exit();
			}
		} else {
			echo json_encode(array('error' => "Please upload comma seprated CSV file", 'data' => null));exit();
		}
	}

	public function setStorePermission(Request $request, $id)
	{
		if(empty($request->all()))
		{
			$store = StoresVendor::select('vendor_stores.id','vendor_stores.name')
				->join('vendor_stores','vendor_stores.id','stores_vendors.store_id')
				->where('stores_vendors.vendor_id',$id)
				->first();
			$store_permission = VendorStorePermission::where('vendor_id',$id)->where('store_id',$store->id)->first();
			$vendor_name  = Vendor::where('id',$id)->first();
			return view('vendor/vendors/set_store_permission',compact('id','store','store_permission','vendor_name'));
		}else{

			$request->validate([
				'to_date'=>'required',
				'from_date'=>'required',
			]);
			$store_permission = VendorStorePermission::where('vendor_id',$id)->where('store_id',$request->store_id)->first();

			if(!empty($store_permission)){
				if($request->btn == 'btnDelete'){
					VendorStorePermission::where('vendor_id',$id)->where('store_id',$request->store_id)->delete();
					return redirect('/vendor/vendors')->with('success',"Vendor Permission deleted.");
				}else{
					$store_permission->to = $request->to_date;
					$store_permission->from = $request->from_date;
					$store_permission->status = 'active';
					$store_permission->save();
					return redirect('/vendor/vendors')->with('success',"Vendor Permission updated.");
				}
			}else{
				$vendor_store_permission = new VendorStorePermission;
				$vendor_store_permission->vendor_id = $id;
				$vendor_store_permission->store_id = $request->store_id;
				$vendor_store_permission->to = $request->to_date;
				$vendor_store_permission->from = $request->from_date;
				$vendor_store_permission->status = 'active';
				$vendor_store_permission->save();
				return redirect('/vendor/vendors')->with('success',"Vendor Permission saved.");
			}
		}
	}

	public function exportVendor()
	{
		$filename = "employees.csv";
		$fp = fopen('php://output', 'w');

		$header = array('Name', 'Email', 'Phone Number', 'Mobile Number', 'Address', 'City', 'State', 'Country', 'Zip Code', 'Store', 'Role', 'Image');

		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		fputcsv($fp, $header);

		if(Auth::user()->parent_id == 0){
        	$vendorID = Auth::user()->id;
        }else{
        	$vendorID = Auth::user()->parent_id;
        }

		$vendors = Vendor::select(
				'vendors.*',
				'countries.name as country_name',
				'states.name as state_name',
				'cities.name as city_name',
				'vendor_stores.name as store_name',
				'vendor_roles.role_name'
			)
			->leftjoin('vendor_roles', 'vendor_roles.id', 'vendors.role_id')
			->leftjoin('stores_vendors', 'stores_vendors.vendor_id', 'vendors.id')
			->leftjoin('vendor_stores', 'vendor_stores.id', 'stores_vendors.store_id')
			->leftjoin('countries', 'countries.id', 'vendors.country')
			->leftjoin('states', 'states.id', 'vendors.state')
			->leftjoin('cities', 'cities.id', 'vendors.city')
			->where('vendors.parent_id', $vendorID)
			->groupBy('vendors.id')
			->get();

		$image_url = url('/');

		foreach ($vendors as $key => $vendor) {

			if(!empty($vendor->image)){
				$image = $image_url.'/public/images/vendors/'.$vendor->image;
			}else{
				$image = '';
			}

			$data = array(
				'Name' => $vendor->name,
				'Email' => $vendor->email,
				'Phone Number' => $vendor->phone_number,
				'Mobile Number' => $vendor->mobile_number,
				'Address' => $vendor->address,
				'City' => $vendor->city_name,
				'State' => $vendor->state_name,
				'Country' => $vendor->country_name,
				'Zip Code' => $vendor->pincode,
				'Store' => $vendor->store_name,
				'Role' => $vendor->role_name,
				'Image' => $image
			);

		 	fputcsv($fp, $data);
		}
		Helper::addToLog('Export Vendor',Auth::user()->id);
		exit();
	}

	public function loginVendorHistory()
	{
		$login_history = DB::table('log_activities')
							->select('vendors.name',
									'log_activities.created_at',
									'log_activities.ip',
									'log_activities.subject',
									'vendor_roles.role_name',
									'log_activities.type')
							->join('vendors','vendors.id','log_activities.user_id')
							->leftjoin('vendor_roles','vendor_roles.id','vendors.role_id')
							->orderBy('log_activities.id','DESC')
							->where('log_activities.subject','!=','Vendor Login')
							->get();

		return view('vendor.vendors.login_history_vendor',compact('login_history'));
	}

	public function addBankDetail(Request $request)
	{
		$detail = array(
			'bank_name' => $request->bank_name,
			'bank_account_number' => $request->bank_account_no,
			'bank_routing_number' => $request->bank_routing_no
		);

		Vendor::where('id',Auth::user()->id)->update($detail);

		echo json_encode(array('success' => 'Bank Detail has been added.'));exit();
		// return redirect('vendor/home')->with('success','Bank Detail has been added.');
	}

	public function activePlan()
	{
		$plans = StoreSubscription::select(
				'store_subscriptions.id',
				'store_subscriptions.start_date',
				'store_subscriptions.end_date',
				'vendor_stores.name as store_name',
				'memberships.name as plan_name',
				'membership_items.billing_period',
				'membership_items.price'
			)
			->join('vendor_stores', 'vendor_stores.id', 'store_subscriptions.store_id')
			->join('memberships', 'memberships.id', 'store_subscriptions.membership_id')
			->join('membership_items', 'membership_items.id', 'store_subscriptions.membership_item_id')
			->where('store_subscriptions.status', 'active')
			->where('store_subscriptions.is_cancelled', 'no')
			->where('memberships.code', '<>', 'one_time_setup_fee')
			->where('store_subscriptions.vendor_id', Auth::user()->id)
			->get();
		return view('vendor.vendors.active_plan', compact('plans'));
	}

	public function choosePlan()
	{
		$stores = VendorStore::select('id','name')->where('vendor_id',Auth::user()->id)->get();
		$features = vendor_membership_features();
		$memberships = Membership::where('type', 'vendor')
			->with('monthMembershipItem')
			->whereHas('monthMembershipItem',  function($query)  {
				$query->whereNotNull('billing_period');
			})
			->get();
		$one_time_setup_fee = Membership::where('code', 'one_time_setup_fee')->with('discountMembershipItem')->first();
		$cards = $this->retriveVendorCards();
		//echo '<pre>'; print_r($cards); exit();

		return view('vendor.vendors.choose_plan',compact('stores', 'features', 'memberships', 'one_time_setup_fee', 'cards'));
	}

	public function getSubscription($store_id)
	{
		$store = DB::table('vendor_stores')->select('setup_fee_required')->where('id', $store_id)->first();
		$is_setup_required = $store->setup_fee_required;
		$current_subscription = [];
		$pending_subscription = [];

		// check for setup fee
		$setup_fee = DB::table('store_subscriptions')
			->join('memberships','memberships.id', 'store_subscriptions.membership_id')
			->where('store_subscriptions.store_id', $store_id)
			->where('memberships.code', 'one_time_setup_fee')
			->first();
		if(!empty($setup_fee)) {

			$is_setup_required = 'no';
		}

		if($is_setup_required == 'no') {

			$pending_subscription = StoreSubscriptionTemp::where('store_id', $store_id)->first();
			$current_subscription = StoreSubscription::select('store_subscriptions.*', 'memberships.name', 'membership_items.billing_period', 'membership_items.price')
				->join('memberships', 'memberships.id', 'store_subscriptions.membership_id')
				->join('membership_items', 'membership_items.id', 'store_subscriptions.membership_item_id')
				->where('store_id', $store_id)
				->first();
			if(!empty($current_subscription)) {
				$current_subscription->end_date = date('d M, Y h:i A', strtotime($current_subscription->end_date));
			}
		}

		return response()->json( array(
			'is_setup_required' => $is_setup_required,
			'current_subscription' => $current_subscription,
			'pending_subscription' => $pending_subscription
		));
	}

	public function getPlanByIntervalLicense($interval, $license = null)
	{
		$coupon = null;
		if($interval == 'month' && $license == null){
			$join = 'monthMembershipItem';
		}elseif($interval == 'month' && $license == 1){
			$join = 'monthMembershipItemOneLicense';
		}elseif($interval == 'month' && $license == 2){
			$join = 'monthMembershipItemTwoLicense';
		}elseif($interval == 'year' && $license == null){
			$join = 'yearMembershipItem';
		}elseif($interval == 'year' && $license == 1){
			$join = 'yearMembershipItemOneLicense';
		}elseif($interval == 'year' && $license == 2){
			$join = 'yearMembershipItemTwoLicense';
		}

		/*if($interval == 'year'){
			$coupon = DB::table('membership_coupons')->where('code', 'annual_pay_discount')->first();
		}*/
		$memberships = Membership::where('type', 'vendor')
			->with($join)
			->whereHas($join,  function($query)  {
				$query->whereNotNull('billing_period');
			})
			->get();

		$result = array('membership' => $memberships, 'coupon' => $coupon);
		return response()->json($result);
	}

	public function oneTimeSetupFee(Request $request, $store_id)
	{
		$store = VendorStore::findOrFail($store_id);
		$now = time();
		// $store_created_at = strtotime($store->created_at);
		$store_created_at = strtotime('2022-06-01 12:30:49');
		$datediff = $now - $store_created_at;
		$diff_days = round($datediff / (60 * 60 * 24));

		$membership = DB::table('memberships')
			->select('memberships.id', 'memberships.code', 'membership_items.id as item_id', 'membership_items.price')
			->join('membership_items','membership_items.membership_id', 'memberships.id')
			->where('memberships.code', 'one_time_setup_fee')
			->first();

		$stripe_customer_id = Auth::user()->stripe_customer_id;
		if(!empty($membership) && !empty($stripe_customer_id)) {

			$discount = 0;
			/*if($diff_days < 10) { // Apply 70% discount on price
				$discount = 70;
				$coupon_name = 'EXE70';
			} elseif($diff_days >= 10 && $diff_days < 15 ) { // Apply 50% discount on price
				$discount = 50;
				$coupon_name = 'DIS50';
			} elseif ($diff_days >= 15 && $diff_days < 20 ) { // Apply 30% discount on price
				$discount = 30;
				$coupon_name = 'GET30';
			}*/
			if($diff_days < 10) { // Apply 15% discount on price
				$discount = 15;
				$coupon_name = 'EXE15';
			} elseif($diff_days >= 10 && $diff_days < 15 ) { // Apply 10% discount on price
				$discount = 10;
				$coupon_name = 'DIS10';
			} elseif ($diff_days >= 15 && $diff_days < 20 ) { // Apply 5% discount on price
				$discount = 5;
				$coupon_name = 'GET05';
			}

			$discount_price = ($membership->price * ($discount / 100));
			$final_price = $membership->price - $discount_price;

			Stripe\Stripe::setApiKey($this->stripe_secret);

			try {

				$charge = Stripe\Charge::create([
					'amount' => $final_price *100,
					'currency' => 'usd',
					'customer' => $stripe_customer_id,
					'description' => 'One time setup fee',
				]);

				$membership_coupon_id = NULL;
				if($discount > 0) {

					$membership_coupon = new MembershipCoupon;
					$membership_coupon->vendor_id = Auth::user()->id;
					$membership_coupon->store_id = $store_id;
					$membership_coupon->name = $coupon_name;
					$membership_coupon->discount = $discount;
					$membership_coupon->is_used = 'yes';
					$membership_coupon->save();

					$membership_coupon_id = $membership_coupon->id;
				}

		        $store_subscription = new StoreSubscriptionTemp;
				$store_subscription->vendor_id = Auth::user()->id;
				$store_subscription->store_id = $store_id;
				$store_subscription->card_id = $request->card_id;
				$store_subscription->subscription_id = $charge->id;
				$store_subscription->subscription_item_id = $charge->balance_transaction;
				$store_subscription->membership_id = $membership->id;
				$store_subscription->membership_item_id = $membership->item_id;
				$store_subscription->membership_code = $membership->code;
				$store_subscription->membership_coupon_id = $membership_coupon_id;
				$store_subscription->status = $charge->status;
				$store_subscription->save();

				$status = 'success';
				$message = 'Thank you for paying one time setup fee. We will update you shortly.';
			} catch(\Stripe\Exception\CardException $e) {

				$status = 'error';
				$message = $e->getMessage();
			} catch (\Stripe\Exception\RateLimitException $e) {

				$status = 'error';
				$message = $e->getMessage();
			} catch (\Stripe\Exception\InvalidRequestException $e) {

				$status = 'error';
				$message = $e->getMessage();
			} catch (\Stripe\Exception\AuthenticationException $e) {

				$status = 'error';
				$message = $e->getMessage();
			} catch (\Stripe\Exception\ApiConnectionException $e) {

				$status = 'error';
				$message = $e->getMessage();
			} catch (\Stripe\Exception\ApiErrorException $e) {

				$status = 'error';
				$message = $e->getMessage();
			} catch (Exception $e) {

				$status = 'error';
				$message = $e->getMessage();
			}
		} else {

			$status = 'error';
			$message = 'Something went wrong. Please try again later.';
		}
		return response()->json([
			'status' => $status,
			'message' => $message
		]);
	}

	public function createSubscription(Request $request)
	{
		$status = '';
		$message = '';
		//echo '<pre>'; print_r($request->all()); exit();
		$validator = Validator::make($request->all(), [
			'store_id' => 'required',
			'membership_id' => 'required',
			'membership_item_id' => 'required',
			'membership_code' => 'required',
			'stripe_price_id' => 'required',
			'stripe_card_id' => 'required'
		]);

		if($validator->fails()){

			return response()->json([
				'status' => 'error',
				'message' => $validator->errors()->first()
			]);
		}

		$setup_fee_not_exist = DB::table('store_subscriptions')
			->join('memberships','memberships.id', 'store_subscriptions.membership_id')
			->where('store_subscriptions.store_id', $request->store_id)
			->where('memberships.code', 'one_time_setup_fee')
			->doesntExist();

		$store_subscription_exist = DB::table('store_subscriptions')
			->join('memberships','memberships.id', 'store_subscriptions.membership_id')
			->where('store_subscriptions.store_id', $request->store_id)
			->where('memberships.code', '<>', 'one_time_setup_fee')
			->exists();

		if($setup_fee_not_exist) {

			$status = 'error';
			$message = 'please pay first the one-time setup fee.';
		} else if($store_subscription_exist) {

			$status = 'error';
			$message = 'You can not create new subscription for this store. You can upgrade / downgrade it.';
		} else {

			Stripe\Stripe::setApiKey($this->stripe_secret);

			$stripe_customer_id = Auth::user()->stripe_customer_id;
			$data = array(
	            "customer" => $stripe_customer_id,
	            "items" => array(
	                array(
	                    "plan" => $request->stripe_price_id,
	                ),
	            ),
	            "default_payment_method" => $request->stripe_card_id
	        );

	        /*if($request->has('stripe_coupon_id') &&  $request->get('stripe_coupon_id')!=''){

	            $data['coupon'] = $request->get('stripe_coupon_id');
	        }*/

	        try {

		        $subscription = Stripe\Subscription::create($data);

				$store_subscription = new StoreSubscriptionTemp;
				$store_subscription->vendor_id = Auth::user()->id;
				$store_subscription->store_id = $request->store_id;
				$store_subscription->card_id = $request->stripe_card_id;
				$store_subscription->subscription_id = $subscription->id;
				$store_subscription->subscription_item_id = $subscription->items->data[0]->id;
				$store_subscription->membership_id = $request->membership_id;
				$store_subscription->membership_item_id = $request->membership_item_id;
				$store_subscription->membership_code = $request->membership_code;
				if($request->has('stripe_coupon_id') &&  $request->get('stripe_coupon_id')!=''){
					$store_subscription->membership_coupon_id = $request->membership_coupon_id;
				}
				if($request->has('extra_license') &&  $request->get('extra_license')!=''){
					$store_subscription->extra_license = $request->extra_license;
				}
				$store_subscription->start_date = date('Y-m-d H:i:s', $subscription->current_period_start);
				$store_subscription->end_date = date('Y-m-d H:i:s', $subscription->current_period_end);
				$store_subscription->status = $subscription->status;
				$store_subscription->plan_type = 'create';
				$store_subscription->save();

				if($request->has('stripe_coupon_id') &&  $request->get('stripe_coupon_id')!=''){
					DB::table('membership_coupons')
						->where('id', $request->membership_coupon_id)
						->update(['is_used' => 'yes', 'updated_at' => Carbon::now()]);
				}

				$status = 'success';
				$message = 'Thank you for your subscription. We will update you shortly.';
			} catch(\Stripe\Exception\CardException $e) {

				$status = 'error';
				$message = $e->getMessage();
			} catch (\Stripe\Exception\RateLimitException $e) {

				$status = 'error';
				$message = $e->getMessage();
			} catch (\Stripe\Exception\InvalidRequestException $e) {

				$status = 'error';
				$message = $e->getMessage();
			} catch (\Stripe\Exception\AuthenticationException $e) {

				$status = 'error';
				$message = $e->getMessage();
			} catch (\Stripe\Exception\ApiConnectionException $e) {

				$status = 'error';
				$message = $e->getMessage();
			} catch (\Stripe\Exception\ApiErrorException $e) {

				$status = 'error';
				$message = $e->getMessage();
			} catch (Exception $e) {

				$status = 'error';
				$message = $e->getMessage();
			}
		}

		return response()->json([
			'status' => $status,
			'message' => $message
		]);
	}

	public function changeSubscription(Request $request)
	{
		$status = '';
		$message = '';
		$validator = Validator::make($request->all(), [
			'store_id' => 'required',
			'membership_id' => 'required',
			'membership_item_id' => 'required',
			'membership_code' => 'required',
			'stripe_price_id' => 'required',
		]);

		if($validator->fails()){

			return response()->json([
				'status' => 'error',
				'message' => $validator->errors()->first()
			]);
		}
		// echo '<pre>'; print_r($request->all()); exit();

		$store_subscription = StoreSubscription::where('store_id', $request->store_id)->where('vendor_id', Auth::user()->id)->first();
		if(!empty($store_subscription)){

			if($store_subscription->is_cancelled == 'yes') {

				$status = 'error';
				$message = 'You have already cancelled the plan and you cannot upgrade / downgrade your plan.';
			} else {

				$price_id = $request->stripe_price_id;
				$subscription_id = $store_subscription->subscription_id;
				$subscription_item_id = $store_subscription->subscription_item_id;

				Stripe\Stripe::setApiKey($this->stripe_secret);

				try {

					$data = array(
						/*'cancel_at_period_end' => false,
						'proration_behavior' => 'create_prorations',*/

						'payment_behavior' => 'pending_if_incomplete',
    					'proration_behavior' => 'always_invoice',
						'items' => [
							[
								'id' => $subscription_item_id,
								'price' => $price_id,
							],
						],
					);

					if($request->has('stripe_coupon_id') &&  $request->get('stripe_coupon_id')!=''){

						$data['coupon'] = $request->get('stripe_coupon_id');
					}

					$subscription = Stripe\Subscription::update($subscription_id, $data);

					$store_subscription_temp = new StoreSubscriptionTemp;
					$store_subscription_temp->vendor_id = Auth::user()->id;
					$store_subscription_temp->store_id = $request->store_id;
					$store_subscription_temp->card_id = $store_subscription->card_id;
					$store_subscription_temp->subscription_id = $subscription->id;
					$store_subscription_temp->subscription_item_id = $subscription->items->data[0]->id;
					$store_subscription_temp->membership_id = $request->membership_id;
					$store_subscription_temp->membership_item_id = $request->membership_item_id;
					$store_subscription_temp->membership_code = $request->membership_code;
					if($request->has('stripe_coupon_id') &&  $request->get('stripe_coupon_id')!=''){
						$store_subscription_temp->membership_coupon_id = $request->membership_coupon_id;
					}
					if($request->has('extra_license') &&  $request->get('extra_license')!=''){
						$store_subscription_temp->extra_license = $request->extra_license;
					}
					$store_subscription_temp->start_date = date('Y-m-d H:i:s', $subscription->current_period_start);
					$store_subscription_temp->end_date = date('Y-m-d H:i:s', $subscription->current_period_end);
					$store_subscription_temp->status = $subscription->status;
					$store_subscription_temp->plan_type = 'change';
					$store_subscription_temp->save();

					if($request->has('stripe_coupon_id') &&  $request->get('stripe_coupon_id')!=''){
						DB::table('membership_coupons')
							->where('id', $request->membership_coupon_id)
							->update(['is_used' => 'yes', 'updated_at' => Carbon::now()]);
					}

					$status = 'success';
					$message = 'Your subscription has been changed. We will update you shortly.';

				} catch(\Stripe\Exception\CardException $e) {

					$status = 'error';
					$message = $e->getMessage();
				} catch (\Stripe\Exception\RateLimitException $e) {

					$status = 'error';
					$message = $e->getMessage();
				} catch (\Stripe\Exception\InvalidRequestException $e) {

					$status = 'error';
					$message = $e->getMessage();
				} catch (\Stripe\Exception\AuthenticationException $e) {

					$status = 'error';
					$message = $e->getMessage();
				} catch (\Stripe\Exception\ApiConnectionException $e) {

					$status = 'error';
					$message = $e->getMessage();
				} catch (\Stripe\Exception\ApiErrorException $e) {

					$status = 'error';
					$message = $e->getMessage();
				} catch (Exception $e) {

					$status = 'error';
					$message = $e->getMessage();
				}
			}
		} else {

			$status = 'error';
			$message = 'Store subscription not found.';
		}

		return response()->json([
			'status' => $status,
			'message' => $message
		]);
	}

	public function cancelSubscription($id)
	{
		$plan = StoreSubscription::findOrFail($id);
		if($plan) {

			Stripe\Stripe::setApiKey($this->stripe_secret);
			try {

				/*$subscription = Stripe\Subscription::retrieve($plan->subscription_id);
				$subscription->cancel();*/

				Stripe\Subscription::update(
					$plan->subscription_id,
					[
						'cancel_at_period_end' => true,
					]
				);

				$plan->is_cancelled = 'yes';
				$plan->save();

				return redirect('/vendor/active-plans')->with('success',"Your plan is valid till ".date('d M, Y h:i A', strtotime($plan->end_date)));
			} catch(\Stripe\Exception\CardException $e) {
				$message = $e->getMessage();
			} catch (\Stripe\Exception\RateLimitException $e) {
				$message = $e->getMessage();
			} catch (\Stripe\Exception\InvalidRequestException $e) {
				$message = $e->getMessage();
			} catch (\Stripe\Exception\AuthenticationException $e) {
				$message = $e->getMessage();
			} catch (\Stripe\Exception\ApiConnectionException $e) {
				$message = $e->getMessage();
			} catch (\Stripe\Exception\ApiErrorException $e) {
				$message = $e->getMessage();
			} catch (Exception $e) {
				$message = $e->getMessage();
			}
		} else {
			$message = "Plan not found.";
		}

		return back()->with("error", $message);
	}

	public function checklist()
	{
		//$data = $this->getChecklist();
		return view('vendor.vendors.checklist'/*,compact('data')*/);
	}

	private function retriveVendorCards()
    {
    	$cards = [];
    	$stripe_customer_id = Auth::user()->stripe_customer_id;
        if($stripe_customer_id != NULL && $stripe_customer_id != ''){
        	Stripe::setApiKey($this->stripe_secret);
            try {
                $response = Customer::retrieve($stripe_customer_id);
                if(isset($response->sources->data)){
	                $stripe_cards = $response->sources->data;
	                foreach ($stripe_cards as $key => $value) {
	                    $cards[] = array(
	                        'id' => $value->id,
	                        'object' => $value->object,
	                        'brand' => $value->brand,
	                        'country' => $value->country,
	                        'exp_month' => $value->exp_month,
	                        'exp_year' => $value->exp_year,
	                        'funding' => $value->funding,
	                        'last4' => $value->last4,
	                        'default' => ($response->default_source == $value->id ? true : false)
	                    );
	                }
	            }
            } catch(\Stripe\Exception\CardException $e) {

			} catch (\Stripe\Exception\RateLimitException $e) {

			} catch (\Stripe\Exception\InvalidRequestException $e) {

			} catch (\Stripe\Exception\AuthenticationException $e) {

			} catch (\Stripe\Exception\ApiConnectionException $e) {

			} catch (\Stripe\Exception\ApiErrorException $e) {

			} catch (Exception $e) {

			}
        }
        return $cards;
    }

	/*public function manageVendorCard()
	{
		$manageCard = view('vendor/vendors/card')->render();
		$data = array('manageCard' => $manageCard);
		return response()->json(['status' => 'success', 'data' => $data]);
	}*/

	public function getVendorCard()
	{
		$cards = $this->retriveVendorCards();
		$cardlist = view('vendor/vendors/card-list', compact('cards'))->render();
		$data = array('cardlist' => $cardlist);
		return response()->json(['status' => 'success', 'data' => $data]);
	}

	public function saveVendorCard(Request $request)
    {
    	$status = '';
		$data = '';
		$message = '';
    	$stripe_customer_id = Auth::user()->stripe_customer_id;
    	$name = Auth::user()->first_name.' '.Auth::user()->last_name;
    	$email = Auth::user()->email;

        if($request->has('stripeToken') && $request->get('stripeToken')!=''){
             if($stripe_customer_id != NULL && $stripe_customer_id != ''){
                $customer_id = $stripe_customer_id;
            } else {
                try {
                    Stripe\Stripe::setApiKey($this->stripe_secret);
                    $customer = Stripe\Customer::create ([
                        "name" => $name,
                        "email" => $email
                    ]);
                    $customer_id = $customer->id;
                    DB::table('vendors')->where('id', Auth::user()->id)->update(['stripe_customer_id' => $customer_id]);
                } catch(\Stripe\Exception\CardException $e) {
					$status = 'error';
					$message = $e->getMessage();
				} catch (\Stripe\Exception\RateLimitException $e) {
					$status = 'error';
					$message = $e->getMessage();
				} catch (\Stripe\Exception\InvalidRequestException $e) {
					$status = 'error';
					$message = $e->getMessage();
				} catch (\Stripe\Exception\AuthenticationException $e) {
					$status = 'error';
					$message = $e->getMessage();
				} catch (\Stripe\Exception\ApiConnectionException $e) {
					$status = 'error';
					$message = $e->getMessage();
				} catch (\Stripe\Exception\ApiErrorException $e) {
					$status = 'error';
					$message = $e->getMessage();
				} catch (Exception $e) {
					$status = 'error';
					$message = $e->getMessage();
				}
            }

            if($status == 'error') {

            	return response()->json([
					'status' => 'error',
					'data' => [],
					'message' =>$message
				]);
            }

            try {
                Stripe\Stripe::setApiKey($this->stripe_secret);
                $card = Stripe\Customer::createSource(
                    $customer_id,
                    ['source' => $request->get('stripeToken')]
                );

                $data = array(
                    'id' => $card->id,
                    'object' => $card->object,
                    'brand' => $card->brand,
                    'country' => $card->country,
                    'exp_month' => $card->exp_month,
                    'exp_year' => $card->exp_year,
                    'funding' => $card->funding,
                    'last4' => $card->last4
                );

                $status = 'success';
				$message = 'Your card has been saved.';
            } catch(\Stripe\Exception\CardException $e) {
				$status = 'error';
				$message = $e->getMessage();
			} catch (\Stripe\Exception\RateLimitException $e) {
				$status = 'error';
				$message = $e->getMessage();
			} catch (\Stripe\Exception\InvalidRequestException $e) {
				$status = 'error';
				$message = $e->getMessage();
			} catch (\Stripe\Exception\AuthenticationException $e) {
				$status = 'error';
				$message = $e->getMessage();
			} catch (\Stripe\Exception\ApiConnectionException $e) {
				$status = 'error';
				$message = $e->getMessage();
			} catch (\Stripe\Exception\ApiErrorException $e) {
				$status = 'error';
				$message = $e->getMessage();
			} catch (Exception $e) {
				$status = 'error';
				$message = $e->getMessage();
			}
        } else {
            $status = 'error';
			$message = 'Stripe token field is required.';
        }

        return response()->json([
			'status' => $status,
			'data' => $data,
			'message' => $message
		]);
    }

    public function editVendorCard(Request $request)
    {
    	$status = '';
		$data = '';
		$message = '';
    	$vendor = Vendor::findOrFail(Auth::user()->id);

    	if ($request->get('month') != '' && $request->get('year') != '') {

			if($request->has('card_id') && $request->get('card_id')!=''){

			    if($vendor->stripe_customer_id != NULL) {

					try {

						Stripe\Stripe::setApiKey($this->stripe_secret);
						$response = Stripe\Customer::updateSource(
							$vendor->stripe_customer_id,
							$request->get('card_id'),
							['exp_month' => $request->get('month'), 'exp_year' => $request->get('year')]
						);
						$status = 'success';
						$message = 'Your card has been updated.';

					} catch(\Stripe\Exception\CardException $e) {

						$status = 'error';
						$message = $e->getMessage();
					} catch (\Stripe\Exception\RateLimitException $e) {

						$status = 'error';
						$message = $e->getMessage();
					} catch (\Stripe\Exception\InvalidRequestException $e) {

						$status = 'error';
						$message = $e->getMessage();
					} catch (\Stripe\Exception\AuthenticationException $e) {

						$status = 'error';
						$message = $e->getMessage();
					} catch (\Stripe\Exception\ApiConnectionException $e) {

						$status = 'error';
						$message = $e->getMessage();
					} catch (\Stripe\Exception\ApiErrorException $e) {

						$status = 'error';
						$message = $e->getMessage();
					} catch (Exception $e) {

						$status = 'error';
						$message = $e->getMessage();
					}
			    } else {

			    	$status = 'error';
					$message = 'Your are not our vendor client.';
			    }
			} else {

				$status = 'error';
				$message = 'Card not found.';
			}
		} else {

			$status = 'error';
			$message = 'All fields are required.';
		}

		$result = array(
			'status' => $status,
			'data' => $data,
			'message' => $message
		);

		return response()->json($result);
    }

	public function deleteVendorCard(Request $request)
	{
		$status = '';
		$message = '';
		$vendor = Vendor::findOrFail(Auth::user()->id);

		if($request->has('card_id') && $request->get('card_id')!=''){

            if($vendor->stripe_customer_id != NULL) {

                try {

                    Stripe\Stripe::setApiKey($this->stripe_secret);
                    $response = Stripe\Customer::deleteSource(
                        $vendor->stripe_customer_id,
                        $request->get('card_id')
                    );
                    $status = 'success';
					$message = 'Your selected card has been deleted.';
                } catch(\Stripe\Exception\CardException $e) {
                    $status = 'error';
					$message = $e->getMessage();
                } catch (\Stripe\Exception\RateLimitException $e) {
                    $status = 'error';
					$message = $e->getMessage();
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    $status = 'error';
					$message = $e->getMessage();
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    $status = 'error';
					$message = $e->getMessage();
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    $status = 'error';
					$message = $e->getMessage();
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    $status = 'error';
					$message = $e->getMessage();
                } catch (Exception $e) {
                    $status = 'error';
					$message = $e->getMessage();
                }
            } else {
            	$status = 'error';
				$message = 'Customer not found.';
            }
        } else {
        	$status = 'error';
			$message = 'Card not found.';
        }

        $result = array(
			'status' => $status,
			'message' => $message
		);

		return response()->json($result);
	}

	public function setVendorDefaultCard(Request $request)
    {
        $status = '';
		$message = '';
		$vendor = Vendor::findOrFail(Auth::user()->id);

        if($request->has('card_id') && $request->get('card_id')!=''){

            if($vendor->stripe_customer_id != NULL) {

                try {

                    Stripe\Stripe::setApiKey($this->stripe_secret);
                    $response = Stripe\Customer::update(
                        $vendor->stripe_customer_id,
                        ['default_source' => $request->get('card_id')]
                    );
                    $status = 'success';
					$message = 'Your selected card has been save as defualt.';
                } catch(\Stripe\Exception\CardException $e) {
                    $status = 'error';
					$message = $e->getMessage();
                } catch (\Stripe\Exception\RateLimitException $e) {
                    $status = 'error';
					$message = $e->getMessage();
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    $status = 'error';
					$message = $e->getMessage();
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    $status = 'error';
					$message = $e->getMessage();
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    $status = 'error';
					$message = $e->getMessage();
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    $status = 'error';
					$message = $e->getMessage();
                } catch (Exception $e) {
                    $status = 'error';
					$message = $e->getMessage();
                }
            }else{
            	$status = 'error';
				$message = 'You did not save any card.';
            }
        } else {
        	$status = 'error';
			$message = 'Card not found.';
        }

        $result = array(
			'status' => $status,
			'message' => $message
		);
		return response()->json($result);
    }

    public function getAssignedCoupon($store_id)
    {
		$data = DB::table('membership_coupons')
			->where('store_id', $store_id)
			->where('vendor_id', Auth::user()->id)
			->where('is_used', 'no')
			->first();
    	return response()->json($data);
    }

    public function getStoreRoles($store_id)
	{
		$limit = 2;
		$current_subscription = StoreSubscription::where('store_id', $store_id)->first();
		if(!empty($current_subscription)){
			$limit = empty($current_subscription->extra_license) ? $limit : $current_subscription->extra_license + $limit;
			$vendor_roles = VendorRoles::where('vendor_id',Auth::user()->id)->limit($limit)->get();
		}else{
			$vendor_roles = [];
		}
		echo json_encode($vendor_roles); exit();
	}

	public function completeUserGuide(Request $request, $id)
	{
		Vendor::where('id',$id)->update(array('is_user_guide_completed' => $request->status));
		return response()->json([
			'status' => 'success',
			'message' => 'User guide has been completed.'
		]);
	}

	/*public function inventoryUpdateReminderCheck($id)
	{
		$day = date('l');
		$time = date('H:i');
		$date = date('Y-m-d', strtotime('-7 days'));
		$user = DB::table('vendors')
			->select(
				'vendors.id',
				'vendors.name',
				'vendors.email',
				'stores_vendors.store_id',
				'vendor_stores.name as store_name'
			)
			->join('vendor_roles', 'vendor_roles.id', 'vendors.role_id')
			->join('stores_vendors', 'stores_vendors.vendor_id', 'vendors.id')
			->join('vendor_stores', 'vendor_stores.id', 'stores_vendors.store_id')
			->join('vendor_settings as setting_day', 'setting_day.vendor_id', 'vendors.parent_id')
			->join('vendor_settings as setting_time', 'setting_time.vendor_id', 'vendors.parent_id')
			->join('products', 'products.store_id', 'stores_vendors.store_id')
			->where(function ($query) {
				$query->where('vendor_roles.slug', 'store-manager')
					->orWhere('vendor_roles.slug', 'store-supervisor');
			})
			->where('setting_day.key', 'inventory_update_reminder_day')
			->where('setting_day.value', $day)
			->where('setting_time.key', 'inventory_update_reminder_time')
			->where('setting_time.value', $time)
			->where('vendors.id', $id)
			->whereDate('products.updated_at', '<', $date)
			->groupBy('stores_vendors.store_id')
			->first();

		return response()->json($user);
	}*/
    public function sendError($error, $errorMessages = [], $code = 200)
    {
        $response = [
            'success' => false,
            'data' => null,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
    public function rutiFulfillSubmit(Request $request)
    {
        // dd($request->all());
        $uid = Auth::user()->id;
        $supplier = Vendor::where('id', $uid)->first();
		Stripe::setApiKey($this->stripe_secret);
        // dd('aa00');
		 try {
            if ($supplier->stripe_customer_id) {
                $customer = $supplier->stripe_customer_id;
                //  dd(122);
            }
            else {
                # code...
                //  dd(123);
                $customer = Customer::create(array(

                    "email" => $supplier->email,

                    "name" => $supplier->first_name,

                    "source" => $request->stripeToken

                 ));
                   dd($customer->id);
                 $supplier->update([
                    'stripe_customer_id' => $customer->id
                 ]);
                //  dd($wallet);
            }

            //   dd($customer->id);

                Charge::create ([
	                "amount" => 25 * 100,
	                "currency" => "usd",
	                "customer" => $supplier->stripe_customer_id,
	                "description" => "Nature checkout fulfillment done"
        		]);
                $debit = $supplier->wallet_amount - 25;
                $supplier->update([
                    'wallet_amount' => $debit,
                    'fulfill_type' => 'nature'
                 ]);

			    return redirect()->back()->with('success', 'Your Fulfillments will now be done by Nature checkout');

            } catch(CardException $e) {
                $errors = $e->getMessage();
            } catch (RateLimitException $e) {
                $errors = $e->getMessage();
            } catch (InvalidRequestException $e) {
                $errors = $e->getMessage();
            } catch (AuthenticationException $e) {
                $errors = $e->getMessage();
            } catch (ApiConnectionException $e) {
                $errors = $e->getMessage();
            } catch (ApiErrorException $e) {
               $errors = $e->getMessage();
            } catch (Exception $e) {
                $errors = $e->getMessage();
            }

			return $this->sendError($errors);
    }
    public function fulfillWithWallet(Request $request)
    {
        $input = $request->amount;

        $uid = Auth::user()->id;
        //  dd($input);
        $user = Vendor::where('id', $uid)->first();
        // dd($user);
        if ($user->wallet_amount < $input) {
            return redirect()->back()->with('error', 'Your balance is not enough');
        }
        else {
            $debit = $user->wallet_amount - $input;
            $user->update([
                'wallet_amount' => $debit,
                'fulfill_type' => 'nature'
            ]);
            return redirect()->back()->with('success', 'Your Fulfillments will now be done by Nature checkout');
        }
    }
    public function vendorFulfill(Request $request)
    {
        # code...
        $uid = Auth::user()->id;
        $supplier = Vendor::where('id', $uid)->first();
        $supplier->update([
            'fulfill_type' => $request->fulfill_type
         ]);
         return redirect()->back()->with('success', 'Your Fulfillments will now be done by Yourself');
    }
    public function vendorWallet()
    {
        # code...
        $supplier = Vendor::where('id', Auth::user()->id)->first();
        $stripe_key = $this->stripe_key;

        return view('vendor.settings.supplier_wallet', compact('supplier','stripe_key'));
    }
    public function receiveWallet()
    {
        # code...
        $supplier = Vendor::where('id', Auth::user()->id)->first();

        return view('vendor.settings.receive_funds', compact('supplier'));
    }
    public function withdrawWallet()
    {
        # code...

        $vendor = Auth::user();

        return view('vendor.settings.withdraw_funds', compact('vendor'));
    }
    public function withdrawToBank(Request $request)
    {
        // $request->validate([
        //     'routing_number' => [
        //         'required',
        //         'regex:/^\d{9}$/',
        //         // Add any additional validation rules for the routing number.
        //     ],
        //     'account_no' => [
        //         'required',
        //         'regex:/^\d{6,17}$/',
        //         // Add any additional validation rules for the account number.
        //     ],
        // ]);
        Stripe::setApiKey($this->stripe_secret);
        // $token = Token::create([
        //     'bank_account' => [
        //         'country' => 'US',            // Replace with the appropriate country code
        //         'currency' => 'usd',
        //         'account_holder_name' => 'Test User',
        //         'account_holder_type' => 'individual',
        //         'routing_number' => '110000000', // Use a valid routing number
        //         'account_number' => '000123456789', // Use a valid account number
        //     ],
        // ]);
        // dd($token);
        // $bankAccountToken = $token->id;
        $payout = Transfer::create([
            'amount' => 20,
            'currency' => 'usd', // Change to your desired currency
            'destination' => 'acct_1NtEpW4fazg3JJUP'
        ]);
        dd($payout);
        //  dd($request->all());
        $uid = Auth::user()->id;
        $vendor = Vendor::where('id', $uid)->first();
        if ($vendor->wallet_amount < $request->amount) {
            return redirect()->back()->with('error', 'Your balance is not enough');
        }
        else {

            $debit = $vendor->wallet_amount - $request->amount;
            // dd($debit);
            $vendor->update([
                'wallet_amount' => $debit
            ]);
        }

        WithdrawRequest::create([
            'user_id' => $uid,
            'bank_name' => $request->bank_name,
            'routing_number' => $request->routing_number,
            'account_title' => $request->account_title,
            'account_no' => $request->account_no,
            'amount' => $request->amount
        ]);
        $contact_data = [

            'name' => $vendor->name,
            'email' => $vendor->email,
            'account_title' => $request->account_title,
            'account_no' => $request->account_no,
            'bank_name' => $request->bank_name,
            'routing_number' => $request->routing_number,
            'amount' => $request->amount
        ];


        Mail::to($vendor->email)->send(new WithdrawMail($contact_data));

        $admin_email = Config::get('app.admin_email');
        Mail::to($admin_email)->send(new AdminWithdrawMail($contact_data));

        return redirect()->route('vendor.withdraw-thank-you');

    }

    public function withdrawThankYou()
    {
        return view('vendor.settings.withdraw_thank_you');
    }

    public function vendorWalletPayment(Request $request, $amount)
    {
        $uid = Auth::user()->id;
        $supplier = Vendor::where('id', $uid)->first();
        if ($supplier->wallet_amount < $amount) {
            return redirect()->back()->with('error', 'Your balance is not enough');
        }
        else {

            $debit = $supplier->wallet_amount - $amount;
            $supplier->update([
                'wallet_amount' => $debit,
            ]);

        }
        return redirect()->back()->with('success', 'Your Fulfillments will now be done by Nature checkout');
    }
    public function addToWallet(Request $request)
    {
        # code...
        // dd($request->all());
        $uid = Auth::user()->id;
        $wallet = Vendor::where('id', $uid)->first();
        // dd($wallet);
		Stripe::setApiKey($this->stripe_secret);
		 try {
            if ($wallet->stripe_customer_id) {
                $customer = $wallet->stripe_customer_id;
                // dd(122);
            }
            else {
                # code...
                // dd(123);
                $customer = Customer::create(array(

                    "email" => $wallet->email,

                    "name" => $wallet->first_name,

                    "source" => $request->stripeToken

                 ));
                //   dd($customer->id);
                 $wallet->update([
                    'stripe_customer_id' => $customer->id
                 ]);
                //   dd($wallet);
            }

            //  dd($customer->id);

                Charge::create ([
	                "amount" => $request->amount * 100,
	                "currency" => "usd",
	                "customer" => $wallet->stripe_customer_id,
	                "description" => "Money added in your wallet."
        		]);

        		$closing_amount = $wallet->wallet_amount+$request->amount;

				$customer_wallet = new CustomerWallet;
				$customer_wallet->customer_id = $uid;
				$customer_wallet->amount = $request->amount;
				$customer_wallet->closing_amount = $closing_amount;
				$customer_wallet->type = 'credit';
				$customer_wallet->save();

				if(empty($wallet->wallet_amount)){
					Vendor::where('id',$uid)->update(array('wallet_amount'=>$request->amount));
				}else{
					$amount = $wallet->wallet_amount+$request->amount;
					Vendor::where('id',$uid)->update(array('wallet_amount'=>$amount));
				}

				// notification
				$id = $customer_wallet->id;
				$type = 'wallet_transaction';
			    $title = 'Wallet';
			    $message = 'Money has been added to your wallet';
			    $devices = UserDevice::where('user_id',$wallet->id)->where('user_type','customer')->get();

			    return redirect()->back()->with('success', 'Money added to wallet');

            } catch(CardException $e) {
                $errors = $e->getMessage();
            } catch (RateLimitException $e) {
                $errors = $e->getMessage();
            } catch (InvalidRequestException $e) {
                $errors = $e->getMessage();
            } catch (AuthenticationException $e) {
                $errors = $e->getMessage();
            } catch (ApiConnectionException $e) {
                $errors = $e->getMessage();
            } catch (ApiErrorException $e) {
               $errors = $e->getMessage();
            } catch (Exception $e) {
                $errors = $e->getMessage();
            }

			return $this->sendError($errors);
    }
    public function chooseRutiFullfillPage()
    {
        $supplier = Vendor::where('id', Auth::user()->id)->first();
        $stripe_key = $this->stripe_key;
        return view('vendor.settings.ruti_fulfill_page', compact('stripe_key','supplier'));
    }


    public function marketplacePage()
    {
        // dd('123');
        $categories = W2bCategory::take(9)->get();
        // dd($categories);
        $supplier_products = Products::where('seller_type', 'supplier')->get();
        // dd($supplier_products);
        return view('vendor.marketplace.index', compact('supplier_products','categories'));
    }
    public function productSearch2(Request $request)
    {
        //   dd($request->all());

        $query = $request->input('query');
        $categories = W2bCategory::take(9)->get();
        if ($request->input('query') && $request->input('category_name') && $request->input('status') && $request->input('fulfill_by')) {

            $supplier_products = Products::
            join('vendors','vendors.id', 'products.vendor_id')
            ->where('products.seller_type', 'supplier')
            ->whereIn('products.w2b_category_1', $request->category_name)
            ->where('products.status', $request->status)
            ->where('vendors.fulfill_type', $request->fulfill_type)
            ->where('products.title', 'like', "%$query%")
            ->select('products.*')
            ->get();
        }
        elseif ($request->input('query') && $request->input('category_name') && $request->input('status') && !$request->input('status')) {
            $supplier_products = Products::
              where('seller_type', 'supplier')
            ->whereIn('w2b_category_1', $request->category_name)
            ->where('status', $request->status)
            ->where('title', 'like', "%$query%")
            ->get();
        }
        elseif ($request->input('query') && $request->input('category_name')) {
            $supplier_products = Products::
              where('seller_type', 'supplier')
            ->whereIn('w2b_category_1', $request->category_name)
            ->where('title', 'like', "%$query%")
            ->get();
        }

        elseif ($request->input('query') && $request->input('status')) {
            $supplier_products = Products::
              where('seller_type', 'supplier')
            ->where('status', $request->status)
            ->where('title', 'like', "%$query%")
            ->get();
        }
        elseif ($request->input('query') && $request->input('fulfill_by')) {
            $supplier_products = Products::
            join('vendors','vendors.id', 'products.vendor_id')
            ->where('products.seller_type', 'supplier')
            ->where('vendors.fulfill_type', $request->fulfill_type)
            ->where('products.title', 'like', "%$query%")
            ->select('products.*')
            ->get();
        }
        elseif ($request->input('category_name') && $request->status) {
            dd('cs');
            $supplier_products = Products::
              where('seller_type', 'supplier')
            ->whereIn('w2b_category_1', $request->category_name)
            ->where('status', $request->status)
            ->get();
        }
        elseif ($request->input('category_name') && $request->input('fulfill_by')) {
            $supplier_products = Products::
            join('vendors','vendors.id', 'products.vendor_id')
            ->where('products.seller_type', 'supplier')
            ->where('vendors.fulfill_type', $request->fulfill_type)
            ->whereIn('products.w2b_category_1', $request->category_name)
            ->select('products.*')
            ->get();
        }
        elseif ($request->input('status') && $request->input('fulfill_by')) {
            $supplier_products = Products::
            join('vendors','vendors.id', 'products.vendor_id')
            ->where('products.seller_type', 'supplier')
            ->where('vendors.fulfill_type', $request->fulfill_type)
            ->where('products.status', $request->status)
            ->select('products.*')
            ->get();
        }
        elseif ($request->input('query')) {
            $supplier_products = Products::
              where('seller_type', 'supplier')
            ->where('title', 'like', "%$query%")
            ->get();
        }
        elseif ($request->input('category_name')) {
            dd('c');
            $supplier_products = Products::
              where('seller_type', 'supplier')
              ->whereIn('w2b_category_1', $request->category_name)
            ->get();
        }
        elseif ($request->input('status')) {
            $supplier_products = Products::
              where('seller_type', 'supplier')
              ->where('status', $request->status)
            ->get();
        }
        elseif ($request->input('fulfill_by')) {
            $supplier_products = Products::
            join('vendors','vendors.id', 'products.vendor_id')
            ->where('products.seller_type', 'supplier')
            ->where('vendors.fulfill_type', $request->fulfill_type)
            ->select('products.*')
            ->get();
        }
        else  {
            $supplier_products = Products::
              where('seller_type', 'supplier')
            ->get();
        }




        return view('vendor.marketplace.index', compact('supplier_products','categories'));
    }


    public function productSearch(Request $request)
    {


        $query1 = $request->input('query');
        $categories = W2bCategory::take(9)->get();
        $query = Products::select('products.*')
                ->join('vendors','vendors.id', 'products.vendor_id')
                ->where('products.seller_type', 'supplier');

            $query->when(isset($query1), function ($q) use($query1){
                return $q->where('products.title', 'like', "%$query1%");
            });

            $query->when(isset($request->category_name), function ($q) use($request){
                return $q->whereIn('products.w2b_category_1', $request->category_name);
            });
            $query->when(isset($request->status), function ($q) use($request){
                return $q->where('products.status', $request->status);
            });
            $query->when(isset($request->fulfill_type), function ($q) use($request){
                return $q->where('vendors.fulfill_type', $request->fulfill_type);
            });



            $supplier_products = $query->orderBy('created_at', 'ASC')->get();

        return view('vendor.marketplace.index', compact('supplier_products','categories'));

    }

    public function buyProduct(Request $request)
    {

        $quantity = $request->quantity;
        $input_q = array_filter($quantity, fn ($quantity) => !is_null($quantity));

        $retail_price = $request->retail_price;
        $input_r = array_filter($retail_price, fn ($retail_price) => !is_null($retail_price));

        $wholesale_price = $request->wholesale_price;
        $input_w = array_filter($wholesale_price, fn ($wholesale_price) => !is_null($wholesale_price));

        $nature_fee = $request->nature_fee;
        $input_nf = array_filter($nature_fee, fn ($nature_fee) => !is_null($nature_fee));

        $selectedProducts = $request->input('product_sku', []);
        $user_id = Auth::user()->id;

        session()->put('input_q', $input_q);
        session()->put('input_r', $input_r);
        session()->put('input_w', $input_w);
        session()->put('input_nf', $input_nf);
        session()->put('selectedProducts', $selectedProducts);

        $productDetails = []; // Initialize an array to store product details

foreach ($selectedProducts as $productId) {
    $quantity2 = $input_q[$productId];
    $retail2 = $input_r[$productId];
    $nature_fee2 = $input_nf[$productId];
    $wholesale2 = $input_w[$productId];

    // Calculate the total price for this product
    $totalPrice = $quantity2 * $wholesale2;

    // Retrieve the product title (you should have a way to do this)
    $product = DB::table('products')
        ->select('title')
        ->where('sku', $productId)
        ->first(); // Replace with your method to fetch product titles
        $productTitle = $product ? $product->title : 'Unknown Product';

    // Store product details in the array
        $productDetails[] = [
            'title' => $productTitle,
            'quantity' => $quantity2,
            'price' => $wholesale2,
            'total_price' => $totalPrice,
        ];
    }
    $stripe_key = $this->stripe_key;
    //  dd($productDetails);

    // Pass the product details to the 'thank-you' view
    return view('vendor.marketplace.payment_page', compact('productDetails','stripe_key'));
    // return view('vendor.marketplace.payment_page', compact('productDetails'));
    }

    public function storePayment( Request $request)
    {
        // dd($request->all());
        $vendorId = auth()->user()->id;
        $input_q = session()->get('input_q');
        $input_r = session()->get('input_r');
        $input_w = session()->get('input_w');
        $input_nf = session()->get('input_nf');
        $selectedProducts = session()->get('selectedProducts');

        $order_id =  strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 9));
        $user_id = Auth::user()->id;

        Stripe::setApiKey($this->stripe_secret);

        $user = Vendor::where('id', Auth::user()->id)->first();
        $city = City::where('id', $user->city)->first();
        $customer = Customer::create(array(

            "email" => $user->email,

            "name" => $user->name,

            "source" => $request->stripeToken

         ));

        $charge = Charge::create ([

            "amount" => round($request->total_price * 100),

            "currency" => "usd",

            "customer" => $customer->id,

            "description" => "Payment from Nature Checkout",

            "shipping" => [

              "name" => $user->name,

              "address" => [

                "line1" => $user->address,

                "city" => $city->name,

                "country" => "US",

              ],

            ]

        ]);
        if ($charge) {

            foreach ($selectedProducts as $productId) {
                $quantity2 = $input_q[$productId];
                $retail2 = $input_r[$productId];
                $nature_fee2 = $input_nf[$productId];
                $wholesale2 = $input_w[$productId];


                $newProduct1 = Products::where('sku',$productId)->first();
                $sup =  Vendor::where('id', $newProduct1->vendor_id)->first();

                // Store the selected product and quantity in the seller's products table
                $total_price = $wholesale2 * $quantity2;
                $nature_total_fee = $nature_fee2 * $quantity2;
                $supplier_total_price = $total_price - $nature_total_fee;
                $mpOrder = marketplaceOrder::create([
                    'order_id' => $order_id,
                    'vendor_id' => $vendorId,
                    'supplier_id' => $newProduct1->vendor_id,
                    'product_sku' => $productId,
                    'quantity' => $quantity2,
                    'wholesale_price' => $wholesale2,
                    'retail_price' => $retail2,
                    'nature_fee' => $nature_fee2,
                    'total_price' => $total_price,
                    'nature_total_fee' => $nature_total_fee,
                    'supplier_total_price' => $supplier_total_price,
                ]);
                $skuWithUserId = $productId.$user_id;

                $existingProduct = Products::where('sku', $skuWithUserId)->first();

                if ($existingProduct) {
                    $existingStock = $existingProduct->stock;
                    $updatedStock = $existingStock + $quantity2;

                    $existingProduct->update([
                        'retail_price' => $retail2,
                        'stock' => $updatedStock,
                        // Update other fields as needed
                    ]);
                } else {
                $newProduct = Products::where('sku',$productId)->first();
                if ($newProduct) {
                        Products::updateOrCreate([
                            'sku' => $skuWithUserId,
                            'title' => $newProduct->title,
                            'slug' => $newProduct->slug,
                            'description' => $newProduct->description,
                            'original_image_url' => $newProduct->original_image_url,
                            'large_image_url_250x250' => $newProduct->large_image_url_250x250,
                            'large_image_url_500x500' => $newProduct->large_image_url_500x500,
                            'retail_price' => $retail2,
                            'vendor_id' => $user_id,
                            'seller_type' => 'vendor',
                            'w2b_category_1' => $newProduct->w2b_category_1,
                            'stock' => $quantity2,
                            'in_stock' => 'Y',
                            'condition' => $newProduct->condition,
                        ]);
                    }
                }



                $details2 = [
                    'order_no' => $order_id

                ];
                Mail::to($sup->email)->send(new SupplierMarketplaceOrderMail($details2));
            }
            $grand_total = marketplaceOrder::where('order_id', $order_id)
                ->sum('total_price');
                $details = [
                    'order_no' => $order_id,
                    'total_price' => $grand_total
                ];
                Mail::to($user->email)->send(new VendorMarketplaceOrderMail($details));


            session()->forget('input_q');
            session()->forget('input_r');
            session()->forget('input_w');
            session()->forget('input_nf');
            session()->forget('selectedProducts');
            return redirect()->route('marketplace-thank-you');

        }
        return redirect()->back();

    }
    public function marketplaceWalletPayment(Request $request)
    {
        $amount = $request->amount;
        $vendorId = auth()->user()->id;
        $input_q = session()->get('input_q');
        $input_r = session()->get('input_r');
        $input_w = session()->get('input_w');
        $input_nf = session()->get('input_nf');
        $selectedProducts = session()->get('selectedProducts');

        $order_id =  strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 9));
        $user_id = Auth::user()->id;
        $user = Vendor::where('id', $user_id)->first();

        if ($user->wallet_amount < $amount) {
            return redirect()->back()->with('error', 'Your balance is not enough');
        }
        else {
            $debit = $user->wallet_amount - $amount;
            $user->update([
                'wallet_amount' => $debit,
            ]);
            foreach ($selectedProducts as $productId) {
                $quantity2 = $input_q[$productId];
                $retail2 = $input_r[$productId];
                $nature_fee2 = $input_nf[$productId];
                $wholesale2 = $input_w[$productId];


                $newProduct1 = Products::where('sku',$productId)->first();

                // Store the selected product and quantity in the seller's products table
                $total_price = $wholesale2 * $quantity2;
                $nature_total_fee = $nature_fee2 * $quantity2;
                $supplier_total_price = $total_price - $nature_total_fee;
                marketplaceOrder::create([
                    'order_id' => $order_id,
                    'vendor_id' => $vendorId,
                    'supplier_id' => $newProduct1->vendor_id,
                    'product_sku' => $productId,
                    'quantity' => $quantity2,
                    'wholesale_price' => $wholesale2,
                    'retail_price' => $retail2,
                    'nature_fee' => $nature_fee2,
                    'total_price' => $total_price,
                    'nature_total_fee' => $nature_total_fee,
                    'supplier_total_price' => $supplier_total_price,
                ]);
                $skuWithUserId = $productId.$user_id;

                $existingProduct = Products::where('sku', $skuWithUserId)->first();

                if ($existingProduct) {
                    $existingStock = $existingProduct->stock;
                    $updatedStock = $existingStock + $quantity2;

                    $existingProduct->update([
                        'retail_price' => $retail2,
                        'stock' => $updatedStock,
                        // Update other fields as needed
                    ]);
                } else {
                $newProduct = Products::where('sku',$productId)->first();
                if ($newProduct) {
                        Products::updateOrCreate([
                            'sku' => $skuWithUserId,
                            'title' => $newProduct->title,
                            'slug' => $newProduct->slug,
                            'description' => $newProduct->description,
                            'original_image_url' => $newProduct->original_image_url,
                            'large_image_url_250x250' => $newProduct->large_image_url_250x250,
                            'large_image_url_500x500' => $newProduct->large_image_url_500x500,
                            'retail_price' => $retail2,
                            'vendor_id' => $user_id,
                            'seller_type' => 'vendor',
                            'w2b_category_1' => $newProduct->w2b_category_1,
                            'stock' => $quantity2,
                            'in_stock' => 'Y',
                            'condition' => $newProduct->condition,
                        ]);
                    }
                }
            }
            $contact_data = [
                'fullname' => $request->account_title,
                'account_no' => $request->account_no,
                'amount' => $request->amount
            ];
            Mail::to('ahmad.nab331@gmail.com')->send(new WithdrawMail($contact_data));
            session()->forget('input_q');
            session()->forget('input_r');
            session()->forget('input_w');
            session()->forget('input_nf');
            session()->forget('selectedProducts');
            return redirect()->route('marketplace-thank-you');

        }
        return redirect()->back();
    }

    public function thankYou()
    {
        return view('vendor.marketplace.thank-you');
    }
}


