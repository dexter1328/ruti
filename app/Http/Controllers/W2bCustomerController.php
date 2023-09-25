<?php

namespace App\Http\Controllers;

use View;
use App\User;
use App\PageMeta;
use App\W2bOrder;
use Carbon\Carbon;
use Stripe\Charge;
use Stripe\Stripe;
use App\ReturnItem;
use App\UserDevice;
use App\W2bProduct;
use App\WbWishlist;

use App\GiftReceipt;
use App\W2bCategory;
use Stripe\Customer;
use App\CustomerWallet;
use App\OrderedProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Exception\CardException;
use Illuminate\Support\Facades\Auth;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\RateLimitException;
use Stripe\Exception\ApiConnectionException;
use Stripe\Exception\AuthenticationException;
use Stripe\Exception\InvalidRequestException;

class W2bCustomerController extends Controller
{

    private $stripe_secret;
    private $stripe_key;

    public function __construct()
	{

		$page_meta = PageMeta::pluck('meta_value', 'meta_key')->all();
		View::share('page_meta', $page_meta);

        $categories = W2bCategory::with('childrens')->get();
        View::share('categories', $categories);
        $categories2 = W2bCategory::whereIn('id', [1, 6, 9,12,20,23])->get();
        View::share('categories2', $categories2);
        $wb_wishlist = null;

        if (Auth::guard('w2bcustomer')->user()) {
            $wb_wishlist = WbWishlist::where('user_id', Auth::guard('w2bcustomer')->user()->id)
            ->get();
        }
        View::share('wb_wishlist', $wb_wishlist);


        $this->stripe_secret = config('services.stripe.secret');
        $this->stripe_key = config('services.stripe.key');


	}

