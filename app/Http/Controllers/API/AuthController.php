<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\Traits\AppNotification;
use App\Http\Controllers\API\BaseController as BaseController;
use App\UserDevice;
use App\User;
use App\Vendor;
use App\PasswordReset;
use App\ProductVariants;
use App\AttributeValue;
use App\ProductImages;
use App\Products;
use App\CustomerInvite;
use App\RewardPoint;
use App\CustomerWallet;
use App\CustomerRewardPoint;
use App\CustomerEarnRewardPoint;
use App\Membership;
use App\MembershipItem;
use App\MembershipCoupon;
use App\UserSubscription;
use App\SubscriptionHistory;
use App\ErrandRunner;
use App\Mail\CustomerSignup;
use App\Mail\CustomerSubscriptionMail;
use App\Helpers\LogActivity as Helper;
use App\Notifications\W2bCustomerResetPassword;
use DB;
use Hash;
Use Redirect;
use Validator;
use Stripe;
use Carbon\Carbon;
use Exception;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends BaseController
{
	use AppNotification;

	// private $stripe_secret = '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';
	// private $stripe_secret = 'sk_test_Tl9CUopVg1Pjb9iYt7WS4Nye003cV0vCK6';
	private $stripe_secret;

	public function __construct()
	{
		$this->stripe_secret = config('services.stripe.secret');
	}

	/**
	* Register api
	*
	* @return \Illuminate\Http\Response
	*/
	public function register(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'first_name' => 'required',
			'last_name' => 'required',
			'email' => 'required|email|unique:users',
			'mobile'=>'required',
			'social_id' => 'unique:users',
		]);

		if($validator->fails()){
			return $this->sendError($validator->errors()->first());
		}

		$user = new User;
		$user->first_name = $request->first_name;
		$user->last_name = $request->last_name;
		$user->email = $request->email;
		$user->password = bcrypt($request->password);
		$user->mobile = $request->mobile;
		$user->status = 'active';

        if ($request->hasFile('image')) { // Check if a file named 'image' is present in the request
            $image = $request->file('image'); // Get the uploaded file from the request

            if ($image->isValid()) { // Check if the file is valid
                $imageName = time() . '.' . $image->extension(); // Generate a unique filename
                $image->move(public_path('user_photo'), $imageName); // Move the file to the 'user_photo' directory
                $user->image = $image;
            }
        }

		if($request->dob){
			$dob = str_replace('/', '-', $request->dob);
			$user->dob = date("Y-m-d", strtotime($dob));
		}

		if($request->anniversary_date){
			$anniversary_date = str_replace('/', '-', $request->anniversary_date);
			$user->anniversary_date = date("Y-m-d", strtotime($anniversary_date));
		}

		if($request->social_id && $request->social_type){
			$user->social_type = $request->social_type;
			$user->social_id = $request->social_id;
		}

		$user->save();
		//$name = $user->first_name.' '.$user->last_name;
		$name = $user->first_name;
		Mail::to($user->email)->send(new CustomerSignup($user->email,$name));


		$success['token'] =  $user->createToken('NatureCheckout')->accessToken;
		$success['user'] = array(
			'user_id' => $user->id,
			'stripe_customer_id' => $user->stripe_customer_id,
			'social_id' => $user->social_id,
			'social_type' => $user->social_type,
			'first_name'=>$user->first_name,
			'last_name' =>  $user->last_name,
			'email'=>$user->email,
			'dob'=> ($user->dob == '' ? null : date("d/m/Y", strtotime($user->dob))),
			'anniversary_date'=>($user->anniversary_date == '' ? null : date("d/m/Y", strtotime($user->anniversary_date))),
			'mobile'=>$user->mobile,
			'photo' => ($user->image == Null ? asset('public/images/User-Avatar.png') : asset('public/user_photo/'.$user->image)),
            'about' => $user->about
		);
		return $this->sendResponse($success, 'Your account has been created successfully.');

	}

	public function login(Request $request)
	{
		if(Auth::attempt(['email' => request('email'),'status' =>'active' ,'password' => request('password')]))
		{
			$user = Auth::user();

			$success['token'] =  $user->createToken('NatureCheckout')->accessToken;
			$success['user'] = array(
				'user_id' => $user->id,
				'stripe_customer_id' => $user->stripe_customer_id,
				'social_id' => $user->social_id,
				'social_type' => $user->social_type,
				'first_name' => $user->first_name,
				'last_name' => $user->last_name,
				'email' => $user->email,
				'dob' => ($user->dob == '' ? null : date("d/m/Y", strtotime($user->dob))),
				'anniversary_date' => ($user->anniversary_date == '' ? null : date("d/m/Y", strtotime($user->anniversary_date))),
				'mobile' => $user->mobile,
				'photo' => ($user->image == Null ? asset('public/images/User-Avatar.png') : asset('public/user_photo/'.$user->image)),
            	'about' => $user->about,

			);
			// notification
		    /*$title = 'login';
		    $message = 'You are logged in.';
		    $devices = UserDevice::where('user_id',$user->id)->get();
		    $this->sendNotification($title, $message, $devices);*/
			//notification
		    // Helper::addToLog('Customer Login',$user->id);

			return $this->sendResponse($success, 'Login Successful');
		} else{
			return $this->sendError('The email address or password you entered isn\'t correct. Try entering it again');
		}
	}

	public function socialLogin(Request $request)
	{
		$success = [];
		$user = User::where('social_id',$request->social_id)->where('social_type',$request->social_type)->first();
        if(!empty($user)){
            Auth::loginUsingId($user->id, true);

            $success['token'] =  $user->createToken('Hellamaid')->accessToken;
            $success['user'] = array(
            	'user_id' => $user->id,
				'stripe_customer_id' => $user->stripe_customer_id,
				'social_id' => $user->social_id,
				'social_type' => $user->social_type,
				'first_name' => $user->first_name,
				'last_name' => $user->last_name,
				'email' => $user->email,
				'dob' => ($user->dob == '' ? null : date("d/m/Y", strtotime($user->dob))),
				'anniversary_date' => ($user->anniversary_date == '' ? null : date("d/m/Y", strtotime($user->anniversary_date))),
				'mobile' => $user->mobile,
				'photo' => ($user->image == Null ? asset('public/images/User-Avatar.png') : asset('public/user_photo/'.$user->image)),
            	'about' => $user->about,

			);
            return $this->sendResponse($success, 'Login Successful');
        }else{
        	return $this->sendResponse(null, "We can't find any account attached with our system from this provider");
        }
	}

    public function authFacebook()
    {
        // Return the Facebook login URL as a JSON response
        $facebookRedirectUrl = Socialite::driver('facebook')->stateless()->redirect()->getTargetUrl();
        return response()->json(['facebook_login_url' => $facebookRedirectUrl]);
    }

    public function fbCallback(Request $request)
    {
        try {
            $user = Socialite::driver('facebook')->stateless()->user();

            $finduser = User::where('social_id', $user->id)->first();

            if ($finduser) {
                Auth::guard('w2bcustomer')->login($finduser);

                return response()->json(['message' => 'Logged in successfully']);
            } else {
                $newUser = User::updateOrCreate(['email' => $user->email], [
                    'first_name' => $user->name,
                    'social_id' => $user->id,
                    'social_type' => 'facebook',
                    'password' => bcrypt('123456dummy')
                ]);

                Auth::guard('w2bcustomer')->login($newUser);

                return response()->json(['message' => 'Registered and logged in successfully']);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function authGoogle()
    {
        // Return the google login URL as a JSON response
        $googleRedirectUrl = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
        return response()->json(['google_login_url' => $googleRedirectUrl]);
    }

    public function googleCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();

            $finduser = User::where('social_id', $user->id)->first();

            if ($finduser) {
                Auth::guard('w2bcustomer')->login($finduser);

                return response()->json(['message' => 'Logged in successfully']);
            } else {
                $newUser = User::updateOrCreate(['email' => $user->email],[
                    'first_name' => $user->name,
                    // 'image' => $user1['picture'],
                    'social_id'=> $user->id,
                    'social_type'=> 'google',
                    'password' => encrypt('123456dummy')
                ]);

                Auth::guard('w2bcustomer')->login($newUser);

                return response()->json(['message' => 'Registered and logged in successfully']);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


	public function ForgotPassword(Request $request)
	{
		$request->validate([
			'email' => 'required|string|email',
		]);
		$user = User::where('email', $request->email)->first();
		// print_r($user->toArray());exit();
		if (!$user){
			return $this->sendError("We can't find any account registered with the email address you have entered.");
		}
		$passwordReset = PasswordReset::updateOrCreate(
			['email' => $user->email],
			['email' => $user->email,
			'token' => Str::random(60)
			]
		);
		// print_r($passwordReset);exit();
		if ($user && $passwordReset)
			$user->notify(
				new W2bCustomerResetPassword($passwordReset->token)
			);
		// print_r($user->notify(
		// 		new PasswordResetRequest($passwordReset->token)
		// 	));die();
		return $this->sendResponse(null,"An email has been sent to your email address, follow the direction in email to reset your password.");
	}

	public function editProfile(Request $request, $id)
	{
		$data = array(
			'first_name'=>$request->first_name,
			'last_name'=> $request->last_name,
			'mobile'=>$request->mobile,
			'about'=>$request->about
		);

		if($request->dob){
			$dob = str_replace('/', '-', $request->dob);
			$data['dob'] = date("Y-m-d", strtotime($dob));
		}else{
			$data['dob']='';
		}

		if($request->anniversary_date){
			$anniversary_date = str_replace('/', '-', $request->anniversary_date);
			$data['anniversary_date'] = date("Y-m-d", strtotime($anniversary_date));
		}else{
			$data['anniversary_date']='';
		}

		if ($files = $request->file('image')){
            $path = 'public/user_photo/';
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($path, $profileImage);
            $data['image'] = $profileImage;
        }

		User::where('id',$id)->update($data);
		$user = User::where('id',$id)->first();
		$subscription = UserSubscription::with(['Membership', 'MembershipItem'])->where('user_subscriptions.user_id', $user->id)->first();

		$success['user'] = array(
        	'user_id' => $user->id,
			'stripe_customer_id' => $user->stripe_customer_id,
			'social_id' => $user->social_id,
			'social_type' => $user->social_type,
			'first_name' => $user->first_name,
			'last_name' => $user->last_name,
			'email' => $user->email,
			'dob' => ($user->dob == '' ? null : date("d/m/Y", strtotime($user->dob))),
			'anniversary_date' => ($user->anniversary_date == '' ? null : date("d/m/Y", strtotime($user->anniversary_date))),
			'mobile' => $user->mobile,
			'photo' => ($user->image == Null ? asset('public/images/User-Avatar.png') : asset('public/user_photo/'.$user->image)),
        	'about' => $user->about,
        	'wallet_terms_conditions' => (int)$user->wallet_terms_conditions,
        	'price_drop_alert' => (int)$user->price_drop_alert,
        	'is_join' => (int)$user->is_join,
        	'is_user_guide_completed' => (int)$user->is_user_guide_completed,
        	'subscription' => $subscription
        );
		return $this->sendResponse($success,'Your profile details have been updated successfully');
	}

	public function ChangePassword(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'email'  => 'exists:users,email',
			'old_pass'=>'required',
			'new_pass'=>'required'
		]);

		if($validator->fails()){
			return $this->sendError($validator->errors()->first(), 'Validation Error.');
		}

		$email = $request->email;
		$old_pass = $request->old_pass;
		$new_pass =$request->new_pass;

		$users = User::where('email',$email)->first();

		if (Hash::check($old_pass, $users->password)){
				$password = bcrypt($new_pass);
				User::where('email',$email)
				->where('id',$id)
				->update(array('password' => $password));
                $success['user'] = array(
                    'user_id' => $users->id,
                    'old_password' => $request->old_pass,
                    'new_password' => $request->new_pass

                );
			return $this->sendResponse($success,'Your password has been successfully changed.');
		}else{
			return $this->sendError('The current password you have entered is incorrect');
			// return $this->sendError(null,'Old password does not match.');
		}
	}

	// public function resetPassword(Request $request, $token)
	// {
	// 	return view('auth.passwords.reset',compact('token'));
	// }
    public function showResetForm(Request $request, $token = null)
    {
        return view('w2b_customers.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

	public function reset(Request $request)
	{
		$errors = $request->validate([
		   	'email'  => 'exists:password_resets,email',
			'password' => 'required|confirmed',
			'password_confirmation' => 'required'
		]);

		$token = $request->token;
		$users =PasswordReset::where('email',$request->email)
				->where('token',$request->token)
				->first();

		if(!empty($users)){

			User::where('email',$request->email)
				->update(array('password'=>bcrypt($request->password)));

			PasswordReset::where('email',$request->email)
				->where('token',$request->token)->delete();

			return view('auth.passwords.thankyou');
		}else{
			return Redirect::back()->withErrors(['token does not match', 'token does not match']);
		}
	}

	public function saveUserDevice(Request $request)
	{
		$device_exists = UserDevice::where('device_token', $request->token);
        if($request->has('id')){
            $user_device = UserDevice::findOrFail($request->id);
            $device_exists = $device_exists->where('id', $request->id)->where('user_id',$request->user_id)->where('user_type','customer');
        }else{
            $user_device = new UserDevice;
            $user_device->user_type = 'customer';
        }
        $device_exists = $device_exists->first();

        if(!empty($device_exists)){
        	$device_exists->device_token = $request->token;
        	$device_exists->user_id = $request->user_id;
        	$device_exists->save();
            return $this->sendResponse($device_exists, 'Device token already exists.');
        }else{
            $user_device->device_token = $request->token;
            if($request->has('user_id')){
                $user_device->user_id = $request->user_id;
            }else{
                $user_device->user_id = NULL;
            }

            $user_device->save();
            return $this->sendResponse($user_device, 'Device token has been saved.');
        }

		/*$device_exists = UserDevice::where('device_token', $request->token);;
        if($request->has('id')){
            $user_device = UserDevice::findOrFail($request->id);
            $device_exists = $device_exists->where('id', $request->id);
        }else{
            $user_device = new UserDevice;
        }
        $device_exists = $device_exists->first();

        if(!empty($device_exists)){
            $user_device->device_token = $device_exists->device_token;
        }else{
        	$user_device->device_token = $request->token;
        }

        if($request->user_id){
            $user_device->user_id = $request->user_id;
        }else{
            $user_device->user_id = null;
        }

        $user_device->save();
        return $this->sendResponse($user_device, 'Device token has been saved.');*/
	}

	public function getUserByEmail(Request $request){

		$email = $request->email;
		$user = User::where('email', $email)->first();
		if(!empty($user)){
			$success['user'] = array(
				'user_id' => $user->id,
				'first_name'=>$user->first_name,
				'last_name' =>  $user->last_name,
				'email'=>$user->email,
				'dob'=> ($user->dob == '' ? null : date("d/m/Y", strtotime($user->dob))),
				'anniversary_date'=>($user->anniversary_date == '' ? null : date("d/m/Y", strtotime($user->anniversary_date))),
				'mobile'=>$user->mobile,
				'photo' => ($user->image == Null ? asset('public/images/User-Avatar.png') : asset('public/user_photo/'.$user->image)),
				'about' => $user->about,
			);
			return $this->sendResponse($success, 'Login Successful');
		}else{
			return $this->sendError('The email address you entered isn\'t correct. Try to enter valid email address');
		}
	}

	public function saveCustomerCard(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if($request->has('stripeToken') && $request->get('stripeToken')!=''){
            if($user->stripe_customer_id != NULL) {
                $customer_id = $user->stripe_customer_id;
            } else {
                try {
                    Stripe\Stripe::setApiKey($this->stripe_secret);
                    $customer = Stripe\Customer::create ([
                        "name" => $user->first_name,
                        "email" => $user->email
                    ]);
                    $customer_id = $customer->id;
                    $user->stripe_customer_id = $customer_id;
                    $user->save();
                } catch(\Stripe\Exception\CardException $e) {
                    return $this->sendError($e->getMessage());
                } catch (\Stripe\Exception\RateLimitException $e) {
                    return $this->sendError($e->getMessage());
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    return $this->sendError($e->getMessage());
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    return $this->sendError($e->getMessage());
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    return $this->sendError($e->getMessage());
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    return $this->sendError($e->getMessage());
                } catch (Exception $e) {
                    return $this->sendError($e->getMessage());
                }
            }

            try {
                Stripe\Stripe::setApiKey($this->stripe_secret);
                $card = Stripe\Customer::createSource(
                    $customer_id,
                    ['source' => $request->get('stripeToken')]
                );

                $data = array(
                    'id' => $card->id,
                    'object' => $card->object,
                    'brand' => $card->brand,
                    'country' => $card->country,
                    'exp_month' => $card->exp_month,
                    'exp_year' => $card->exp_year,
                    'funding' => $card->funding,
                    'last4' => $card->last4
                );

                $success['card'] = $data;
                return $this->sendResponse($success, 'Your card has beed saved.');
            } catch(\Stripe\Exception\CardException $e) {
                return $this->sendError($e->getMessage());
            } catch (\Stripe\Exception\RateLimitException $e) {
                return $this->sendError($e->getMessage());
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                return $this->sendError($e->getMessage());
            } catch (\Stripe\Exception\AuthenticationException $e) {
                return $this->sendError($e->getMessage());
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                return $this->sendError($e->getMessage());
            } catch (\Stripe\Exception\ApiErrorException $e) {
                return $this->sendError($e->getMessage());
            } catch (Exception $e) {
                return $this->sendError($e->getMessage());
            }
        } else {
            return $this->sendError('Stripe token field is required..');
        }
    }

    public function retriveCustomerCards($id)
    {
        $user = User::findOrFail($id);
        if($user->stripe_customer_id != NULL) {
        	Stripe\Stripe::setApiKey($this->stripe_secret);
            try {
                $response = Stripe\Customer::retrieve($user->stripe_customer_id);
                $cards = [];
                if(isset($response->sources->data)){
	                $stripe_cards = $response->sources->data;
	                foreach ($stripe_cards as $key => $value) {
	                    $cards[] = array(
	                        'id' => $value->id,
	                        'object' => $value->object,
	                        'brand' => $value->brand,
	                        'country' => $value->country,
	                        'exp_month' => $value->exp_month,
	                        'exp_year' => $value->exp_year,
	                        'funding' => $value->funding,
	                        'last4' => $value->last4,
	                        'defualt' => ($response->default_source == $value->id ? true : false)
	                    );
	                }
	            }
                //$success['defualt'] = $response->default_source;
                $success = $cards;
                return $this->sendResponse($success, 'Your card list.');
            } catch(\Stripe\Exception\CardException $e) {
                return $this->sendError($e->getMessage());
            } catch (\Stripe\Exception\RateLimitException $e) {
                return $this->sendError($e->getMessage());
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                return $this->sendError($e->getMessage());
            } catch (\Stripe\Exception\AuthenticationException $e) {
                return $this->sendError($e->getMessage());
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                return $this->sendError($e->getMessage());
            } catch (\Stripe\Exception\ApiErrorException $e) {
                return $this->sendError($e->getMessage());
            } catch (Exception $e) {
                return $this->sendError($e->getMessage());
            }
        } else {
        	return $this->sendResponse(null,'You did not save any card.');
           // return $this->sendError('You did not save any card.');
        }
    }

    public function setCustomerDefaultCard(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if($request->has('card_id') && $request->get('card_id')!=''){
            if($user->stripe_customer_id != NULL) {
                try {
                    Stripe\Stripe::setApiKey($this->stripe_secret);
                    $response = Stripe\Customer::update(
                        $user->stripe_customer_id,
                        ['default_source' => $request->get('card_id')]
                    );
                    return $this->sendResponse(null, 'Your selected card has been save as defualt.');
                } catch(\Stripe\Exception\CardException $e) {
                    return $this->sendError($e->getMessage());
                } catch (\Stripe\Exception\RateLimitException $e) {
                    return $this->sendError($e->getMessage());
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    return $this->sendError($e->getMessage());
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    return $this->sendError($e->getMessage());
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    return $this->sendError($e->getMessage());
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    return $this->sendError($e->getMessage());
                } catch (Exception $e) {
                    return $this->sendError($e->getMessage());
                }
            }else{
                return $this->sendError('You did not save any card.');
            }
        } else {
            return $this->sendError('Card id field is required.');
        }
    }

    public function deleteCustomerCard(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if($request->has('card_id') && $request->get('card_id')!=''){
            if($user->stripe_customer_id != NULL) {
                try {
                    Stripe\Stripe::setApiKey($this->stripe_secret);
                    $response = Stripe\Customer::deleteSource(
                        $user->stripe_customer_id,
                        $request->get('card_id')
                    );
                    return $this->sendResponse(null, 'Your selected card has been deleted.');
                } catch(\Stripe\Exception\CardException $e) {
                    return $this->sendError($e->getMessage());
                } catch (\Stripe\Exception\RateLimitException $e) {
                    return $this->sendError($e->getMessage());
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    return $this->sendError($e->getMessage());
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    return $this->sendError($e->getMessage());
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    return $this->sendError($e->getMessage());
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    return $this->sendError($e->getMessage());
                } catch (Exception $e) {
                    return $this->sendError($e->getMessage());
                }
            }else{
                return $this->sendError('You did not delete any card.');
            }
        } else {
            return $this->sendError('Card id field is required.');
        }
    }

	public function getCustomerChecklist($id)
	{
		$checklist = [];
		$customer_checklist = DB::table('checklists')->where('type', 'customer')->where('status', 'active')->get();
		//$total_checklist = count($customer_checklist->toArray());

		//$completed_checklist = 0;
		foreach ($customer_checklist as $item) {

			$status = false;
			$key = $item->code;
			if($key == 'signup_image_upload'){

				$signup_image_upload = DB::table('users')
					->where('id', $id)
					->whereNotNull('image')
					->exists();
				if($signup_image_upload){
					$status = true;
					//$completed_checklist++;
				}
			}else if($key == 'refer_20_friends'){

				$customer_total_invites = DB::table('customer_invites')
					->select(DB::raw('COUNT(*) as invited_users'))
					->where('invite_by_id', $id)
					->having('invited_users', '>=' , 20)
					->exists();
				if($customer_total_invites){
					$status = true;
					//$completed_checklist++;
				}else{
					$customer_invite_month = DB::table('customer_invites')
						->where('invite_by_id', $id)
						->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
						->exists();
					if($customer_invite_month){
						$status = true;
						//$completed_checklist++;
					}
				}
			}else if($key == 'maintain_minimum_wallet'){

				$wallet_amount = DB::table('users')
					->where('id', $id)
					->where('wallet_amount', '>=', 25)
					->exists();
				if($wallet_amount){
					$status = true;
					//$completed_checklist++;
				}
			}else if($key == 'make_store_purchase'){

				$orders = DB::table('orders')
					->where('customer_id', $id)
					->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
					->exists();
				if($orders){
					$status = true;
					//$completed_checklist++;
				}
			}else if($key == 'suggest_store'){

				$suggested_places = DB::table('suggested_places')
					->select(DB::raw('COUNT(*) as place_count'))
					->where('user_id', $id)
					->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
					->having('place_count', '>=' , 2)
					->exists();
				if($suggested_places){
					$status = true;
					//$completed_checklist++;
				}
			}else if($key == 'social_share_naturecheckout'){

			}else if($key == 'review'){

			}

			DB::table('completed_checklists')
				->updateOrInsert(
					['user_id' => $id, 'user_type' => 'customer', 'checklist_code' => $key],
					['is_completed' => $status]
				);

			$checklist[] = array(
				'code' => $item->code,
				'title' => $item->title,
				'description' => $item->description,
				'is_completed' => $status,
			);
		}

		$success['checklist'] = $checklist;
		return $this->sendResponse($success, 'Customer Checklist');
	}

	public function membershipList()
	{
		$features = customer_membership_features();
		$memberships = Membership::with('MembershipItems')->where('type', 'customer')->get();
		$coupons = [];
		// $coupons = MembershipCoupon::all();
		return $this->sendResponse(['features' => $features, 'memberships' => $memberships, 'coupons' => $coupons], 'Membership list.');
	}

	public function membershipIncentives()
	{
		$incentives = customer_membership_incentives();
		return $this->sendResponse(['membership_incentives' => $incentives], 'Customer membership incentives');
	}

	public function customerIncentives()
	{
		$incentives = customer_incentives();
		return $this->sendResponse(['customer_incentives' => $incentives], 'Customer incentives');
	}

	private function calculateProrationPrice($old_end_date, $new_start_date, $old_price, $new_price, $old_period, $new_period)
	{
		$month = date('m', strtotime($new_start_date));
		$year = date('Y', strtotime($new_start_date));
		if($old_period == 'month' && $new_period == 'year'){
			$days_of_months = $this->cal_days_in_year($year);
		}else{
			$days_of_months = cal_days_in_month(CAL_GREGORIAN,$month,$year);
		}
		$datediff = strtotime($old_end_date) - strtotime($new_start_date);
		$prorated_days = round($datediff / (60 * 60 * 24));
		$total_amount = ($prorated_days * $old_price) / $days_of_months;
		$total_amount = number_format((float)$total_amount, 2, '.', '');
		return $price = $new_price - $total_amount;
		/*echo $old_end_date = '2022-03-14';
		echo '<br>';
		echo $new_start_date = '2022-02-15';
		echo '<br>';
		echo $month = date('m', strtotime($new_start_date));
		echo '<br>';
		echo $year = date('Y', strtotime($new_start_date));
		echo '<br>';
		echo $days_of_months = cal_days_in_month(CAL_GREGORIAN,$month,$year);
		//$days_of_months = 30;
		echo '<br>';
		$datediff = strtotime($old_end_date) - strtotime($new_start_date);
		echo $prorated_days = round($datediff / (60 * 60 * 24));
		echo '<br>';
		//echo $old_price = 2.99;
		echo $old_price = 2.99;
		echo '<br>';
		echo $new_price = 7.99;
		echo '<br>';
		$total_amount = ($prorated_days * $old_price) / $days_of_months;
		echo $total_amount = number_format((float)$total_amount, 2, '.', '');
		echo '<br>';
		echo $new_price = $new_price - $total_amount;
		exit*/
	}

	private function cal_days_in_year($year){
		$days=0;
		for($month=1;$month<=12;$month++){
			$days = $days + cal_days_in_month(CAL_GREGORIAN,$month,$year);
		}
		return $days;
	}

	public function changeSubscription(Request $request)
	{
		//echo $old_end_date = '2022-03-14';
		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'membership_id' => 'required',
			'membership_item_id' => 'required',
			'subscription_id' => 'required'
		]);

		if($validator->fails()){

			return $this->sendError($validator->errors()->first());
		}

		$cards = [];
		$user = User::findOrFail($request->user_id);
		if(empty($user->stripe_customer_id)){
			return $this->sendError('Please add debit/credit card.');
		}else{

			Stripe\Stripe::setApiKey($this->stripe_secret);
            try {
                $response = Stripe\Customer::retrieve($user->stripe_customer_id);
                if(isset($response->sources->data)){
	                $stripe_cards = $response->sources->data;
	                foreach ($stripe_cards as $key => $value) {
	                    $cards[] = array(
	                        'id' => $value->id,
	                        'object' => $value->object,
	                        'brand' => $value->brand,
	                        'country' => $value->country,
	                        'exp_month' => $value->exp_month,
	                        'exp_year' => $value->exp_year,
	                        'funding' => $value->funding,
	                        'last4' => $value->last4,
	                        'defualt' => ($response->default_source == $value->id ? true : false)
	                    );
	                }
	            }
            } catch(\Stripe\Exception\CardException $e) {
                return $this->sendError($e->getMessage());
            } catch (\Stripe\Exception\RateLimitException $e) {
                return $this->sendError($e->getMessage());
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                return $this->sendError($e->getMessage());
            } catch (\Stripe\Exception\AuthenticationException $e) {
                return $this->sendError($e->getMessage());
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                return $this->sendError($e->getMessage());
            } catch (\Stripe\Exception\ApiErrorException $e) {
                return $this->sendError($e->getMessage());
            } catch (Exception $e) {
                return $this->sendError($e->getMessage());
            }
		}

		if(empty($cards)) {
			return $this->sendError('Please add debit/credit card.');
		}

		$old_subscription = UserSubscription::with(['Membership', 'MembershipItem'])->where('user_subscriptions.user_id', $request->user_id)->first();
		$membership = MembershipItem::with('Membership')->where('id', $request->membership_item_id)->first();
		if($old_subscription->is_cancelled == 'yes') {
			return $this->sendError("You have already cancelled the plan and you cannot upgrade / downgrade your plan.");
		}else if(!empty($old_subscription->MembershipItem) && $old_subscription->MembershipItem->price > $membership->price) {
			return $this->sendError("You can cancel your plan but can't downgrade.");
		} elseif($old_subscription->membership->code == 'bougie' && $old_subscription->membershipItem->billing_period == 'month' && $old_subscription->membership->code != $membership->membership->code) {
			return $this->sendError("You can cancel your plan but can't downgrade.");
		} elseif($membership->membership->code == $old_subscription->membership->code && $old_subscription->membershipItem->billing_period == $membership->billing_period) {
			return $this->sendError("This is your current plan.");
		}

		$price = $membership->price;
		$membership_start_date = date('Y-m-d H:i:s');
		$membership_end_date = date('Y-m-d H:i:s', strtotime('+1 '.$membership->billing_period));

		if($old_subscription->membership->code == $membership->membership->code && $old_subscription->membershipItem->billing_period != $membership->billing_period) {
			$membership_start_date = $old_subscription->membership_start_date;
			$membership_end_date = date('Y-m-d H:i:s', strtotime('+1 '.$membership->billing_period, strtotime($old_subscription->membership_end_date)));
		} else if($membership->membership->code == 'bougie' && $membership->billing_period == 'year' && $old_subscription->is_used_bougie == 0){
			$membership_end_date = date('Y-m-d H:i:s', strtotime('+1 month'));
		}

		if(!empty($old_subscription->MembershipItem->price) && $old_subscription->membership->code != $membership->membership->code) {

			$old_end_date = $old_subscription->membership_end_date;
			$new_start_date = $membership_start_date;
			$month = date('m', strtotime($new_start_date));
			$year = date('Y', strtotime($new_start_date));
			$days_of_months = cal_days_in_month(CAL_GREGORIAN,$month,$year);
			$datediff = strtotime($old_end_date) - strtotime($new_start_date);
			$prorated_days = round($datediff / (60 * 60 * 24));
			$old_price = $old_subscription->membershipItem->price;
			$price_diff = ($prorated_days * $old_price) / 31;
			$price_diff = number_format((float)$price_diff, 2, '.', '');
			$price = $price - $price_diff;
			$price = number_format((float)$price, 2, '.', '');
		}

		// echo '<pre>'; print_r($request->all()); exit();

		 if($membership->membership->code != 'bougie' || ($membership->membership->code == 'bougie' && $old_subscription->is_used_bougie == 1)) {

			if($price > $user->wallet_amount) {

				Stripe\Stripe::setApiKey($this->stripe_secret);
				try {

					$charge = Stripe\Charge::create ([
		                "amount" => $price * 100,
		                "currency" => "usd",
		                "customer" => $user->stripe_customer_id,
		               	// "source" => $request->card_id,
		                "description" => "Money added in your wallet."
	        		]);

					if(empty($user->wallet_amount)){
	        			$closing_amount = $membership->price;
	        		}else{
	        			$closing_amount = $user->wallet_amount + $membership->price;
	        		}

	        		$user->wallet_amount = $closing_amount;
					$user->save();

					$credit_customer_wallet = new CustomerWallet;
					$credit_customer_wallet->customer_id = $request->user_id;
					$credit_customer_wallet->amount = $price;
					$credit_customer_wallet->closing_amount = $user->wallet_amount;
					$credit_customer_wallet->type = 'credit';
					$credit_customer_wallet->save();

				} catch(\Stripe\Exception\CardException $e) {
	                return $this->sendError($e->getMessage());
	            } catch (\Stripe\Exception\RateLimitException $e) {
	                return $this->sendError($e->getMessage());
	            } catch (\Stripe\Exception\InvalidRequestException $e) {
	                return $this->sendError($e->getMessage());
	            } catch (\Stripe\Exception\AuthenticationException $e) {
	                return $this->sendError($e->getMessage());
	            } catch (\Stripe\Exception\ApiConnectionException $e) {
	                return $this->sendError($e->getMessage());
	            } catch (\Stripe\Exception\ApiErrorException $e) {
	                return $this->sendError($e->getMessage());
	            } catch (Exception $e) {
	                return $this->sendError($e->getMessage());
	            }
			}

			$user->wallet_amount = $user->wallet_amount-$price;
			$user->save();

			$customer_wallet = new CustomerWallet;
			$customer_wallet->customer_id = $request->user_id;
			$customer_wallet->amount = $price;
			$customer_wallet->closing_amount = $user->wallet_amount;
			$customer_wallet->type = 'subscription_charge';
			$customer_wallet->save();
		}

		$user_subscription = UserSubscription::findOrFail($old_subscription->id);
		$user_subscription->user_id = $request->user_id;
		$user_subscription->membership_id = $request->membership_id;
		$user_subscription->membership_item_id = $request->membership_item_id;
		$user_subscription->membership_start_date = $membership_start_date;
		$user_subscription->membership_end_date = $membership_end_date;
		$user_subscription->is_cancelled = 'no';
		$user_subscription->status = 'active';
		$user_subscription->renew_period = $membership->billing_period;
		if($membership->membership->code == 'bougie' && $old_subscription->is_used_bougie == 0) {
			$user_subscription->proration_price = $price;
			$user_subscription->is_used_bougie = 1;
		}else{
			$user_subscription->price = $price;
		}
		$user_subscription->save();

		$new_subscription = UserSubscription::with(['Membership', 'MembershipItem'])->findOrFail($old_subscription->id);

		if($user->wallet_amount <= 25) {

			$id = NULL;
			$type = 'wallet_low_balance';
			$title = 'Wallet Balance Required';
			$message = '$25 minimum is required in wallet at any time for transaction';
			$devices = UserDevice::where('user_id',$request->user_id)->where('user_type','customer')->get();
			$this->sendNotification($title, $message, $devices, $type, $id);
		}

		$id = NULL;
		$type = 'membership';
		$title = 'Membership';
		$message = 'You have been successfully subscribed to '.$new_subscription->membership->name;
		$devices = UserDevice::where('user_id',$request->user_id)->where('user_type','customer')->get();
		$this->sendNotification($title, $message, $devices, $type, $id);

		Mail::to($user->email)->send(new CustomerSubscriptionMail($user, $old_subscription, $new_subscription));

		$success['user'] = array(
        	'user_id' => $user->id,
			'stripe_customer_id' => $user->stripe_customer_id,
			'social_id' => $user->social_id,
			'social_type' => $user->social_type,
			'first_name' => $user->first_name,
			'last_name' => $user->last_name,
			'email' => $user->email,
			'dob' => ($user->dob == '' ? null : date("d/m/Y", strtotime($user->dob))),
			'anniversary_date' => ($user->anniversary_date == '' ? null : date("d/m/Y", strtotime($user->anniversary_date))),
			'mobile' => $user->mobile,
			'photo' => ($user->image == Null ? asset('public/images/User-Avatar.png') : asset('public/user_photo/'.$user->image)),
        	'about' => $user->about,
        	'wallet_terms_conditions' => (int)$user->wallet_terms_conditions,
        	'price_drop_alert' => (int)$user->price_drop_alert,
        	'is_join' => (int)$user->is_join,
        	'is_user_guide_completed' => (int)$user->is_user_guide_completed,
        	'subscription' => $new_subscription
        );

		return $this->sendResponse($success,'You have been successfully subscribed.');
	}

	public function cancelSubscription(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'subscription_id' => 'required'
		]);

		if($validator->fails()){

			return $this->sendError($validator->errors()->first());
		}

		$user = User::findOrFail($request->user_id);
		$user_subscription = UserSubscription::findOrFail($request->subscription_id);
		$user_subscription->is_cancelled = 'yes';
		$user_subscription->save();

		$new_subscription = UserSubscription::with(['Membership', 'MembershipItem'])->findOrFail($request->subscription_id);

		$id = NULL;
		$type = 'membership';
		$title = 'Membership';
		$message = 'You have been successfully unsubscribed to '.$new_subscription->membership->name;
		$devices = UserDevice::where('user_id',$new_subscription->user_id)->where('user_type','customer')->get();
		$this->sendNotification($title, $message, $devices, $type, $id);

		$success['user'] = array(
        	'user_id' => $user->id,
			'stripe_customer_id' => $user->stripe_customer_id,
			'social_id' => $user->social_id,
			'social_type' => $user->social_type,
			'first_name' => $user->first_name,
			'last_name' => $user->last_name,
			'email' => $user->email,
			'dob' => ($user->dob == '' ? null : date("d/m/Y", strtotime($user->dob))),
			'anniversary_date' => ($user->anniversary_date == '' ? null : date("d/m/Y", strtotime($user->anniversary_date))),
			'mobile' => $user->mobile,
			'photo' => ($user->image == Null ? asset('public/images/User-Avatar.png') : asset('public/user_photo/'.$user->image)),
        	'about' => $user->about,
        	'wallet_terms_conditions' => (int)$user->wallet_terms_conditions,
        	'price_drop_alert' => (int)$user->price_drop_alert,
        	'is_join' => (int)$user->is_join,
        	'is_user_guide_completed' => (int)$user->is_user_guide_completed,
        	'subscription' => $new_subscription
        );

		return $this->sendResponse($success,'You have been successfully unsubscribed.');
	}

	public function acceptWalletTerm($id)
	{
		$user = User::findOrFail($id);
		$user->wallet_terms_conditions = 1;
		$user->save();

		return $this->sendResponse(null,'You have been successfully accepted terms and conditions.');
	}

	public function changePriceDropAlertStatus(Request $request, $id)
	{
		$user = User::findOrFail($id);
		$user->price_drop_alert = $request->status;
		$user->save();

		return $this->sendResponse(null,'You have been changed the price drop alert status.');
	}

	public function checkPriceDropAlert($id)
	{
		$user = User::findOrFail($id);
		$success['user'] = array(
			'price_drop_alert' => (int)$user->price_drop_alert
		);
		return $this->sendResponse($success,'Check your price drop alert value.');
	}

	public function checkIsJoin($id)
	{
		$user = User::findOrFail($id);
		$success['user'] = array(
			'is_join' => (int)$user->is_join
		);
		return $this->sendResponse($success,'Check you paid fees for join the incentive program.');
	}

	public function userGuideComplete(Request $request, $id)
	{
		$user = User::findOrFail($id);
		$user->is_user_guide_completed = $request->status;
		$user->save();

		return $this->sendResponse(null,'You have been completed the user guide.');
	}

	public function oneTimeCustomerFee($id)
	{
		$joining_fee = 2.95;
		$coins_for_dollar = 5;
		$user = User::findOrFail($id);

		if($user->is_join == 0) {

			if($joining_fee <= $user->wallet_amount) {

				$user->wallet_amount = $user->wallet_amount-$joining_fee;
				$user->is_join = 1;
				$user->joining_expired_date = date("Y-m-d H:i:s", strtotime('+1 year'));
				$user->save();

				$customer_wallet = new CustomerWallet;
				$customer_wallet->customer_id = $user->id;
				$customer_wallet->amount = $joining_fee;
				$customer_wallet->closing_amount = $user->wallet_amount;
				$customer_wallet->type = 'one_time_fees';
				$customer_wallet->save();

				//transaction reward point
				$reward_point = RewardPoint::where('reward_type','transaction')->where('status', 'active')->first();
				if(!empty($reward_point)){

					$reward_point_exchange_rate = $reward_point->reward_point_exchange_rate;
					$coins = $reward_point_exchange_rate * $coins_for_dollar;
					$customer_reward_point = CustomerRewardPoint::where('user_id', $user->id)->where('reward_type','transaction')->first();

					if(!empty($customer_reward_point)){
						$customer_reward_point->total_point = $customer_reward_point->total_point+$coins;
						$customer_reward_point->save();
					}else{
						$customer_point =  new CustomerRewardPoint;
						$customer_point->user_id = $user->id;
						$customer_point->reward_type = 'transaction';
						$customer_point->total_point = $coins;
						$customer_point->save();
					}

					$data = array(
						'user_id' => $user->id,
						'reward_type' => 'transaction',
						'reward_point' => $coins
					);

					CustomerEarnRewardPoint::create($data);
				}

				return $this->sendResponse(null,'You have successfully joined the incentive program.');

			} else {
				$price = (float)number_format($joining_fee-$user->wallet_amount,2);
				$result = array('needed_balance' => (float)number_format(abs($price),2));
				return $this->sendResponse($result,'You have not sufficient balance in your wallet, please add money to complete your joining process.');
			}
		} else {
			return $this->sendError('Your already paid the joining fees.');
		}
	}

	public function getErrandRunner($cid)
	{
		$success['ErrandRunner'] = ErrandRunner::where('customer_id', $cid)->first();
		return $this->sendResponse($success, 'Errand Runner');
	}

	public function saveErrandRunner(Request $request, $cid)
	{
		$validator = Validator::make($request->all(), [
			'status' => 'required'
		]);

		if($validator->fails()){
			return $this->sendError($validator->errors()->first());
		}

		$errandRunner = ErrandRunner::updateOrCreate(
			['customer_id' => $cid],
			['status' => $request->status]
		);

		return $this->sendResponse(null,'You have been saved errand runner.');
	}
}

