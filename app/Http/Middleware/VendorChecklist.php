<?php

namespace App\Http\Middleware;

use DB;
use Closure;
use Illuminate\Support\Facades\Auth;

class VendorChecklist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard('vendor')->check()) {

            if (Auth::guard('vendor')->user()->seller_type!=='vendor') {
                abort(401);
            }

            $data = $this->getChecklist();


            if(!empty(Auth::user()->parent_id) && Auth::user()->parent_id != 0){
                $vid = Auth::user()->parent_id;
            }elseif(!empty(Auth::user()->id)) {
                $vid = Auth::user()->id;
            }

            if(isset($vid) && !empty($vid)) {

                $sales = DB::table('sales')
                    ->select('sales.name', 'sales.mobile')
                    ->join('vendors', 'vendors.sales_id', 'sales.id')
                    ->where('vendors.id', $vid)
                    ->first();
                $data['sales'] = $sales;

                \View::share('data', $data);
            }
        }

        return $next($request);
    }

    private function getChecklist()
    {
        $checklist = [];
        $completed_checklist = 0;
        $vendor_checklist = DB::table('checklists')->where('type', 'vendor')->where('status', 'active')->get();
        $total_checklist = count($vendor_checklist->toArray());
        // $total_checklist = count(vendor_checklist());
        // $vendor_checklist = vendor_checklist();
        if (Auth::check()) {

            $module = '';
            foreach ($vendor_checklist as $item) {

                $key = $item->code;
                $is_completed = DB::table('completed_checklists')
                    ->where('user_id', Auth::user()->id)
                    ->where('checklist_code', $key)
                    ->where('is_completed', 'yes')
                    ->where('user_type', 'vendor')
                    ->exists();
                if(!$is_completed){

                    $status = 'no';
                    if($key == 'signup_image_upload'){

                        $module = '';
                        $url = url('/vendor/profile');
                        $signup_image_upload = DB::table('vendors')->where('id', Auth::user()->id)->whereNotNull('image')->exists();
                        if($signup_image_upload){

                            DB::table('completed_checklists')
                                ->updateOrInsert(
                                    ['user_id' => Auth::user()->id, 'user_type' => 'vendor', 'checklist_code' => $key],
                                    ['is_completed' => 'yes']
                                );
                            $status = 'yes';
                            $url = '';
                            $completed_checklist++;
                        }
                    }else if($key == 'add_vendor'){

                        $module = 'vendors';
                        $url = url('/vendor/vendors');
                        $add_vendor = DB::table('vendors')->where('parent_id', Auth::user()->id)->exists();
                        if($add_vendor){

                            DB::table('completed_checklists')
                                ->updateOrInsert(
                                    ['user_id' => Auth::user()->id, 'user_type' => 'vendor', 'checklist_code' => $key],
                                    ['is_completed' => 'yes']
                                );
                            $status = 'yes';
                            $url = '';
                            $completed_checklist++;
                        }
                    }else if($key == 'add_store'){

                        $module = 'stores';
                        $url = url('/vendor/stores');
                        $add_store = DB::table('vendor_stores')->where('vendor_id', Auth::user()->id)->exists();
                        if($add_store){

                            DB::table('completed_checklists')
                                ->updateOrInsert(
                                    ['user_id' => Auth::user()->id, 'user_type' => 'vendor', 'checklist_code' => $key],
                                    ['is_completed' => 'yes']
                                );
                            $status = 'yes';
                            $url = '';
                            $completed_checklist++;
                        }
                    }else if($key == 'set_role_permission'){

                        $module = 'vendor_roles';
                        $url = url('/vendor/vendor_roles');
                        $set_role_permission = DB::table('vendor_roles')->join('vendor_role_permissions', 'vendor_role_permissions.role_id', '=', 'vendor_roles.id')->where('vendor_roles.vendor_id', Auth::user()->id)->exists();
                        if($set_role_permission){

                            DB::table('completed_checklists')
                                ->updateOrInsert(
                                    ['user_id' => Auth::user()->id, 'user_type' => 'vendor', 'checklist_code' => $key],
                                    ['is_completed' => 'yes']
                                );
                            $status = 'yes';
                            $url = '';
                            $completed_checklist++;
                        }
                    }else if($key == 'add_inventory'){

                        $module = 'products';
                        $url = url('/vendor/products');
                        $add_inventory = DB::table('products')->where('vendor_id', Auth::user()->id)->exists();
                        if($add_inventory){

                            DB::table('completed_checklists')
                                ->updateOrInsert(
                                    ['user_id' => Auth::user()->id, 'user_type' => 'vendor', 'checklist_code' => $key],
                                    ['is_completed' => 'yes']
                                );
                            $status = 'yes';
                            $url = '';
                            $completed_checklist++;
                        }
                    }else if($key == 'inventory_management_review'){

                        // $url = url('/vendor/#');
                        $url = '';
                    }else if($key == 'setup_vendor_app'){

                        // $url = url('/vendor/#');
                        $url = '';
                    }else if($key == 'setup_app_user_permissions'){

                        // $url = url('/vendor/#');
                        $url = '';
                    }else if($key == 'store_hours'){

                        $module = 'stores';
                        $url = url('/vendor/stores');
                        $store_hours = DB::table('vendor_stores')
                            ->leftjoin('vendor_store_hours','vendor_store_hours.store_id','vendor_stores.id')
                            ->where('vendor_stores.vendor_id', Auth::user()->id)
                            ->whereNull('vendor_store_hours.id')
                            ->doesntExist();
                        if($store_hours){

                            DB::table('completed_checklists')
                                ->updateOrInsert(
                                    ['user_id' => Auth::user()->id, 'user_type' => 'vendor', 'checklist_code' => $key],
                                    ['is_completed' => 'yes']
                                );
                            $status = 'yes';
                            $url = '';
                            $completed_checklist++;
                        }
                    }else if($key == 'download_vendor_app'){

                        // $url = url('/vendor/#');
                        $url = '';
                    }else if($key == 'review'){

                        // $url = url('/vendor/#');
                        $url = '';
                    }
                } else {

                    $status = 'yes';
                    $url = '';
                    $completed_checklist++;
                }

                if(Auth::user()->parent_id == 0 || $module == ''){
                    $checkPermission = true;
                }else{
                    $checkPermission = $this->hasChecklistItemPermission(Auth::user()->role_id, $module, 'write');
                    if(!$checkPermission) {
                        $total_checklist = $total_checklist - 1;
                    }
                }

                if($checkPermission) {

                    $checklist[] = array(
                        'code' => $item->code,
                        'title' => $item->title,
                        'description' => $item->description,
                        'is_completed' => $status,
                        'url' => $url
                    );
                }
            }
        }

        $percentage = floor($completed_checklist * 100 / $total_checklist);

        return array('checklist' => $checklist, 'percentage' => $percentage);
    }

    function hasChecklistItemPermission($role_id, $module, $permission) {

        $role = DB::table('vendor_role_permissions')
            ->join('vendor_roles','vendor_roles.id','=','vendor_role_permissions.role_id')
            ->where('vendor_role_permissions.role_id',$role_id)
            ->where('vendor_role_permissions.module_name',$module)
            ->where('vendor_role_permissions.'.$permission,'yes')
            ->where('vendor_roles.status','active')
            ->first();

        if(empty($role) || $role->$permission=='no') {
            return false;
        } else {
            return true;
        }
    }
}
