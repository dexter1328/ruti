<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use App\User;
use App\Admin;
use App\Orders;
use App\Vendor;
use App\Category;
use App\Products;
use App\OrderItems;
use App\VendorStore;
use App\ProductReview;
use App\AttributeValue;
use App\ProductVariants;
use App\WithdrawRequest;
use App\Traits\Permission;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
	use Permission;
	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct()
	{
		$this->middleware('auth:admin');
		// check for permission
		$this->middleware(function ($request, $next) {
			if(!$this->hasPermission(Auth::user())){
				return redirect('admin/home');
			}
			return $next($request);
		});
	}

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index()
	{
		// index of admin.
		$admins = Admin::select('admins.*', 'admin_roles.role_name')
			->join('admin_roles', 'admin_roles.id', 'admins.role_id')
			->whereNotIn('admins.id',[1])
			->get();

		return view('admin.admin.index', compact('admins'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		//create file.
		return view('admin.admin.create');
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
			'name' => 'required',
			'email' => 'required|email|unique:admins',
			'status' => 'required',
			'password' => 'required|min:6',
			'image' => 'mimes:jpeg,png,jpg|max:2048',
			'role_id' => 'required',
		],[
			'role_id.required' => 'The role field is required.',
		]);

		$admins = new Admin;
		$admins->name = $request->input('name');
		$admins->email = $request->input('email');
		$admins->password = bcrypt($request->input('password'));
		$admins->role_id = $request->input('role_id');
		$admins->status = $request->input('status');

		if ($files = $request->file('image')){
			$path = 'public/images/';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);
			$admins->image = $profileImage;
		}
		$admins->save();
		return redirect('/admin/admins')->with('success',"Admin has been saved.");
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		$admins = Admin::find($id);
		if($admins->status == 'active'){
			Admin::where('id',$id)->update(array('status' => 'deactive'));
			echo json_encode('deactive');
		}else{
			Admin::where('id',$id)->update(array('status' => 'active'));
			echo json_encode('active');
		}
	}

	/**
	* Show the form for editing the specified resource.
	* @param  \App\Admin  $admin
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(Admin $admin)
	{
		return view('admin.admin.edit',compact('admin'));
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
			'name' => 'required',
			'email' => 'required|unique:admins,email,' . $id,
			'status' => 'required',
			'image' => 'mimes:jpeg,png,jpg|max:2048',
			'role_id' => 'required',
		],[
			'role_id.required' => 'The role field is required.',
		]);

		$data = array(
			'name' => $request->input('name'),
			'email' => $request->input('email'),
			'role_id' => $request->input('role_id'),
			'status' => $request->input('status'),
		);

		if ($files = $request->file('image')){
			$path = 'public/images/';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);
			$data['image'] = $profileImage;
		}
		Admin::where('id', $id)->update($data);
		return redirect('/admin/admins')->with('success', 'Admin has been updated.');
	}

	/**
	* Remove the specified resource from storage.
	* @param  \App\Admin  $admin
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(Admin $admin)
	{
		$admin->delete();
		return redirect('/admin/admins')->with('success', 'Admin has been deleted.');
	}

	public function profile()
	{
		$admin = Auth::user();
		return view('admin.admin.profile',compact('admin'));
	}

	public function editprofile(Request $request)
	{
		$request->validate([
			'name'=>'required',
			'email'=>'required|unique:admins,email,' . Auth::user()->id,
		]);

		$data = array(
			'name' => $request->input('name'),
			'email' => $request->input('email')
		);
		if ($files = $request->file('image')){
			$path = 'public/images/';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);
			$data['image'] = $profileImage;
		}
		Admin::where('id', Auth::user()->id)->update($data);
		return redirect('admin/profile')->with('success',"Profile has been saved.");
		// return redirect('/admin/admins')->with('success', 'Profile is successfully Updated');
	}

	public function dashboard(Request $request)
	{

		if($request->has('start') && $request->has('end') && $request->start !='' && $request->end != ''){
            // $date = explode('-',$request->daterange);
            $start_date = date('Y-m-d',strtotime($request->start));
            $end_date = date('Y-m-d',strtotime($request->end));
        }else{
            $start_date = date('Y-m-1');
            $end_date = date('Y-m-d');
        }

        $vendor_datas = Vendor::where('status','active')->get();

        $vendor = Vendor::whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date])->count();

        $store = VendorStore::whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date])->count();

        $order = Orders::whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date])
        				->where('order_status','completed')
        				->count();

        $user = User::whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date])->count();

        // sales graph
        $graph_sales = Orders::selectRaw('count(id) as total_price, Date(created_at) as sales_date')
            ->whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date])
            ->where('order_status','completed')
            ->groupBy('sales_date');

        if($request->vendor){
        	$graph_sales = $graph_sales->where('orders.vendor_id',$request->vendor);
        }

        if($request->store){
        	$graph_sales = $graph_sales->where('orders.store_id',$request->store);
        }

        /*if($request->categories)
        {
        	$graph_sales = $graph_sales->join('order_items','order_items.order_id','orders.id')
								->join('product_variants','product_variants.id','order_items.product_variant_id')
								->join('products','products.id','product_variants.product_id')
								->whereIn('products.category_id',$request->categories);
        }*/

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
		/*$customer_reviews = ProductReview::join('products','products.id','=','product_reviews.product_id')
	    	->join('users','users.id','=','product_reviews.customer_id')
	    	->select('products.title as product','users.first_name as username','product_reviews.comment','product_reviews.rating','product_reviews.created_at')*/
	    $customer_reviews =ProductReview::select(
	    		'products.title as product',
	    		'users.first_name as username',
	    		'product_reviews.comment',
	    		'product_reviews.rating',
	    		'product_reviews.created_at',
	    		'users.image'
			)
	    	->join('product_variants','product_variants.id','=','product_reviews.product_id')
			->join('users','users.id','=','product_reviews.customer_id')
			->join('products','products.id','=','product_variants.product_id')
	    	->limit(5)
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
	    					->limit(5)
	    					->orwhereBetween(DB::raw('DATE(orders.created_at)'), [$start_date, $end_date]);

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

		$input = $request->all();
		//print_r($input); exit();

		return view('admin.home',compact('start_date','end_date','vendor','store','order','user','total_sales_graph_label', 'total_sales_graph_data','total_earning_graph_label','total_earning_graph_data','total_store_graph','store_earn','customer_reviews','recent_orders','vendor_datas','result','product_title', 'input'));
	}
    public function dashboard2()
    {
        return view('admin.layout.main2');
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

	public function getSellingChart(Request $request)
	{
		$selling_chart = Orders::selectRaw('count(orders.order_status) as count,MONTH(orders.created_at) as monthyear')
						->join('order_items','order_items.order_id','=','orders.id')
       					->join('product_variants','product_variants.id','=','order_items.product_variant_id')
       					->join('products','products.id','=','product_variants.product_id');

       	if($request->categories){
       		$selling_chart = $selling_chart->whereIn('products.category_id',$request->categories);
       	}

       	if($request->product){
       		$selling_chart = $selling_chart->where('order_items.product_variant_id',$request->product);

       	}

       	if($request->categories && $request->product){
       		$selling_chart = $selling_chart->whereIn('products.category_id',$request->categories)
       				->where('order_items.product_variant_id',$request->product);
       	}

       	$selling_chart = $selling_chart->get();
        $selling = Arr::pluck($selling_chart, 'count', 'monthyear');


        $selling_array = array();

        $months = array(1,2,3,4,5,6,7,8,9,10,11,12);

    	foreach ($months as $month) {

    	 	if (array_key_exists($month, $selling)){

    	 		$selling_array[] = (int)$selling[$month];
    	 	}else{
    	 		$selling_array[] = 0;//
    	 	}
    	}
    	echo json_encode($selling_array);
	}

	public function getEarningChart(Request $request)
	{
		$earnings_chart =Orders::selectRaw('count(orders.total_price) as count,MONTH(orders.created_at) as monthyear')
						->join('order_items','order_items.order_id','=','orders.id')
       					->join('product_variants','product_variants.id','=','order_items.product_variant_id')
       					->join('products','products.id','=','product_variants.product_id');

        if($request->categories){
       		$earnings_chart = $earnings_chart->whereIn('products.category_id',$request->categories);
       	}

       	if($request->product){
       		$earnings_chart = $earnings_chart->where('order_items.product_variant_id',$request->product);

       	}

       	if($request->categories && $request->product){
       		$earnings_chart = $earnings_chart->whereIn('products.category_id',$request->categories)
       				->where('order_items.product_variant_id',$request->product);
       	}
   		$earnings_chart = $earnings_chart->get();
     	$earnings = Arr::pluck($earnings_chart, 'count', 'monthyear');


        $earning_array = array();

        $months = array(1,2,3,4,5,6,7,8,9,10,11,12);

    	foreach ($months as $month) {

    	 	if (array_key_exists($month, $earnings)){

    	 		$earning_array[] = (int)$earnings[$month];
    	 	}else{
    	 		$earning_array[] = 0;//
    	 	}
    	}
    	echo json_encode($earning_array);
	}

	public function loginHistory()
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
							->where('log_activities.subject','Vendor Login')
							->get();

		return view('admin.admin.login_history',compact('login_history'));
	}

	public function importExportLogs()
	{
		$login_history = DB::table('log_activities')
							->select('vendors.name',
									'log_activities.created_at',
									'log_activities.ip',
									'log_activities.subject',
									'vendor_roles.role_name',
									'log_activities.type',
									'log_activities.action',
									'log_activities.module')
							->join('vendors','vendors.id','log_activities.user_id')
							->leftjoin('vendor_roles','vendor_roles.id','vendors.role_id')
							->orderBy('log_activities.id','DESC')
							->where('log_activities.subject','!=','Vendor Login')
							->where('log_activities.subject','!=','Admin Login')
							->where('log_activities.subject','!=','Customer Login')
							->get();

		return view('admin.admin.import_export_logs',compact('login_history'));
	}

    public function withdrawRequest()
    {
        $WithdrawRequests = WithdrawRequest::all();
        return view('admin.withdraw_request.index', compact('WithdrawRequests'));

    }

    public function updateStatus($id)
    {
        $wr = WithdrawRequest::find($id);
        if ($wr) {
            $wr->status = $wr->status == 'paid' ? 'unpaid' : 'paid';
            $wr->save();
        }

        return redirect()->back()->with('success', 'Withdraw updated successfully');
    }

}
