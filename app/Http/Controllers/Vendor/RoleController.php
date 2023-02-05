<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Traits\Permission;
use App\VendorRoles;
use App\VendorRolePermission;
use App\Vendor;
use Auth;

class RoleController extends Controller
{
	use Permission;
	/**
	* Create a new controller instance.
	*
	* @return void
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

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index()
	{
		$store_ids = getVendorStore();
		$vendor_roles = VendorRoles::where('vendor_id',Auth::user()->id)->get();
		return view('vendor/role/index', compact('vendor_roles'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$vendor_roles = VendorRoles::where('vendor_id',Auth::user()->id)->get();
		return view('vendor/role/create',compact('vendor_roles'));
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request)
	{
		//$vendor_role = VendorRoles::where('role_name',$request->role_name)->first();
		$id = $request->role_id;

		$request->validate([
            'role_id'=> [
                'required',
                Rule::unique('vendor_role_permissions')->where(function ($query) use($id) {
                    return $query->where('role_id', $id);
                }),
            ],
        ],[
            'role_id.required' => 'The Role name is required.',
            'role_id.unique' => 'The Role name has already been taken.',
        ]);
		
		//echo '<pre>'; print_r($request->all()); echo "</pre>";exit();
		// $vendor_role = new VendorRoles();
		// $vendor_role->role_name = $request->input('role_name');
		// $vendor_role->status = $request->input('status');
		// $vendor_role->created_by = Auth::user()->id;
		// $vendor_role->updated_by = Auth::user()->id;
		// $vendor_role->save();

		if($request->has('permision')){
			$permision = $request->input('permision');
			foreach ($permision as $key => $value){
				$vendor_permision = new VendorRolePermission();
				$vendor_permision->role_id = $id;
				$vendor_permision->module_name = $key;
				$vendor_permision->read = (array_key_exists("read",$value) ? 'yes' : 'no');
				$vendor_permision->write = (array_key_exists("write",$value) ? 'yes' : 'no');
				$vendor_permision->save();
			}
			$this->__completeVendorChecklist(Auth::user()->id, 'set_role_permission');
		}
		return redirect('vendor/vendor_roles')->with('success', 'Vendor role has been added.');
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		$vendor_roles = VendorRoles::find($id);
		if($vendor_roles->status == 'active'){
			VendorRoles::where('id',$id)->update(array('status' => 'deactive'));
			echo json_encode('deactive');
		}else{
			VendorRoles::where('id',$id)->update(array('status' => 'active'));
			echo json_encode('active');
		}
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  \App\VendorRoles  $vendor_roles
	* @return \Illuminate\Http\Response
	*/
	public function edit(VendorRoles $vendor_role)
	{
		$role_permissions  = VendorRolePermission::where('role_id', $vendor_role->id)->get();  
		$permisions = [];
		foreach ($role_permissions as $role_permission) {
			$permisions[$role_permission->module_name] = array('read' => $role_permission->read, 'write' => $role_permission->write);
		}
		$role = VendorRoles::where('id',$vendor_role->id)->first();
		return view('vendor/role/edit', compact('vendor_role', 'permisions','role'));
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  \App\VendorRoles  $vendor_roles
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, $id)
	{
		// echo $id;exit();
		// $request->validate([
		// 	'role_name' => 'required|unique:vendor_roles,role_name,'.$vendor_roles->id.',id',
		// 	'status' => 'required',
		// ]);

		

		// $vendor_role->role_name = $request->input('role_name');
		// $vendor_role->status = $request->input('status');
		// $vendor_role->updated_by = Auth::user()->id;
		// $vendor_role->save();

		if($request->has('permision')){
			VendorRolePermission::where('role_id', $id)->delete();
			$permision = $request->input('permision');
			foreach ($permision as $key => $value){
				$vendor_permision = new VendorRolePermission();
				$vendor_permision->role_id = $id;
				$vendor_permision->module_name = $key;
				$vendor_permision->read = (array_key_exists("read",$value) ? 'yes' : 'no');
				$vendor_permision->write = (array_key_exists("write",$value) ? 'yes' : 'no');
				$vendor_permision->save();
			}
			$this->__completeVendorChecklist(Auth::user()->id, 'set_role_permission');
		}
		return redirect('vendor/vendor_roles')->with('success', 'Vendor role has been added.');
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  \App\VendorRoles  $vendor_roles
	* @return \Illuminate\Http\Response
	*/
	public function destroy(VendorRoles $vendor_roles)
	{
		VendorRolePermission::where('role_id', $vendor_roles->id)->delete();
		$vendor_roles->delete();
		return redirect('vendor/vendor_roles')->with('success', 'Vendor role has been deleted.');
	}

	public function showRoleCustomer($id)
	{
		$vendor = Vendor::where('role_id',$id)->get();
		echo json_encode($vendor);
	}

	public function deleteRoleCustomer($id)
	{
		$data=  array('role_id'=> NULL);
		$vendor = Vendor::where('id',$id)->update($data);

		echo 'Role has been updated.';
	}
}
