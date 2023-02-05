<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Permission;
use App\Brand;
use App\VendorStore;
use App\Vendor;
use Auth;

class BrandController extends Controller
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


		$brands = Brand::join('vendors','vendors.id','=','brands.vendor_id')
						->join('vendor_stores','vendor_stores.id','=','brands.store_id')
						->select('brands.id','brands.name','brands.description','brands.status','brands.image','vendors.name as vendor','vendor_stores.name as store')
						->whereIn('vendor_stores.id', $store_ids)
						->get();

		return view('vendor/brands/index',compact('brands'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$store_ids = getVendorStore();
		$vendor_stores = VendorStore::whereIn('id',$store_ids)->get();
		return view('vendor/brands/create', compact('vendor_stores'));
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
			'name'=>'required',
			'description'=>'required',
			'status'=>'required',
			'image'=>'required|mimes:jpeg,png,jpg|max:2048',
			'store_id' => 'required'
		]);
		$brands = new Brand;
		$brands->vendor_id = Auth::user()->id;
		$brands->name = $request->input('name');
		$brands->store_id = $request->input('store_id');
		$brands->description = $request->input('description');
		$brands->status = $request->input('status');
		$brands->created_by = Auth::user()->id;

		if ($files = $request->file('image')){
			$path = 'public/images/brands';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);   
			$brands->image = $profileImage;
		}
		$brands->save();
		return redirect('/vendor/brand')->with('success',"Brand Successfully Saved.");
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		$brand = Brand::find($id);
		if($brand->status == 'enable'){
			Brand::where('id',$id)->update(array('status' => 'disable'));
			echo json_encode('disable');
		}else{
			Brand::where('id',$id)->update(array('status' => 'enable'));
			echo json_encode('enable');
		}
	}

	/**
	* Show the form for editing the specified resource.
	* @param App\Brand brand
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(Brand $brand)
	{
		$store_ids = getVendorStore();
		$vendor_stores = VendorStore::whereIn('id',$store_ids)->get();
		return view('vendor/brands/edit',compact('brand','vendor_stores'));
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
			'name'=>'required',
			'description'=>'required',
			'status'=>'required',
			'store_id' => 'required'
		]);
		$brands = new Brand;
		$data =array('name' => $request->input('name'),
					'store_id' => $request->input('store_id'),
					'description' => $request->input('description'),
					'status' => $request->input('status'),
					'updated_by' =>Auth::user()->id
				);
		if ($files = $request->file('image')){
			$path = 'public/images/brands';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);   
			$data['image'] = $profileImage;
		}
		Brand::where('id',$id)->update($data);
		return redirect('/vendor/brand')->with('success',"Brand Successfully Updated.");
	}

	/**
	* Remove the specified resource from storage.
	* @param App\Brand brand
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(Brand $brand)
	{
		$brand->delete();
		return redirect('/vendor/brand')->with('success',"Brand Successfully Deleted.");
	}
}
