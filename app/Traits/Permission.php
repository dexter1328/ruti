<?php

namespace App\Traits;

use App\AdminRolePermission;
use App\VendorRolePermission;
use App\VendorPaidModule;
use Auth;
use DB;

trait Permission {

	public function hasPermission($user) {

		if($user->id == 1){
			return true;
		}else{
			$route = \Request::route()->getName();
			$route_array = explode('.', $route);
			$role_id = $user->role_id;
			$module = $route_array[0];
			if($module == 'admin')
			{
				$module = 'admins';
			}

			//print_r($route_array);die();
			if($route_array[1] == 'index'){
				$permission = 'read';
			}else{
				$permission = 'write';
			}

			$role = AdminRolePermission::join('admin_roles','admin_roles.id','=','admin_role_permissions.role_id')
				->where('admin_role_permissions.role_id',$role_id)
				->where('admin_role_permissions.module_name',$module)
				->where('admin_role_permissions.'.$permission,'yes')
				->where('admin_roles.status','active')
				->first();

			if((empty($role) || $role->$permission=='no') && $route_array[1] != 'home' ) {
				return false;
			} else {
				return true;
			}
		}
	}

	public function hasVendorPermission($user)
	{
		$route = \Request::route()->getName();
		$route_array = explode('.', $route);
		$module = $route_array[1] ?? $route_array[0];

		$paid_module_arr = vendor_paid_modules();

		if(array_key_exists($module,$paid_module_arr))
		{
			$paid_user_id = ($user->parent_id == 0 ? $user->id : $user->parent_id);
			$paid_vendor_module = DB::table('vendor_paid_modules')
				->where('vendor_id',$paid_user_id)
				->where('module_code',$module)
				->whereDate('start_date', '>=', date('m/d/Y'))
				->whereDate('end_date', '<=', date('m/d/Y'))
				->first();

			if(empty($paid_vendor_module) || $paid_vendor_module->status == 'no' ){
				return false;
			}
		}

		if($user->parent_id == 0){
			return true;
		}else{

			if($module == 'index'){
				$permission = 'read';
			}else{
				$permission = 'write';
			}
			$role_id = $user->role_id;
			$role = VendorRolePermission::join('vendor_roles','vendor_roles.id','=','vendor_role_permissions.role_id')
				->where('vendor_role_permissions.role_id',$role_id)
				->where('vendor_role_permissions.module_name',$module)
				->where('vendor_role_permissions.'.$permission,'yes')
				->where('vendor_roles.status','active')
				->first();

			if((empty($role) || $role->$permission=='no') && $module != 'home') {
				return false;
			} else {
				return true;
			}
		}
	}

	public function getNewsletters($user)
	{
		$newsletter = DB::table('vendor_paid_modules')
					->select('status')
					->where('vendor_id', $vendor_id)
					->where('module_name','newsletter')
					->first();
		if($newsletter->status == 'yes'){
			return true;
		}else{
			return false;
		}

	}
}
