<?php

namespace App\Http\Controllers\API\VendorApi;

use App\EmailTemplate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\VendorSignupMail;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Mail\VendorSuccess;
use App\Notifications\VendorResetPassword;
use App\Vendor;
use App\VendorPasswordReset;
use Config;
use App\VendorRoles;
use App\W2bCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Validator;

class AuthController extends BaseController
{



    public function sendResponse($result, $message='')
    {
        $response = [
            'success' => true,
            'result'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200, [], JSON_PRESERVE_ZERO_FRACTION);

    }




    public function register(Request $request)
    {


        $validator = Validator::make($request->all(), [
				// 'g-recaptcha-response' => 'required|captcha',
				'office_number'=>'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
				'mobile_number' =>'required|regex:/^([0-9\s\-\+\(\)]*)$/',
				'email'=>'required|email|unique:vendors',
				'password' => 'required|min:6',
    			'confirm_password' => 'required|min:6|same:password',
				'name'=>'required',
				'image' => 'required|mimes:jpeg,png,jpg|max:2048',
				'business_name' => 'required',
				'tax_id' => 'required',
				'terms_condition' =>'accepted',
				'pincode' =>'nullable|digits:5'
			],[
        		'email.unique' => 'The email has already been taken by you or some other vendor.',
        		'pincode.digits' => 'The zip code must be 5 digits.',
        		'g-recaptcha-response.required' => "Google captcha is required.",
        	]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

			$email = $request->input('email');
			$password = $request->input('password');
			$date = date('Y-m-d');
			$vendor_name = $request->input('name');
			try {
				$data = array(
						'registered_date'=>$date,
						'address' => $request->input('address'),
						'country' => $request->input('country'),
						'state' => $request->input('state'),
						'city' => $request->input('city'),
						'pincode' => $request->input('pincode'),
						'name' => $request->input('name'),
						'phone_number'=> $request->input('office_number'),
						'mobile_number' => $request->input('mobile_number'),
						'email' => $request->input('email'),
						'password' => bcrypt($request->input('password')),
						'website_link'=> $request->input('website_link'),
						'status'    => 'active',
						'business_name' => $request->input('business_name'),
						'tax_id' => $request->input('tax_id'),
						'verification' => 'yes'
					);
                $data['is_approved'] = 1;
				//print_r($data);die();
				if ($files = $request->file('image')){

					$path = 'public/images/vendors';
					$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
					$files->move($path, $profileImage);
					$data['image'] = $profileImage;
				}


			$vendor = Vendor::create($data);
			}
			catch (\Exception $e) {
				return response()->json(['error' => 'Database error', 'message' => $e->getMessage()], 500);
			}

			foreach (main_vendor_roles() as $key => $value) {
				$vendor_roles = new VendorRoles;
				$vendor_roles->vendor_id = $vendor->id;
				$vendor_roles->role_name = $value;
				$vendor_roles->slug = $key;
				$vendor_roles->status = 'active';
				$vendor_roles->save();
			}

			//get email Template
			$mailTemp = EmailTemplate::where('template','supplier-signup');
			Mail::to($email)->send(new VendorSuccess($email,$password,$vendor_name,$mailTemp));

			$country = DB::table('countries')->where('id', $request->input('country'))->value('name') ?? null;
            $state = DB::table('states')->where('id', $request->input('state'))->value('name') ?? null;
            $city = DB::table('cities')->where('id', $request->input('city'))->value('name') ?? null;
			// $admin_email = 'ankita@addonwebsolutions.com';
			$admin_email = Config::get('app.admin_email');
			$name = $request->input('name');
			$id = $vendor->id;
			$address = $request->input('address');

			$pincode = $request->input('pincode');
			$phone_number = $request->input('phone_number');
			$mobile_number  = $request->input('mobile_number');
			Mail::to($admin_email)->send(new VendorSignupMail($email,$name,$id,$address,$country,$state,$city,$pincode,$phone_number,$mobile_number));

            $success['token'] =  $vendor->createToken('VendorNatureCheckout')->accessToken;
            $success['vendor'] = array(
                'vendor_id' => $vendor->id,
                'name' => $vendor->name,
                'email' => $vendor->email,
                'office_number' => $vendor->phone_number,
                'mobile_number' => $vendor->mobile_number,
                'address'=>$vendor->address,
                'country' =>  $country,
                'state'=>$state,
                'city'=> $city,
                'pincode'=> $vendor->pincode,
                'status'=>$vendor->status,
                'tax_id'=>$vendor->tax_id,
                'image' => ($vendor->image == Null ? asset('public/images/User-Avatar.png') : asset('public/images/vendors/'.$vendor->image)),
                'business_name' => $vendor->business_name
            );
            return $this->sendResponse($success, 'Your account has been created successfully.');

		}

    public function login(Request $request)
    {
        // Validate user input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Use the custom guard to attempt authentication
        if (Auth::guard('vendor')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $vendor = Auth::guard('vendor')->user();

            $success['token'] = $vendor->createToken('VendorNatureCheckout')->accessToken;
            $success['vendor'] = [
                'vendor_id' => $vendor->id,
                'name' => $vendor->name,
                'email' => $vendor->email,
                'office_number' => $vendor->phone_number,
                'mobile_number' => $vendor->mobile_number,
                'address' => $vendor->address,
                'pincode' => $vendor->pincode,
                'status' => $vendor->status,
                'tax_id' => $vendor->tax_id,
                'image' => ($vendor->image == null ? asset('public/images/User-Avatar.png') : asset('public/images/vendors/'.$vendor->image)),
                'business_name' => $vendor->business_name,
            ];

            return $this->sendResponse($success, 'Login Successful');
        } else {
            return $this->sendError('The email address or password you entered isn\'t correct. Try entering it again');
        }
    }

    public function ForgotPassword(Request $request)
	{
		$request->validate([
			'email' => 'required|string|email',
		]);
		$vendor = Vendor::where('email', $request->email)->first();
		// print_r($user->toArray());exit();
		if (!$vendor){
			return $this->sendError("We can't find any account registered with the email address you have entered.");
		}
		$passwordReset = VendorPasswordReset::updateOrCreate(
            ['email' => $vendor->email],
            [
                'email' => $vendor->email,
                'token' => Str::random(60),
                'id' => null, // Explicitly set id to null to allow it to be auto-generated
            ]
        );
		// print_r($passwordReset);exit();
		if ($vendor && $passwordReset)
			$vendor->notify(
				new VendorResetPassword($passwordReset->token)
			);
		return $this->sendResponse(null,"An email with a password reset link has been sent, follow the direction in email to reset your password.");
	}

    public function showResetForm(Request $request, $token = null)
    {
        return view('vendor.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
	{
		$errors = $request->validate([
		   	'email'  => 'exists:vendor_password_resets,email',
			'password' => 'required|confirmed',
			'password_confirmation' => 'required'
		]);

		$token = $request->token;
		$vendors =VendorPasswordReset::where('email',$request->email)
				->where('token',$request->token)
				->first();

		if(!empty($vendors)){

			Vendor::where('email',$request->email)
				->update(array('password'=>bcrypt($request->password)));

			VendorPasswordReset::where('email',$request->email)
				->where('token',$request->token)->delete();

			return view('auth.passwords.thankyou');
		}else{
			return Redirect::back()->withErrors(['token does not match', 'token does not match']);
		}
	}

    public function changePassword(Request $request, $id)
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

		$vendors = Vendor::where('email',$email)->first();

		if (Hash::check($old_pass, $vendors->password)){
				$password = bcrypt($new_pass);
				Vendor::where('email',$email)
				->where('id',$id)
				->update(array('password' => $password));
                $success['vendor'] = array(
                    'vendor_id' => $vendors->id,
                    'old_password' => $request->old_pass,
                    'new_password' => $request->new_pass

                );
			return $this->sendResponse($success,'Your password has been successfully changed.');
		}else{
			return $this->sendError('The current password you have entered is incorrect');
			// return $this->sendError(null,'Old password does not match.');
		}
	}

    public function editProfile(Request $request, $id)
	{
		$data = array(
			'name' => $request->input('name'),
			'email' => $request->input('email'),
			'address' => $request->input('address'),
            'country' => $request->input('country'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'pincode' => $request->input('pincode'),
            'phone_number'=> $request->input('office_number'),
            'mobile_number' => $request->input('mobile_number'),
            'password' => bcrypt($request->input('password')),
            'website_link'=> $request->input('website_link'),
            'business_name' => $request->input('business_name'),
            'tax_id' => $request->input('tax_id'),
            'bank_name' => $request->input('bank_name'),
            'bank_routing_number' => $request->input('bank_routing_number'),
            'bank_account_number' => $request->input('bank_account_number')
		);


        if ($request->hasFile('image')) { // Check if a file named 'image' is present in the request
            $image = $request->file('image'); // Get the uploaded file from the request

            if ($image->isValid()) { // Check if the file is valid
                $imageName = time() . '.' . $image->extension(); // Generate a unique filename
                $image->move(public_path('images/vendors'), $imageName); // Move the file to the 'user_photo' directory
                $data['image'] = $imageName;
            }
        }

		Vendor::where('id',$id)->update($data);
		$vendor = Vendor::where('id',$id)->first();

		$success['vendor'] = array(
            'vendor_id' => $vendor->id,
            'name' => $vendor->name,
            'email' => $vendor->email,
            'office_number' => $vendor->phone_number,
            'mobile_number' => $vendor->mobile_number,
            'address'=>$vendor->address,
            'country' =>  $vendor->country,
            'state'=>$vendor->state,
            'city'=> $vendor->city,
            'pincode'=> $vendor->pincode,
            'status'=>$vendor->status,
            'tax_id'=>$vendor->tax_id,
            'image' => ($vendor->image == Null ? asset('public/images/User-Avatar.png') : asset('public/images/vendors/'.$vendor->image)),
            'business_name' => $vendor->business_name,
            'bank_name' => $vendor->bank_name,
            'bank_routing_number' => $vendor->bank_routing_number,
            'bank_account_number' => $vendor->bank_account_number
        );
		return $this->sendResponse($success,'Your profile details have been updated successfully');
	}

    public function getUserByEmail(Request $request){

		$email = $request->email;
		$vendor = Vendor::where('email', $email)->first();
		if(!empty($vendor)){
			$success['vendor'] = array(
			'vendor_id' => $vendor->id,
            'name' => $vendor->name,
            'email' => $vendor->email,
            'office_number' => $vendor->phone_number,
            'mobile_number' => $vendor->mobile_number,
            'address'=>$vendor->address,
            'country' =>  $vendor->country,
            'state'=>$vendor->state,
            'city'=> $vendor->city,
            'pincode'=> $vendor->pincode,
            'status'=>$vendor->status,
            'tax_id'=>$vendor->tax_id,
            'image' => ($vendor->image == Null ? asset('public/images/User-Avatar.png') : asset('public/images/vendors/'.$vendor->image)),
            'business_name' => $vendor->business_name,
            'bank_name' => $vendor->bank_name,
            'bank_routing_number' => $vendor->bank_routing_number,
            'bank_account_number' => $vendor->bank_account_number
			);
			return $this->sendResponse($success, 'Login Successful');
		}else{
			return $this->sendError('The email address you entered isn\'t correct. Try to enter valid email address');
		}
	}







}
