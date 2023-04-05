<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VendorCoupons;
use App\UserCoupon;
use App\VendorStore;
use App\Vendor;
use App\Category;
use App\VendorCouponsUsed;
use App\UserSubscription;
use App\User;
use Auth;
use DB;
use App\Traits\Permission;

class VendorCouponsController extends Controller
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
		$vendor_coupans = VendorCoupons::vendor()->leftjoin('vendor_coupons_useds','vendor_coupons_useds.coupon_id','vendor_coupons.id')
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
								// ->where('vendor_coupons.coupon_status','verified')
								->get();
		return view('admin/vendor_coupons/index',compact('vendor_coupans'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$vendors = Vendor::vendor()->where('parent_id',0)->get();
		$vendor_stores = VendorStore::vendor()->get();
		$users = User::all();
		return view('admin/vendor_coupons/create',compact('vendors','vendor_stores','users'));
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
			'vendor_id'=>'required',
			'store_id'=>'required',
			'coupon_code'=>'required',
			'type'=>'required',
            'discount_for'=>'required',
			'start_date'=>'required',
			'end_date'=>'required',
			'discount'=>'required|numeric',
			'status'=>'required',
			//'description'=>'required',
			'image'=>'required|mimes:jpeg,png,jpg|max:2048'
		]);

		if(!empty($request->categories))
		{
			$categories = implode(',',$request->input('categories'));
		}else{
			$categories = NULL;
		}


		$vendors_coupon = new VendorCoupons;
		$vendors_coupon->vender_id = $request->input('vendor_id');
		$vendors_coupon->store_id = $request->input('store_id');
		$vendors_coupon->brand_id = $request->input('brand');
		$vendors_coupon->category_id = $categories ;
		$vendors_coupon->coupon_code = $request->input('coupon_code');
		$vendors_coupon->type = $request->input('type');
        $vendors_coupon->coupon_for = $request->input('discount_for');
		$vendors_coupon->discount = $request->input('discount');
		$vendors_coupon->description = $request->input('description');
		$vendors_coupon->start_date = date("Y-m-d", strtotime($request->input('start_date')));
		$vendors_coupon->end_date = date("Y-m-d", strtotime($request->input('end_date')));
		$vendors_coupon->status = $request->input('status');
		$vendors_coupon->created_by =Auth::user()->id;


		if ($files = $request->file('image')){
			$path = 'public/images/vendors_coupan';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);
			$vendors_coupon->image = $profileImage;
		}

		$vendors_coupon->save();

		if($request->users) {

            foreach ($request->users as $key => $value) {

            	if($this->checkUserApplicable($value, $vendors_coupon->id)){

	                $user_coupon = new UserCoupon;
	                $user_coupon->coupon_id = $vendors_coupon->id;
	                $user_coupon->user_id = $value;
	                $user_coupon->save();
	            }
            }
        }

		return redirect('/admin/vendor_coupons')->with('success',"Coupon has been saved.");
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		$vendor_coupon = VendorCoupons::vendor()->find($id);
		if($vendor_coupon->status == 'enable'){
			VendorCoupons::vendor()->where('id',$id)->update(array('status' => 'disable'));
			echo json_encode('disable');
		}else{
			VendorCoupons::vendor()->where('id',$id)->update(array('status' => 'enable'));
			echo json_encode('enable');
		}
	}

	/**
	* Show the form for editing the specified resource.
	* @param App\VendorCoupons $vendor_coupon
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(VendorCoupons $vendor_coupon)
	{
		$vendors = Vendor::vendor()->where('parent_id',0)->get();
		$vendor_stores = VendorStore::vendor()->get();
		$vendor_categories = Category::all();
		$users = User::where('status','active')->get();
        $discount_users = UserCoupon::where('coupon_id',$vendor_coupon->id)->pluck('user_id')->toArray();
		return view('admin/vendor_coupons/edit',compact('vendors','vendor_stores','vendor_coupon','vendor_categories','users','discount_users'));
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
			'coupon_code'=>'required',
			'type'=>'required',
			'discount_for' => 'required',
			'start_date'=>'required',
			'end_date'=>'required',
			'discount'=>'required',
			'status'=>'required',
			'image' => 'mimes:jpeg,png,jpg|max:2048',
		]);

		if(!empty($request->categories))
		{
			$categories = implode(',',$request->input('categories'));
		}else{
			$categories = NULL;
		}
		if(empty($request->coupon_status)){
			$coupon_status = 'verified';
		}else{
			$coupon_status = $request->coupon_status;
		}

		$data = array('vender_id'=> $request->input('vendor_id'),
					'store_id' => $request->input('store_id'),
					'brand_id' => $request->input('brand'),
					'category_id' => $categories,
					'coupon_code' => $request->input('coupon_code'),
					'type' => $request->input('type'),
					'coupon_for' => $request->input('discount_for'),
					'discount' => $request->input('discount'),
					'start_date' => date("Y-m-d", strtotime($request->input('start_date'))),
					'end_date' => date("Y-m-d", strtotime($request->input('end_date'))),
					'status' => $request->input('status'),
					'description'=>$request->input('description'),
					'updated_by' =>Auth::user()->id,
					'coupon_status' =>$coupon_status
				);

		if ($files = $request->file('image')){
			$path = 'public/images/vendors_coupan';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);
			$data['image'] = $profileImage;
		}

		VendorCoupons::vendor()->where('id',$id)->update($data);

		UserCoupon::where('coupon_id',$id)->delete();

        if($request->discount_for == 'selected') {

            foreach ($request->users as $key => $value) {

            	if($this->checkUserApplicable($value, $id)){

            		$user_coupon = new UserCoupon;
	                $user_coupon->coupon_id = $id;
	                $user_coupon->user_id = $value;
	                $user_coupon->save();
            	}
            }
        }

		return redirect('/admin/vendor_coupons')->with('success',"Coupon has been updated.");
	}

	/**
	* Remove the specified resource from storage.
	* @param App\VendorCoupons $vendor_coupon
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(VendorCoupons $vendor_coupon)
	{
		UserCoupon::where('coupon_id',$vendor_coupon->id)->delete();
		$vendor_coupon->delete();
		return redirect('/admin/vendor_coupons')->with('success',"Coupon has been deleted.");
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

	public function couponStatus($id)
	{
		$vendor_coupon = VendorCoupons::vendor()->find($id);
		if($vendor_coupon->status == 'enable'){
			VendorCoupons::vendor()->where('id',$id)->update(array('status' => 'disable'));
			echo json_encode('disable');
		}else{
			VendorCoupons::vendor()->where('id',$id)->update(array('status' => 'enable'));
			echo json_encode('enable');
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

	public function unverifiedVendorCoupon()
	{
		$vendor_coupans = VendorCoupons::vendor()->leftjoin('vendor_coupons_useds','vendor_coupons_useds.coupon_id','vendor_coupons.id')
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
								->where('vendor_coupons.coupon_status','unverified')
								->get();
		return view('admin.vendor_coupons.unverified_index',compact('vendor_coupans'));
	}

	public function verifiedVendorCoupon($id)
	{
		$data = array('coupon_status'=> 'verified');
		VendorCoupons::vendor()->where('id',$id)->update($data);
		return redirect('/admin/vendor_coupons/unverified')->with('success',"Coupon has been Verified.");
	}

	public function verifiedEditVendorCoupon($id)
	{
		$vendor_coupon = VendorCoupons::vendor()->where('id',$id)->first();
		$vendors = Vendor::vendor()->where('parent_id',0)->get();
		$vendor_stores = VendorStore::vendor()->get();
		$vendor_categories = Category::all();
		$users = User::where('status','active')->get();
        $discount_users = UserCoupon::where('coupon_id',$id)->pluck('user_id')->toArray();
		return view('admin/vendor_coupons/unverified_edit',compact('vendors','vendor_stores','vendor_coupon','vendor_categories','users','discount_users'));
	}
}
