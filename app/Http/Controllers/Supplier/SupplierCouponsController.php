<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VendorCoupons;
use App\VendorPaidModule;
use App\VendorCouponsUsed;
use App\VendorStore;
use App\Vendor;
use App\User;
use App\UserCoupon;
use App\Category;
use App\Orders;
use App\UserSubscription;
use App\StoreSubscription;
use Auth;
use DB;
use App\Traits\Permission;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendorCouponAdminMail;
use Illuminate\View\View;

class SupplierCouponsController extends Controller
{
	use Permission;
	/**
	* Display a listing of the resource.
	*
	* @return Response
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
		/*$vendor_paid_module = VendorPaidModule::where('module_name','coupon')
						->where('vendor_id',Auth::user()->id)
						->first();*/

		$store_ids = getSupplierStore();

		$vendor_coupans = VendorCoupons::leftjoin('vendor_coupons_useds','vendor_coupons_useds.coupon_id','vendor_coupons.id')
							->join('vendors','vendors.id','=','vendor_coupons.vender_id')
								->join('vendor_stores','vendor_stores.id','=','vendor_coupons.store_id')
								->selectRaw('count(vendor_coupons_useds.coupon_id) as count_used_coupon,
										vendors.name as owner_name,
										vendor_stores.name as store_name,
										vendor_coupons.id,
										vendor_coupons.type,
										vendor_coupons.coupon_code,
										vendor_coupons.status,
										vendor_coupons.start_date,
										vendor_coupons.end_date,
										vendor_coupons.discount,
									    vendor_coupons.coupon_status')
								->groupBy('vendor_coupons.id')
								->whereIn('vendor_stores.id', $store_ids)
								// ->where('vendor_coupons.coupon_status','verified')
								->get();

		/*$vendor_coupans = VendorCoupons::join('vendors','vendors.id','=',
									'vendor_coupons.vender_id')
								->join('vendor_stores','vendor_stores.id','=','vendor_coupons.store_id')
								->select('vendors.name as owner_name','vendor_stores.name as store_name',
										'vendor_coupons.id','vendor_coupons.type',
										'vendor_coupons.coupon_code',
										'vendor_coupons.status','vendor_coupons.start_date',
										'vendor_coupons.end_date',
										'vendor_coupons.discount')
								->whereIn('vendor_stores.id', $store_ids)
								->get();*/
		return view('supplier/supplier_coupons/index',compact('vendor_coupans'/*,'vendor_paid_module'*/));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return Application|Factory|View
     */
	public function create()
	{
		$store_ids = getSupplierStore();
		$vendor_stores = VendorStore::supplier()->whereIn('id', $store_ids)->get();
		// $vendor_stores = VendorStore::supplier()->where('vendor_id',Auth::user()->id)->get();
		/*$order = Orders::selectRaw('DISTINCT customer_id')->where('vendor_id',Auth::user()->id)->get()->pluck('customer_id')->toArray();

		$users = User::whereIn('id',$order)->get();*/
		return view('supplier/supplier_coupons/create',compact('vendor_stores'/*,'users'*/));
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param Request $request
	* @return Application|RedirectResponse|Redirector
     */
	public function store(Request $request)
	{
		$request->validate([
			'store_id'=>'required',
			'coupon_code'=>'required',
			'type'=>'required',
            //'discount_for'=>'required',
            'users'=>'required',
			'start_date'=>'required',
			'end_date'=>'required',
			'discount'=>'required|numeric',
			'status'=>'required',
			'image'=>'required|mimes:jpeg,png,jpg|max:2048'
		],[
			'users.required'=>'This field is required.'
		]);

		if(!empty($request->categories))
		{
			$categories = implode(',',$request->input('categories'));
		}else{
			$categories = NULL;
		}

		$vendors_coupon = new VendorCoupons;
		$vendors_coupon->vender_id = Auth::user()->id;
		$vendors_coupon->store_id = $request->input('store_id');
		$vendors_coupon->brand_id = $request->input('brand');
		$vendors_coupon->category_id = $categories;
		$vendors_coupon->coupon_code = $request->input('coupon_code');
		$vendors_coupon->type = $request->input('type');
        //$vendors_coupon->coupon_for = $request->input('discount_for');
        $vendors_coupon->coupon_for = 'selected';
		$vendors_coupon->discount = $request->input('discount');
		$vendors_coupon->description = $request->input('description');
		$vendors_coupon->start_date = date("Y-m-d", strtotime($request->input('start_date')));
		$vendors_coupon->end_date = date("Y-m-d", strtotime($request->input('end_date')));
		$vendors_coupon->status = $request->input('status');
		$vendors_coupon->coupon_status = 'unverified';
		$vendors_coupon->created_by =Auth::user()->id;

		if ($files = $request->file('image')){
			$path = 'public/images/vendors_coupan';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);
			$vendors_coupon->image = $profileImage;
		}

		$vendors_coupon->save();

		$store_subscription = StoreSubscription::with('membership')->where('store_id', $request->input('store_id'))->first();
		if(!empty($store_subscription)) {
			if($store_subscription->membership->code == 'sprout') {
				$assign_limit = 20;
			} else if($store_subscription->membership->code == 'blossom') {
				$assign_limit = 30;
			}
		}else {
			$assign_limit = 0;
		}

		if($request->users) {

			$i = 1;
            foreach ($request->users as $key => $value) {

            	if($i <= $assign_limit){

	            	if($this->checkUserApplicable($value, $vendors_coupon->id)){

		                $user_coupon = new UserCoupon;
		                $user_coupon->coupon_id = $vendors_coupon->id;
		                $user_coupon->user_id = $value;
		                $user_coupon->save();

		                $i++;
		            }
		        }
            }
        }

        $vendor_name = Vendor::where('id',Auth::user()->id)->first();
        // $admin_email = 'ankita@addonwebsolutions.com';
        $admin_email = \Config::get('app.admin_email');
		$name = $vendor_name->name;
		$id = $vendors_coupon->id;
		Mail::to($admin_email)->send(new VendorCouponAdminMail($name,$id));

		return redirect('/supplier/supplier_coupons')->with('success',"Coupan successfully saved.");
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($id)
	{
		$vendor_coupons = VendorCoupons::find($id);
		if($vendor_coupons->status == 'enable'){
			VendorCoupons::where('id',$id)->update(array('status' => 'disable'));
			echo json_encode('disable');
		}else{
			VendorCoupons::where('id',$id)->update(array('status' => 'enable'));
			echo json_encode('enable');
		}
	}

	/**
	* Show the form for editing the specified resource.
	* @param App\VendorCoupons $vendor_coupon
	* @param  int  $id
	* @return Response
	*/
	public function edit(VendorCoupons $vendor_coupon)
	{
		$vendors = Vendor::all();
		$store_ids = getSupplierStore();
		$vendor_stores = VendorStore::supplier()->whereIn('id', $store_ids)->get();
		$order = Orders::selectRaw('DISTINCT customer_id')->where('vendor_id',Auth::user()->id)->get()->pluck('customer_id')->toArray();
		$users = User::where('id',$order)->where('status','active')->get();
		$vendor_categories = Category::all();
        $discount_users = UserCoupon::where('coupon_id',$vendor_coupon->id)->pluck('user_id')->toArray();
		return view('supplier/supplier_coupons/edit',compact('vendors','vendor_stores','vendor_coupon','users','vendor_categories','discount_users'));
	}

	/**
	* Update the specified resource in storage.
	*
	* @param Request $request
	* @param  int  $id
	* @return Response
	*/
	public function update(Request $request, $id)
	{
		/*$request->validate([
			'store_id'=>'required',
			'coupon_code'=>'required',
			'type'=>'required',
			'start_date'=>'required',
			'end_date'=>'required',
			'discount'=>'required|numeric',
			'status'=>'required'
		]);
		$data = array(
					'store_id' => $request->input('store_id'),
					'brand_id' => $request->input('brand'),
					'category_id' => implode(',',$request->input('categories')),
					'coupon_code' => $request->input('coupon_code'),
					'type' => $request->input('type'),
					'discount' => $request->input('discount'),
					'start_date' => date("Y-m-d", strtotime($request->input('start_date'))),
					'end_date' => date("Y-m-d", strtotime($request->input('end_date'))),
					'status' => $request->input('status'),
					'description'=>$request->input('description'),
					'updated_by' =>Auth::user()->id
				);
		if ($files = $request->file('image')){
			$path = 'public/images/vendors_coupan';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);
			$data['image'] = $profileImage;
		}
		VendorCoupons::where('id',$id)->update($data);*/

		$request->validate([
			'store_id'=>'required',
			'coupon_code'=>'required',
			'type'=>'required',
			//'discount_for' => 'required',
			'users'=>'required',
			'start_date'=>'required',
			'end_date'=>'required',
			'discount'=>'required',
			'status' => 'required',
			'image' => 'mimes:jpeg,png,jpg|max:2048',
		]);

		if(!empty($request->categories))
		{
			$categories = implode(',',$request->input('categories'));
		}else{
			$categories = NULL;
		}

		$data = array('store_id' => $request->input('store_id'),
					'brand_id' => $request->input('brand'),
					'category_id' => $categories,
					'coupon_code' => $request->input('coupon_code'),
					'type' => $request->input('type'),
					//'coupon_for' => $request->input('discount_for'),
					'discount' => $request->input('discount'),
					'start_date' => date("Y-m-d", strtotime($request->input('start_date'))),
					'end_date' => date("Y-m-d", strtotime($request->input('end_date'))),
					'status' => $request->input('status'),
					'description'=>$request->input('description'),
					'updated_by' =>Auth::user()->id
				);

		if ($files = $request->file('image')){
			$path = 'public/images/vendors_coupan';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);
			$data['image'] = $profileImage;
		}

		VendorCoupons::where('id',$id)->update($data);

		UserCoupon::where('coupon_id',$id)->delete();

		$store_subscription = StoreSubscription::with('membership')->where('store_id', $request->input('store_id'))->first();
		if(!empty($store_subscription)) {
			if($store_subscription->membership->code == 'sprout') {
				$assign_limit = 20;
			} else if($store_subscription->membership->code == 'blossom') {
				$assign_limit = 30;
			}
		}else {
			$assign_limit = 0;
		}

		if($request->users) {

			$i = 1;
            foreach ($request->users as $key => $value) {

            	if($i <= $assign_limit){

	            	if($this->checkUserApplicable($value, $id)){

		                $user_coupon = new UserCoupon;
		                $user_coupon->coupon_id = $id;
		                $user_coupon->user_id = $value;
		                $user_coupon->save();

		                $i++;
		            }
		        }
            }
        }

		return redirect('/supplier/supplier_coupons')->with('success',"Coupan successfully updated.");
	}

	/**
	* Remove the specified resource from storage.
	* @param App\VendorCoupons $vendor_coupon
	* @param  int  $id
	* @return Response
	*/
	public function destroy(VendorCoupons $vendor_coupon)
	{
		UserCoupon::where('coupon_id',$vendor_coupon->id)->delete();
		$vendor_coupon->delete();
		return redirect('/supplier/supplier_coupons')->with('success',"Coupan successfully deleted.");
	}

	private function checkUserApplicable($user_id, $coupon_id)
	{
		$user_coupon = UserCoupon::select(DB::raw('count(id) as total_coupon'))
			->whereRaw('MONTH(created_at) = ?',[date('m')])
			->whereRaw('YEAR(created_at) = ?',[date('Y')])
			->where('user_id',$user_id)
			->where('coupon_id', '!=', $coupon_id)
			->first();
		$subscription = UserSubscription::with(['Membership'])->where('user_subscriptions.user_id', $user_id)->first();

		if($subscription->membership->code == 'explorer' && $user_coupon->total_coupon >= 2) {
			return false;
		}else if($subscription->membership->code == 'classic' && $user_coupon->total_coupon >= 10) {
			return false;
		}else{
			return true;
		}
	}

	public function viewUsedCoupon($id)
	{
		$user_coupons = VendorCouponsUsed::select('users.first_name','users.last_name')
				->join('users','users.id','vendor_coupons_useds.user_id')
				->where('vendor_coupons_useds.coupon_id',$id)
				->get();

		echo json_encode($user_coupons);
	}
}
