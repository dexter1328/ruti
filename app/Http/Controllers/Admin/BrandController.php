<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Brand;
use App\VendorStore;
use App\Vendor;
use Auth;
use App\Traits\Permission;
use DB;

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
		$brands = Brand::join('vendors','vendors.id','=','brands.vendor_id')
						->join('vendor_stores','vendor_stores.id','=','brands.store_id')
						->select('brands.id','brands.name','brands.description','brands.status','brands.image','vendors.name as vendor','vendor_stores.name as store')
						->get();
		return view('admin/brands/index',compact('brands'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$vendors = Vendor::where('parent_id',0)->get();
		return view('admin/brands/create',compact('vendors'));
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
			'vendor' => 'required',
			'store' =>'required',
			'name'=>'required',
			'status'=>'required',
			'image'=>'required|mimes:jpeg,png,jpg|max:2048'
		]);
		$brands = new Brand;
		$brands->vendor_id = $request->input('vendor');
		$brands->store_id = $request->input('store');
		$brands->name = $request->input('name');
		$brands->description = $request->input('description');
		$brands->status = $request->input('status');
		$brands->created_by =Auth::user()->id;

		if ($files = $request->file('image')){
			$brandPath = 'public/images/brands';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($brandPath, $profileImage);   
			$brands->image = $profileImage;
		}
		$brands->save();
		return redirect('/admin/brand')->with('success',"Brand has been saved.");
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		$brands = Brand::find($id);
		if($brands->status == 'enable'){
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
		$vendor_stores = VendorStore::all();
		$vendors = Vendor::where('parent_id',0)->get();
		return view('admin/brands/edit',compact('brand','vendors','vendor_stores'));
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
			'vendor' => 'required',
			'store' =>'required',
			'name'=>'required',
			'status'=>'required',
			'image' => 'mimes:jpeg,png,jpg|max:2048',
		]);
		$brands = new Brand;
		$data = array(
					'vendor_id' => $request->input('vendor'),
					'store_id' => $request->input('store'),
					'name' => $request->input('name'),
					'description' => $request->input('description'),
					'status' => $request->input('status'),
					'updated_by' =>Auth::user()->id
				);

		if ($files = $request->file('image')){
			$brandPath = 'public/images/brands';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($brandPath, $profileImage);   
			$data['image'] = $profileImage;
		}
		Brand::where('id',$id)->update($data);
		return redirect('/admin/brand')->with('success',"Brand has been updated.");
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
		return redirect('/admin/brand')->with('success',"Brand has been deleted.");
	}
}
