<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Permission;
use Auth;
use App\VendorCouponsUsed;
use App\VendorCoupons;
use App\User;

class VendorCouponsUsedController extends Controller
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
		$vendor_coupans = VendorCouponsUsed::select(
				'vendor_coupons_useds.*',
				'vendor_coupons.coupon_code',
				'vendor_coupons.discount',
				'vendor_coupons.type',
				'orders.order_no',
				'users.first_name'
			)
			->join('vendor_coupons','vendor_coupons.id', 'vendor_coupons_useds.coupon_id')
			->join('orders', 'orders.id', 'vendor_coupons_useds.order_id')
			->join('users', 'users.id', 'orders.customer_id')
			->get();

		return view('admin/vendor_coupons_used/index',compact('vendor_coupans'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$users = User::all();
		$vendor_coupons = VendorCoupons::all();
		return view('admin/vendor_coupons_used/create',compact('users','vendor_coupons'));
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
			'user_id'=>'required',
			'coupon_id'=>'required'
		]);
		$vendors_coupon_used = new VendorCouponsUsed;
		$vendors_coupon_used->customer_id = $request->input('user_id');
		$vendors_coupon_used->coupon_id = $request->input('coupon_id');
		$vendors_coupon_used->date_time=date("Y/m/d H:i:s");
		$vendors_coupon_used->created_by =Auth::user()->id;
		$vendors_coupon_used->save();
		return redirect('/admin/vendor_coupons_used')->with('success',"Coupan Successfully Saved");
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		//
	}

	/**
	* Show the form for editing the specified resource.
	* 
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$users = User::all();
		$vendor_coupons = VendorCoupons::all();
		$vendor_coupon_used = VendorCouponsUsed::findOrFail($id);
		return view('admin/vendor_coupons_used/edit',compact('users','vendor_coupons','vendor_coupon_used'));
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
			'user_id'=>'required',
			'coupon_id'=>'required'
		]);

		$data = array(
					'customer_id' => $request->input('user_id'),
					'coupon_id' => $request->input('coupon_id'),
					'updated_by' =>Auth::user()->id
				);
		VendorCouponsUsed::where('id',$id)->update($data);
		return redirect('/admin/vendor_coupons_used')->with('success',"Coupan Successfully Updated");
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy($id)
	{
		 VendorCouponsUsed::where('id',$id)->delete();
        return redirect('/admin/vendor_coupons_used')->with('success', 'Coupan is successfully deleted');
	}
}
