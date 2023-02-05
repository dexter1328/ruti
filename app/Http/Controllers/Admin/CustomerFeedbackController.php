<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\CustomerFeedback;
use App\VendorStore;
use App\Vendor;
use App\User;
use App\Traits\Permission;

class CustomerFeedbackController extends Controller
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
		$customer_feedbacks = CustomerFeedback::join('vendors','vendors.id','=',
									'customer_feedback.vendor_id')
								->join('vendor_stores','vendor_stores.id','=','customer_feedback.store_id')
								->join('users','users.id','=','customer_feedback.customer_id')
								->select('vendors.name as owner_name','vendor_stores.name as store_name',
								'customer_feedback.id','customer_feedback.message','customer_feedback.status',
								'users.first_name') 
								->get();

		return view('admin/customer_feedback/index',compact('customer_feedbacks'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$vendors = Vendor::all();
		$vendor_stores = VendorStore::all();
		$customers = User::all();
		return view('admin/customer_feedback/create',compact('vendors','vendor_stores','customers'));
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
			'vendor_id'=>'required',
			'store_id'=>'required',
			'customer_id'=>'required',
			'message'=>'required',
			'status'=>'required'
		]);
		$customer_feedback = new CustomerFeedback;
		$customer_feedback->date = $date;
		$customer_feedback->vendor_id = $request->input('vendor_id');
		$customer_feedback->store_id = $request->input('store_id');
		$customer_feedback->customer_id = $request->input('customer_id');
		$customer_feedback->message = $request->input('message');
		$customer_feedback->status = $request->input('status');
		$customer_feedback->created_by =Auth::user()->id;
		$customer_feedback->save();
		return redirect('/admin/customer_feedback')->with('success',"Feedback has been saved.");
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		$customer_feedback = CustomerFeedback::find($id);
		if($customer_feedback->status == 'enable'){
			CustomerFeedback::where('id',$id)->update(array('status' => 'disable'));
			echo json_encode('disable');
		}else{
			CustomerFeedback::where('id',$id)->update(array('status' => 'enable'));
			echo json_encode('enable');
		}
	}

	/**
	* Show the form for editing the specified resource.
	* @param CustomerFeedback customer_feedback
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(CustomerFeedback $customer_feedback)
	{
		$vendors = Vendor::all();
		$vendor_stores = VendorStore::all();
		$customers = User::all();
		return view('admin/customer_feedback/edit',compact('vendors','vendor_stores','customers','customer_feedback'));
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
		$date = date('Y-m-d');
		$request->validate([
			'vendor_id'=>'required',
			'store_id'=>'required',
			'customer_id'=>'required',
			'message'=>'required',
			'status'=>'required'
		]);
		$data = array('date'=> $date,
					'vendor_id' => $request->input('vendor_id'),
					'store_id' => $request->input('store_id'),
					'customer_id' => $request->input('customer_id'),
					'message' => $request->input('message'),
					'status' => $request->input('status'),
					'updated_by' =>Auth::user()->id
				);
		CustomerFeedback::where('id',$id)->update($data);
		return redirect('/admin/customer_feedback')->with('success',"Feedback has been updated.");
	}

	/**
	* Remove the specified resource from storage.
	* @param CustomerFeedback customer_feedback
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(CustomerFeedback $customer_feedback)
	{
		$customer_feedback->delete();
		return redirect('/admin/customer_feedback')->with('success',"Feedback has been deleted.");
	}
}