    public function sendError($error, $errorMessages = [], $code = 200)
    {
        $response = [
            'success' => false,
            'data' => null,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
    //
    public function userAccount($filter = "orders")
    {

        if ($filter == "shipped") {
            # code...
            $orders = DB::table('w2b_orders')
            ->where('w2b_orders.user_id', Auth::guard('w2bcustomer')->user()->id)
            ->where('w2b_orders.is_paid','yes')
            ->where('w2b_orders.status','shipped')
            ->get();
            // dd('123');
        }
        elseif ($filter == 'cancelled') {
            # code...
            $orders = DB::table('w2b_orders')
            ->where('w2b_orders.user_id', Auth::guard('w2bcustomer')->user()->id)
            ->where('w2b_orders.is_paid','yes')
            ->where('w2b_orders.status','cancelled')
            ->get();
            // dd('124');
        }
        elseif ($filter == 'processing') {
            $orders = DB::table('w2b_orders')
            ->where('w2b_orders.user_id', Auth::guard('w2bcustomer')->user()->id)
            ->where('w2b_orders.is_paid','yes')
            ->where('w2b_orders.status','processing')
            ->get();
        }
        elseif ($filter == 'delivered') {
            $orders = DB::table('w2b_orders')
            ->where('w2b_orders.user_id', Auth::guard('w2bcustomer')->user()->id)
            ->where('w2b_orders.is_paid','yes')
            ->where('w2b_orders.status','delivered')
            ->get();
        }
        elseif ($filter == 'orders'){
            $orders = DB::table('w2b_orders')
            ->where('w2b_orders.user_id', Auth::guard('w2bcustomer')->user()->id)
            ->where('w2b_orders.is_paid','yes')
            ->get();
        }
        elseif ($filter == 'onemonth'){
            $orders = DB::table('w2b_orders')
            ->where('w2b_orders.user_id', Auth::guard('w2bcustomer')->user()->id)
            ->where('w2b_orders.is_paid','yes')
            ->where('created_at', '>=', Carbon::now()->subDays(30)->toDateTimeString())->get();
        }
        elseif ($filter == 'threemonth'){
            $orders = DB::table('w2b_orders')
            ->where('w2b_orders.user_id', Auth::guard('w2bcustomer')->user()->id)
            ->where('w2b_orders.is_paid','yes')
            ->where('created_at', '>=', Carbon::now()->subDays(90)->toDateTimeString())->get();
        }
        elseif ($filter == '2023'){
            $orders = DB::table('w2b_orders')
            ->where('w2b_orders.user_id', Auth::guard('w2bcustomer')->user()->id)
            ->where('w2b_orders.is_paid','yes')
            ->where( DB::raw('YEAR(created_at)'), '=', '2023' )
            ->get();
        }
        elseif ($filter == '2022'){
            $orders = DB::table('w2b_orders')
            ->where('w2b_orders.user_id', Auth::guard('w2bcustomer')->user()->id)
            ->where('w2b_orders.is_paid','yes')
            ->where( DB::raw('YEAR(created_at)'), '=', '2022' )
            ->get();
        }
        elseif ($filter == '2021'){
            $orders = DB::table('w2b_orders')
            ->where('w2b_orders.user_id', Auth::guard('w2bcustomer')->user()->id)
            ->where('w2b_orders.is_paid','yes')
            ->where( DB::raw('YEAR(created_at)'), '=', '2021' )
            ->get();
        }
        else {
            $orders = DB::table('w2b_orders')
            ->where('w2b_orders.user_id', Auth::guard('w2bcustomer')->user()->id)
            ->where('w2b_orders.is_paid','yes')
            ->get();
        }
        $user = User::where('id', Auth::guard('w2bcustomer')->user()->id)->first();
        // dd($user_info);

        $stripe_key = $this->stripe_key;

        return view('front_end.user_account',compact('orders','user','stripe_key'));
    }
    public function userProduct($id)
    {


        $ordered_product1 = DB::table('w2b_orders')
        ->join('ordered_products', 'ordered_products.order_id', '=', 'w2b_orders.order_id')
        ->join('w2b_products', 'w2b_products.sku', '=', 'ordered_products.sku')
        ->where('w2b_orders.user_id', Auth::guard('w2bcustomer')->user()->id)
        ->where('w2b_orders.is_paid','yes')
        ->where('w2b_orders.order_id', $id)
        ->select('ordered_products.*','w2b_products.slug as slug', 'w2b_orders.order_id as p_order_id', 'w2b_orders.total_price as p_total_price',
         'w2b_orders.created_at as p_created_at', 'w2b_orders.status as p_status', 'w2b_orders.user_id as p_user_id');

         $ordered_product2 = DB::table('w2b_orders')
        ->join('ordered_products', 'ordered_products.order_id', '=', 'w2b_orders.order_id')
        ->join('products', 'products.sku', '=', 'ordered_products.sku')
        ->where('w2b_orders.user_id', Auth::guard('w2bcustomer')->user()->id)
        ->where('w2b_orders.is_paid','yes')
        ->where('w2b_orders.order_id', $id)
        ->select('ordered_products.*','products.slug as slug', 'w2b_orders.order_id as p_order_id', 'w2b_orders.total_price as p_total_price',
         'w2b_orders.created_at as p_created_at', 'w2b_orders.status as p_status', 'w2b_orders.user_id as p_user_id');
        //  dd($ordered_products);
        $ordered_products = $ordered_product2->union($ordered_product1)->get();


        return view('front_end.user_products',compact('ordered_products'));
    }

    public function orderInvoice($id)
    {

        $order = DB::table('w2b_orders')
        ->join('users', 'users.id', '=', 'w2b_orders.user_id')
        ->join('states', 'states.id', '=', 'users.state')
        ->join('cities', 'cities.id', '=', 'users.city')
        ->where('w2b_orders.order_id', $id)
        ->select('w2b_orders.*', 'users.first_name as fname','users.last_name as lname','users.email as email',
        'users.address as address','users.zip_code as zip_code','users.mobile as mobile','states.name as state_name','cities.name as city_name')
        ->first();
        // dd($order);

        $ordered_products = DB::table('w2b_orders')
        ->join('ordered_products', 'ordered_products.order_id', '=', 'w2b_orders.order_id')
        ->where('w2b_orders.user_id', Auth::guard('w2bcustomer')->user()->id)
        ->where('w2b_orders.is_paid','yes')
        ->where('w2b_orders.order_id', $id)
        ->select('ordered_products.*', 'w2b_orders.order_id as p_order_id', 'w2b_orders.total_price as p_total_price',
         'w2b_orders.created_at as p_created_at', 'w2b_orders.status as p_status')
        ->get();
        //   dd($ordered_products);


        return view('front_end.order_invoice',compact('order', 'ordered_products'));
    }

    public function userProfileUpdate(Request $request, $id)
    {
        //  dd($request->all());
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'confirmed'
        ]);

        if ($request->filled('password')) {
            $input = $request->except('password_confirmation');
            $input['password'] = bcrypt($request->password);
        }
        else {
            $input = $request->except('password_confirmation','password');
        }
        //  dd($input);

        if ($image = $request->file('image')) {
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('user_photo'), $imageName);
            $input['image'] = $imageName;
        }else{
            unset($input['image']);
        }
        $user = User::where('id', $id)->first();

