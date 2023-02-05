<?php

namespace App\Http\Controllers\API\w2b;

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
            'title' => 'Ruti Self Checkout Order #'.$w2border->order_id,
            'body' => 'Dear '.$fname.' '.$lname,
            'email' => $user->email
        ];
        $details2 = [
            'title' => 'New Order Received #'.$w2border->order_id,
            'body' => 'A new Customer named '.$fname.' '.$lname.' has created an order',
            'email' => 'rutiorders@gmail.com'
        ];
        // dispatch(new OrderMailJob($details));
        // dispatch(new RutiMailJob($details2));
        Mail::to($user->email)->send(new WbOrderMail($details));
        Mail::to('rutiorders@gmail.com')->send(new WbRutiOrderMail($details2));

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
            'title' => 'Ruti Self Checkout Order #'.$w2border->order_id,
            'body' => 'Dear '.$fname.' '.$lname,
            'email' => $user->email
        ];
        $details2 = [
            'title' => 'New Order Received #'.$w2border->order_id,
            'body' => 'A new Customer named '.$fname.' '.$lname.' has created an order',
            'email' => 'rutiorders@gmail.com'
        ];
        dispatch(new OrderMailJob($details));
        dispatch(new RutiMailJob($details2));

            return $this->sendResponse($success,'Your Order has been created successfully.');

    }

    public function payment(Request $request, $order_id, $user_id)
    {
        # code...
        $w2border = session()->get('w2border');
        $user_details = session()->get('user_details');
        $order = W2bOrder::where('id', $order_id)->first();
        $user = User::where('id', $user_id)->first();
        Stripe::setApiKey('sk_test_51IarbDGIhb5eK2lSAhS5c8HvzuCmQh8CuCx81iR1hYfzSIwGpS1gLnTWs4xfhI9cwcpS8XYKbep9N8h1ZDSSxr0Y00NoFqGE3J');

        $customer = Customer::create(array(

            "email" => $user->email,

            "name" => $user->first_name,

            "source" => $request->stripeToken

         ));

        $charge = Charge::create ([

            "amount" => round($request->total_price * 100),

            "currency" => "usd",

            "customer" => $customer->id,

            "description" => "Payment from Ruti Self Checkout",

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
            'title' => 'Ruti Self Checkout Order #'.$w2border->order_id,
            'body' => 'Dear '.$fname.' '.$lname,
            'email' => $user->email
        ];
        $details2 = [
            'title' => 'New Order Received #'.$w2border->order_id,
            'body' => 'A new Customer named '.$fname.' '.$lname.' has created an order',
            'email' => 'rutiorders@gmail.com'
        ];
        dispatch(new OrderMailJob($details))->delay(now()->addSeconds(30));
        dispatch(new RutiMailJob($details2))->delay(now()->addSeconds(30));
        // Mail::to($user_details->email)->send(new WbOrderMail($details));
        // Mail::to('rutiorders@gmail.com')->send(new WbRutiOrderMail($details2));
    }


        // session()->flash('success', 'Payment successful!');
        return redirect('/thank-you-page');
        return ;
    }

}
