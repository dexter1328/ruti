<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Permission;
use App\CustomerReviews;
use App\VendorStore;
use App\Vendor;
use App\User;
use Auth;

class CustomerReviewsController extends Controller
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
		$customer_reviews = CustomerReviews::join('vendor_stores','vendor_stores.id','=','customer_reviews.store_id')
							->join('users','users.id','=','customer_reviews.customer_id')
							->select('vendor_stores.name as store_name',
									'customer_reviews.id','customer_reviews.review','customer_reviews.status',
									'users.first_name')
							->get();
		// $customer_reviews = CustomerReviews::all();
		return view('supplier/customers_reviews/index',compact('customer_reviews'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$vendor_stores = VendorStore::where('vendor_id',Auth::user()->id)->get();
		$customers = User::all();
		return view('supplier/customers_reviews/create',compact('vendor_stores','customers'));
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
			'store_id'=>'required',
			'customer_id'=>'required',
			'review'=>'required',
			'status'=>'required'
		]);
		$customer_review = new CustomerReviews;
		$customer_review->date = $date;
		$customer_review->vendor_id = Auth::user()->id;
		$customer_review->store_id = $request->input('store_id');
		$customer_review->customer_id = $request->input('customer_id');
		$customer_review->order_id = '1';
		$customer_review->review = $request->input('review');
		$customer_review->status = $request->input('status');
		$customer_review->created_by =Auth::user()->id;
		$customer_review->save();
		return redirect('/supplier/customer_reviews')->with('success',"Review Successfully Saved.");
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		$customer_review = CustomerReviews::find($id);
		if($customer_review->status == 'verified'){
			CustomerReviews::where('id',$id)->update(array('status' => 'unverified'));
			echo json_encode('unverified');
		}else{
			CustomerReviews::where('id',$id)->update(array('status' => 'verified'));
			echo json_encode('verified');
		}
	}

	/**
	* Show the form for editing the specified resource.
	* @param CustomerReviews customer_review
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(CustomerReviews $customer_review)
	{
		$vendor_stores = VendorStore::where('vendor_id',Auth::user()->id)->get();
		$customers = User::all();
		return view('supplier/customers_reviews/edit',compact('vendor_stores','customers','customer_review'));
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
			'store_id'=>'required',
			'customer_id'=>'required',
			'review'=>'required',
			'status'=>'required'
		]);
		$data = array('date' => $date,
					'vendor_id' => Auth::user()->id,
					'store_id' => $request->input('store_id'),
					'customer_id' => $request->input('customer_id'),
					'order_id' => '1',
					'review' => $request->input('review'),
					'status' => $request->input('status'),
					'updated_by' =>Auth::user()->id
				);
		CustomerReviews::where('id',$id)->update($data);
		return redirect('/supplier/customer_reviews')->with('success',"Review Successfully Updated.");
	}

	/**
	* Remove the specified resource from storage.
	* @param CustomerReviews customer_review
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(CustomerReviews $customer_review)
	{
		$customer_review->delete();
		return redirect('/supplier/customer_reviews')->with('success',"Review Successfully Deleted.");
	}
}
