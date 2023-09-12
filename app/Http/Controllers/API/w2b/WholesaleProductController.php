<?php

namespace App\Http\Controllers\API\w2b;

use App\BestProduct;
use App\BestSeller;
use App\User;
use Validator;
use App\W2bOrder;
use App\W2bCategory;
use App\OrderedProduct;
use App\Jobs\RutiMailJob;
use App\Mail\WbOrderMail;
use App\Jobs\OrderMailJob;
use Illuminate\Http\Request;
use App\Mail\WbRutiOrderMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class WholesaleProductController extends Controller
{
    private $stripe_secret;
    private $stripe_key;

    public function __construct()
	{
        $this->stripe_secret = config('services.stripe.secret');
        $this->stripe_key = config('services.stripe.key');
	}

    public function sendResponse($result, $message='')
    {
        $response = [
            'success' => true,
            'result'    => $result,
            'message' => $message,
        ];

        // return response()->json($response, 200, []);
        return response()->json($response, 200, [], JSON_PRESERVE_ZERO_FRACTION);
        // return response()->json($response, 200, [], JSON_PRESERVE_ZERO_FRACTION | JSON_NUMERIC_CHECK);
        // return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
        /*$json = json_encode( $response, JSON_PRESERVE_ZERO_FRACTION);
        $json = preg_replace( "/\"(\d+)\"/", '$1', $json );
        echo $json;exit();*/
    }
    public function index()
	{
        $products = DB::table('w2b_products')->paginate(15);
        return $this->sendResponse(['Wholesale2b' => $products], 'Wholesale2b_Products_list.');
    }
    public function categories()
	{
        $categories = W2bCategory::with('childrens')->get();
        return $this->sendResponse(['Wholesale2b_Categories' => $categories], 'Wholesale2b_Categories_list.');
    }

    public function get_products($cat_name)
	{
        $get_products = DB::table('w2b_categories')
        ->join('w2b_products', 'w2b_categories.category1', '=', 'w2b_products.w2b_category_1')
        ->select('w2b_products.*')
        ->where('w2b_products.w2b_category_1', $cat_name)
        ->distinct()
        ->paginate(28);
        return $this->sendResponse(['Wholesale2b_Category_products' => $get_products], 'Wholesale2b_Category_product_list.');
    }
    public function ProductDetail($sku)
    {
        $product = DB::table('w2b_products')
        ->where('sku', $sku)
        ->first();
        return $this->sendResponse(['Product_Details' => $product], 'single product details');
    }

    public function postCheckout(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'total_price' => 'required',
			'user_id' => 'required',
			'order_notes' => 'required',
			'price'=>'required',
			'title'=>'required',
			'quantity'=>'required',
			'image'=>'required',
			'sku'=>'required',
		]);
        $user = User::where('id', $request->user_id)->first();
        $fname = ucfirst($user->first_name);
        $lname = ucfirst($user->last_name);
        // $user = User::where('id',$userId)->first();
        $w2border = W2bOrder::create([

            'total_price' => $request->total_price,
            'user_id' => $request->user_id,

            'order_notes' => $request->order_notes,
            'order_id' => strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 9))

        ]);
        $ordered_products = [];

         $input = $request->except(['total_price','user_id','order_notes','order_id']);
            //  dd($input);
        foreach($input as $sku => $details) {

            $ordered_products[] = OrderedProduct::create([
                'sku' => $sku,
                'price' => $details['price'],
                'quantity' => $details['quantity'],
                'title' => $details['title'],
                'image' => $details['image'],
                'order_id' => $w2border->order_id

            ]);

        }
        $success = [];
        $success[] = array(
                    'w2border' => $w2border,
                    'ordered_products' => $ordered_products

                );
        $details = [
            'title' => 'Nature Checkout Order #'.$w2border->order_id,
            'body' => 'Dear '.$fname.' '.$lname,
            'email' => $user->email
        ];
        $details2 = [
            'title' => 'New Order Received #'.$w2border->order_id,
            'body' => 'A new Customer named '.$fname.' '.$lname.' has created an order',
            'email' => 'sales@naturecheckout.com'
        ];
        // dispatch(new OrderMailJob($details));
        // dispatch(new RutiMailJob($details2));
        Mail::to($user->email)->send(new WbOrderMail($details));
        Mail::to('sales@naturecheckout.com')->send(new WbRutiOrderMail($details2));

            return $this->sendResponse($success,'Your Order has been created successfully.');
    }
    public function postCheckout2(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'total_price' => 'required',
			'user_id' => 'required',
			'order_notes' => 'required',
			'price'=>'required',
			'title'=>'required',
			'quantity'=>'required',
			'image'=>'required',
			'sku'=>'required',
		]);
        $user = User::where('id', $request->user_id)->first();
        $fname = ucfirst($user->first_name);
        $lname = ucfirst($user->last_name);
        $w2border = W2bOrder::create([

            'total_price' => $request->total_price,
            'user_id' => $request->user_id,

            'order_notes' => $request->order_notes,
            'order_id' => strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 9))

        ]);
        $ordered_products = [];

         $input = $request->except(['total_price','user_id','order_notes','order_id']);

        foreach($input as $sku => $details) {

            $ordered_products[] = OrderedProduct::create([
                'sku' => $sku,
                'price' => $details[0]['price'],
                'quantity' => $details[0]['quantity'],
                'title' => $details[0]['title'],
                'image' => $details[0]['image'],
                'order_id' => $w2border->order_id

            ]);

        }
        $success = [];
        $success[] = array(
                    'w2border' => $w2border,
                    'ordered_products' => $ordered_products

                );
        $details = [
            'title' => 'Nature Checkout Order #'.$w2border->order_id,
            'body' => 'Dear '.$fname.' '.$lname,
            'email' => $user->email
        ];
        $details2 = [
            'title' => 'New Order Received #'.$w2border->order_id,
            'body' => 'A new Customer named '.$fname.' '.$lname.' has created an order',
            'email' => 'sales@naturecheckout.com'
        ];
        // for laravel mail job
          // dispatch(new OrderMailJob($details));
        // dispatch(new RutiMailJob($details2));
        Mail::to($user->email)->send(new WbOrderMail($details));
        Mail::to('sales@naturecheckout.com')->send(new WbRutiOrderMail($details2));

            return $this->sendResponse($success,'Your Order has been created successfully.');

    }

    public function payment(Request $request, $order_id, $user_id)
    {
        # code...
        $w2border = session()->get('w2border');
        $user_details = session()->get('user_details');
        $order = W2bOrder::where('id', $order_id)->first();
        $user = User::where('id', $user_id)->first();
        Stripe::setApiKey($this->stripe_secret);

        $customer = Customer::create(array(

            "email" => $user->email,

            "name" => $user->first_name,

            "source" => $request->stripeToken

         ));

        $charge = Charge::create ([

            "amount" => round($request->total_price * 100),

            "currency" => "usd",

            "customer" => $customer->id,

            "description" => "Payment from Nature Checkout",

            "shipping" => [

              "name" => $user->first_name,

              "address" => [

                "line1" => $user->address,

                "city" => $user->city,

                "country" => "US",

              ],

            ]

    ]);
    if ($charge) {
        $order->update([
            'is_paid' => 'yes',
        ]);
        $fname = ucfirst($user->first_name);
        $lname = ucfirst($user->last_name);
        $details = [
            'title' => 'Nature Checkout Order #'.$w2border->order_id,
            'body' => 'Dear '.$fname.' '.$lname,
            'email' => $user->email
        ];
        $details2 = [
            'title' => 'New Order Received #'.$w2border->order_id,
            'body' => 'A new Customer named '.$fname.' '.$lname.' has created an order',
            'email' => 'sales@naturecheckout.com'
        ];
        dispatch(new OrderMailJob($details))->delay(now()->addSeconds(30));
        dispatch(new RutiMailJob($details2))->delay(now()->addSeconds(30));
        // Mail::to($user_details->email)->send(new WbOrderMail($details));
        // Mail::to('sales@naturecheckout.com')->send(new WbRutiOrderMail($details2));
    }


        // session()->flash('success', 'Payment successful!');
        // return redirect('/thank-you-page');
        return ;
    }
    public function userOrder($userId)
    {
        $orders = W2bOrder::where('user_id', $userId)->get();

        return $this->sendResponse(['orders' => $orders], 'Wholesale2b_user_orders.');

    }

    public function orderedProduct($orderId)
    {
        $products = OrderedProduct::where('order_id',$orderId)->get();
        return $this->sendResponse(['ordered_products' => $products], 'Wholesale2b_user_ordered_products_according_to_order_id.');

    }

    public function singleOrder($orderId)
    {
        # code...
        $order = W2bOrder::where('id', $orderId)->first();
        return $this->sendResponse(['single_order' => $order], 'single_order_fetched_with_order_id.');

    }

    public function cancelOrder($orderId)
    {
        $cancel_order = W2bOrder::where('id', $orderId)
        ->update(['status' => 'cancelled']);
        return $this->sendResponse(['cancel_order' => $cancel_order], 'order_cancelled.');

    }
    public function repeatOrder($orderId)
    {
        $old_order = W2bOrder::where('id', $orderId)->first();
        // ->update(['status' => 'cancelled']);
        $w2border = W2bOrder::create([

            'total_price' => $old_order->total_price,
            'user_id' => $old_order->user_id,

            'order_notes' => $old_order->order_notes,
            'order_id' => $old_order->order_id

        ]);
        return $this->sendResponse(['order_repeat' => $w2border], 'order_repeat.');

    }

    public function bestProduct()
    {
        $p1 = BestProduct::join('w2b_products', 'w2b_products.sku', '=', 'best_products.product_sku')
        ->leftJoin('users', 'users.id', '=', 'best_products.user_id')
        ->selectRaw('w2b_products.sku as product_sku,
            w2b_products.title as product_title,
            COALESCE(users.first_name, "not defined") as user_fname,
            COALESCE(users.last_name, "not defined") as user_lname,
            COALESCE(users.mobile, "not defined") as user_phone,
            COALESCE(users.email, "not defined") as user_email');

        $p2 = BestProduct::join('products', 'products.sku', '=', 'best_products.product_sku')
        ->leftJoin('users', 'users.id', '=', 'best_products.user_id')
        ->selectRaw('products.sku as product_sku,
                products.title as product_title,
                COALESCE(users.first_name, "not defined") as user_fname,
                COALESCE(users.last_name, "not defined") as user_lname,
                COALESCE(users.mobile, "not defined") as user_phone,
                COALESCE(users.email, "not defined") as user_email');

        $best_products = $p1->union($p2)->get();



        return $this->sendResponse(['best_products' => $best_products], 'best_products_list.');
    }

    public function bestSeller()
    {
        $best_sellers = BestSeller::join('vendors', 'vendors.id', '=', 'best_sellers.vendor_id')
            ->leftJoin('users', 'users.id', '=', 'best_sellers.user_id')
            ->selectRaw('vendors.name as vendor_name, vendors.mobile_number as vendor_phone,
                COALESCE(users.first_name, "Not defined") as user_fname,
                COALESCE(users.last_name, "Not defined") as user_lname,
                COALESCE(users.mobile, "Not defined") as user_phone,
                COALESCE(users.email, "Not defined") as user_email')
            ->get();


        return $this->sendResponse(['best_sellers' => $best_sellers], 'best_sellers_list.');
    }

}
