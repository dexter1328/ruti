<?php

namespace App\Http\Controllers;

use DB;
use Stripe;
use Carbon\Carbon;
use App\UserDevice;
use App\StoresVendor;
use App\VendorStoreHours;
use App\VendorPaidModule;
use App\Notification;
use App\Mail\CustomerSubscriptionRenewMail;
use App\Mail\CustomerSubscriptionCancelMail;
use App\Mail\CustomerSubscriptionRemiderMail;
use App\Mail\VendorInventoryReminderMail;
// use App\Traits\AppNotification;
use App\Traits\SilentAppNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class TestController extends Controller
{
    use SilentAppNotification;

	private $stripe_secret;

	public function __construct()
	{
		$this->stripe_secret = config('services.stripe.secret');
	}

	public function PriceDropNotification()
	{
		$notifications = Notification::with('userWishlist')->get();

        if($notifications->isNotEmpty()){
            
            foreach ($notifications as $key => $notification) {

            	$id = $notification->reference_id;
                $type = $notification->type;
                $title = $notification->title;
                $message = $notification->description;
            	foreach ($notification->userWishlist as $key => $user_wishlist) {
            	
            		$devices = DB::table('user_devices')->where('user_id', $user_wishlist->user_id)->where('user_type', 'customer')->get();
	                $this->sendNotification($title, $message, $devices, $type, $id);	
            	}
                
                // DB::table('notifications')->where('id', $notifications->id)->delete();
            }
        }
        exit();
	}

	public function vendorInventoryReminder()
	{
		$day = date('l');
		$time = date('H:i');
		$date = date('Y-m-d', strtotime('-7 days'));
		$users = DB::table('vendors')
			->select(
				'vendors.id',
				'vendors.name',
				'vendors.email',
				'stores_vendors.store_id',
				'vendor_stores.name as store_name'
			)
			->join('vendor_roles', 'vendor_roles.id', 'vendors.role_id')
			->join('stores_vendors', 'stores_vendors.vendor_id', 'vendors.id')
			->join('vendor_stores', 'vendor_stores.id', 'stores_vendors.store_id')
			->join('vendor_settings as setting_day', 'setting_day.vendor_id', 'vendors.parent_id')
			->join('vendor_settings as setting_time', 'setting_time.vendor_id', 'vendors.parent_id')
			->join('products', 'products.store_id', 'stores_vendors.store_id')
			->where(function ($query) {
                $query->where('vendor_roles.slug', 'store-manager')
                      ->orWhere('vendor_roles.slug', 'store-supervisor');
            })
            ->where('setting_day.key', 'inventory_update_reminder_day')
            ->where('setting_day.value', $day)
            ->whereDate('products.updated_at', '<', $date)
			->groupBy('stores_vendors.store_id')
			->get();
		
		echo '<pre>';print_r($users);exit();

		//$user_ids = [];
		foreach ($users as $key => $value) {

			//$user_ids[] = $value->id;
			Mail::to($value->email)->send(new VendorInventoryReminderMail($value));
			// $id = null;
			// $type = 'inventory_update_reminder';
			// $title = 'Inventory Update Reminder';
			// $message = 'It is time to update inventory. Please follow the steps to complete the process.';
			// $devices = DB::table('user_devices')->whereIn('user_id', $value->id)->where('user_type','vendor')->get();
			// if($devices->isNotEmpty()){
			// 	$this->sendVendorNotification($title, $message, $devices, $type, $id);
			// }
		}

		// $id = null;
		// $type = 'inventory_update_reminder';
		// $title = 'Inventory Update Reminder';
		// $message = 'It is time to update inventory. Please follow the steps to complete the process.';
		// $devices = DB::table('user_devices')->whereIn('user_id', $user_ids)->where('user_type','vendor')->get();
		// if($devices->isNotEmpty()){
		// 	$this->sendNotification($title, $message, $devices, $type, $id);
		// }
	}

	public function maintainCustomerWalletAmount()
	{
		$min_amount = 25;
		$users = DB::table('users')
			->whereNotNull('stripe_customer_id')
			->where('wallet_amount', '<', $min_amount)
			->get();

		foreach ($users as $key => $value) {
			
			$price = $min_amount - $value->wallet_amount;

			Stripe\Stripe::setApiKey($this->stripe_secret);
			try {

				$charge = Stripe\Charge::create ([
					"amount" => $price * 100,
					"currency" => "usd",
					"customer" => $value->stripe_customer_id,
					// "source" => $value->card_id,
					"description" => "Money automatically added in your wallet due to low balance." 
				]);

				if(empty($value->wallet_amount)){
					$closing_amount = $price;
				}else{
					$closing_amount = $value->wallet_amount + $price;
				}

				DB::table('customer_wallets')->insert([
					'customer_id' => $value->user_id, 
					'amount' => $price,
					'closing_amount' => $closing_amount,
					'type' => 'credit'
				]);
				DB::table('users')->where('id', $value->user_id)->update(['wallet_amount' => $closing_amount, 'updated_at' => now()]);

			} catch (Exception $e) {}
		}
	}

	public function customerIncentiveWinners()
	{
		$limit = 1;
		$date = date('m-Y', strtotime('-1 month'));

		$exist_customers = DB::table('customer_incentive_winners')
			->whereDate('created_at', '>', date("d-m-Y", strtotime('-5 years')))
			->get()
			->pluck('user_id')
			->toArray();

		for ($i=1; $i < 4; $i++) { 

			if($i == 1){
				$code = 'bougie';
				$sub_type1 = 'college_scholarship';
				$sub_type2 = 'europe_trip';
				$sub_type3 = 'caribbean_trip';
			}elseif($i == 2){
				$code = 'classic';
				$sub_type1 = 'stay_in_hotel';
				$sub_type2 = 'adventure_park';
				$sub_type3 = 'theme_park';
			}elseif($i == 3){
				$code = 'explorer';
				$sub_type1 = 'gift_card';
				$sub_type2 = 'laptop';
				$sub_type3 = 'tablet';
			}
		
			$inserted_ids = [];
			$subtype1_customers = DB::table('customer_incentive_qualifiers')
				->where('membership_code', $code)
				->where('month_year', $date)
				->whereNotIn('user_id', $exist_customers)
				->orderBy(DB::raw('RAND()'))
				->take($limit)
				->get();

			$subtype1_data = [];
			foreach ($subtype1_customers as $key => $value) {
				$subtype1_data[] = array(
					'user_id' => $value->user_id, 
					'month_year' => date('m-Y', strtotime('-1 month')),
					'membership_code' => $value->membership_code,
					'type' => $value->type,
					'sub_type' => $sub_type1,
					'created_at' => now(),
					'updated_at' => now()
				);
			}
			if(!empty($subtype1_data)){
				$inserted_ids = $subtype1_customers->pluck('id')->toArray();
				DB::table('customer_incentive_winners')->insert($subtype1_data);
			}

			$subtype2_customers = DB::table('customer_incentive_qualifiers')
				->where('membership_code', $code)
				->where('month_year', $date)
				->whereNotIn('user_id', $exist_customers)
				->whereNotIn('id', $inserted_ids)
				->orderBy(DB::raw('RAND()'))
				->take($limit)
				->get();

			$subtype2_data = [];
			foreach ($subtype2_customers as $key => $value) {
				$subtype2_data[] = array(
					'user_id' => $value->user_id, 
					'month_year' => date('m-Y', strtotime('-1 month')),
					'membership_code' => $value->membership_code,
					'type' => $value->type,
					'sub_type' => $sub_type2,
					'created_at' => now(),
					'updated_at' => now()
				);
			}
			if(!empty($subtype2_data)){
				$inserted_ids = array_merge($inserted_ids, $subtype2_customers->pluck('id')->toArray());
				DB::table('customer_incentive_winners')->insert($subtype2_data);
			}

			$subtype3_customers = DB::table('customer_incentive_qualifiers')
				->where('membership_code', $code)
				->where('month_year', $date)
				->whereNotIn('user_id', $exist_customers)
				->whereNotIn('id', $inserted_ids)
				->orderBy(DB::raw('RAND()'))
				->take($limit)
				->get();

			$subtype3_data = [];
			foreach ($subtype3_customers as $key => $value) {
				$subtype3_data[] = array(
					'user_id' => $value->user_id, 
					'month_year' => date('m-Y', strtotime('-1 month')),
					'membership_code' => $value->membership_code,
					'type' => $value->type,
					'sub_type' => $sub_type3,
					'created_at' => now(),
					'updated_at' => now()
				);
			}
			if(!empty($subtype3_data)){
				DB::table('customer_incentive_winners')->insert($subtype3_data);
			}
		}        
	}

	public function customerIncentiveQalifiers()
	{
		$date = date('m-Y', strtotime('-1 month'));
		$date_arr = explode('-', $date);
		$month = $date_arr[0];
		$year = $date_arr[1];

		for ($i=1; $i < 4; $i++) { 

			if($i == 1){
				$code = 'bougie';
				$price = 150;
			}elseif($i == 2){
				$code = 'classic';
				$price = 100;
			}elseif($i == 3){
				$code = 'explorer';
				$price = 100;
			}
		
			$tier_customers = DB::table('users')
				->select(
					'users.*',
					'memberships.code',
					'memberships.name',
					DB::raw('COUNT(orders.id) as order_count')
				)
				->join('user_subscriptions', 'user_subscriptions.user_id', 'users.id')
				->join('memberships', 'memberships.id', 'user_subscriptions.membership_id')
				->join('orders', 'orders.customer_id', 'users.id')
				->where('memberships.code', $code)
				->where('orders.total_price', '>=', $price)
				->where('orders.order_status', 'completed')
				->whereMonth('orders.created_at', $month)
				->whereYear('orders.created_at', $year)
				->having('order_count', '>=', 2)
				->get();


			$tier_data = [];
			foreach ($tier_customers as $key => $value) {
				$tier_data[] = array(
					'user_id' => $value->id, 
					'month_year' => date('m-Y', strtotime('-1 month')),
					'membership_code' => $code,
					'type' => 'tier_'.$i,
					'created_at' => now(),
					'updated_at' => now()
				);
			}
			if(!empty($tier_data)){
				DB::table('customer_incentive_qualifiers')->insert($tier_data);
			}
		}
	}

	public function cancelCustomerSubscription()
	{
		$expired_date = date('Y-m-d');
		$users = DB::table('user_subscriptions')
			->select(
				'users.email',
				'users.first_name',
				'users.last_name',
				'memberships.name AS membership_name',
				'membership_items.billing_period',
			)
			->join('users', 'users.id', 'user_subscriptions.user_id')
			->join('memberships', 'memberships.id', 'user_subscriptions.membership_id')
			->join('membership_items', 'membership_items.id', 'user_subscriptions.membership_item_id')
			->whereNotNull('membership_item_id')
			->whereDate('user_subscriptions.membership_end_date', '<' , $expired_date)
			->get();

		// echo '<pre>';
		// print_r($users->toArray());
		// exit();
		foreach ($users as $key => $value) {

			$update_data = array(
				'membership_id' => 1,
				'membership_item_id' => NULL,
				'membership_start_date' => NULL,
				'membership_end_date' => NULL,
				'price' => NULL,
				'proration_price' => NULL,
				'renew_period' => NULL,
				'is_cancelled' => 'no',
				'updated_at' => now()
			);
			DB::table('user_subscriptions')->where('id', $value->id)->update($update_data);

			Mail::to($value->email)->send(new CustomerSubscriptionCancelMail($value));
		}

		die('cancel customer subscription');
	}

	public function renewCustomerSubscription($days = null)
	{
		$renew_date = (!empty($days) ? date('Y-m-d', strtotime('+'.$days.' days')) : date('Y-m-d'));
		
		$users = DB::table('user_subscriptions')
			->select(
				'user_subscriptions.*',
				'users.email',
				'users.first_name',
				'users.last_name',
				'users.wallet_amount',
				'users.stripe_customer_id',
				'memberships.code',
				'memberships.name AS membership_name',
				'membership_items.billing_period',
				'membership_items.price AS membership_price'
			)
			->join('users', 'users.id', 'user_subscriptions.user_id')
			->join('memberships', 'memberships.id', 'user_subscriptions.membership_id')
			->join('membership_items', 'membership_items.id', 'user_subscriptions.membership_item_id')
			->whereNotNull('user_subscriptions.membership_item_id')
			->whereDate('user_subscriptions.membership_end_date', $renew_date)
			->where('user_subscriptions.status', 'active')
			->where('user_subscriptions.is_cancelled', 'no')
			->get();

		echo '<pre>';
		print_r($users->toArray());
		exit();
		foreach ($users as $key => $value) {
			
			$price = $value->price;
			if($value->code == 'bougie' && empty($value->price)) {
				$price = $value->proration_price;
			}

			$renew = 'yes';
			if($price > $value->wallet_amount) {

				Stripe\Stripe::setApiKey($this->stripe_secret);
				try {

					$charge = Stripe\Charge::create ([
		                "amount" => $price * 100,
		                "currency" => "usd",
		                "customer" => $value->stripe_customer_id,
		               	// "source" => $value->card_id,
		                "description" => "Money added in your wallet." 
	        		]);

					if(empty($value->wallet_amount)){
						$closing_amount = $price;
					}else{
						$closing_amount = $value->wallet_amount + $price;
	        		}

					DB::table('customer_wallets')->insert([
						'customer_id' => $value->user_id, 
						'amount' => $price,
						'closing_amount' => $closing_amount,
						'type' => 'credit'
					]);
					DB::table('users')->where('id', $value->user_id)->update(['wallet_amount' => $closing_amount, 'updated_at' => Carbon::now()]);

				} catch (Exception $e) {

					$renew = 'no';
					if(!empty($days)) {
						Mail::to($value->email)->send(new CustomerSubscriptionRemiderMail($value, $days));
					}
				}
			}

			if($renew == 'yes') {

				$closing_amount = $value->wallet_amount-$price;
				DB::table('customer_wallets')->insert([
					'customer_id' => $value->user_id, 
					'amount' => $price,
					'closing_amount' => $closing_amount,
					'type' => 'subscription_charge'
				]);
				DB::table('users')->where('id', $value->user_id)->update(['wallet_amount' => $closing_amount, 'updated_at' => Carbon::now()]);

				$membership_start_date = $value->membership_end_date;
				$membership_end_date = date('Y-m-d H:i:s', strtotime('+1 '.$value->renew_period, strtotime($membership_start_date)));
				$update_data = array(
					'membership_start_date' => $membership_start_date,
					'membership_end_date' => $membership_end_date, 
					'updated_at' => Carbon::now()
				);
				if($value->code == 'bougie' && empty($value->price)) {
					$update_data['price'] = $price;
					$update_data['proration_price'] = NULL;
				}

				DB::table('user_subscriptions')->where('id', $value->id)->update($update_data);

				Mail::to($value->email)->send(new CustomerSubscriptionRenewMail($value));
			}
		}

		die('renew customer subscription');
	}

	public function StoreHourCron($id)
	{
		$store_vendor = StoresVendor::where('vendor_id',$id)->first();
        if(!empty($store_vendor))
        {
            date('w'); //gets day of week as number(0=sunday,1=monday...,6=sat)

            if(date('w') == 1){
                $day = 'monday';
            }else if(date('w') == 2){
                $day = 'tuesday';
            }else if(date('w') == 3){
                $day = 'wednesday';
            }else if(date('w') == 4){
                $day = 'thursday';
            }else if(date('w') == 5){
                $day = 'friday';
            }else if(date('w') == 6){
                $day = 'saturday';
            }else if(date('w') == 7){
                $day = 'sunday';
            }
        
            $current_date = date("H:i");

            $vendor_store_hours = VendorStoreHours::where('week_day',$day)
                        ->where('store_id',$store_vendor->store_id)
                        ->whereRaw('TIME(daystart_time) <= "'.$current_date.'"')
                        ->whereRaw('TIME(dayend_time) >= "'.$current_date.'"')
                        ->first();

            if(!empty($vendor_store_hours))
            {
            	//vendor notification
			    $id = $id;
				$type = 'SCHEDULE';
			    $title = 'Login';
			    $message = 'Success Login';
			    $devices = UserDevice::where('user_id',$id)->where('user_type','vendor')->get();
			    $this->sendSilentVendorNotification($title, $message, $devices, $type, $id);
                //notofication suuccess login
            }else{
            	//vendor notification
			    $id = $id;
				$type = 'SCHEDULE';
			    $title = 'Login';
			    $message = 'Not Able to login';
			    $devices = UserDevice::where('user_id',$id)->where('user_type','vendor')->get();
			    $this->sendSilentVendorNotification($title, $message, $devices, $type, $id);
                // login in store time
            }
        }else{
        	//vendor notification
		    $id = $id;
			$type = 'SCHEDULE';
		    $title = 'Login';
		    $message = 'No Store assign to you';
		    $devices = UserDevice::where('user_id',$id)->where('user_type','vendor')->get();
		    $this->sendSilentVendorNotification($title, $message, $devices, $type, $id);
            // you can not assign the store
        }
	}

	public function PaidModuleChangeStatusCron()
	{
		$date = date('m/d/Y');
		$paid_module = VendorPaidModule::where('start_date','<',$date)->where('end_date','>',$date)->update(array('status'=>'no'));
	}
}
