<?php

namespace App\Http\Controllers\Supplier;

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
		$brands = Brand::leftJoin('vendors','vendors.id','=','brands.vendor_id')
            ->select(['brands.id','brands.name','brands.description','brands.status','brands.image','vendors.name as vendor'])
            ->where('brands.vendor_id', auth()->id())
            ->get();


		return view('supplier/brands/index',compact('brands'));
	}

	/**
	* Show the form for creating a new resource.
	*/
	public function create()
	{
		return view('supplier/brands/create');
	}

	/**
	* Store a newly created resource in storage.
	*/
	public function store(Request $request)
	{
		$request->validate([
			'name'=>'required',
			'description'=>'required',
			'status'=>'required',
			'image'=>'required|mimes:jpeg,png,jpg|max:2048'
		]);
		$brands = new Brand;
		$brands->vendor_id = Auth::user()->id;
		$brands->name = $request->input('name');
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

		return redirect('/supplier/brand')->with('success',"Brand Successfully Saved.");
	}

	/**
	* Display the specified resource.
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
	*/
	public function edit(Brand $brand)
	{
		return view('supplier/brands/edit', compact('brand'));
	}

	/**
	* Update the specified resource in storage.
	*/
	public function update(Request $request, $id)
	{
		$request->validate([
			'name'=>'required',
			'description'=>'required',
			'status'=>'required',
		]);

        $brand = Brand::find($id);

		$data = array(
            'name' => $request->input('name'),
            'store_id' => $request->input('store_id'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
            'updated_by' => Auth::user()->id
        );

		if ($files = $request->file('image')){
			$path = 'public/images/brands';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);
			$data['image'] = $profileImage;
		}

        $brand->update($data);

		return redirect('/supplier/brand')->with('success',"Brand Successfully Updated.");
	}

	/**
	* Remove the specified resource from storage.
	*/
	public function destroy(Brand $brand)
	{
		$brand->delete();

		return redirect('/supplier/brand')->with('success',"Brand Successfully Deleted.");
	}
}