        $user->update($input);

        return redirect()->back()->withInput(['tab' => 'profile']);
    }

    public function giftReceipt($orderId)
    {
        # code...


        return view('front_end.gift_receipt', compact('orderId'));

    }

    public function giftReceiptUpdate(Request $request, $orderId)
    {
        # code...
        // dd($request->all());

        $input = $request->all();
        //  dd($input);


        GiftReceipt::create($input);


        return redirect('/user-account');

    }

    public function returnItem($sku, $orderId, $userId)
    {

        $product = W2bProduct::where('sku', $sku)->first();
        return view('front_end.return_item', compact('sku','orderId','userId','product'));
    }

    public function returnItemSubmit(Request $request)
    {
        # code...
        $input = $request->all();
        ReturnItem::create($input);
        return redirect('/user-account')->with('success', 'Your Request is in process. One of our representative will contact you soon.');


    }

    public function addToWallet(Request $request)
    {
        # code...
        $uid = Auth::guard('w2bcustomer')->user()->id;
        $wallet = User::where('id', $uid)->first();
		Stripe::setApiKey($this->stripe_secret);
		 try {
            if ($wallet->stripe_customer_id) {
                $customer = $wallet->stripe_customer_id;
                // dd(122);
            }
            else {
                # code...
                $customer = Customer::create(array(

                    "email" => $wallet->email,

                    "name" => $wallet->first_name,

                    "source" => $request->stripeToken

                 ));
                 $wallet->update([
                    'stripe_customer_id' => $customer->id,
                 ]);
            }

            //  dd($customer->id);

                Charge::create ([
	                "amount" => $request->amount * 100,
	                "currency" => "usd",
	                "customer" => $wallet->stripe_customer_id,
	                "description" => "Money added in your wallet."
        		]);

        		$closing_amount = $wallet->wallet_amount+$request->amount;

				$customer_wallet = new CustomerWallet;
				$customer_wallet->customer_id = $uid;
				$customer_wallet->amount = $request->amount;
				$customer_wallet->closing_amount = $closing_amount;
				$customer_wallet->type = 'credit';
				$customer_wallet->save();

				if(empty($wallet->wallet_amount)){
					User::where('id',$uid)->update(array('wallet_amount'=>$request->amount));
				}else{
					$amount = $wallet->wallet_amount+$request->amount;
					User::where('id',$uid)->update(array('wallet_amount'=>$amount));
				}

				// notification
				$id = $customer_wallet->id;
				$type = 'wallet_transaction';
			    $title = 'Wallet';
			    $message = 'Money has been added to your wallet';
			    $devices = UserDevice::where('user_id',$wallet->id)->where('user_type','customer')->get();

			    return redirect()->back()->with('success', 'Money added to wallet');

            } catch(CardException $e) {
                $errors = $e->getMessage();
            } catch (RateLimitException $e) {
                $errors = $e->getMessage();
            } catch (InvalidRequestException $e) {
                $errors = $e->getMessage();
            } catch (AuthenticationException $e) {
                $errors = $e->getMessage();
            } catch (ApiConnectionException $e) {
                $errors = $e->getMessage();
            } catch (ApiErrorException $e) {
               $errors = $e->getMessage();
            } catch (Exception $e) {
                $errors = $e->getMessage();
            }

			return $this->sendError($errors);
    }

}
