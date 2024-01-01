<?php

namespace App\Http\Controllers\API\w2b;

use Config;
use App\Blog;
use App\City;
use App\User;
use App\Admin;
use App\State;
use Validator;
use App\Rating;
use App\Vendor;
use App\Country;
use App\Products;
use App\W2bOrder;
use Stripe\Charge;
use Stripe\Stripe;
use App\BestSeller;
use App\W2bProduct;
use App\AdminCoupon;
use App\BestProduct;
use App\W2bCategory;
use Stripe\Customer;
use App\OrderedProduct;
use App\Jobs\RutiMailJob;
use App\Mail\WbOrderMail;
use App\Jobs\OrderMailJob;
use App\Mail\WelcomeCoupon;
use App\Jobs\SellerOrderJob;
use Illuminate\Http\Request;
use App\Mail\WbRutiOrderMail;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;

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
        $p1 = W2bProduct::select('sku', 'title', 'w2b_category_1', 'retail_price', 'slug', 'original_image_url')
                    ->inRandomOrder()
                    ->limit(3000);
        $p2 = Products::select('sku', 'title', 'w2b_category_1', 'retail_price', 'slug', 'original_image_url')
                    ->inRandomOrder()
                    ->limit(3000);

        $products = $p2->union($p1)->paginate(18);


        return $this->sendResponse(['All_Products' => $products], 'Get_All_Products.');
    }

    public function categories()
	{
        $categories = W2bCategory::with('childrens')->get();
        return $this->sendResponse(['Get_Categories' => $categories], 'Get_All_Categories_list.');
    }

    public function get_products($cate)
    {
        $p1 = W2bCategory::join('w2b_products', 'w2b_categories.category1', '=', 'w2b_products.w2b_category_1')
            ->select('w2b_products.*')
            ->where('w2b_products.w2b_category_1', $cate)
            ->groupBy('w2b_products.title')
            ->paginate(24);

        $p2 = W2bCategory::join('products', 'w2b_categories.category1', '=', 'products.w2b_category_1')
            ->select('products.*')
            ->where('products.w2b_category_1', $cate)
            ->groupBy('products.title')
            ->paginate(24);

        $products = $p2->union($p1);

        return $this->sendResponse(['Category_products' => $products], 'Category_product_list.');
    }

    public function ProductDetail($sku)
    {
        $p1 = DB::table('w2b_products')
        ->where('sku', $sku)
        ->first();

        if ($p1 == Null) {
            $product = Products::where('sku', $sku)->first();
            // dd($product);
        }
        else {
            $product = W2bProduct::where('sku', $sku)->first();
            // dd($product);
        }

        return $this->sendResponse(['Product_Details' => $product], 'single product details');
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

            $best_products = BestProduct::join('products', 'products.sku', '=', 'best_products.product_sku')
        ->leftJoin('users', 'users.id', '=', 'best_products.user_id')
        ->selectRaw('products.sku as product_sku,
                products.title as product_title,
                COALESCE(users.first_name, "not defined") as user_fname,
                COALESCE(users.last_name, "not defined") as user_lname,
                COALESCE(users.mobile, "not defined") as user_phone,
                COALESCE(users.email, "not defined") as user_email')
                ->get();



        return $this->sendResponse(['best_products' => $best_products], 'best_products_list.');
    }

    public function bestProductId($productSku)
    {
        $today = Carbon::today(); // Get today's date

        $b_product = BestProduct::join('products', 'products.sku', '=', 'best_products.product_sku')
        ->selectRaw('best_products.*, products.title as product_title, products.original_image_url as product_image,
        (SELECT COUNT(*) FROM best_products WHERE product_sku = ?) AS total_vote_count,
        (SELECT COUNT(*) FROM best_products WHERE product_sku = ? AND DATE(created_at) = ?) AS today_vote_count',
        [$productSku, $productSku, $today])
        ->where('best_products.product_sku', $productSku)
        ->first();

        return $this->sendResponse(['best_Product' => $b_product], 'best_Product.');

    }



    public function bestSeller()
    {
        $best_sellers = BestSeller::join('vendors', 'vendors.id', '=', 'best_sellers.vendor_id')
        ->leftJoin('users', 'users.id', '=', 'best_sellers.user_id')
        ->selectRaw('best_sellers.user_id as user_id,vendors.id as vendor_id, vendors.name as vendor_name, vendors.mobile_number as vendor_phone,
            COALESCE(users.first_name, "Not defined") as user_fname,
            COALESCE(users.last_name, "Not defined") as user_lname,
            COALESCE(users.mobile, "Not defined") as user_phone,
            COALESCE(users.email, "Not defined") as user_email')
        ->get();



        return $this->sendResponse(['best_sellers' => $best_sellers], 'best_sellers_list.');
    }

    public function bestSellerId($vendorId)
    {
        $today = Carbon::today(); // Get today's date

        $b_seller = BestSeller::join('vendors', 'vendors.id', '=', 'best_sellers.vendor_id')
        ->selectRaw('best_sellers.*, vendors.name as vendor_name, vendors.image as vendor_image,
        (SELECT COUNT(*) FROM best_sellers WHERE vendor_id = ?) AS total_vote_count,
        (SELECT COUNT(*) FROM best_sellers WHERE vendor_id = ? AND DATE(created_at) = ?) AS today_vote_count',
        [$vendorId, $vendorId, $today])
        ->where('best_sellers.vendor_id', $vendorId)
        ->first();

        return $this->sendResponse(['best_seller' => $b_seller], 'best_seller.');

    }

    public function rating(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'user_email' => 'required|email',
            'product_id' => 'required',
            'star' => 'required|integer|between:1,5', // Assuming 'star' is an integer between 1 and 5.
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Create a new rating record
        $rating_data =  Rating::create([
            'user_name' => $request->input('user_name'),
            'user_email' => $request->input('user_email'),
            'product_id' => $request->input('product_id'),
            'star' => $request->input('star'),
            'comment' => $request->input('comment')
        ]);

        $rating = array(
        	'user_name' => $rating_data->user_name,
            'user_email' => $rating_data->user_email,
            'product_id' => $rating_data->product_id,
            'star' => $rating_data->star,
            'comment' => $rating_data->comment
    	);


        return $this->sendResponse(['Product_Rating' => $rating], 'Rating added successfully.');
    }

    public function ShowRating($product_sku)
    {
        $ratings = Rating::where('product_id', $product_sku)->get();

        return $this->sendResponse(['Product_Ratings' => $ratings], 'Product ratings or reviews fetched successfully.');

    }

    public function shopSearch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'query' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $query = $request->input('query');
        $p1 = DB::table('w2b_products')->where('title', 'like', "%$query%")->paginate(24);
        $p2 = DB::table('products')->where('title', 'like', "%$query%")->paginate(24);
        $products = $p2->union($p1);


        return $this->sendResponse(['Search_products' => $products], 'Searched Products fetched successfully.');

    }



    public function voteBestSeller(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required',
            'user_id' => 'nullable|integer', // Validate user_id if present
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $best_seller = BestSeller::create([
            'vendor_id' => $request->input('vendor_id'),
            'user_id' => $request->input('user_id') ?? null, // Use user_id from the request or set it to null
        ]);

        $best_sellers = array(
        	'vendor_id' => $best_seller->vendor_id,
            'user_id' => $best_seller->user_id
    	);

        return $this->sendResponse(['best_product' => $best_sellers], 'Best seller added successfully.');
    }
    public function voteBestProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_sku' => 'required',
            'user_id' => 'nullable|integer', // Validate user_id if present
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $best_product = BestProduct::create([
            'product_sku' => $request->input('product_sku'),
            'user_id' => $request->input('user_id') ?? null, // Use user_id from the request or set it to null
        ]);

        $best_products = array(
        	'product_sku' => $best_product->product_sku,
            'user_id' => $best_product->user_id
    	);

        return $this->sendResponse(['best_product' => $best_products], 'Best product added successfully.');
    }


    public function trendingProducts()
    {
        $p1 = W2bProduct::select('sku', 'title', 'w2b_category_1', 'retail_price', 'slug', 'original_image_url')
                    ->inRandomOrder()
                    ->limit(3000);
        $p2 = Products::select('sku', 'title', 'w2b_category_1', 'retail_price', 'slug', 'original_image_url')
                    ->inRandomOrder()
                    ->limit(3000);

        $trending_products = $p2->union($p1)->paginate(24);
        // You can customize the response structure as needed
        return $this->sendResponse(['Trending_products' => $trending_products], 'Trending Products fetched successfully.');
    }


    public function specialProducts(Request $request)
    {
        $p1 = W2bProduct::select('sku', 'title', 'w2b_category_1', 'retail_price', 'slug', 'original_image_url')
                    ->inRandomOrder()
                    ->limit(8000);
        $p2 = Products::select('sku', 'title', 'w2b_category_1', 'retail_price', 'slug', 'original_image_url')
                    ->inRandomOrder()
                    ->limit(8000);
        $special_products = $p2->union($p1)->paginate(24);

        // You can customize the response structure as needed
        return $this->sendResponse(['special_products' => $special_products], 'Special Products fetched successfully.');

    }

    public function SellerProduct($vendor_id)
    {
        // Check if there are products in the w2b_products table for the given vendor_id
        $w2b_products = DB::table('w2b_products')->where('vendor_id', $vendor_id)->paginate(24);

        // Use a ternary operator to determine which products to retrieve
        $seller_products = $w2b_products->isEmpty()
            ? DB::table('products')->where('vendor_id', $vendor_id)->paginate(24)
            : $w2b_products;

        return $this->sendResponse(['seller_products' => $seller_products], 'Seller Products fetched successfully.');
    }

    public function Country()
    {
        $countries =  Country::all();

        return $this->sendResponse(['countries' => $countries], 'Countries fetched successfully.');

    }

    public function State($country_id)
    {
        $states =  State::where('country_id' , $country_id)->get();

        return $this->sendResponse(['states' => $states], 'states fetched successfully.');

    }

    public function City($state_id)
    {
        $cities =  City::where('state_id' , $state_id)->get();

        return $this->sendResponse(['cities' => $cities], 'cities fetched successfully.');

    }

    public function postCheckout(Request $request)
    {
        // dd($request->all());
        $user = User::where('id', $request->user_id)->first();


        if (!$user) {
            // Validation rules for guest users
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->where(function ($query) use ($request) {
                        return $query->where('email', $request->input('email'));
                    }),
                ],
                'zip_code' => 'required',
                'mobile' => 'required',
                'state' => 'required',
                'city' => 'required',
                'address' => 'required',
                'password' => 'required',
            ], [
                'email.unique' => 'The email address is already registered. Please log in first to complete order.',
            ]);

            $user = new User;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->mobile = $request->mobile;
            $user->state = $request->state;
            $user->city = $request->city;
            $user->zip_code = $request->zip_code;
            $user->address = $request->address;
            $user->address2 = $request->address2;
            $user->save();
        } else {
            // Validation rules for authenticated users
            $request->validate([
                'zip_code' => 'required',
                'state' => 'required',
                'city' => 'required',
                'address' => 'required',
            ]);

            $user->update([
                'state' => $request->state,
                'city' => $request->city,
                'address' => $request->address,
                'address2' => $request->address2,
                'zip_code' => $request->zip_code
            ]);
        }

        $w2border = W2bOrder::create([
            'total_price' => number_format((float)$request->total_price, 2, '.', ''),
            'user_id' => $user->id,
            'order_notes' => $request->order_notes,
            'order_id' => strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 9)),
        ]);

        $ordered_products = [];
        $input = $request->all();
        // Assuming $input contains the expected structure
        foreach ($input['cart'] as $sku => $details) {
            $tax = ($details['sales_tax_pct'] / 100) * $details['retail_price'];
            $tp = $details['retail_price'] * $details['quantity'];
            $total_price_items = $tax + $tp + $details['shipping_price'];

            $orderedProduct = OrderedProduct::create([
                'sku' => $sku,
                'price' => $details['retail_price'],
                'quantity' => $details['quantity'],
                'sales_tax' => $tax,
                'shipping_price' => $details['shipping_price'],
                'total_price' => $total_price_items,
                'title' => $details['title'],
                'image' => $details['original_image_url'],
                'order_id' => $w2border->order_id,
                'vendor_id' => $details['vendor_id'],
                'seller_type' => $details['seller_type'],
                // Add other fields as needed
            ]);

            // Add the created ordered product to the array
            $ordered_products[] = $orderedProduct;
        }



        // You may want to return a JSON response instead of a redirect
        return response()->json([
            'message' => 'Order placed successfully',
            'order' => $w2border,
            'user_details' => $user,
            'products_details' => $ordered_products,
        ]);
    }

    public function processPayment(Request $request)
    {
        try {
            // Validate the incoming request data
            $request->validate([
                'user_id' => 'required|exists:users,id', // Ensure user_id exists in the users table
                'stripeToken' => 'required|string', // Stripe token from the frontend
                'order_id' => 'required|string', // Add validation for order_id if needed
                // Add any other validation rules you need
            ]);

            // Retrieve user details from the request (you can use authentication if needed)
            $userId = $request->input('user_id');
            $orderId = $request->input('order_id'); // Assuming order_id is provided
            $user = User::findOrFail($userId);

            // Process the payment with Stripe
            Stripe::setApiKey($this->stripe_secret);
            $customer = Customer::create([
                "email" => $user->email,
                "name" => $user->first_name,
                "source" => $request->stripeToken,
            ]);

            $totalPrice = number_format((float)$request->input('total_price'), 2, '.', '');
            $charge = Charge::create([
                "amount" => round($totalPrice * 100),
                "currency" => "usd",
                "customer" => $customer->id,
                "description" => "Payment from Nature Checkout",
                // Add shipping information if needed
            ]);

            if ($charge) {
                // Payment successful
                // Update the order and send emails to the user and sellers
                // ...

                // Update the user's stripe_customer_id and order's is_paid status
                $user->update(['stripe_customer_id' => $customer->id]);
                $userOrder = W2bOrder::where('order_id', $orderId)->firstOrFail();
                $userOrder->update(['is_paid' => 'yes']);

                // Prepare email details
                $fname = ucfirst($user->first_name);
                $lname = ucfirst($user->last_name);
                $stateName = DB::table('states')->where('id', $user->state)->first();
                $state = $stateName ? $stateName->name : null;
                $cityName = DB::table('cities')->where('id', $user->city)->first();
                $city = $cityName ? $cityName->name : null;
                $zipCode = $user->zip_code ?? null;

                $details = [
                    'email' => $user->email,
                    'name' => $fname . ' ' . $lname,
                    'order_no' => $userOrder->order_id,
                    'address' => $user->address,
                    'city' => $city,
                    'state' => $state,
                    'zip_code' => $zipCode,
                    'total_price' => $userOrder->total_price,
                ];

                // Send emails
                dispatch(new OrderMailJob($user->email, $details));
                // Mail::to($user_details->email)->send(new WbOrderMail($details));

                $adminEmail = config('app.admin_email');
                $details2 = [
                    'name' => $fname . ' ' . $lname,
                    'order_no' => $userOrder->order_id,
                    'total_price' => $userOrder->total_price,
                ];

                dispatch(new RutiMailJob($adminEmail, $details2));
                // Mail::to($adminEmail)->send(new WbRutiOrderMail($details2));

                if ($userOrder) {
                    // Check if $userOrder is not null

                    $orderedProducts = OrderedProduct::where('order_id', $userOrder->order_id)->get();

                    foreach ($orderedProducts as $product) {
                        $sellerId = $product->vendor_id; // Assuming you have a relationship set up
                        $seller = Vendor::where('id', $sellerId)->first();

                        $details = [
                            'email' => $user->email,
                            'name' => $fname . ' ' . $lname,
                            'order_no' => $userOrder->order_id,
                            'address' => $user->address,
                            'city' => $city,
                            'state' => $state,
                            'zip_code' => $zipCode,
                        ];

                        // Send an email to the seller
                        dispatch(new SellerOrderJob($seller->email, $details));
                    }
                } else {
                    return response()->json(['message' => 'Order not found'], 404);
                }

                return response()->json([
                    'message' => 'Payment successful',
                    'order_details' => $userOrder, // Include the order details if needed
                ], 200);
            } else {
                // Payment failed
                return response()->json(['message' => 'Payment failed'], 400);
            }
        } catch (\Exception $e) {
            // Handle exceptions here, log errors, and return an appropriate response
            return response()->json(['message' => 'Payment error: ' . $e->getMessage()], 500);
        }
    }


    public function blogList()
    {
        $latest_blogs = Blog::latest()->take(6)->get();
        $blogs = Blog::all();

        return response()->json(['latest_blogs' => $latest_blogs, 'blogs' => $blogs]);
    }

    public function showBlog($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        return response()->json(['blog' => $blog]);
    }

    public function adminCoupon()
    {
        $coupons =  AdminCoupon::all();
        return response()->json(['coupons' => $coupons]);
    }

    public function showCoupon($code)
    {
        $coupon = AdminCoupon::where('code', $code)->first();

        if (!$coupon) {
            return response()->json(['message' => 'Coupon not found'], 404);
        }

        return response()->json(['coupon' => $coupon]);
    }

    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');

        // Check the admin_coupons table for the validity of the coupon code
        $coupon = AdminCoupon::where('code', $couponCode)
            ->where('start_date', '<=', now())
            ->where('expire_date', '>=', now())
            ->where('status', 1)
            ->first();

        if ($coupon) {
            // Apply your coupon logic here
            // For example, you can retrieve the discount value from $coupon->discount

            // Assuming $coupon->discount_type is either 'percent' or 'fixed'
            $discountType = $coupon->discount_type;
            $discount = ($discountType == 'percent') ? ($coupon->discount / 100) * $request->total_price : $coupon->discount;

            $response = [
                'success' => true,
                'message' => 'Coupon applied successfully!',
                'discount' => $discount,
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Invalid coupon code or the coupon is not applicable at this time.',
            ];
        }

        return response()->json($response);
    }

    public function newsletter(Request $request)
    {
        $wel_coupon = AdminCoupon::where('code', 'WELCOMETOFAMILY')->first();
        // $request->all();
        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'coupon' => $wel_coupon->code
        ];
        Mail::to($request->email)->send(new WelcomeCoupon($details));

        return $this->sendResponse(['message' => 'Successfuly subscribed']);
    }



}
