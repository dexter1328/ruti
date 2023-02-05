<?php

namespace App\Http\Controllers\API;

use DB;
use Carbon\Carbon;
use Stripe;
use Session;
use Validator;
use Response;
use App\User;
use App\Setting;
use App\VendorStore;
use App\Products;
use App\Category;
use App\ProductImages;
use App\Banner;
use App\ProductVariants;
use App\AttributeValue;
use App\ProductReview;
use App\Admin;
use App\Brand;
use App\UserWishlist;
use App\Orders;
use App\OrderItems;
use App\CancelledOrders;
use App\CustomerWallet;
use App\CustomerWalletInward;
use App\CustomerWalletOutward;
use App\VendorCoupons;
use App\SuggestedPlace;
use App\UserNotification;
use App\VendorCouponsUsed;
use App\CustomerInvite;
use App\RewardPoint;
use App\CustomerRewardPoint;
use App\CustomerRewardUsed;
use App\UserDevice;
use App\OrderReason;
use App\ActiveUser;
use App\CustomerEarnRewardPoint;
use App\UserCoupon;
use App\UserSubscription;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Traits\AppNotification;
use App\Mail\OrderReturnMail;
use App\Mail\lowstockVendorMail;
use App\Mail\OrderReturnVendorMail;
use App\Mail\OrderSuccessVendorMail;
use App\Mail\OrderSuccessMail;
use App\Mail\OrderCancelVendorMail;
use App\Mail\OrderCancelMail;
use App\UserCart;
use App\Vendor;
use App\Http\Controllers\API\BaseController as BaseController;

class OrderController extends BaseController
{
	use AppNotification;

	// private $stripe_secret = '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';
	// private $stripe_secret = 'sk_test_Tl9CUopVg1Pjb9iYt7WS4Nye003cV0vCK6';
	private $stripe_secret;

	public function __construct()
	{
		$this->stripe_secret = config('services.stripe.secret');
	}

