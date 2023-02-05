<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\UserDevice;
use App\Setting;
use App\Traits\AppNotification;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

   	public function __completeVendorChecklist($user_id, $item)
   	{
   		DB::table('completed_checklists')
			->updateOrInsert(
				['user_id' => $user_id, 'user_type' => 'vendor', 'checklist_code' => $item],
				['is_completed' => 'yes']
			);
   	}

   	public function __newStoreCustomerNotification($store_id, $store_name, $store_lat, $store_long)
   	{
   		if(!empty($store_lat) && !empty($store_long)) {

			$customer_store_radius = Setting::where('key','customer_store_radius')->first();
			if(!empty($customer_store_radius)){

				$near_by_limit = miles2kms($customer_store_radius->value);
			
				$users = User::select(
					"id",
					DB::raw(
	                    "6371 * acos(cos(radians(" . $store_lat . ")) 
	                    * cos(radians(`lat`)) 
	                    * cos(radians(`long`) - radians(" . $store_long . ")) 
	                    + sin(radians(" . $store_lat . ")) 
	                    * sin(radians(`lat`))) AS distance"
	                )
				)
				->where("status","enable")
				->whereNotNull("lat")
				->whereNotNull("long")
				->having("distance", '<', $near_by_limit)
				->get()
				->pluck('id');

				$id = $store_id;
				$type = 'new_store';
				$title = 'New Store Open';
				$message = 'Hooray! '.$store_name.' joined us and now available near by. Have fun shopping!';
				$devices = UserDevice::whereIn('user_id',$users)->where('user_type','customer')->get();
				$this->sendNotification($title, $message, $devices, $type, $id);
			}
		}
   	}
}
