<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductReview;
use App\Products;
use App\User;
use App\Orders;
use Auth;
use App\Traits\Permission;

class ProductReviewsController extends Controller
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
		// print_r($store_ids);die();
		$product_reviews = ProductReview::select('products.title as product',
								'product_reviews.id','product_reviews.comment','product_reviews.rating',
								'users.first_name','products.store_id') 
								->join('product_variants','product_variants.id','=',
									'product_reviews.product_id')
								->join('users','users.id','=','product_reviews.customer_id')
								->join('products','products.id','=','product_variants.product_id')
								->whereIn('products.store_id', $store_ids)
								->get();
								// print_r($product_reviews);die();
		return view('vendor/products_reviews/index',compact('product_reviews'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$store_ids = getVendorStore();
		$products = Products::select('products.title','product_variants.id')
						->join('product_variants','product_variants.product_id','=','products.id')
						->whereIn('products.store_id',$store_ids)
						->get();
		$order = Orders::selectRaw('DISTINCT customer_id')->where('vendor_id',Auth::user()->id)->get()->pluck('customer_id')->toArray();

		$customers = User::whereIn('id',$order)->get();
		return view('vendor/products_reviews/create',compact('products','customers'));
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
			'product_id'=>'required',
			'customer_id'=>'required',
			'rating'=>'required_without:comment|max:5',
			'comment'=>'required_without:rating'
		]);
		$product_review = new ProductReview;
		$product_review->product_id = $request->input('product_id');
		$product_review->customer_id = $request->input('customer_id');
		$product_review->comment = $request->input('comment');
		$product_review->rating = $request->input('rating');
		$product_review->save();
		return redirect('/vendor/product_reviews')->with('success',"Review successfully saved.");
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
	* @param ProductReview product_review
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(ProductReview $product_review)
	{
		$products = Products::all();
		$customers = User::all();
		return view('vendor/products_reviews/edit',compact('products','customers',
			'product_review'));
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
			'product_id'=>'required',
			'customer_id'=>'required',
			'rating'=>'required_without:comment|max:5',
			'comment'=>'required_without:rating'
		]);
		$data = array(
					'product_id' => $request->input('product_id'),
					'customer_id' => $request->input('customer_id'),
					'comment' => $request->input('comment'),
					'rating' => $request->input('rating')
				);
		ProductReview::where('id',$id)->update($data);
		return redirect('/vendor/product_reviews')->with('success',"Review successfully updated.");
	}

	/**
	* Remove the specified resource from storage.
	* @param ProductReview product_review
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(ProductReview $product_review)
	{
		$product_review->delete();
		return redirect('/vendor/product_reviews')->with('success',"Review successfully deleted.");
	}
}
