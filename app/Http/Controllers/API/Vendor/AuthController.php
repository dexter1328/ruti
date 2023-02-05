<?php

namespace App\Http\Controllers\API\Vendor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Notifications\VendorResetPassword;
use App\Traits\AppNotification;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Helpers\LogActivity as Helper;
use App\UserDevice;
use App\User;
use App\Vendor;
use App\VendorPasswordReset;
use App\ProductVariants;
use App\AttributeValue;
use App\ProductImages;
use App\Products;
use App\StoresVendor;
use App\VendorRoles;
use App\VendorStoreHours;
use App\VendorStorePermission;
use App\Mail\StoreMainVendorMail;
use DB;
use Hash;
Use Redirect;
use Validator;

class AuthController extends BaseController
{
	public function login(Request $request)
	{	
		if(Auth::guard('vendor')->attempt(['email' =>  $request->email, 'password' =>  $request->password]))
		{
			/*$lat = $request->lat;
			$lon = $request->long;*/
			$lat = 34.307144;
			$lon = -106.018066;
			$vendor = Vendor::where('email',$request->email)->first();
			if($vendor->parent_id !=0)
            {
				$vendor_stores = DB::table('stores_vendors')->where('vendor_id',$vendor->id)
									->first(); 
				
				$stores = DB::table("vendor_stores")
	                ->select(
	                    DB::raw(
	                        "6371 * acos(cos(radians(" . $lat . ")) 
	                        * cos(radians(vendor_stores.lat)) 
	                        * cos(radians(vendor_stores.long) - radians(" . $lon . ")) 
	                        + sin(radians(" .$lat. ")) 
	                        * sin(radians(vendor_stores.lat))) AS distance"
	                    )
	                )
	                ->where('vendor_stores.id', $vendor_stores->store_id)
	               	->having('distance','<',100)
	                ->first();
	            // print_r($vendor_stores);die();
	            if(!empty($stores)){

	            	$day = strtolower(date("l"));
	            	$current_time = date("H:i");
	            	$vendor_store_hours = VendorStoreHours::where('week_day',$day)
	                    ->where('store_id',$vendor_stores->store_id)
	                    ->whereRaw('TIME(daystart_time) <= "'.$current_time.'"')
	                    ->whereRaw('TIME(dayend_time) >= "'.$current_time.'"')
	                    ->first();

			        if(!empty($vendor_store_hours))
			        {

		            	// if successful, then redirect to their intended location
						$vendor = auth()->guard('vendor')->user();
						//$success['token'] =  $vendor->createToken('vendor')->accessToken;
						//return response()->json(['success' => $success], $this->successStatus);
						$vendor_permissions = VendorRoles::join('vendor_role_permissions','vendor_role_permissions.role_id','vendor_roles.id')
							->where('vendor_roles.id',$vendor->role_id)
							->get();
						$data =[];
						foreach ($vendor_permissions as $key => $value) {
							$word = "mobile";
							$mystring = $value->module_name;
							 
							// Test if string contains the word 
							if(strpos($mystring, $word) !== false){
							    $data[]=array('module_name' => $mystring,
							    	'read' => ($value->read == 'yes' ? true : false),
							    	'write' => ($value->write == 'yes' ? true : false));
							} 
						}
						
						$success['token'] =  $vendor->createToken('vendor')->accessToken;
						$success['user'] = array(
							'vendor_id' => $vendor->id,
							'name' => $vendor->name,
							'email' => $vendor->email,
							'mobile' => $vendor->mobile_number,
							'is_parent' => ($vendor->parent_id == 0 ? 'parent' : 'child'),
							'photo' => ($vendor->image == Null ? asset('public/images/User-Avatar.png') : asset('public/images/vendors/'.$vendor->image)),
							'role' => $data
						);
						Helper::addToLog('Vendor Login',$vendor->id);
						return $this->sendResponse($success, 'Login successfully');
					}else{
						$curr_date = date('m/d/Y');
                        $store_permission = VendorStorePermission::where('vendor_id',$vendor->id)
                                        ->where('store_id',$vendor_stores->store_id)
                                        ->where('to','<=',$curr_date)
                                        ->where('from','>=',$curr_date)
                                        ->where('status','=','active')
                                        ->first();
                        if(!empty($store_permission))
                        {
	                    	$vendor = auth()->guard('vendor')->user();
							$vendor_permissions = VendorRoles::join('vendor_role_permissions','vendor_role_permissions.role_id','vendor_roles.id')
								->where('vendor_roles.id',$vendor->role_id)
								->get();
							$data =[];
							foreach ($vendor_permissions as $key => $value) {
								$word = "mobile";
								$mystring = $value->module_name;
								 
								if(strpos($mystring, $word) !== false){
								    $data[]=array('module_name' => $mystring,
								    	'read' => ($value->read == 'yes' ? true : false),
								    	'write' => ($value->write == 'yes' ? true : false));
								} 
							}

                        	$success['token'] =  $vendor->createToken('vendor')->accessToken;
							$success['user'] = array(
								'vendor_id' => $vendor->id,
								'name' => $vendor->name,
								'email' => $vendor->email,
								'mobile' => $vendor->mobile_number,
								'is_parent' => ($vendor->parent_id == 0 ? 'parent' : 'child'),
								'photo' => ($vendor->image == Null ? asset('public/images/User-Avatar.png') : asset('public/images/vendors/'.$vendor->image)),
								'role' => $data
							);
							Helper::addToLog('Vendor Login',$vendor->id);
							return $this->sendResponse($success, 'Login successfully');	
						}else{
							$parent = Vendor::where('id',$vendor->parent_id)->first();
							$email = $parent->email;
                            $name = $vendor->name;
							Mail::to($email)->send(new StoreMainVendorMail($name));
							return $this->sendError('Store is currently closed. You cannot access application after store hours. Contact your administrator for more information.');
						}
					}
	            }else{
	            	return $this->sendError('You can not access application outside of store. Contact your administrator for more information.');
	            }
			}else{
				$vendor = auth()->guard('vendor')->user();
				$vendor_permissions = VendorRoles::join('vendor_role_permissions','vendor_role_permissions.role_id','vendor_roles.id')
					->where('vendor_roles.id',$vendor->role_id)
					->get();
				$data =[];
				foreach ($vendor_permissions as $key => $value) {
					$word = "mobile";
					$mystring = $value->module_name;
					 
					if(strpos($mystring, $word) !== false){
					    $data[]=array('module_name' => $mystring,
					    	'read' => ($value->read == 'yes' ? true : false),
					    	'write' => ($value->write == 'yes' ? true : false));
					} 
				}
				
				$success['token'] =  $vendor->createToken('vendor')->accessToken;
				$success['user'] = array(
					'vendor_id' => $vendor->id,
					'name' => $vendor->name,
					'email' => $vendor->email,
					'mobile' => $vendor->mobile_number,
					'is_parent' => ($vendor->parent_id == 0 ? 'parent' : 'child'),
					'photo' => ($vendor->image == Null ? asset('public/images/User-Avatar.png') : asset('public/images/vendors/'.$vendor->image)),
					'role' => $data
				);
				Helper::addToLog('Vendor Login',$vendor->id);
				return $this->sendResponse($success, 'Login successfully');
			}
		}else{ 
			return $this->sendError('The email address or password you entered isn\'t correct. Try entering it again');
		}
	}

	public function ForgotPassword(Request $request)
	{
		$request->validate([
			'email' => 'required|string|email',
		]);
		$user = Vendor::where('email', $request->email)->first();
		// print_r($user->toArray());exit();
		if (!$user){
			return $this->sendError("We can't find any account registered with the email address you have entered.");
		}
		$passwordReset = VendorPasswordReset::updateOrCreate(
			['email' => $user->email],
			['email' => $user->email,
			'token' => Str::random(60)
			]
		);
		// print_r($passwordReset);exit();
		if ($user && $passwordReset)
			$user->notify(
				new VendorResetPassword($passwordReset->token)
			);
		return $this->sendResponse(null,"An email with a password reset link has been sent, follow the direction in email to reset your password.");
	}

	public function resetPassword(Request $request, $token)
	{
		return view('vendor.auth.passwords.api_reset',compact('token'));
	}

	public function reset(Request $request)
	{	
		
		$errors = $request->validate([
		   	'email'  => 'exists:vendor_password_resets,email',
			'password' => 'required|confirmed', 
			'password_confirmation' => 'required'
		]);

		$token = $request->token;
		$users =VendorPasswordReset::where('email',$request->email)
				->where('token',$request->token)
				->first();

		if(!empty($users)){
			
			Vendor::where('email',$request->email)
				->update(array('password'=>bcrypt($request->password)));

			VendorPasswordReset::where('email',$request->email)
				->where('token',$request->token)->delete();
				
			return view('vendor.auth.passwords.thankyou');
		}else{
			return Redirect::back()->withErrors(['token does not match', 'token does not match']);
		}
	}

	public function ApiReset(Request $request)
	{	
		$errors = $request->validate([
		   	'email'  => 'exists:vendor_password_resets,email',
			'password' => 'required|confirmed', 
			'password_confirmation' => 'required'
		]);

		$token = $request->token;
		$users =VendorPasswordReset::where('email',$request->email)
				->where('token',$request->token)
				->first();

		if(!empty($users)){
			
			Vendor::where('email',$request->email)
				->update(array('password'=>bcrypt($request->password)));

			VendorPasswordReset::where('email',$request->email)
				->where('token',$request->token)->delete();
			
			  return redirect('vendor/home');
		}else{
			return Redirect::back()->withErrors(['token does not match', 'token does not match']);
		}
	}

	public function editProfile(Request $request, $id)
	{
		$data = array(
			'name' => $request->name,
			'email' => $request->email,
			'mobile_number' => $request->mobile
		);

		if ($files = $request->file('image')){
            $path = 'public/images/vendors/';
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($path, $profileImage); 
            $data['image'] = $profileImage;  
        }
        // print_r($data);die();
		Vendor::where('id',$id)->update($data);
		$vendor = Vendor::where('id',$id)->first();
		
		//$success['token'] =  $vendor->createToken('vendor')->accessToken;
		//return response()->json(['success' => $success], $this->successStatus);
		$vendor_permissions = VendorRoles::join('vendor_role_permissions','vendor_role_permissions.role_id','vendor_roles.id')
			->where('vendor_roles.id',$vendor->role_id)
			->get();
		$data =[];
		foreach ($vendor_permissions as $key => $value) {
			$word = "mobile";
			$mystring = $value->module_name;
			 
			// Test if string contains the word 
			if(strpos($mystring, $word) !== false){
			    $data[]=array('module_name' => $mystring,
			    	'read' => ($value->read == 'yes' ? true : false),
			    	'write' => ($value->write == 'yes' ? true : false));
			} 
		}
						
		$success['user'] = array( 
                            'vendor_id' => $vendor->id,
                            'is_parent' => ($vendor->parent_id == 0 ? 'parent' : 'child'),
                            'role_id' => $vendor->role_id,
                            'name' => $vendor->name,
                            'email'=>$vendor->email,
                            'mobile' => $vendor->mobile_number,
                            'photo' => ($vendor->image == Null ? asset('public/images/User-Avatar.png') : asset('public/images/vendors/'.$vendor->image)),
                            'role' => $data
                        );
		return $this->sendResponse($success,'Your profile details have been updated successfully.');
	}

	public function ChangePassword(Request $request, $id)
	{	
		$validator = Validator::make($request->all(), [
			'email'  => 'exists:vendors,email',
			'old_pass'=>'required',
			'new_pass'=>'required'
		]);

		if($validator->fails()){
			return $this->sendError($validator->errors()->first(), 'Validation Error.');       
		}

		$email = $request->email;
		$old_pass = $request->old_pass;
		$new_pass =$request->new_pass;

		$users = Vendor::where('email',$request->email)->first();
		
		if (Hash::check($request->old_pass, $users->password)){
				Vendor::where('email',$request->email)
					->where('id',$id)
					->update(array('password' => bcrypt($request->new_pass)));

			return $this->sendResponse(null,'Your password has been successfully changed.');
		}else{
			return $this->sendError('The current password you have entered is incorrect');
			// return $this->sendError(null,'Old password does not match.');  
		}
	}

	public function signup($id,Request $request)
	{
		$store = [];
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'email' => 'required|email|unique:vendors',
			'password'=>'required|min:6',
			'role' =>'required',
			'store' => 'required'
		]);

		if($validator->fails()){
			return $this->sendError($validator->errors()->first());       
		}

		$vendor = new Vendor;
		$vendor->name = $request->name;
		$vendor->email = $request->email;
		$vendor->password = bcrypt($request->password);
		$vendor->mobile_number = $request->mobile_number;
		$vendor->role_id = $request->role;
		$vendor->parent_id = $id;
		$vendor->save();

		$success['token'] =  $vendor->createToken('childvendor')->accessToken;

		foreach (explode(",",$request->store) as $key => $value) {
			# code...
			$store_vendor = new StoresVendor;
			$store_vendor->vendor_id = $vendor->id;
			$store_vendor->store_id = $value;
			$store_vendor->save();
		}

		$storeData = StoresVendor::select('vendor_stores.id',
			            	'vendor_stores.name',
			            	'vendor_stores.email',
							'vendor_stores.branch_admin',
							'vendor_stores.phone_number',
							'vendor_stores.open_status',
							'vendor_stores.image'
						)
						->join('vendor_stores','vendor_stores.id','stores_vendors.store_id')
						->where('stores_vendors.vendor_id',$vendor->id)
						->get();

		if($storeData->isNotEmpty()){
			foreach ($storeData as $key => $value) {
				$store[] = array('store_id' =>  $value->id,
							'name' =>  $value->name,
							'branch_admin' =>$value->branch_admin,
							'phone_number' =>$value->phone_number,
							'email' =>$value->email,
							'current_status' =>$value->open_status,
							'image' => ($value->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$value->image))
						);
			}
		}

		$success['user'] = array(
				'vendor_id' => $vendor->id,
				'role_id' => (int)$vendor->role_id,
				'name' => $vendor->name,
				'email' => $vendor->email,
				'mobile' => $vendor->mobile_number,
				'is_parent' => ($vendor->parent_id == 0 ? 'parent' : 'child'),
				'photo' => ($vendor->image == Null ? asset('public/images/User-Avatar.png') : asset('public/images/vendors/'.$vendor->image)),
				'store' => $store
			);
		return $this->sendResponse($success, 'A vendor account has been created successfully.');
	}

	public function childVendorList($id)
	{
		$vendorData = [];
		$vendors = Vendor::where('parent_id',$id)->get();

		foreach ($vendors as $key => $vendor) {
			$storeData = StoresVendor::select('vendor_stores.id',
			            	'vendor_stores.name',
			            	'vendor_stores.email',
							'vendor_stores.branch_admin',
							'vendor_stores.phone_number',
							'vendor_stores.open_status',
							'vendor_stores.image'
						)
						->join('vendor_stores','vendor_stores.id','stores_vendors.store_id')
						->where('stores_vendors.vendor_id',$vendor->id)
						->get();

			if($storeData->isNotEmpty()){
				$store = [];
				foreach ($storeData as $key => $value) {
					$store[] = array('store_id' =>  $value->id,
								'name' =>  $value->name,
								'branch_admin' =>$value->branch_admin,
								'phone_number' =>$value->phone_number,
								'email' =>$value->email,
								'current_status' =>$value->open_status,
								'image' => ($value->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$value->image))
							);
				}
			}
			$vendorData[] = array('vendor_id' => $vendor->id,
							'role_id' => $vendor->role_id,
                            'name' => $vendor->name,
                            'email'=>$vendor->email,
                            'mobile' => $vendor->mobile_number,
                            'photo' => ($vendor->image == Null ? asset('public/images/User-Avatar.png') : asset('public/images/vendors/'.$vendor->image)),
                            'store' => $store
                        );
		}
		
		return $this->sendResponse($vendorData, 'Data retrieved successfully');
	}

	public function childVendorEdit(Request $request, $id)
	{	
		$store = [];
		$data = array(
			'name' => $request->name,
			'email' => $request->email,
			'mobile_number' => $request->mobile
		);

		if($request->password != ''){
			$data['password'] = bcrypt($request->password);  
		}

		if($request->role_id != ''){
			$data['role_id'] = $request->role_id;
		}

		if ($files = $request->file('image')){
            $path = 'public/images/vendors/';
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($path, $profileImage); 
            $data['image'] = $profileImage;  
        }
        
		Vendor::where('id',$id)->update($data);
		$vendor = Vendor::where('id',$id)->first();
		if($request->store){
			StoresVendor::where('vendor_id',$id)->delete();
			foreach (explode(",",$request->store) as $key => $value) {
				$store_vendor = new StoresVendor;
				$store_vendor->vendor_id = $vendor->id;
				$store_vendor->store_id = $value;
				$store_vendor->save();
			}
		}

		$storeData = StoresVendor::select('vendor_stores.id',
			            	'vendor_stores.name',
			            	'vendor_stores.email',
							'vendor_stores.branch_admin',
							'vendor_stores.phone_number',
							'vendor_stores.open_status',
							'vendor_stores.image'
						)
						->join('vendor_stores','vendor_stores.id','stores_vendors.store_id')
						->where('stores_vendors.vendor_id',$id)
						->get();

		if($storeData->isNotEmpty()){
			foreach ($storeData as $key => $value) {
				$store[] = array('store_id' =>  $value->id,
							'name' =>  $value->name,
							'branch_admin' =>$value->branch_admin,
							'phone_number' =>$value->phone_number,
							'email' =>$value->email,
							'current_status' =>$value->open_status,
							'image' => ($value->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$value->image))
						);
			}
		}
		
		$success['user'] = array( 
                            'vendor_id' => $vendor->id,
                            'role_id' => $vendor->role_id,
                            'is_parent' => ($vendor->parent_id == 0 ? 'parent' : 'child'),
                            'name' => $vendor->name,
                            'email'=>$vendor->email,
                            'mobile' => $vendor->mobile_number,
                            'photo' => ($vendor->image == Null ? asset('public/images/User-Avatar.png') : asset('public/images/vendors/'.$vendor->image)),
                            'store' => $store
                        );
		return $this->sendResponse($success,'The vendor details have been updated.');
	}

	public function saveVendorDevice(Request $request)
	{
		$device_exists = UserDevice::where('device_token', $request->token)->where('user_type','vendor');
		if($request->has('user_id')){
			$device_exists = $device_exists->where('user_id', $request->user_id);
		}
		if($request->has('id')){
			$device_exists = $device_exists->where('id', $request->id);
		}
		$device_exists = $device_exists->first();

		if(!empty($device_exists)){
			if($request->has('user_id')){
				$device_exists->user_id = $request->user_id;
			}else{
				$device_exists->user_id = NULL;
			}
			$device_exists->save();
			return $this->sendResponse($device_exists, 'Device token already exists.');
		}else{
		if($request->has('id')){
			$user_device = UserDevice::findOrFail($request->id);
		}else{
			$user_device = new UserDevice;
			$user_device->user_type = 'vendor';
		}
		$user_device->device_token = $request->token;
		if($request->has('user_id')){
			$user_device->user_id = $request->user_id;
		}else{
			$user_device->user_id = NULL;
		}

		$user_device->save();
		return $this->sendResponse($user_device, 'Device token has been saved.');
		}
	}

	public function childVendorDelete(Request $request, $id)
	{	
		Vendor::where('id',$id)->delete();
		StoresVendor::where('vendor_id',$id)->delete();
		return $this->sendResponse(null, 'The vendor account has been deleted successfully.');
	}

}