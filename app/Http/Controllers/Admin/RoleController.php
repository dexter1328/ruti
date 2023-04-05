<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Permission;
use App\AdminRole;
use App\AdminRolePermission;
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
		$this->middleware('auth:admin');
		$this->middleware(function ($request, $next) {
			if(!$this->hasPermission(Auth::user())){
				return redirect('admin/home');
			}
			return $next($request);
		});
	}

	/**
	* Display a listing of the resource.
	*/
	public function index()
	{
		$admin_roles = AdminRole::all();
		return view('admin/role/index', compact('admin_roles'));
	}

	/**
	* Show the form for creating a new resource.
	*/
	public function create()
	{
		return view('admin/role/create');
	}

	/**
	* Store a newly created resource in storage.
	*/
	public function store(Request $request)
	{
		$request->validate([
			'role_name' => 'required|unique:admin_roles,role_name,NULL,id',
			'status' => 'required',
			'permision' =>'required'
		]);

		//echo '<pre>'; print_r($request->all()); echo "</pre>";exit();
		$admin_role = new AdminRole();
		$admin_role->role_name = $request->input('role_name');
		$admin_role->status = $request->input('status');
		$admin_role->created_by = Auth::user()->id;
		$admin_role->updated_by = Auth::user()->id;
		$admin_role->save();

		if($request->has('permision')){
			$permision = $request->input('permision');
			foreach ($permision as $key => $value){
				$admin_permision = new AdminRolePermission();
				$admin_permision->role_id = $admin_role->id;
				$admin_permision->module_name = $key;
				$admin_permision->read = (array_key_exists("read",$value) ? 'yes' : 'no');
				$admin_permision->write = (array_key_exists("write",$value) ? 'yes' : 'no');
				$admin_permision->save();
			}
		}
		return redirect('admin/admin_roles')->with('success', 'Admin role has been added.');
	}

	/**
	* Display the specified resource.
	*/
	public function show($id)
	{
		$admin_role = AdminRole::find($id);
		if($admin_role->status == 'active'){
			AdminRole::where('id',$id)->update(array('status' => 'deactive'));
			echo json_encode('deactive');
		}else{
			AdminRole::where('id',$id)->update(array('status' => 'active'));
			echo json_encode('active');
		}

	}

	/**
	* Show the form for editing the specified resource.
	*/
	public function edit(AdminRole $admin_role)
	{
		$role_permissions  = AdminRolePermission::where('role_id', $admin_role->id)->get();
		$permisions = [];
		foreach ($role_permissions as $role_permission) {
			$permisions[$role_permission->module_name] = array('read' => $role_permission->read, 'write' => $role_permission->write);
		}
		return view('admin/role/edit', compact('admin_role', 'permisions'));
	}

	/**
	* Update the specified resource in storage.
	*/
	public function update(Request $request, AdminRole $admin_role)
	{
		$request->validate([
			'role_name' => 'required|unique:admin_roles,role_name,'.$admin_role->id.',id',
			'status' => 'required',
		]);
		$admin_role->role_name = $request->input('role_name');
		$admin_role->status = $request->input('status');
		$admin_role->updated_by = Auth::user()->id;
		$admin_role->save();

		if($request->has('permision')){
			AdminRolePermission::where('role_id', $admin_role->id)->delete();
			$permision = $request->input('permision');
			foreach ($permision as $key => $value){
				$admin_permision = new AdminRolePermission();
				$admin_permision->role_id = $admin_role->id;
				$admin_permision->module_name = $key;
				$admin_permision->read = (array_key_exists("read",$value) ? 'yes' : 'no');
				$admin_permision->write = (array_key_exists("write",$value) ? 'yes' : 'no');
				$admin_permision->save();
			}
		}
		return redirect('admin/admin_roles')->with('success', 'Admin role has been added.');
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  \App\AdminRole  $admin_role
	* @return \Illuminate\Http\Response
	*/
	public function destroy(AdminRole $admin_role)
	{
		AdminRolePermission::where('role_id', $admin_role->id)->delete();
		$admin_role->delete();
		return redirect('admin/admin_roles')->with('success', 'Admin role has been deleted.');
	}
}