	public function Checkout(Request $request)
	{	

		$request_data = $request->all();
		$image = [];
		$validate = true; 
		$total_price = 0;
		$items_total= 0;
		$total_tax = 0;
		foreach ($request_data['products'] as $key => $value) {

			$product = ProductVariants::select('product_variants.*')->where('id',$value['id'])->first();
			$product_price = $product->price;
			
			if($product->discount !=Null && $product->discount > 0){
				$discount = $product->price*$product->discount/100;
				$product_price = $product_price - $discount;
				// print_r($discount);
			}
			$product_total_price = $product_price *(int)$value['quantity'];
			$items_total += $product_total_price;
			$product_price = $product_total_price;
		
			$tax_price = 0;
			$product_tax = Products::where('id', $product->product_id)->first();
			if($product_tax->tax!=Null && $product_tax->tax > 0){
				// $tax_price = $product_total_price*$product_tax->tax/100;
				$tax_price = $product_total_price*$product_tax->tax/100;
				$product_price = $product_price+$tax_price;
			}
				
			$total_tax += $tax_price;
			// print_r($tax_price);print_r($total_tax);
			if($value['quantity'] > $product->quantity){
				$validate = false;
				$out_stock_product[] = $product->id;
			}
		}

		$coupan_code = [];
		$coupan_price = 0;
		if($request->has('coupan_id') && $request_data['coupan_id']!=''){
			$coupan_code = VendorCoupons::where('id', $request_data['coupan_id'])->first();
			$coupan_price =$items_total*$coupan_code->discount/100;
			$coupon = array('id' => $coupan_code->id,
						'coupon_code' => $coupan_code->coupon_code,
						'image' => ($coupan_code->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/vendors_coupan/'.$coupan_code->image)),
						'title' => $coupan_code->discount.' % off',
						'discount' => $coupan_code->discount,
						'description' => $coupan_code->description,
						'start_date' => 1000 * strtotime($coupan_code->start_date),
						'end_date' => 1000 * strtotime($coupan_code->end_date)
					);
		}else{
			$coupon = [];
		}

		$total_price = $items_total + $total_tax - $coupan_price;
		
		
		if($validate)
		{
	        $wallet = User::where('id',$request_data['customer_id'])->first();
	       
	        //if(!empty($wallet->wallet_amount)){

	        	/*if($total_price > $wallet->wallet_amount)
				{
					$price = (float)number_format($total_price,2)-$wallet->wallet_amount;
					echo $total_price.'total'; echo $wallet->wallet_amount.'wallet'; exit();
					$result = array('order' => null,'needed_balance' =>(float)number_format(abs($price),2));
					return $this->sendResponse($result,'You have not sufficient balance in your wallet, please add money to complete your order.');

				}else{*/
					
					// echo 'out'.$total_price;
		        	//transaction reward point
			        if($request_data['used_reward_point'] == 'yes'){

			        	// total price = total price minus reward percentage eg. 225 - 5% = 11.25
			        	// total price = 225 - 11.25 = 213.75
			        	// minus 11.25 gems or coin from the database

			        	$setting = Setting::where('key','reward_point_max_per_order')->first();
			        	$max_reward_price = (float)number_format($total_price * $setting->value/100,2);
			        			
						$gem_points = CustomerRewardPoint::where('reward_type','invite')->where('user_id', $request_data['customer_id'])->first();
						$gem_setting = RewardPoint::where('reward_type','invite')->first();
						

						$coin_points = CustomerRewardPoint::where('reward_type','transaction')->where('user_id', $request_data['customer_id'])->first();
						//print_r($coin_points);die();
						$coin_setting = RewardPoint::where('reward_type','transaction')->first();

						// echo 'in'.$total_price;die();

			        	if(!empty($gem_points) || !empty($coin_points)){

			        		$gem_glitch_price = 0;
			        		$coin_glitch_price = 0;

			        		$gem_reward_price = 0;
			        		if(!empty($gem_points)){
			        			$gem_reward_price = $gem_points->total_point/$gem_setting->reward_point_exchange_rate;
			        		}

			        		$coin_reward_price = 0;
			        		if(!empty($coin_points)){
			        			$coin_reward_price = $coin_points->total_point/$coin_setting->reward_point_exchange_rate;
			        		}

				        	if($gem_reward_price >= $max_reward_price){
				        		
				        		$total_price = (float)number_format($total_price-$max_reward_price,2);
				        		$invite_reward_points = $max_reward_price*$gem_setting->reward_point_exchange_rate;
				        		if(strpos($invite_reward_points,".")!==false){
									$invite_glitch_array = explode('.', $invite_reward_points);
									$invite_reward_points = $invite_glitch_array[0];
									$gem_glitch_point = '0.'.$invite_glitch_array[1];
									$gem_glitch_price = (float)$gem_glitch_point/$gem_setting->reward_point_exchange_rate;
								}
				        		$reward_points = $invite_reward_points;
				        	}else{
				        		
				        		$total_reward_price = $gem_reward_price+$coin_reward_price;
				        		$invite_reward_points = $gem_reward_price*$gem_setting->reward_point_exchange_rate;
				        		if(strpos($invite_reward_points,".")!==false){
									$invite_glitch_array = explode('.', $invite_reward_points);
									$invite_reward_points = $invite_glitch_array[0];
									$gem_glitch_point = '0.'.$invite_glitch_array[1];
									$gem_glitch_price = (float)$gem_glitch_point/$gem_setting->reward_point_exchange_rate;
								}

				        		if($total_reward_price >= $max_reward_price){
				        			$total_price = (float)number_format($total_price-$max_reward_price,2);
				        			$coin_reward_price = $max_reward_price - $gem_reward_price;
				        			$transaction_reward_point = $coin_reward_price*$coin_setting->reward_point_exchange_rate;
				        			if(strpos($transaction_reward_point,".")!==false){
										$transaction_glitch_array = explode('.', $transaction_reward_point);
										$transaction_reward_point = $transaction_glitch_array[0];
										$coin_glitch_point = '0.'.$transaction_glitch_array[1];
										$coin_glitch_price = (float)$coin_glitch_point/$coin_setting->reward_point_exchange_rate;
									}
				        			$reward_points = $invite_reward_points + $transaction_reward_point;
				        		}else{
				        			$total_price = (float)number_format($total_price-$total_reward_price,2);
				        			$transaction_reward_point = $coin_reward_price*$coin_setting->reward_point_exchange_rate;
				        			if(strpos($transaction_reward_point,".")!==false){
										$transaction_glitch_array = explode('.', $transaction_reward_point);
										$transaction_reward_point = $transaction_glitch_array[0];
										$coin_glitch_point = '0.'.$transaction_glitch_array[1];
										$coin_glitch_price = (float)$coin_glitch_point/$coin_setting->reward_point_exchange_rate;
									}
				        			$reward_points = $invite_reward_points + $transaction_reward_point;
				        		}

				        		/*if(!empty($coin_points)){
				        			// update transaction reward point
				        			$coin_points->total_point = $coin_points->total_point - $transaction_reward_point;
				        			
				        			$coin_points->save();
				        			$coin_reward_points = $transaction_reward_point;
				        		}else{
				        			$coin_reward_points = 0;
				        		}*/
				        	}

				        	if($gem_glitch_price != 0 || $coin_glitch_price != 0 ){
								$total_glitch_price = $gem_glitch_price + $coin_glitch_price;
								$total_price = (float)number_format($total_price+$total_glitch_price,2);
							}
							
							//  check wallet condition
							if($total_price > $wallet->wallet_amount)
							{ 

								$price = (float)number_format($total_price-$wallet->wallet_amount,2);
								//echo $total_price.'total'; echo $wallet->wallet_amount.'wallet'; exit();
								$result = array('order' => null,'needed_balance' =>(float)number_format(abs($price),2));
								//print_r($result); exit();
								return $this->sendResponse($result,'You have not sufficient balance in your wallet, please add money to complete your order.');

							}

							// update transaction reward points
							if(!empty($coin_points) &&  isset($transaction_reward_point)){
			        			// update transaction reward point
			        			$coin_points->total_point = $coin_points->total_point - $transaction_reward_point;
			        			
			        			$coin_points->save();
			        			$coin_reward_points = $transaction_reward_point;
			        		}else{
			        			$coin_reward_points = 0;
			        		}

				        	// update invite reward points
				        	if(!empty($gem_points)){
				        		$gem_points->total_point = $gem_points->total_point-$invite_reward_points;
				        		$gem_points->save();
				        		$gems_reward_points = $invite_reward_points;
				        	}else{
				        		$gems_reward_points=0;
				        	}

				        }
			        }else{
			        	//echo'in';exit();
			        	if(number_format($total_price,2) > $wallet->wallet_amount)
						{
							$price = (float)number_format($total_price-$wallet->wallet_amount,2);
							// echo $total_price.'total'; echo $wallet->wallet_amount.'wallet'; exit();
							$result = array('order' => null,'needed_balance' =>(float)number_format(abs($price),2));
							return $this->sendResponse($result,'You have not sufficient balance in your wallet, please add money to complete your order.');

						}
			        }

			        User::where('id',$request_data['customer_id'])
		        		->update(array('wallet_amount'=>$wallet->wallet_amount-$total_price));
		        	/*if($request_data['used_reward_point'] == 'yes'){
		        		$coin = Setting::where('key','reward_coins_exchagne_rate')->first();
		        		$gems = Setting::where('key','reward_gems_exchagne_rate')->first();
		        		$coin_convert = number_format($coin_reward_points,2)*$coin->value/100;
		        		$gems_convert= number_format($gems_reward_points,2)*$gems->value/100;
		        		$convert = number_format($coin_convert,2)+number_format($gems_convert,2);
		        		
		        		$total_price = number_format($total_price,2)-number_format($convert,2);
		        		// echo $total_price;die();
		        		
		        	}else{
		        		$total_price = $total_price;
		        	}*/
		        	/*echo $total_price;echo'<br>';
		        	echo $items_total;echo'<br>';
		        	echo $total_tax;echo'<br>';die();*/
		        	// echo $total_price;die();

		        	$store_limit = VendorStore::where('id',$request_data['store_id'])->first();

		        	$orders = new Orders;
			        $orders->customer_id = $request_data['customer_id'];
			        $orders->vendor_id = $product_tax->vendor_id;
			        $orders->store_id = $request_data['store_id'];
			        $orders->order_no = strtoupper(uniqid());
			        $orders->type = $request_data['type'];
			        $orders->pickup_time = date("H:i:s", strtotime("+30 minutes"));
			        $orders->pickup_date = date('Y-m-d');
			        $orders->total_price = $total_price;
			        $orders->item_total = $items_total;
			        $orders->promo_code = $coupan_price;
			        $orders->tax = $total_tax;
			        if($request->has('coupan_id')){
			        	$orders->coupan_id  = $request_data['coupan_id'];
			        }
			        if($request_data['type'] == 'pickup'){
			        	$orders->order_status = 'pending';
			        }else{
			        	$orders->order_status = 'pending';
			        	$orders->completed_date = date('Y-m-d');
			        }	
			       
			        $orders->save();
			        // invite reward point
			   //      	$user_invite = CustomerInvite::where('customer_id',$request_data['customer_id'])
						//             ->first();
						// $reward_point = RewardPoint::where('reward_type','invite')->where('status', 'active')->first();
						// if(!empty($reward_point))
						// {
						// 	$customer_reward_point = CustomerRewardPoint::where('user_id',$user_invite->invite_by_id)->where('reward_type','invite')->first();

						// 	if(!empty($customer_reward_point)){
						// 		$customer_reward_point->total_point = $customer_reward_point->total_point+$reward_point->reward_points;
						// 		$customer_reward_point->save();
						// 	}else{
						// 		$customer_point =  new CustomerRewardPoint;
						// 		$customer_point->user_id = $user_invite->invite_by_id;
						// 		$customer_point->reward_type = 'invite';
						// 		$customer_point->total_point = $reward_point->reward_points;
						// 		$customer_point->save();
						// 	}
						// }

						// $data = array(
						// 	'user_id' => $user_invite->invite_by_id,
						// 	'reward_type'=>'invite',
						// 	'reward_point'=>$reward_point->reward_points
						// );

						// CustomerEarnRewardPoint::create($data);

			        // end invite reward point

			        $user_balance = User::where('id',$request_data['customer_id'])->first();

			        if($user_balance->wallet_amount <= 25)
			        {
						$id = NULL;
						$type = 'wallet_low_balance';
					    $title = 'Wallet Balance Required';
					    $message = '$25 minimum is required in wallet at any time for transaction';
					    $devices = UserDevice::where('user_id',$user_balance->id)->where('user_type','customer')->get();
					    $this->sendNotification($title, $message, $devices, $type, $id);
			        }

			        if($request_data['used_reward_point'] == 'yes'){

			        	$used_point = new CustomerRewardUsed;
		        		$used_point->user_id = $request_data['customer_id'];
		        		$used_point->order_id = $orders->id;
		        		$used_point->reward_point = $reward_points;
		        		$used_point->gems_point = $gems_reward_points;
		        		$used_point->coin_point = $coin_reward_points;
		        		$used_point->save();
			        }

			         //customer notification
					$id = $orders->id;
					$type = 'order';
				    $title = 'Order';
				    $message = 'Your order - '.$orders->order_no.' has been placed successfully.';
				    $devices = UserDevice::where('user_id',$orders->customer_id)->where('user_type','customer')->get();
				    $this->sendNotification($title, $message, $devices, $type, $id);

				    //vendor notification
				    $id = $orders->id;
					$type = 'order';
				    $title = 'Order';
				    $message = 'You have received a new order - '.$orders->order_no;
				    $devices = UserDevice::where('user_id',$orders->vendor_id)->where('user_type','vendor')->get();
				    $this->sendVendorNotification($title, $message, $devices, $type, $id);

			        $customer_wallet = new CustomerWallet;
			        $customer_wallet->customer_id = $orders->customer_id;
			        $customer_wallet->store_id = $orders->store_id;
			        $customer_wallet->order_id = $orders->id;
			        $customer_wallet->amount = $orders->total_price;
			        $customer_wallet->closing_amount = $wallet->wallet_amount-$total_price;
			        $customer_wallet->type = 'debit';
			        $customer_wallet->save();

			        // print_r($request_data['products']);
			        foreach ($request_data['products'] as $key => $value) {
			        	// print_r('in');
			        	// print_r($value['id']);
			        	$product = ProductVariants::join('products','products.id','=','product_variants.product_id')
			        				->select('product_variants.quantity',
			        						'product_variants.id',
			        						'product_variants.price',
			        						'product_variants.discount',
			        						'product_variants.lowstock_threshold',
			        						'products.title',
			        						'products.vendor_id'
			        					)
			        				->where('product_variants.id',$value['id'])
			        				->first();

			        	$discount_price = $product->price*$product->discount/100;
			        	$discounted_price = $product->price - $discount_price;
			        
			        	$product_images = ProductImages::where('variant_id',$product->id)->get();
			        	foreach ($product_images as $product_image) {
							$image[] = asset('public/images/product_images/'.$product_image->image);
						}

			        	$orders_item = new OrderItems;
			        	$orders_item->order_id = $orders->id;
			        	$orders_item->product_variant_id = $value['id'];
			        	$orders_item->customer_id = $request_data['customer_id'];
			        	$orders_item->quantity = $value['quantity'];
			        	$orders_item->price = $discounted_price;
			        	$orders_item->actual_price = $product->price;
			        	$orders_item->discount = $product->discount;
			        	$orders_item->save();

			        	//lowstock threshold
			        	$threshold_quanity = $product->quantity-$value['quantity'];
			        	if($threshold_quanity <= $product->lowstock_threshold){

			        		ProductVariants::where('id',$product->id)->update(array('quantity' => $threshold_quanity));
			        		//vendor notification
				    		$id = $orders->id;
							$type = 'lowstock_threshold';
						    $title = 'Product Low stock';
						    $message = $product->title.'stock has gone below the threshold';
						    $devices = UserDevice::where('user_id',$product->vendor_id)->where('user_type','vendor')->get();
						    $this->sendVendorNotification($title, $message, $devices, $type, $id);
			        	}

			        	//end of lowstock threshold
						
			        	$products[] = array('id' => $orders_item->product_variant_id,
							'title' => $product->title,
							'price' => (float)$orders_item->price,
							'quantity' => $orders_item->quantity,
							'images' => $image
						);
			        }
					if($orders->type == 'pickup')
					{
						$pickup = 1000 * strtotime($orders->pickup_date.' '.$orders->pickup_time);
					}else{
						$pickup = null;
					}
					$vendor_store = VendorStore::where('id',$product_tax->store_id)->first();
					// print_r($order_item->store);die();
					$store = array('store_id' => $vendor_store['id'],
								'name' => $vendor_store['name'],
								'branch_admin' => $vendor_store['branch_admin'],
								'phone_number' => $vendor_store['phone_number'],
								'email' => $vendor_store['email'],
								'current_status' => $vendor_store['open_status'],
								'image' => ($vendor_store['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$vendor_store['image']))
							);
					$success = array('order_id' => $orders->id,
									'order_no' => $orders->order_no,
									'status' => $orders->order_status,	
									'placed_on' => 1000 * strtotime($orders->created_at),
									'type' => $orders->type,
									'pickup_date_time' => $pickup,
									'items_total'=>$orders->item_total,
									'promo_code' => $orders->promo_code,
									'tax'=> $orders->tax,
									'grand_total' => $orders->total_price,
									'coupan_code' => $coupon,
									'product' => $products,
									'store' => $store
								);

					// used coupon
					if($request->coupan_id){
						$used_coupon = new VendorCouponsUsed;
						$used_coupon->coupon_id = $orders->coupan_id;
						$used_coupon->order_id = $orders->id;
						$used_coupon->user_id = $orders->customer_id;
						$used_coupon->save();
		        		// $orders->coupan_id  = $request_data['coupan_id'];
		        	}
					// 
					$result = array('order' => $success,'needed_balance' =>0.0);
					
					$subscription = UserSubscription::with(['Membership'])->where('user_subscriptions.user_id', $request_data['customer_id'])->first();
					if($subscription->membership->code != 'explorer') {

						//transaction reward point
						$reward_point = RewardPoint::where('reward_type','transaction')->where('status', 'active')->first();
						if(!empty($reward_point)){

				            $customer_reward_point = CustomerRewardPoint::where('user_id',$request_data['customer_id'])->where('reward_type','transaction')->first();

				            if(!empty($customer_reward_point)){
				            	$customer_reward_point->total_point = $customer_reward_point->total_point+$reward_point->reward_points;
				            	$customer_reward_point->save();
				            }else{
				        	 	$customer_point =  new CustomerRewardPoint;
				        	 	$customer_point->user_id = $request_data['customer_id'];
				        	 	$customer_point->reward_type = 'transaction';
				        	 	$customer_point->total_point = $reward_point->reward_points;
				        	 	$customer_point->save();
				            }

				            $data = array(
				            	'user_id' => $request_data['customer_id'],
				                'reward_type'=>'transaction',
				                'reward_point'=>$reward_point->reward_points
				            );

				            CustomerEarnRewardPoint::create($data);
				        }
			        }
			        
			        // update user active
					ActiveUser::where('user_id',$request_data['customer_id'])->where('store_id',$request_data['store_id'])->delete();
			        return $this->sendResponse($result,'Order successfully.');

			       
		        //}
		        
	        /*}else{

	        	$result = array('order' => null,'needed_balance' =>(float)number_format(abs($total_price),2));
	        	return $this->sendResponse($result,'You have not sufficient balance in your wallet, please add money to complete your order.');
	        }*/
		}else{
			return $this->sendError('Your order contains products that are out of stock.',$out_stock_product);
		}
	}

	public function orderList($id)
	{
		$orders = Orders::select('orders.id',
								'orders.order_no',
								'orders.created_at',
								'orders.type',
								'orders.pickup_date',
								'orders.pickup_time',
								'orders.coupan_id',
								'orders.total_price',
								'orders.item_total',
								'orders.promo_code',
								'orders.tax',
								'orders.order_status',
								'vendor_stores.id as store_id',
								'vendor_stores.name',
								'vendor_stores.branch_admin',
								'vendor_stores.phone_number',
								'vendor_stores.email',
								'vendor_stores.open_status',
								'vendor_stores.image'
							)
							->join('vendor_stores','vendor_stores.id','=','orders.store_id')
							->where('orders.customer_id',$id)
							->orderBy('orders.created_at', 'desc')
							->paginate(10);

		if($orders->isNotEmpty())
		{
			$current_page = $orders->currentPage();
			$total_pages  = $orders->lastPage();	

			foreach ($orders as $key => $order) {

				
				$used_reward = CustomerRewardUsed::where('order_id',$order->id)->where('user_id',$id)->first();
				$gem_setting=  RewardPoint::where('reward_type','invite')->first();
				$coin_setting=  RewardPoint::where('reward_type','transaction')->first();
				if(!empty($used_reward)){
					$gem_point = $used_reward->gems_point/$gem_setting->reward_point_exchange_rate;
					$coin_point =$used_reward->coin_point/$coin_setting->reward_point_exchange_rate;
					$point = $gem_point+$coin_point;
				}else{
					$point = null;
				}
				$store = array('store_id' => $order['store_id'],
							'name' => $order['name'],
							'branch_admin' => $order['branch_admin'],
							'phone_number' => $order['phone_number'],
							'email' => $order['email'],
							'current_status' => $order['open_status'],
							'image' => ($order['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$order['image']))
						);

				if($order['type'] == 'pickup')
				{
					$pickup = 1000 * strtotime($order->pickup_date.' '.$order->pickup_time);

				}else{
					
					$pickup = null;
				}

				$coupon = [];

				if($order->coupan_id!='' && $order->coupan_id!=Null){

					$coupon_data = VendorCoupons::where('id',$order->coupan_id)->first();
					$coupon = array('id' => $coupon_data->id,
								'coupon_code' => $coupon_data->coupon_code,
								'image' => ($coupon_data->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/vendors_coupan/'.$coupon_data->image)),
								'title' => $coupon_data->discount.' % off',
								'discount' => $coupon_data->discount,
								'description' => $coupon_data->description,
								'start_date' => 1000 * strtotime($coupon_data->start_date),
								'end_date' => 1000 * strtotime($coupon_data->end_date)
							);
				}

				$data[]= array('order_id' => $order['id'],
							'order_no' => $order['order_no'],
							'placed_on' => 1000 * strtotime($order['created_at']),
							'type' => $order['type'],
							'pickup_date_time' => $pickup ,
							'items_total' => $order['item_total'],
							'promo_code' => $order['promo_code'],
							'tax' => (float)$order['tax'],
							'status' => $order['order_status'],
							'grand_total' => (float)$order['total_price'],
							'store' => $store,
							'coupon' => $coupon,
							'used_reward' => $point
						);
			}

			return $this->sendResponse(array('page'=>$current_page,'totalPage'=>$total_pages,'orders'=>$data),'Data retrieved successfully');
		}else{

			$data = [];
			return $this->sendResponse(array('page'=>1,'totalPage'=>1,'orders'=>$data),'We can\'t find proper data to display');
		}
	}

	public function orderDetail($id)
	{

		/*$date = "2015-11-17";
		$ab = 5;
    	echo date('Y-m-d', strtotime($date. '+ '.$ab.' days'));

    	//echo date('Y-m-d', strtotime($date. ' + 5 days'));
    	die();*/
		/*date('Y-m-d', strtotime($order->completed_date. ' + '+$vendor_store->return_policy+'days'))*/
		$order = Orders::find($id);
		
		if($order == null)
		{
			$success = [];
			return $this->sendResponse($success,'Not Found');

		}else{

			$order_items = OrderItems::select('order_items.*',
										'products.title',
										'products.store_id as store',
										'product_variants.attribute_value_id',
										'products.id as product_id',
										'categories.name as category',
										'brands.name as brand',
										'order_items.product_variant_id',
										'order_items.created_at'
									)
							->join('product_variants', 'order_items.product_variant_id', 'product_variants.id')
							->join('products', 'product_variants.product_id', 'products.id')
							->join('categories','categories.id','=','products.category_id')
							->leftjoin('brands','brands.id','=','products.brand_id')
							->where('order_items.order_id', $order->id)
							->get();

			$products = [];
			// $store = [];
			foreach ($order_items as $order_item) {
				$used_reward = CustomerRewardUsed::where('order_id',$id)->where('user_id',$order->customer_id)->first();
				$gem_setting=  RewardPoint::where('reward_type','invite')->first();
				$coin_setting=  RewardPoint::where('reward_type','transaction')->first();
				if(!empty($used_reward)){
					$gem_point = $used_reward->gems_point/$gem_setting->reward_point_exchange_rate;
					$coin_point =$used_reward->coin_point/$coin_setting->reward_point_exchange_rate;
					$point = $gem_point+$coin_point;
				}else{
					$point = null;
				}
				// review
				$product_review = ProductReview::where('product_id',$order_item->product_variant_id)->where('customer_id',$order->customer_id)->first();
				if(!empty($product_review)){
					$review = array('id' => $product_review->id,
	        		'rating' => $product_review->rating,
	        		'comment' => $product_review->comment);
				}else{
					$review = NULL;
				}
				$wishlist = UserWishlist::where('product_id',$order_item->product_variant_id)->where('user_id',$order->customer_id)->exists();
				$title = $order_item->title;

				$image = [];
				$product_images = ProductImages::where('variant_id',$order_item->product_variant_id)->get();

				foreach ($product_images as $product_image) {
					$image[] = asset('public/images/product_images/'.$product_image->image);
				}

				$products[] = array('id' => $order_item->id,
					'product_id' => $order_item->product_id,
					'name' => $title,
					'price' => (float)$order_item->price,
					'quantity' => $order_item->quantity,
					'brand' => $order_item->brand,
					'category' => $order_item->category,
					'status' => $order_item->status,
					'wishlist' =>$wishlist,
					'review' => $review,
					'images' => $image
				);

				

				$vendor_store = VendorStore::where('id',$order_item->store)->first();

				$store = array('store_id' => $vendor_store['id'],
							'name' => $vendor_store['name'],
							'branch_admin' => $vendor_store['branch_admin'],
							'phone_number' => $vendor_store['phone_number'],
							'email' => $vendor_store['email'],
							'current_status' => $vendor_store['open_status'],
							'image' => ($vendor_store['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$vendor_store['image']))
						);
			}

			if($order->type == 'pickup'){
				$pickup = 1000 * strtotime($order->pickup_date.' '.$order->pickup_time);
				}else{
					$pickup = null;
				}

			$coupon = [];

			if($order->coupan_id!='' && $order->coupan_id!=Null){

				$coupon_data = VendorCoupons::where('id',$order->coupan_id)->first();

				$coupon = array('id' => $coupon_data->id,
							'coupon_code' => $coupon_data->coupon_code,
							'image' => ($coupon_data->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/vendors_coupan/'.$coupon_data->image)),
							'title' => $coupon_data->discount.' % off',
							'discount' => $coupon_data->discount,
							'description' => $coupon_data->description,
							'start_date' => 1000 * strtotime($coupon_data->start_date),
							'end_date' => 1000 * strtotime($coupon_data->end_date)
						);
			}
			if($order->completed_date != ''){

				$return_date = date('Y-m-d', strtotime($order->completed_date. ' + '.$vendor_store->return_policy.' days'));
				$return_date = 1000 * strtotime($return_date);
			}else{
				$return_date = null;
			}

			if($order->is_verified == 'yes'){
				$verified = true;
			}else if($order->is_verified == 'no'){
				$verified = false;
			}
			$success = array( 'order_id' => $order->id,
						'order_no' => $order->order_no,
						'is_verified'=>$verified,
						'placed_on' => 1000 * strtotime($order->created_at),
						'type' => $order->type,
						'pickup_date_time' => $pickup,
						'items_total'=>$order->item_total,
						'promo_code' => $order->promo_code,
						'tax' => (float)$order->tax,
						'status' => $order->order_status,
						'return_date' => $return_date,
						'grand_total' => $order->total_price,
						'used_reward' => $point,
						'coupan_code' => $coupon,
						'product' => $products,
						'store' => $store
					);

			return $this->sendResponse($success,'Data retrieved successfully');
		}
	}

	public function addMoneyWallet(Request $request, $id)
	{
		$wallet = User::where('id', $id)->first();
		Stripe\Stripe::setApiKey($this->stripe_secret);
		 try {
                Stripe\Charge::create ([
	                "amount" => $request->amount * 100,
	                "currency" => "usd",
	                "customer" => $wallet->stripe_customer_id,
	               	"source" => $request->card_id,
	                "description" => "Money added in your wallet." 
        		]);

        		$closing_amount = $wallet->wallet_amount+$request->amount;
		
				$customer_wallet = new CustomerWallet;
				$customer_wallet->customer_id = $id;
				$customer_wallet->amount = $request->amount;
				$customer_wallet->closing_amount = $closing_amount;
				$customer_wallet->type = 'credit';
				$customer_wallet->save();

				if(empty($wallet->wallet_amount)){
					User::where('id',$id)->update(array('wallet_amount'=>$request->amount));
				}else{
					$amount = $wallet->wallet_amount+$request->amount;
					User::where('id',$id)->update(array('wallet_amount'=>$amount));
				}

				// notification
				$id = $customer_wallet->id;
				$type = 'wallet_transaction';
			    $title = 'Wallet';
			    $message = 'Money has been added to your wallet';
			    $devices = UserDevice::where('user_id',$wallet->id)->where('user_type','customer')->get();
			    $this->sendNotification($title, $message, $devices, $type, $id);

			    return $this->sendResponse(null,'Money has been added to your wallet successfully');

            } catch(\Stripe\Exception\CardException $e) {
                $errors = $e->getMessage();
            } catch (\Stripe\Exception\RateLimitException $e) {
                $errors = $e->getMessage();
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                $errors = $e->getMessage();
            } catch (\Stripe\Exception\AuthenticationException $e) {
                $errors = $e->getMessage();
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                $errors = $e->getMessage();
            } catch (\Stripe\Exception\ApiErrorException $e) {
               $errors = $e->getMessage();
            } catch (Exception $e) {
                $errors = $e->getMessage();
            }
        
			return $this->sendError($errors);
	}

	public function transferMoney(Request $request, $id)
	{
		$debit_user = User::where('id', $id)->first();
		$credit_user = User::where('email', $request->email)->first();
		
		$count_debituser_transcation = CustomerWallet::where('customer_id',$id)
							->where('type','=','sent')
							->whereDate('created_at', '=', Carbon::today()->toDateString())
							->sum('amount');

		$count_month_debituser_transcation = CustomerWallet::where('customer_id',$id)
							->where('type','=','sent')
							->whereMonth('created_at', '=', date('m'))
							->count('id');

		$percentage = '';
		$amount = $request->amount;
		$subscription = UserSubscription::with(['Membership', 'MembershipItem'])->where('user_subscriptions.user_id', $id)->first();
		
		if($subscription->membership->code == 'explorer') {
			$percentage = 2;
		} else if($subscription->membership->code == 'classic') {
			$percentage = 1;
		}
		if($percentage != ''){
			$amount = $request->amount;
			$transaction_fee = ($percentage / 100) * $amount;
			$amount = $amount + $transaction_fee;
		}

		if($count_month_debituser_transcation == 5){
			return $this->sendError('You have exceeded the monthly transaction limit. You can send funds a maximum of five times monthly.');
		}					
		else if($count_debituser_transcation+$amount >=250){
			return $this->sendError('You have exceeded the daily limit. You can send funds up to $250 daily.');
		}
		else if(trim($debit_user->email) == trim($request->email)){
			return $this->sendError('You can\'t transfer money to yourself.');
		}else if(empty($credit_user)){
			return $this->sendError('We can\'t find a user with the email address you have entered');
		}else if($debit_user->wallet_amount < $amount){
			return $this->sendError('You have not enough balance in your wallet to transfer money.');
		}else{

			$debit_user_closing_amount = $debit_user->wallet_amount-$request->amount;
		
			$debit_user_wallet = new CustomerWallet;
			$debit_user_wallet->customer_id = $debit_user->id;
			$debit_user_wallet->amount = $amount;
			$debit_user_wallet->closing_amount = $debit_user_closing_amount;
			$debit_user_wallet->sent_received_id = $credit_user->id;
			$debit_user_wallet->type = 'sent';
			$debit_user_wallet->save();

			User::where('id',$debit_user->id)->update(array('wallet_amount'=>$debit_user_closing_amount));

			// notification
			$id = $debit_user_wallet->id;
			$type = 'wallet_transaction';
		    $title = 'Wallet';
		    $message = 'Money has been transferred to '.$credit_user->first_name.' '.$credit_user->last_name;
		    $devices = UserDevice::where('user_id',$debit_user->id)->where('user_type','customer')->get();
		    $this->sendNotification($title, $message, $devices, $type, $id);
		    // notification

		    $user_balance = User::where('id',$debit_user->id)->first();

	        if($user_balance->wallet_amount <= 25)
	        {
				$id = NULL;
				$type = 'wallet_low_balance';
			    $title = 'Wallet Balance Required';
			    $message = '$25 minimum is required in wallet at any time for transaction';
			    $devices = UserDevice::where('user_id',$user_balance->id)->where('user_type','customer')->get();
			    $this->sendNotification($title, $message, $devices, $type, $id);
	        }
			        
			if(empty($credit_user->wallet_amount)){
				$credit_user_closing_amount = $request->amount;
			}else{
				$credit_user_closing_amount = $credit_user->wallet_amount+$request->amount;
			}

			$credit_user_wallet = new CustomerWallet;
			$credit_user_wallet->customer_id = $credit_user->id;
			$credit_user_wallet->amount = $request->amount;
			$credit_user_wallet->closing_amount = $credit_user_closing_amount;
			$credit_user_wallet->sent_received_id = $debit_user->id;
			$credit_user_wallet->type = 'received';
			$credit_user_wallet->save();

			User::where('id',$credit_user->id)->update(array('wallet_amount'=>$credit_user_closing_amount));
			// notification
			$id = $credit_user_wallet->id;
			$type = 'wallet_transaction';
		    $title = 'Wallet';
		    $message = $debit_user->first_name.' '.$debit_user->last_name .' has sent money to your wallet';
		    $devices = UserDevice::where('user_id',$credit_user->id)->where('user_type','customer')->get();
		    $this->sendNotification($title, $message, $devices, $type, $id);
			//notification
			return $this->sendResponse(null,'Money has been transferred to the account registered with the email address you have entered.');
		}
	}

	public function customerBalance($id)
	{
		$customer_wallet = User::find($id);
		if($customer_wallet){
			return $this->sendResponse((float)number_format($customer_wallet->wallet_amount,2,'.',''),'Your current balance.');
		}else{
			return $this->sendResponse(0.0,'Account balance retrieved successfully');
		}
	}

	public function coupanList($id)
	{
		$couponData = []; 
		$used_coupon = vendorCouponsUsed::select(DB::raw('count(id) as total_coupon'))
			->whereRaw('MONTH(created_at) = ?',[date('m')])
			->whereRaw('YEAR(created_at) = ?',[date('Y')])
			->where('user_id',$id)
			->first();
		$subscription = UserSubscription::with(['Membership'])->where('user_subscriptions.user_id', $id)->first();

		if($subscription->membership->code == 'explorer' && $used_coupon->total_coupon >= 2) {
			$display_coupon = 'no';
		} else if($subscription->membership->code == 'classic' && $used_coupon->total_coupon >= 10) {
			$display_coupon = 'no';
		} else {
			$display_coupon = 'yes';
		}

		if($display_coupon == 'yes') {

			$signle_all_discount_codes = VendorCoupons::select('vendor_coupons.id',
	                'vendor_coupons.discount as title',
	                'vendor_coupons.coupon_code',
	                'vendor_coupons.description',
	                'vendor_coupons.discount',
	                'vendor_coupons.start_date',
	                'vendor_coupons.end_date',
	                'vendor_coupons.image',
	                DB::raw("( SELECT COUNT(vendor_coupons_useds.id) FROM vendor_coupons_useds WHERE (vendor_coupons_useds.coupon_id = vendor_coupons.id AND vendor_coupons_useds.user_id = '".$id."')) as used_count")
	            )
	            ->where('vendor_coupons.type','single')
	            ->where('vendor_coupons.coupon_for','all')
	            ->where('vendor_coupons.coupon_status','verified')
	            ->whereDate('vendor_coupons.start_date', '<=', date("Y-m-d"))
	            ->whereDate('vendor_coupons.end_date', '>=', date("Y-m-d"))
	            ->having('used_count', 0)
	            ->get()
	            ->toArray();

        	$multiple_all_discount_codes = VendorCoupons::select('vendor_coupons.id',
                    'vendor_coupons.discount as title',
                    'vendor_coupons.coupon_code',
                    'vendor_coupons.description',
                    'vendor_coupons.discount',
                    'vendor_coupons.start_date',
                    'vendor_coupons.end_date',
                    'vendor_coupons.image'
                )
                ->where('vendor_coupons.type','multiple')
                ->where('vendor_coupons.coupon_for','all')
                ->where('vendor_coupons.coupon_status','verified')
                ->whereDate('vendor_coupons.start_date', '<=',date("Y-m-d"))
                ->whereDate('vendor_coupons.end_date', '>=',date("Y-m-d"))
                ->get()
                ->toArray();

        	$signle_selected_discount_codes = VendorCoupons::select('vendor_coupons.id',
                    'vendor_coupons.discount as title',
                    'vendor_coupons.coupon_code',
                    'vendor_coupons.description',
                    'vendor_coupons.discount',
                    'vendor_coupons.start_date',
                    'vendor_coupons.end_date',
                    'vendor_coupons.image',
                    DB::raw("( SELECT COUNT(vendor_coupons_useds.id) FROM vendor_coupons_useds WHERE (vendor_coupons_useds.coupon_id = vendor_coupons.id AND vendor_coupons_useds.user_id = '".$id."')) as used_count")
                )
                ->join('user_coupons','user_coupons.coupon_id','=','vendor_coupons.id')
                ->where('vendor_coupons.type','single')
                ->where('vendor_coupons.coupon_for','selected')
                ->where('vendor_coupons.coupon_status','verified')
                ->whereDate('vendor_coupons.start_date', '<=',date("Y-m-d"))
                ->whereDate('vendor_coupons.end_date', '>=',date("Y-m-d"))
                ->where('user_coupons.user_id',$id) 
                ->having('used_count', 0)
                ->get()
                ->toArray();

        	$multiple_selected_discount_codes = VendorCoupons::select('vendor_coupons.id',
                    'vendor_coupons.discount as title',
                    'vendor_coupons.coupon_code',
                    'vendor_coupons.description',
                    'vendor_coupons.discount',
                    'vendor_coupons.start_date',
                    'vendor_coupons.end_date',
                    'vendor_coupons.image'
                )
                ->join('user_coupons','user_coupons.coupon_id','=','vendor_coupons.id')
                ->where('vendor_coupons.type','multiple')
                ->where('vendor_coupons.coupon_for','selected')
                ->where('vendor_coupons.coupon_status','verified')
                ->whereDate('vendor_coupons.start_date', '<=',date("Y-m-d"))
                ->whereDate('vendor_coupons.end_date', '>=',date("Y-m-d"))
                ->where('user_coupons.user_id',$id) 
                ->get()
                ->toArray();

        	$single_rewarded_dicount_code = VendorCoupons::select('vendor_coupons.id',
                    'vendor_coupons.discount as title',
                    'vendor_coupons.coupon_code',
                    'vendor_coupons.description',
                    'vendor_coupons.discount',
                    'vendor_coupons.start_date',
                    'vendor_coupons.end_date',
                    'vendor_coupons.image',
                    DB::raw("( SELECT COUNT(vendor_coupons_useds.id) FROM vendor_coupons_useds WHERE (vendor_coupons_useds.coupon_id = vendor_coupons.id AND vendor_coupons_useds.user_id = '".$id."')) as used_count")
                )
                ->join('user_coupons','user_coupons.coupon_id','=','vendor_coupons.id')
                ->where('vendor_coupons.type','single')
                ->where('vendor_coupons.coupon_status','verified')
                ->where('vendor_coupons.coupon_for','rewarded')
                ->where('user_coupons.user_id',$id) 
                ->having('used_count', 0)
                ->get()
                ->toArray();

	        $data = array_merge($signle_all_discount_codes,$multiple_all_discount_codes,$signle_selected_discount_codes,$multiple_selected_discount_codes,$single_rewarded_dicount_code);

	        foreach ($data as $key => $value) {
	        	$couponData[] = array('id' => $value['id'],
	        		'title' => $value['title'].'% off',
	        		'coupon_code' => $value['coupon_code'],
	        		'description' => $value['description'],
	        		'discount' => $value['discount'],
	        		'start_date' => $value['start_date'],
	        		'end_date' => $value['end_date'],
	        		'image' => $value['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/vendors_coupan/'.$value['image'])
	        	);
	        }
	    }

        return $this->sendResponse($couponData,'Data retrieved successfully');
	}

	public function transcationHistory(Request $request, $id)
	{
		
		$start_timestamp = $request['start_date']/1000;
		$start_date = date('Y-m-d H:i:s:m', $start_timestamp);
		
		
		$end_timestamp = $request['end_date']/1000;
		$end_date = date('Y-m-d H:i:s:m', $end_timestamp);

		/*echo $start_date;
		echo '</br>';
		echo $end_date;die();*/

		// echo $end_timestamp;die();
		$customer_wallets = CustomerWallet::leftjoin('vendor_stores','vendor_stores.id','=','customer_wallets.store_id')
								->join('users','users.id','=','customer_wallets.customer_id')
								->join('user_subscriptions','user_subscriptions.user_id','=','users.id')
								->join('memberships','memberships.id','=','user_subscriptions.membership_id')
								->select('vendor_stores.name',
										'vendor_stores.image',
										'customer_wallets.id',
										'customer_wallets.type',
										'customer_wallets.amount',
										'customer_wallets.closing_amount',
										'customer_wallets.created_at',
										'customer_wallets.customer_id',
										'customer_wallets.sent_received_id',
										'users.wallet_amount',
										'users.email',
										'users.first_name',
										'users.last_name',
										'memberships.name as membership_name'
									)
								->where('customer_wallets.customer_id','=',$id);

		if($request['start_date'] && $request['end_date'])
		{
			$customer_wallets = $customer_wallets->whereRaw('DATE(customer_wallets.created_at) >= "'.$start_date.'"')
				->whereRaw('DATE(customer_wallets.created_at) <= "'.$end_date.'"');
		}

		if($request['type'] == 'paid') {
			$customer_wallets = $customer_wallets->where('customer_wallets.type','debit');
		} elseif($request['type'] == 'added') {
			$customer_wallets = $customer_wallets->where('customer_wallets.type','credit');
		} elseif($request['type'] == 'sent') {
			$customer_wallets = $customer_wallets ->where('customer_wallets.type','sent');
		} elseif($request['type'] == 'received') {
			$customer_wallets = $customer_wallets ->where('customer_wallets.type','received');
		} elseif($request['type'] == 'subscription_charge') {
			$customer_wallets = $customer_wallets ->where('customer_wallets.type','subscription_charge');
		}
		
		$customer_wallets = $customer_wallets->orderBy('customer_wallets.created_at', 'desc')->paginate(10);
		

		if($customer_wallets->isNotEmpty())
		{	
			$current_page = $customer_wallets->currentPage();
			$total_pages  = $customer_wallets->lastPage();

			foreach ($customer_wallets as $key => $value) {

				$wallet_amount = $value->wallet_amount;
				if($value->type == 'debit') {

					$type = $value->type;
					$title = "paid to  ".$value->name;
					$image = $value->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$value->image);
				}elseif($value->type == 'credit') {

					$type = $value->type;
					$title ='Money added to Wallet';
					$image = null;
				}elseif($value->type == 'refund'){

					$type = 'credit';
					$title ='Refund Money to Wallet';
					$image = null;
				}elseif($value->type == 'sent'){

					$type = $value->type;
					$user = User::where('id',$value->sent_received_id)->first();
					$title ='Sent to '.' '.$user->first_name.' '.$user->last_name;
					$image = null;
				}elseif($value->type == 'received'){

					$type = $value->type;
					$user = User::where('id',$value->sent_received_id)->first();
					$title ='Received from '.' '.$user->first_name.' '.$user->last_name;
					$image = null;
				}elseif($value->type == 'subscription_charge'){

					$type = $value->type;
					$title = $value->membership_name. ' plan subscription';
					$image = null;
				}elseif($value->type == 'one_time_fees'){

					$type = $value->type;
					$title = 'One time joining fees for incentive program';
					$image = null;
				}else{
					
					$type = $value->type;
					$title = null;
					$image = null;
				}
				
				// echo $value->closing_amount;die();
				$data[] = array(
						'id'=>$value->id,
						'title'=> $title,
						'image'=>$image,
						'type'=>$type,
						'amount' => $value->amount,
						'closing_amount' => $value->closing_amount,
						'placed_on'=>1000 * strtotime($value['created_at'])
					);
			}
			
			return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'wallet_amount'=>$wallet_amount,'history'=>$data),'Data retrieved successfully');	
		}else{

			$data=[];
			$user = User::where('id',$id)->first();
			
			return $this->sendResponse(array('page'=> 1,'totalPage'=>1,'wallet_amount'=>$user->wallet_amount,'history'=>$data),'We can\'t find proper data to display');	
		}
	}

	public function cancelOrder(Request $request, $id)
	{
		//$orders = Orders::where('id',$id)->where('customer_id',$request->customer_id)->first();
		$order = Orders::select('orders.id',
								'orders.order_no',
								'orders.created_at',
								'orders.type',
								'orders.pickup_date',
								'orders.pickup_time',
								'orders.coupan_id',
								'orders.total_price',
								'orders.item_total',
								'orders.promo_code',
								'orders.tax',
								'orders.order_status',
								'vendor_stores.id as store_id',
								'vendor_stores.vendor_id',
								'vendor_stores.name',
								'vendor_stores.branch_admin',
								'vendor_stores.phone_number',
								'vendor_stores.email',
								'vendor_stores.open_status',
								'vendor_stores.image'
							)
							->join('vendor_stores','vendor_stores.id','=','orders.store_id')
							->where('orders.id',$id)
							->where('orders.customer_id',$request->customer_id)
							->orderBy('orders.created_at', 'desc')
							->first();
		
		if($order->order_status != 'completed'){

			$order->order_status = 'cancelled';
			$order->cancel_reason = $request->reason;
			$order->additional_comment = $request->additional_comment;
			$order->save();
			$user = User::where('id',$request->customer_id)->first();

			//Admin mail
	        /*$admin = 'ankita@addonwebsolutions.com';
	        Mail::to($admin)->send(new OrderCancelMail($order));*/

	      
			$vendor = Vendor::where('id',$order->vendor_id)->first();
			if($vendor->parent_id == 0){
				$vendor_email = $vendor->id;
			}
			else{
				$vendor_email = $vendor->parent_id;
			}
			$email = Vendor::where('id',$vendor_email)->first();
	        Mail::to($email->email)->send(new OrderCancelVendorMail($order));


			//customer notification
			$id = $id;
			$type = 'order';
		    $title = 'Order';
		    $message = 'Your order - '.$order->order_no.' has been canceled';
		    $devices = UserDevice::where('user_id',$request->customer_id)->where('user_type','customer')->get();
		    $this->sendNotification($title, $message, $devices, $type, $id);

		    //vendor notification
		    $id = $id;
			$type = 'order';
		    $title = 'Order';
		    $message = 'Order - '.$order->order_no.' has been canceled';
		    $devices = UserDevice::where('user_id',$order->vendor_id)->where('user_type','vendor')->get();
		    $this->sendVendorNotification($title, $message, $devices, $type, $id);

			// customer wallet amount
			$customer_wallet = new CustomerWallet;
			$customer_wallet->customer_id = $user->id;
			$customer_wallet->amount = $order->total_price;
			$customer_wallet->closing_amount = $user->wallet_amount+$order->total_price;
			$customer_wallet->type = 'refund';
			$customer_wallet->save();

			$user->wallet_amount = $user->wallet_amount+$order->total_price;
			$user->save();

			// respone
			$store = array('store_id' => $order['store_id'],
						'name' => $order->name,
						'branch_admin' => $order->branch_admin,
						'phone_number' => $order->phone_number,
						'email' => $order->email,
						'current_status' => $order->open_status,
						'image' => ($order->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$order->image))
					);

			if($order['type'] == 'pickup')
			{
				$pickup = 1000 * strtotime($order->pickup_date.' '.$order->pickup_time);

			}else{
				
				$pickup = null;
			}

			$coupon = [];

			if($order->coupan_id!='' && $order->coupan_id!=Null){

				$coupon_data = VendorCoupons::where('id',$order->coupan_id)->first();
				$coupon = array('id' => $coupon_data->id,
							'coupon_code' => $coupon_data->coupon_code,
							'image' => ($coupon_data->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/vendors_coupan/'.$coupon_data->image)),
							'title' => $coupon_data->discount.' % off',
							'discount' => $coupon_data->discount,
							'description' => $coupon_data->description,
							'start_date' => 1000 * strtotime($coupon_data->start_date),
							'end_date' => 1000 * strtotime($coupon_data->end_date)
						);
			}
			$products = OrderItems::select('order_items.*',
									'products.title',
									'products.store_id as store',
									'product_variants.attribute_value_id',
									'products.id as product_id',
									'categories.name as category',
									'brands.name as brand',
									'order_items.product_variant_id',
									'order_items.created_at'
								)
						->join('product_variants', 'order_items.product_variant_id', 'product_variants.id')
						->join('products', 'product_variants.product_id', 'products.id')
						->join('categories','categories.id','=','products.category_id')
						->leftjoin('brands','brands.id','=','products.brand_id')
						->where('order_items.order_id', $order->id)
						->get();
							
			$produc = [];
			foreach($products as $product){

				// review
				$product_review = ProductReview::where('product_id',$product->product_variant_id)->where('customer_id',$product->customer_id)->first();
				if(!empty($product_review)){
					$review = array('id' => $product_review->id,
	        		'rating' => $product_review->rating,
	        		'comment' => $product_review->comment);
				}else{
					$review = NULL;
				}
				$wishlist = UserWishlist::where('product_id',$product->product_variant_id)->where('user_id',$product->customer_id)->exists();
				$title = $product->title;

				$image = [];
				$product_images = ProductImages::where('variant_id',$product->product_variant_id)->get();

				foreach ($product_images as $product_image) {
					$image[] = asset('public/images/product_images/'.$product_image->image);
				}

				$produc[] = array('id' => $product->id,
					'product_id' => $product->product_id,
					'name' => $title,
					'price' => (float)$product->price,
					'quantity' => $product->quantity,
					'brand' => $product->brand,
					'category' => $product->category,
					'status' => $product->status,
					'wishlist' =>$wishlist,
					'review' => $review,
					'images' => $image
				);
			}
				
				$data= array('order_id' => $order->id,
							'order_no' => $order->order_no,
							'placed_on' => 1000 * strtotime($order->created_at),
							'type' => $order->type,
							'pickup_date_time' => $pickup ,
							'items_total' => $order->item_total,
							'promo_code' => $order->promo_code,
							'tax' => (float)$order->tax,
							'status' => $order->order_status,
							'grand_total' => (float)$order->total_price,
							'store' => $store,
							'coupan_code' => $coupon,
							'product' => $produc
						);

			// end
		
			return $this->sendResponse($data,'Your order has been canceled successfully');
		}else{
			return $this->sendResponse(null,'Your order cannot be canceled at this time.');
		}
	}

	public function returnOrderItem(Request $request, $id)
	{

		$orders = OrderItems::select('order_items.id',
						'order_items.product_variant_id',
						'order_items.price',
						'order_items.quantity',
						'products.title',
						'products.store_id as store',
						'products.id as product_id',
						'orders.type',
						'orders.pickup_date',
						'orders.pickup_time',
						'orders.customer_id',
						'brands.name as brand',
						'categories.name as category',
						'orders.vendor_id'
					)
				->join('orders','orders.id','order_items.order_id')
				->join('product_variants', 'order_items.product_variant_id', 'product_variants.id')
				->join('products', 'product_variants.product_id', 'products.id')
				->join('vendor_stores','vendor_stores.id','orders.store_id')
				->join('categories','categories.id','=','products.category_id')
				->leftjoin('brands','brands.id','=','products.brand_id')
				->leftjoin('vendor_coupons','vendor_coupons.id','orders.coupan_id')
				->where('order_items.id',$id)
				->where('orders.order_status','completed')
				->whereNull('order_items.status')
				->first();

		if(!empty($orders)){
			$order_items = OrderItems::where('id',$orders->id)->first();
			$order_items->status = 'return_request';
			$order_items->return_reason = $request->reason;
			$order_items->additional_comment = $request->additional_comment;
			$order_items->save();

			// review
			$product_review = ProductReview::where('product_id',$orders->product_variant_id)->where('customer_id',$orders->customer_id)->first();
			if(!empty($product_review)){
				$review = array('id' => $product_review->id,
        		'rating' => $product_review->rating,
        		'comment' => $product_review->comment);
			}else{
				$review = NULL;
			}

			//Admin mail
	        /*$admin = 'ankita@addonwebsolutions.com';
	        Mail::to($admin)->send(new OrderReturnMail($order_items));

	      
			$vendor = Vendor::where('id',$orders->vendor_id)->first();
			if($vendor->parent_id == 0){
				$vendor_email = $vendor->id;
			}
			else{
				$vendor_email = $vendor->parent_id;
			}
			$email = Vendor::where('id',$vendor_email)->first();
	        Mail::to($email->email)->send(new OrderReturnVendorMail($order_items));*/

	        $image = [];
			$product_images = ProductImages::where('variant_id',$orders->product_variant_id)->get();

			foreach ($product_images as $product_image) {
				$image[] = asset('public/images/product_images/'.$product_image->image);
			}

			$wishlist = UserWishlist::where('product_id',$orders->product_variant_id)->where('user_id',$request->current_user)->exists();
			$products = array('id' => $orders->id,
				'product_id' => $orders->product_id,
				'name' => $orders->title,
				'quantity' => $orders->quantity,
				'price' => (float)$orders->price,
                'brand' => $orders->brand,
                'category' => $orders->category,
                'status' => "return_request",
                'wishlist'=> $wishlist,
                'images' => $image,
                'review' => $review
			);

	        return $this->sendResponse($products,'Product return request has been created successfully');
		}else{
			return $this->sendError('You have already submitted return request for this product');
		}
	}

    public function suggestedPlace(Request $request, $id)
    {
    	$store_name = $request->store;
    	$store_exist = SuggestedPlace::whereRaw('lower(store) like (?)',["%{$store_name}%"])->exists();
    	if ($store_exist) {
		   return $this->sendResponse(null,'This store is already suggested.');
		} else {

			$suggested_place = new SuggestedPlace;
			$suggested_place->user_id = $id;
			$suggested_place->store = $request->store;
			$suggested_place->address = $request->address;
			$suggested_place->email = $request->email;
			$suggested_place->mobile_no = $request->mobile_no;
			$suggested_place->save();
			return $this->sendResponse(null,'Thanks for your suggestion.');
		}
    }

    public function test_store(Request $request)
    {
    	$end_date = date('Y-m-d');
    	$start_date =  date('Y-m-d', strtotime('-7 days'));
			// die();

    	$selling_products = Products::join('vendor_stores','vendor_stores.id','=','products.store_id')
								->select('product_variants.id',
										DB::raw('count(order_items.product_variant_id) as count'),
										'products.title as product',
										'products.id as product_id',
										'products.status',
										'categories.name as category',
										'brands.name as brand',
										'vendor_stores.name',
										'vendor_stores.branch_admin',
										'vendor_stores.email',
										'vendor_stores.phone_number',
										'vendor_stores.open_status',
										'vendor_stores.image',
										'vendor_stores.id as store_id',
										'product_variants.price',
										'product_variants.discount',
										'order_items.created_at'
									)
								->join('categories','categories.id','=','products.category_id')
								->join('brands','brands.id','=','products.brand_id')
								->join('product_variants','product_variants.product_id','=','products.id')
								->join('order_items','order_items.product_variant_id','=','product_variants.id')
								->whereBetween(DB::raw('DATE(order_items.created_at)'), [$start_date, $end_date])
								->groupBy('order_items.product_variant_id')
		                		->orderBy('count', 'DESC')
								->paginate(10);

		// print_r($selling_products);die();
		if($selling_products->isNotEmpty())
		{	
			$current_page = $selling_products->currentPage();
			$total_pages  = $selling_products->lastPage();		
			foreach ($selling_products as $key => $value) {

				$wish_list = UserWishlist::where('product_id',$value['id'])
								->where('user_id',$request->current_user)
								->exists();

				$product_images = ProductImages::where('product_id',$value['id'])->get();
				$image=[];
				foreach ($product_images as $key) {

					$image[] = array('image' => ($key['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/product_images/'.$key['image'])) );

				}
				$store=array('store_id' =>  $value->store_id,
							'name' =>  $value->name,
							'branch_admin' =>$value->branch_admin,
							'phone_number' =>$value->phone_number,
							'email' =>$value->email,
							'current_status' =>$value->open_status,
							'image' => ($value->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$value->image))
						);
				$success[] = array( 'id' => $value['id'],
								'product_id' => $value['product_id'],
								'name' => $value['product'],
								'brand' =>  $value['brand'],
								'price' => $value['price'],
								'discount' => $value['discount'],
								'category' =>  $value['category'],
								'status' => $value['status'],
								'wishlist' => $wish_list,
								'image' => $image,
								'store' => $store
							);
			}
			return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'products'=>$success),'Best selling product');
		}else{
			$success =[];
			return $this->sendResponse(array('page'=> 1,'totalPage'=>1,'products'=>$success),'Data avaliable');
		}
    }

    public function notificationList($id)
    {
    	$notification_data = [];
    	$user_notifications = UserNotification::where('user_id',$id)
    							// ->groupBy('title')
    							->where('user_type','customer')
    							->orderBy('id','DESC')
    							->paginate(10);
    	
		if($user_notifications->isNotEmpty())
		{	
			$current_page = $user_notifications->currentPage();
			$total_pages  = $user_notifications->lastPage();

			foreach ($user_notifications as $key => $user_notification) {
				
				$notification_data[] = array(
					'id' => $user_notification->id,
					'title' => $user_notification->title,
					'description' => $user_notification->description,
					'date' => 1000 * strtotime($user_notification->updated_at)
				);
			}
			return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'Notifications'=>$notification_data),'Data retrieved successfully');		
		}else{
			return $this->sendResponse(array('page'=> 1,'totalPage'=>1,'Notifications'=>$notification_data),'We can\'t find proper data to display');
		}
    }

    public function rewardPointHistory(Request $request, $id)
    {
    	$gem_setting = RewardPoint::where('reward_type','invite')->first();
		$coin_setting = RewardPoint::where('reward_type','transaction')->first();

    	$start_timestamp = $request->start_date/1000;
    	$start_date = date('Y-m-d H:i:s:m', $start_timestamp);
		
		$end_timestamp = $request->end_date/1000;
		$end_date = date('Y-m-d H:i:s:m', $end_timestamp);

		$data = [];

    	$customer_reward_points = CustomerRewardPoint::select(DB::raw(
                        "(SELECT SUM(customer_reward_points.total_point) FROM customer_reward_points
                        WHERE customer_reward_points.user_id = ".$id." AND customer_reward_points.reward_type = 'invite'  GROUP BY customer_reward_points.user_id) as gem"
                    ),
					DB::raw("(SELECT SUM(customer_reward_points.total_point) FROM customer_reward_points
                        WHERE customer_reward_points.user_id = ".$id." AND customer_reward_points.reward_type = 'transaction' GROUP BY customer_reward_points.user_id) as coin"
                    ))
    			->where('user_id',$id)
    			->groupBy('user_id')
    			->first();
    	if(!empty($customer_reward_points)){
    	if($request->page == 1){

    		$gem_balance = 0.00; $coin_balance = 0.00;
			if($customer_reward_points->gem > 0){
				$gem_balance = $customer_reward_points->gem / $gem_setting->reward_point_exchange_rate;
				$gem_balance = floatval(number_format($gem_balance,2,".",""));
			}

			if($customer_reward_points->coin > 0){
				$coin_balance = $customer_reward_points->coin / $coin_setting->reward_point_exchange_rate;
				$coin_balance = floatval(number_format($coin_balance,2,".",""));
			}

    		$balance = array(
    			'gem' => (int)$customer_reward_points->gem,
    			'coin' => (int)$customer_reward_points->coin,
    			'gem_amount' => $gem_balance, 
    			'coin_amount' => $coin_balance
    		);
    	}else{
    		$balance  = NULL;
    	}

    	$earn = DB::table("customer_earn_reward_points")
    			->select("customer_earn_reward_points.reward_point","users.first_name","users.last_name","customer_earn_reward_points.created_at as created","customer_earn_reward_points.id","customer_earn_reward_points.gems_point","customer_earn_reward_points.coin_point","customer_earn_reward_points.reward_type","customer_earn_reward_points.reward_sub_type","customer_earn_reward_points.created_at")
    			->join('users','users.id','customer_earn_reward_points.user_id')
			->where('customer_earn_reward_points.user_id',$id);
			

  		if($request->start_date && $request->end_date) {

			$earn = $earn->whereRaw('DATE(customer_earn_reward_points.created_at) >= "'.$start_date.'"')
				->whereRaw('DATE(customer_earn_reward_points.created_at) <= "'.$end_date.'"');
		}

		if($request->type == 'gem')
		{
			// aa condition ma issue ave 6e..koi type pass na karo to thai jay 6e

			$earn = $earn->where('customer_earn_reward_points.reward_type','invite');
			$type = 'gem';
		}

		if($request->type == 'coin')
		{
			$earn = $earn ->where('customer_earn_reward_points.reward_type','transaction');
			$type = 'coin';
		}
		$reaward_points = DB::table("customer_reward_useds")
			    ->select("customer_reward_useds.reward_point","users.first_name","users.last_name","customer_reward_useds.created_at as created","customer_reward_useds.id","customer_reward_useds.gems_point","customer_reward_useds.coin_point","customer_reward_useds.reward_type","customer_reward_useds.reward_type as reward_sub_type","customer_reward_useds.created_at")
			    ->join('users','users.id','customer_reward_useds.user_id')
				->where('customer_reward_useds.user_id',$id)
			    ->unionall($earn);

		if($request->start_date && $request->end_date){

			$reaward_points = $reaward_points->whereRaw('DATE(customer_reward_useds.created_at) >= "'.$start_date.'"')
				->whereRaw('DATE(customer_reward_useds.created_at) <= "'.$end_date.'"');
		}

		if($request->type == 'gem')
		{
			// aa condition ma issue ave 6e..koi type pass na karo to thai jay 6e

			$reaward_points = $reaward_points->where('customer_reward_useds.gems_point','!=',0);
			$type = 'gem';
		}

		if($request->type == 'coin')
		{
			$reaward_points = $reaward_points ->where('customer_reward_useds.coin_point','!=',0);
			$type = 'coin';
		}	   
			   
    	/*$reaward_points = CustomerEarnRewardPoint::select('users.first_name',
				'users.last_name',
				'customer_earn_reward_points.id',
				'customer_earn_reward_points.reward_point',
				'customer_earn_reward_points.reward_type',
				'customer_earn_reward_points.created_at'
			)
			->join('users','users.id','customer_earn_reward_points.user_id')
			->where('user_id',$id);*/
			/*->get();
			print_r($reaward_points);die();*/
			//var_dump($reaward_points->toSql()); exit();
		
		$reaward_points = $reaward_points->orderBy('created','DESC')->paginate(10);


		//$reaward_points = $reaward_points->paginate(2);

		if($reaward_points->isNotEmpty())
		{
			$current_page = $reaward_points->currentPage();
			$total_pages  = $reaward_points->lastPage();

			foreach ($reaward_points as $key => $reaward_point) {
				if($reaward_point->gems_point != 0){
					$description = 'Used for order';
					$reward_type = 'gem';
					$type='debit';
				}else if($reaward_point->reward_type == 'invite'){
					$reward_type = 'gem';
					$description = 'Invitation Reward';
					$type='credit';
				}else if($reaward_point->coin_point != 0){
					$reward_type = 'coin';
					$description = 'Used for order';
					$type='debit';
				}else if($reaward_point->reward_type == 'transaction'){

					if(isset($reaward_point->reward_sub_type) && $reaward_point->reward_sub_type == 'joining_fee_reward') {
						$description = 'Customer incentive program reward';
					} else {
						$description = 'Order Reward';
					}
					$reward_type = 'coin';
					$type='credit';
				}

				if($reward_type == 'gem') {
					$reward_point = $reaward_point->reward_point / $gem_setting->reward_point_exchange_rate;
				}elseif($reward_type == 'coin') {
					$reward_point = $reaward_point->reward_point / $coin_setting->reward_point_exchange_rate;
				}

				$reward_point = floatval(number_format($reward_point,2,".",""));

				$data[] = array(
					'id' => $reaward_point->id,
					'reward_type' => $reward_type,
					'reward_point' => (int)$reaward_point->reward_point,
					'reward_point_amount' => $reward_point,
					'description' => $description,
					'type' => $type,
					'created_at' => 1000 * strtotime($reaward_point->created)
				);
			}
			return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'balance'=>$balance,'transaction'=>$data),'Data retrieved successfully');		
		}else{
			return $this->sendResponse(array('page'=> 1,'totalPage'=>1,'balance'=>$balance,'transaction'=>$data),'We can\'t find proper data to display');
		}
		}else{
			$balance1 = array('gem' => 0, 'coin' => 0, 'gem_amount' => floatval(0.00), 'coin_amount' => floatval(0.00));
			return $this->sendResponse(array('page'=> 1,'totalPage'=>1,'balance'=>$balance1,'transaction'=>$data),'We can\'t find proper data to display');
		}
    }

    public function orderReason(Request $request)
    {
    	$order_reasons = OrderReason::where('type',$request->type)->get();
    	$data = [];
    	foreach ($order_reasons as $key => $order_reason) {
    		$data[] = array('id' => $order_reason->id,
    			'type' => $order_reason->type,
    			'reason' => $order_reason->reason);
    	}
    	return $this->sendResponse(array('order_reason'=>$data),'Data retrieved successfully');		
    }

    public function productFeedback(Request $request, $id)
    {
    	$item = OrderItems::where('id',$request->product_id)->first();

    	$review = ProductReview::where('customer_id',$id)->where('product_id',$item->product_variant_id)->first();

    	if(!empty($review)){
    		$review->customer_id = $id;
	    	$review->product_id = $item->product_variant_id;
	    	$review->comment = $request->comment;
	    	$review->rating = $request->rating;
	    	$review->save();
    	}else{
    		$review = new ProductReview;
	    	$review->customer_id = $id;
	    	$review->product_id = $item->product_variant_id;
	    	$review->comment = $request->comment;
	    	$review->rating = $request->rating;
	    	$review->save();
    	}
    	
    	$data = array('id' => $review->id,
    		'rating' => (float)$review->rating,
    		'comment' => $review->comment);

    	return $this->sendResponse($data,'Feedback is saved.');	
    }

    public function repeatOrder(Request $request, $id)
    {
    	$success = [];
    	$order_items = OrderItems::where('order_id',$id)->whereNull('order_items.status')->get();
    	
    	foreach ($order_items as $key => $value) {
    		$products = Products::join('vendor_stores','vendor_stores.id','=','products.store_id')
						->select('product_variants.id',
							DB::raw('count(order_items.product_variant_id) as count'),
							'products.title as product',
							'products.id as product_id',
							'products.status',
							'product_variants.price',
							'product_variants.discount',
							'categories.name as category',
							'brands.name as brand',
							'vendor_stores.name',
							'vendor_stores.branch_admin',
							'vendor_stores.email',
							'vendor_stores.phone_number',
							'vendor_stores.open_status',
							'vendor_stores.image',
							'vendor_stores.id as store_id'
						)
						->leftjoin('categories','categories.id','=','products.category_id')
						->leftjoin('brands','brands.id','=','products.brand_id')
						->join('product_variants','product_variants.product_id','=','products.id')
						->join('order_items','order_items.product_variant_id','=','product_variants.id')
						->where('product_variants.id',$value->product_variant_id)
						->groupBy('order_items.product_variant_id')
                		->orderBy('count', 'DESC')
						->first();
			
				/*foreach ($products as $key => $value) {*/

			$wish_list = UserWishlist::where('product_id',$products->id)->where('user_id',$request->current_user)->exists();

			$product_images = ProductImages::where('variant_id',$products->id)->get();
			$image=[];
			foreach ($product_images as $key) {

				$image[] = array('image' => ($key['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/product_images/'.$key['image'])) );

			}
			$store=array('store_id' =>  $products->store_id,
						'name' =>  $products->name,
						'branch_admin' =>$products->branch_admin,
						'phone_number' =>$products->phone_number,
						'email' =>$products->email,
						'current_status' =>$products->open_status,
						'image' => ($products->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$products->image))
					);
			$success[] = array( 'id' => $products->id,
							'product_id' => $products->product_id,
							'name' => $products->product,
							'quantity' => $value->quantity,
							'brand' =>  $products->brand,
							'price' => $products->price,
							'discount' => $products->discount,
							'category' =>  $products->category,
							'status' => $value->status,
							'wishlist' => $wish_list,
							'image' => $image,
							'store' => $store
						);
				/*}*/
		}
		return $this->sendResponse($success,'Data retrieved successfully');
    }	

    /*public function repeatOrder(Request $request, $id)
    {
    	$success = [];
    	$order_items = OrderItems::select('product_variants.id',
							DB::raw('count(order_items.product_variant_id) as count'),
							'products.title as product',
							'products.id as product_id',
							'products.status',
							'product_variants.price',
							'product_variants.discount',
							'categories.name as category',
							'brands.name as brand',
							'vendor_stores.name',
							'vendor_stores.branch_admin',
							'vendor_stores.email',
							'vendor_stores.phone_number',
							'vendor_stores.open_status',
							'vendor_stores.image',
							'vendor_stores.id as store_id',
							'product_variants.id as product_variant_id',
							'order_items.quantity'
						)
    					->join('product_variants','product_variants.product_id','=','order_items.product_variant_id')
    					->join('products','products.id','product_variants.product_id')
    					->join('vendor_stores','vendor_stores.id','=','products.store_id')
						->leftjoin('categories','categories.id','=','products.category_id')
						->leftjoin('brands','brands.id','=','products.brand_id')
						->groupBy('order_items.product_variant_id')
                		->orderBy('count', 'DESC')
    					->where('order_items.order_id',$id)
    					->whereNull('order_items.status')
    					->get();
    	print_r($order_items->toArray());die();
    	foreach ($order_items as $key => $value) {			

			$wish_list = UserWishlist::where('product_id',$value->product_variant_id)->where('user_id',$request->current_user)->exists();

			$product_images = ProductImages::where('variant_id',$value->product_variant_id)->get();
			$image=[];
			foreach ($product_images as $key) {

				$image[] = array('image' => ($key['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/product_images/'.$key['image'])) );

			}
			$store=array('store_id' =>  $value->store_id,
						'name' =>  $value->name,
						'branch_admin' =>$value->branch_admin,
						'phone_number' =>$value->phone_number,
						'email' =>$value->email,
						'current_status' =>$value->open_status,
						'image' => ($value->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$value->image))
					);
			$success[] = array( 'id' => $value->product_variant_id,
							'product_id' => $value->product_id,
							'name' => $value->product,
							'quanity' => $value->quantity,
							'brand' =>  $value->brand,
							'price' => $value->price,
							'discount' => $value->discount,
							'category' =>  $value->category,
							'status' => $value->status,
							'wishlist' => $wish_list,
							'image' => $image,
							'store' => $store
						);
		}
		return $this->sendResponse($success,'Data');
    }*/

    public function addToCart(Request $request, $id)
    {
    	$user_cart = UserCart::where('user_id' , $id)->where('product_variant_id',$request->id)->first();

    	$product_variants = ProductVariants::where('id',$request->id)->first();


    	if($product_variants->quantity - 1 <= 0)
    	{
    		return $this->sendResponse(null,'Not sufficient quantity');
	    	
    	}else{
    		if(!empty($user_cart)){
    			$user_cart->product_variant_id = $request->id;
    			$user_cart->quantity = $user_cart->quantity+1;
    			$user_cart->save(); 
	    	}else{
	    		$user_cart = new UserCart;
	    		$user_cart->user_id = $id;
	    		$user_cart->product_variant_id = $request->id;
	    		$user_cart->quantity = 1;
	    		$user_cart->save();
	    	}
	    	return $this->sendResponse(null,'Product is added in cart.');
    		
    	}
    }

    public function removeCart($id){
    	UserCart::where('user_id',$id)->delete();

    	return $this->sendResponse('product remove from cart.');
    }

    public function inshopCart(Request $request, $id)
    {
    	$user_carts = UserCart::select('products.title',
				'products.store_id as store',
				'product_variants.id as product_variant_id',
				'product_variants.price',
				'products.id as product_id',
				'products.title',
				'categories.name as category',
				'brands.name as brand',
				'user_carts.quantity',
				'vendor_stores.id as store_id',
				'vendor_stores.name as store_name',
				'vendor_stores.branch_admin',
				'vendor_stores.phone_number',
				'vendor_stores.email',
				'vendor_stores.open_status',
				'vendor_stores.image'
			)
    		->join('product_variants','product_variants.id','user_carts.product_variant_id')
    		->join('products', 'product_variants.product_id', 'products.id')
    		->join('vendor_stores','vendor_stores.id','products.store_id')
			->leftjoin('categories','categories.id','=','products.category_id')
			->leftjoin('brands','brands.id','=','products.brand_id')
    		->where('user_id',$id)
    		->get();
    	
    	$products = [];
    	
    	foreach ($user_carts as $key => $user_cart) {
    		// review
			$product_review = ProductReview::where('product_id',$user_cart->product_variant_id)->where('customer_id',$id)->first();
			if(!empty($product_review)){
				$review = array('id' => $product_review->id,
        		'rating' => $product_review->rating,
        		'comment' => $product_review->comment);
			}else{
				$review = NULL;
			}
			$wishlist = UserWishlist::where('product_id',$user_cart->product_variant_id)->where('user_id',$id)->exists();

			$image = [];
			$product_images = ProductImages::where('variant_id',$user_cart->product_variant_id)->get();

			foreach ($product_images as $product_image) {
				$image[] = asset('public/images/product_images/'.$product_image->image);
			}
			$store =array('store_id' =>  $user_cart->store_id,
						'name' =>  $user_cart->store_name,
						'branch_admin' =>$user_cart->branch_admin,
						'phone_number' =>$user_cart->phone_number,
						'email' =>$user_cart->email,
						'current_status' =>$user_cart->open_status,
						'image' => ($user_cart->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$user_cart->image))
					);
			$products[] = array('id' => $user_cart->product_variant_id,
				'product_id' => $user_cart->product_id,
				'name' => $user_cart->title,
				'price' => (float)$user_cart->price,
				'quantity' => $user_cart->quantity,
				'brand' => $user_cart->brand,
				'category' => $user_cart->category,
				'wishlist' => $wishlist,
				// 'review' => $review,
				'image' => $image,
				'store' => $store
			);
    	}

    	return $this->sendResponse($products,'products data');
    }

    public function storeDetail($id){

    	$store = VendorStore::where('id',$id)->first();

    	$storeData =array('store_id' =>  $store->id,
				'name' =>  $store->name,
				'branch_admin' =>$store->branch_admin,
				'phone_number' =>$store->phone_number,
				'email' =>$store->email,
				'current_status' =>$store->open_status,
				'image' => ($store->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$store->image))
			);
    	return $this->sendResponse($storeData,'Data retrieved successfully');
    }

    public function pickupOrderNotification(Request $request, $id)
    {
    	$customer_at = $request->location;
        $order = Orders::where('id',$id)->first();
        $id = $id;
        $type = 'order';
        $title = 'Customer at Store';
        $message = 'The customer is in store to pick up order-'.$order->order_no.'. Customer Location: '.$request->location;
        $devices = UserDevice::whereIn('user_id',[$order->vendor_id])->where('user_type','vendor')->get();
        $this->sendVendorNotification($title, $message, $devices, $type, $id);
        return $this->sendResponse(null,'Notification Send to the vendor.');
    }	
}
