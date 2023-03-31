<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Permission;
use Auth;
use App\VendorStore;
use App\Vendor;
use App\User;
use App\Orders;
use App\Products;
use App\OrderItems;
use App\ProductVariants;
use App\DiscountOffers;
use App\DiscountOfferProduct;

class DiscountOffersController extends Controller
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
		$store_ids = getSupplierStore();
		$discount_offers = DiscountOffers::join('vendors','vendors.id','=',
									'discount_offers.vendor_id')
								->join('vendor_stores','vendor_stores.id','=','discount_offers.store_id')
								->leftjoin('products','products.id','=','discount_offers.product_id')
								->select('vendors.name as owner_name','vendor_stores.name as store_name','products.title as product','discount_offers.id','discount_offers.title','discount_offers.description','discount_offers.image')
								->whereIn('vendor_stores.id', $store_ids)
								->get();
		return view('supplier/discount_offers/index',compact('discount_offers'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$store_ids = getSupplierStore();
		$vendor_stores = VendorStore::whereIn('id', $store_ids)->get();
		// $users = User::all();
		// $products = Products::all();
		return view('supplier/discount_offers/create',compact('vendor_stores'));
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
			'store'=>'required',
			'title'=>'required',
			'discount' => 'required'
		]);


		$discount_offers = new DiscountOffers;
		$discount_offers->vendor_id = Auth::user()->id;
		$discount_offers->store_id = $request->input('store');
		$discount_offers->title = $request->input('title');
		$discount_offers->description = $request->input('description');
		$discount_offers->discount = $request->input('discount');

		if ($files = $request->file('image')){
			$path = 'public/images/';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);
			$discount_offers->image = $profileImage;
		}

		// print_r($discount_offers);die();
		$discount_offers->save();

		if($request->input('categories')){
			foreach ($request->input('categories') as $key => $value) {

				$products = Products::where('category_id',$value)->get();

				foreach ($products as $key => $product) {

					$product_store = new DiscountOfferProduct;
					$product_store->discount_id = $discount_offers->id;
					$product_store->product_id = $product->id;
					$product_store->save();
				}
			}
		}else{
			$products = Products::where('store_id',$request->input('store'))->get();

			foreach ($products as $key => $product) {

				$product_store = new DiscountOfferProduct;
				$product_store->discount_id = $discount_offers->id;
				$product_store->product_id = $product->id;
				$product_store->save();
			}
		}

		if($request->input('product')){
			foreach ($request->input('product') as $key => $value) {

				$product_store = new DiscountOfferProduct;
				$product_store->discount_id = $discount_offers->id;
				$product_store->product_id = $value;
				$product_store->save();
			}
		}
		return redirect('/supplier/discount_offers')->with('success',"Offer has been added.");
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		die('show');
	}

	/**
	* Show the form for editing the specified resource.
	* @param  \App\DiscountOffers  $discount_offers
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$store_ids = getSupplierStore();
		$discount_offers = DiscountOffers::findOrFail($id);

		$categories = DiscountOfferProduct::select('products.category_id')
					->join('products','products.id','=','discount_offer_products.product_id')
					->where('discount_offer_products.discount_id','=',$id)
					->get();

		$products = DiscountOfferProduct::select('products.id')
					->join('products','products.id','=','discount_offer_products.product_id')
					->where('discount_offer_products.discount_id','=',$id)
					->get();

		$vendor_stores = VendorStore::whereIn('id', $store_ids)->get();

		return view('supplier/discount_offers/edit',compact('categories','discount_offers','products','vendor_stores'));
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
			'vendor'=>'required',
			'store'=>'required',
			'title'=>'required',
			'discount'=>'required',
		]);

		$data = array(
			'vendor_id' => Auth::user()->id,
			'store_id' => $request->input('store'),
			'title' => $request->input('title'),
			'discount' => $request->input('discount'),
			'description' => $request->input('description')
		);

		if ($files = $request->file('image')){
			$path = 'public/images/';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);
			$data['image'] = $profileImage;
		}

		DiscountOffers::where('id',$id)->update($data);

		DiscountOfferProduct::where('discount_id',$id)->delete();

		if($request->input('categories')){
			foreach ($request->input('categories') as $key => $value) {

				$products = Products::where('category_id',$value)->get();

				foreach ($products as $key => $product) {

					$product_store = new DiscountOfferProduct;
					$product_store->discount_id = $id;
					$product_store->product_id = $product->id;
					$product_store->save();
				}
			}
		}else{
			$products = Products::where('store_id',$request->input('store'))->get();

			foreach ($products as $key => $product) {

				$product_store = new DiscountOfferProduct;
				$product_store->discount_id = $id;
				$product_store->product_id = $product->id;
				$product_store->save();
			}
		}

		if($request->input('product')){
			foreach ($request->input('product') as $key => $value) {

				$product_store = new DiscountOfferProduct;
				$product_store->discount_id = $id;
				$product_store->product_id = $value;
				$product_store->save();
			}
		}
		return redirect('/supplier/discount_offers')->with('success',"Offer has been updated.");
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy($id)
	{
		DiscountOffers::where('id',$id)->delete();
		DiscountOfferProduct::where('discount_id',$id)->delete();
		return redirect('/supplier/discount_offers')->with('success',"Offer has been deleted.");
	}
}
