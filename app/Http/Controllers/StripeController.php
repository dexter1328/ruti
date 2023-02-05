<?php

namespace App\Http\Controllers;

use DB;
use Stripe;
use Carbon\Carbon;
use App\Invoice;
use App\StoreSubscription;
use App\StoreSubscriptionTemp;
use App\Mail\InvoiceSuccessMail;
use App\Mail\InvoiceFailedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class StripeController extends Controller
{

	private $stripe_secret;
	private $webhook_endpoint;

	public function __construct()
	{
		$this->stripe_secret = config('services.stripe.secret');
		$this->webhook_endpoint = config('services.stripe.webhook.secret');
	}

    public function index(Request $request)
	{
		$payload = @file_get_contents('php://input');
		$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
		$event = null;

		/*try {
			$event = \Stripe\Webhook::constructEvent(
				$payload, $sig_header, $this->webhook_endpoint
			);
		} catch(\UnexpectedValueException $e) {
			// Invalid payload
			http_response_code(400);
			exit();
		} catch(\Stripe\Exception\SignatureVerificationException $e) {
			// Invalid signatured
			http_response_code(400);
			exit();
		}*/

		try {
			$event = \Stripe\Event::constructFrom(
				json_decode($payload, true)
			);
		} catch(\UnexpectedValueException $e) {
			// Invalid payload
			http_response_code(400);
			exit();
		}

		if(!empty($event))
		{
			DB::table('stripe_response')->insert(
				[
					'response_type' => $event->type,
					'response' => json_encode($event),
					'response_date' => date('Y-m-d H:i:s')
				]
			);

			switch($event->type) {
				case "charge.succeeded":
					$temp_record = StoreSubscriptionTemp::where('subscription_id', $event->data->object->id)
						->where('subscription_item_id', $event->data->object->balance_transaction)
						->first();
					if(!empty($temp_record)){

						$invoice_data = [
							'vendor_id' => $temp_record->vendor_id,
							'store_id' => $temp_record->store_id,
							'invoice_number' => 'INV'.$temp_record->vendor_id.'-'.$temp_record->store_id,
							'subscription_id' => $event->data->object->id,
							'customer_id' => $event->data->object->customer,
							'currency' => $event->data->object->currency,
							'subtotal' => $event->data->object->amount,
							'total' => $event->data->object->amount,
							'amount_paid' => $event->data->object->amount,
							'invoice_status' => 'paid',
							'invoice_created_date' => date("Y-m-d H:i:s", $event->data->object->created),
							'user_type' => 'vendor',
							'created_at' => Carbon::now(),
							'updated_at' => Carbon::now()
						];

						$membership_coupon = DB::table('membership_coupons')->where('id', $temp_record->membership_coupon_id)->first();
						if(!empty($membership_coupon)) {

							$membership_item = DB::table('membership_items')->where('id', $temp_record->membership_item_id)->first();

							if(!empty($membership_item)) {

								$actual_price = $membership_item->price * 100;
								$discount_price = ($actual_price * ($membership_coupon->discount / 100));

								$invoice_data['membership_coupon_id'] = $temp_record->membership_coupon_id;
								$invoice_data['subtotal'] = $actual_price;
								$invoice_data['total_discount_amount'] = $discount_price;
							}
						}

						$invoice_id = DB::table('invoices')->insertGetId($invoice_data);

						DB::table('invoice_items')->insert(
							[
								'invoice_id' => $invoice_id,
								'description' => $event->data->object->description,
								'quantity' => 1,
								'amount' => $event->data->object->amount,
								'currency' => $event->data->object->currency,
								'created_at' => Carbon::now(),
								'updated_at' => Carbon::now()
							]
						);

						$data = array(
							'vendor_id' => $temp_record->vendor_id,
							'store_id' => $temp_record->store_id,
							'card_id' => $temp_record->card_id,
							'subscription_item_id' => $temp_record->subscription_item_id,
							'membership_id' => $temp_record->membership_id,
							'membership_code' => $temp_record->membership_code,
							'membership_item_id' => $temp_record->membership_item_id,
							'membership_coupon_id' => $temp_record->membership_coupon_id,
							'extra_license' => $temp_record->extra_license,
							'start_date' => $temp_record->start_date,
							'end_date' => $temp_record->end_date,
							'status' => $temp_record->status
						);
						// print_r($data);
						$store_subscription = StoreSubscription::updateOrCreate(
							['subscription_id' => $temp_record->subscription_id],
							$data
						);

						$invoice = Invoice::with(['invoiceItems', 'membershipCoupon', 'vendor', 'vendorStore'])
							->where('invoices.id', $invoice_id)
							->first();

						DB::table('store_subscription_temps')->where('id', $temp_record->id)->delete();

						Mail::to($invoice->vendor->email)->send(new InvoiceSuccessMail($invoice));
					}
					break;

				case "invoice.payment_succeeded":
					DB::table('invoices')
						->where('invoice_id', $event->data->object->id)
						->update(['invoice_status' => $event->data->object->status, 'updated_at' => Carbon::now()]);

					$invoice = Invoice::with(['invoiceItems', 'membershipCoupon', 'vendor', 'vendorStore'])
						->where('invoices.invoice_id', $event->data->object->id)
						->first();
					if(!empty($invoice)){

						$temp_record = DB::table('store_subscription_temps')
							->where('subscription_id', $event->data->object->subscription)
							->first();

						if(!empty($temp_record)){

							$data = array(
								'vendor_id' => $temp_record->vendor_id,
								'store_id' => $temp_record->store_id,
								'card_id' => $temp_record->card_id,
								'subscription_item_id' => $temp_record->subscription_item_id,
								'membership_id' => $temp_record->membership_id,
								'membership_code' => $temp_record->membership_code,
								'membership_item_id' => $temp_record->membership_item_id,
								'membership_coupon_id' => $temp_record->membership_coupon_id,
								'extra_license' => $temp_record->extra_license,
								'start_date' => $temp_record->start_date,
								'end_date' => $temp_record->end_date,
								'status' => $temp_record->status
							);
							// print_r($data);
							$store_subscription = StoreSubscription::updateOrCreate(
								['subscription_id' => $temp_record->subscription_id],
								$data
							);

							DB::table('store_subscription_temps')->where('id', $temp_record->id)->delete();

							Mail::to($invoice->vendor->email)->send(new InvoiceSuccessMail($invoice));
						}
					}
					break;

				case "invoice.payment_failed":
					$user = DB::table('vendors')
						->select('name', 'email', 'stripe_customer_id')
						->where('stripe_customer_id', $event->data->object->customer)
						->first();

					if(!empty($user)){
						$user->description = $event->data->object->lines->data[1]->plan->nickname;
						$user->total = $event->data->object->amount_due;
						$subscription = DB::table('store_subscription_temps')->where('subscription_id', $event->data->object->subscription)->first();

						if(!empty($subscription)){
							try {

								Stripe\Stripe::setApiKey($this->stripe_secret);
								$card = Stripe\Customer::retrieveSource(
									$user->stripe_customer_id,
									$subscription->card_id
								);

								Mail::to($user->email)->send(new InvoiceFailedMail($user, $card));

								if($subscription->plan_type == 'change') {
									DB::table('store_subscription_temps')->where('id', $subscription->id)->delete();
								}
							} catch(\Stripe\Exception\CardException $e) {
					
							} catch (\Stripe\Exception\RateLimitException $e) {
							
							} catch (\Stripe\Exception\InvalidRequestException $e) {
							
							} catch (\Stripe\Exception\AuthenticationException $e) {
							
							} catch (\Stripe\Exception\ApiConnectionException $e) {
							
							} catch (\Stripe\Exception\ApiErrorException $e) {
							
							} catch (Exception $e) {
								
							}
						}
					}
					break;

				case "customer.subscription.deleted":
					$temp_record = StoreSubscriptionTemp::where('subscription_id', $event->data->object->id)->first();
					if(!empty($temp_record)){
						DB::table('store_subscription_temps')->where('subscription_id', $event->data->object->id)->delete();
					}else{
						DB::table('store_subscriptions')->where('subscription_id', $event->data->object->id)->delete();
					}
					break;

				case "invoice.created":
					$temp_record = StoreSubscriptionTemp::where('subscription_id', $event->data->object->subscription)->first();
					if(!empty($temp_record)){

						$invoice_data = [
							'vendor_id' => $temp_record->vendor_id,
							'store_id' => $temp_record->store_id,
							'membership_coupon_id' => $temp_record->membership_coupon_id,
							'invoice_number' => $event->data->object->number,
							'subscription_id' => $event->data->object->subscription,
							'invoice_id' => $event->data->object->id,
							'customer_id' => $event->data->object->customer,
							'billing_email' => $event->data->object->customer_email,
							'currency' => $event->data->object->currency,
							'subtotal' => $event->data->object->subtotal,
							//'total_discount_amount' => $event->data->object->total_discount_amounts[0]->amount,
							'total' => $event->data->object->total,
							'starting_balance' => $event->data->object->starting_balance,
							'amount_due' => $event->data->object->amount_due,
							'amount_paid' => $event->data->object->amount_paid,
							'amount_remaining' => $event->data->object->amount_remaining,
							'invoice_status' => $event->data->object->status,
							'invoice_created_date' => date("Y-m-d H:i:s", $event->data->object->created),
							'user_type' => 'vendor',
							'created_at' => Carbon::now(),
							'updated_at' => Carbon::now()
						];

						if(!empty($event->data->object->total_discount_amounts)){
							$invoice_data['total_discount_amount'] = $event->data->object->total_discount_amounts[0]->amount;
						}

						$extra_license_str = '';
						if(!empty($temp_record->extra_license)) {
							$number_str = '';
							if($temp_record->extra_license == 1) {
								$number_str = 'one';
							} else if($temp_record->extra_license == 2) {
								$number_str = 'two';
							}
							$extra_license_str = ' with ' . $number_str . ' extra license';
						}

						$invoice_id = DB::table('invoices')->insertGetId($invoice_data);

						foreach($event->data->object->lines->data as $data)
						{
							DB::table('invoice_items')->insert(
								[
									'invoice_id' => $invoice_id,
									'description' => $data->description.$extra_license_str,
									'quantity' => $data->quantity,
									'amount' => $data->amount,
									'currency' => $data->currency,
									'created_at' => Carbon::now(),
									'updated_at' => Carbon::now()
								]
							);
						}
					}
					break;
			}
		}
		exit();
	}
}
