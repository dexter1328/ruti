<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Permission;
use Auth;
use App\Vendor;
use App\VendorConfiguration;

class SupplierConfigurationController extends Controller
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
		$vendor_configurations = VendorConfiguration::join('vendors','vendors.id','=','vendor_configurations.vendor_id')
						->select('vendors.name','vendor_configurations.payment_gateway','vendor_configurations.client_id',
							'vendor_configurations.id')
						->get();
		return view('admin/vendor_configuration/index',compact('vendor_configurations'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$vendors = Vendor::where('parent_id',0)->get();
		return view('admin/vendor_configuration/create',compact('vendors'));
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
			'payment_gateway'=>'required',
			'client_id'=>'required|numeric',
			'client_secret'=>'required'
		]);
		$vendor_configuration = new VendorConfiguration;
		$vendor_configuration->vendor_id = $request->input('vendor_id');
		$vendor_configuration->payment_gateway = $request->input('payment_gateway');
		$vendor_configuration->client_id = $request->input('client_id');
		$vendor_configuration->client_secret = $request->input('client_secret');
		$vendor_configuration->created_by = Auth::user()->id;
		$vendor_configuration->save();
		return redirect('/admin/vendor_configuration')->with('success',"Configuration Successfully Saved");
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
	*@param VendorConfiguration vendor_configuration
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(VendorConfiguration $vendor_configuration)
	{
		$vendors = Vendor::where('parent_id',0)->get();
		return view('admin/vendor_configuration/edit',compact('vendors','vendor_configuration'));
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
			'payment_gateway'=>'required',
			'client_id'=>'required|numeric',
			'client_secret'=>'required'
		]);

		$data = array('vendor_id' => $request->input('vendor_id'),
					'payment_gateway' => $request->input('payment_gateway'),
					'client_id' => $request->input('client_id'),
					'client_secret' => $request->input('client_secret'),
					'updated_by' =>Auth::user()->id
				);

		VendorConfiguration::where('id',$id)->update($data);
		return redirect('/admin/vendor_configuration')->with('success',"Configuration Successfully Updated");
	}

	/**
	* Remove the specified resource from storage.
	* @param VendorConfiguration vendor_configuration
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(VendorConfiguration $vendor_configuration)
	{
		$vendor_configuration->delete();
		return redirect('/admin/vendor_configuration')->with('success',"Configuration Successfully Deleted");
	}
}
