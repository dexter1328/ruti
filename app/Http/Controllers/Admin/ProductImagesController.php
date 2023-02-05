<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VendorStore;
use App\Vendor;
use Auth;
use App\ProductImages;
use App\Products;
use App\Traits\Permission;

class ProductImagesController extends Controller
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
		$product_images = ProductImages::join('vendors','vendors.id','=',
										'product_images.vendor_id')
								->join('vendor_stores','vendor_stores.id','=','product_images.store_id')
								->join('products','products.id','=','product_images.product_id')
								->select('vendors.owner_name','vendor_stores.name as store_name',
								'products.title as product_name','product_images.id','product_images.image') 
								->get();
		return view('admin/products_images/index',compact('product_images'));
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
		$products = Products::all();
		return view('admin/products_images/create',compact('vendors','vendor_stores','products'));
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
			'product_id'=>'required'
		]);
		foreach($request->file('image') as $images){
			$path = 'public/images/product_images';
			$profileImage = date('YmdHis') . "." . $images->getClientOriginalExtension();
			$images->move($path, $profileImage); 
			$product_images = new ProductImages;
			$product_images->product_id = $request->input('product_id');
			$product_images->created_by =Auth::user()->name;
			$product_images['image'] = $profileImage;
			$product_images->save();
		}
		return redirect('/admin/product-gallery/'.$product_images->product_id)->with('success',"Images has been saved.");
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
	* @param App\ProductImages product_image
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(ProductImages $product_image)
	{
		$vendors = Vendor::all();
		$vendor_stores = VendorStore::all();
		$products = Products::all();
		return view('admin/products_images/edit',compact('vendors','vendor_stores','products','product_image'));
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
		$product_images =  ProductImages::findOrFail($id);
		foreach($request->file('image') as $images){
			$path = 'public/images/product_images';
			$profileImage = date('YmdHis') . "." . $images->getClientOriginalExtension();
			$images->move($path, $profileImage); 
			$product_images->image = $profileImage;
		}
		$product_images->save();
		return redirect('/admin/product-gallery/'.$product_images->product_id)->with('success',"Images has been updated.");
	}

	/**
	* Remove the specified resource from storage.
	* @param App\ProductImages product_image
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy($id)
	{
		$product_images =  ProductImages::findOrFail($id);
		$product_id = $product_images->product_id;
		$product_images->delete();   
		return redirect('/admin/product-gallery/'.$product_id)->with('success','Images has been deleted.');
	}

	public function productGallery($id)
	{
		$product =  Products::findOrFail($id);
		$product_images = ProductImages::where('product_id', $id)->get();
		return view('admin/products_images/index', compact('product','product_images'));
	}
	public function addimage($id)
	{
		$product =  Products::findOrFail($id);
		return view('admin/products_images/create', compact('product'));  
	}
}
