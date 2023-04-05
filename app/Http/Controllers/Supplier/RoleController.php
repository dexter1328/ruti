<?php

namespace App\Http\Controllers\Supplier;

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

	/**
	* Display a listing of the resource.
	*/
	public function index()
	{
		$vendor_roles = VendorRoles::where('vendor_id',Auth::user()->id)->get();
		return view('supplier/role/index', compact('vendor_roles'));
	}

	/**
	* Show the form for creating a new resource.
	*/
	public function create()
	{
		$vendor_roles = VendorRoles::where('vendor_id',Auth::user()->id)->get();
		return view('supplier/role/create',compact('vendor_roles'));
	}

	/**
	* Store a newly created resource in storage.
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
		return redirect('supplier/supplier_roles')->with('success', 'Supplier role has been added.');
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
	*/
	public function edit(VendorRoles $supplier_role)
	{
		$role_permissions  = VendorRolePermission::where('role_id', $supplier_role->id)->get();
		$permisions = [];
		foreach ($role_permissions as $role_permission) {
			$permisions[$role_permission->module_name] = array('read' => $role_permission->read, 'write' => $role_permission->write);
		}
		$role = VendorRoles::where('id',$supplier_role->id)->first();

        $supplier_modules = \supplier_modules();

		return view('supplier/role/edit', compact('supplier_role', 'permisions', 'role', 'supplier_modules'));
	}

	/**
	* Update the specified resource in storage.
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
		return redirect('supplier/supplier_roles')->with('success', 'Supplier role has been added.');
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
		return redirect('supplier/supplier_roles')->with('success', 'Supplier role has been deleted.');
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
