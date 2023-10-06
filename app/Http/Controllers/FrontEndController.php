<?php

namespace App\Http\Controllers;

use Mail;
use View;
use Share;
use Config;
use Session;
use App\City;
use App\User;
use App\State;
use Exception;
use Validator;
use App\Rating;
use App\Vendor;
use App\UsState;
use App\PageMeta;
use App\Products;
use App\W2bOrder;
use Carbon\Carbon;
use Stripe\Charge;
use Stripe\Stripe;
use App\BestSeller;
use App\W2bProduct;
use App\WbWishlist;
use App\BestProduct;
use App\W2bCategory;
use PayPal\Api\Item;
use Stripe\Customer;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use App\OrderedProduct;
use PayPal\Api\Payment;
use PayPal\Api\ItemList;
use App\Jobs\RutiMailJob;
use App\Mail\WbOrderMail;
use App\Jobs\OrderMailJob;
use App\Mail\CartOrderMail;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use App\Jobs\SellerOrderJob;
use Illuminate\Http\Request;
use PayPal\Api\RedirectUrls;
use App\Mail\SellerOrderMail;
use App\Mail\WbRutiOrderMail;
use PayPal\Api\PaymentExecution;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use PayPal\Auth\OAuthTokenCredential;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Stevebauman\Location\Facades\Location;
use PayPal\Exception\PPConnectionException;

class FrontEndController extends Controller
{
    private $_api_context;
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


        $paypal_configuration = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);

	}


    public function optimize()
    {
        Artisan::call('optimize');
        Artisan::call('cache:clear');

        return 'Cache cleared and Optimization completed.';
    }


    public function index(Request $request)
    {
        $ip = '162.159.24.227'; /* Static IP address */
        $currentUserInfo =  Location::get($ip);


		return view('front_end.index');
    }



    public function dmca()
    {


    	return view('front_end.dmca');
    }

    public function termsCondition()
    {

    	return view('front_end.terms-condition');
    }

    public function privacyPolicy()
    {

    	return view('front_end.privacy-policy');
    }

    public function readFirst()
    {
        $details = [
            'title' => 'Nature Checkout Order #AZ123',
            'body' => 'Dear User'
        ];

        // dispatch(new OrderMailJob($details))->delay(now()->addSeconds(30));
        // dispatch(new RutiMailJob($details2))->delay(now()->addSeconds(30));
        Mail::to('muhammadaatir.30@gmail.com')->send(new WbRutiOrderMail($details));

        return view('front_end.read-first');
    }

    public function blog()
    {

        return view('front_end.blog.blog');
    }


    public function shop()
    {


        $categories1 = W2bCategory::whereIn('id', [1, 6, 9,12,20,23,29,69])
        ->get();

        $sold = rand(20, 50);
        $available = rand(60, 99);

        $product1 = W2bProduct::select('sku','title','w2b_category_1','brand','retail_price', 'slug','original_image_url')->orderBy('sku','DESC')->skip(4)->first();
        //  dd($product1);
        $product2 =  W2bProduct::select('sku','title','w2b_category_1','retail_price', 'slug','original_image_url')->orderBy('sku','DESC')->skip(3)->first();
        $product3 =  W2bProduct::select('sku','title','w2b_category_1','retail_price', 'slug','original_image_url')->orderBy('sku','DESC')->skip(50)->first();
        $product4 = W2bProduct::select('sku','title','w2b_category_1','retail_price', 'slug','original_image_url')->orderBy('sku','DESC')->skip(80)->first();
        $product5 = W2bProduct::select('sku','title','w2b_category_1','retail_price', 'slug','original_image_url')->orderBy('sku','DESC')->skip(10)->first();
        $product6 = W2bProduct::select('sku','title','w2b_category_1','retail_price', 'slug','original_image_url')->orderBy('sku','DESC')->skip(120)->first();
        $product7 = W2bProduct::select('sku','title','w2b_category_1','retail_price', 'slug','original_image_url')->orderBy('sku','DESC')->skip(14)->first();
        $product8 = W2bProduct::select('sku','title','w2b_category_1','retail_price', 'slug','original_image_url')->orderBy('sku','DESC')->skip(131)->first();
        $product9 = W2bProduct::select('sku','title','w2b_category_1','retail_price', 'slug','original_image_url')->orderBy('sku','DESC')->skip(20)->first();
        $product10 = W2bProduct::select('sku','title','w2b_category_1','retail_price', 'slug','original_image_url')->orderBy('sku','DESC')->skip(132)->first();



        $products = W2bProduct::select('sku','title','w2b_category_1','retail_price', 'slug','large_image_url_250x250','original_image_url')->inRandomOrder()->limit(3000)->paginate(6);
        return view('front_end.shop',compact('products',
        'categories1','sold','available','product1','product2','product3','product4','product5',
        'product6','product7','product8','product9','product10'));
    }
    public function catName($cate)
    {

        $p1 = DB::table('w2b_categories')
        ->join('w2b_products', 'w2b_categories.category1', '=', 'w2b_products.w2b_category_1')
        ->select('w2b_products.*')
        ->where('w2b_products.w2b_category_1', $cate)
        ->distinct()
        ->get();

        $p2 = DB::table('w2b_categories')
        ->join('products', 'w2b_categories.category1', '=', 'products.w2b_category_1')
        ->select('products.*')
        ->where('products.w2b_category_1', $cate)
        ->distinct()
        ->get();
        $products = $p2->merge($p1)->paginate(24);

        $cat_name = $cate;

        return view('front_end.cat_products', compact('products','cat_name'));
    }
    public function autocomplete(Request $request)
    {
        $p1 = DB::table('w2b_products')->select('title')
        ->where('title', 'like', "%{$request->term}%")
        ->pluck('title');
        $p2 = DB::table('products')->select('title')
        ->where('title', 'like', "%{$request->term}%")
        ->pluck('title');

        return $p2->merge($p1);
    }

    public function shopSearch(Request $request)
    {

        $query = $request->input('query');
        $p1 = DB::table('w2b_products')->where('title', 'like', "%$query%")->get();
        $p2 = DB::table('products')->where('title', 'like', "%$query%")->get();
        $products = $p2->merge($p1)->paginate(24);


        return view('front_end.search-products', compact('products'));
    }

    public function ProductDetail($slug, $sku)
    {


        $shareComponent = Share::page(
            'http://www.naturecheckout.com//shop/product_detail/'.$slug.'/'.$sku,
            'Your share text comes here',
        )
        ->facebook()
        ->twitter()
        ->linkedin()
        ->telegram()
        ->whatsapp()
        ->reddit();

        $p1 = DB::table('w2b_products')
        ->where('sku', $sku)
        ->first();

        if ($p1 == Null) {
            $product = Products::with('vendor')->where('sku', $sku)->first();
            // dd($product);
        }
        else {
            $product = W2bProduct::with('vendor')->where('sku', $sku)->first();
            // dd($product);
        }



        $rps1 = DB::table('w2b_products')
        ->where('w2b_category_1', $product->w2b_category_1)
        ->inRandomOrder()->limit(2000)->get();
        $rps2 = DB::table('products')
        ->where('w2b_category_1', $product->w2b_category_1)
        ->inRandomOrder()->limit(2000)->get();
        $related_productss = $rps2->merge($rps1)->paginate(8);



        $rp1 = DB::table('w2b_products')
        ->where('w2b_category_1', $product->w2b_category_1)
        ->inRandomOrder()->limit(2000)->get();
        $rp2 = DB::table('products')
        ->where('w2b_category_1', $product->w2b_category_1)
        ->inRandomOrder()->limit(2000)->get();
        $related_products = $rp2->merge($rp1)->paginate(8);

        $ratings = Rating::where('product_id', $sku)->get();
        return view('front_end.product-detail',compact('product','ratings','related_products','related_productss','shareComponent'));
    }
    public function wishlist($sku)
    {
        // dd($sku);
        $gg = WbWishlist::create([
            'user_id' => Auth::guard('w2bcustomer')->user()->id,
            'product_id' => $sku,
        ]);
        // dd($gg);
        return redirect()->back();
    }
    public function wishlistPage()
    {
        $wb_wishlist = null;

        if (Auth::guard('w2bcustomer')->user()) {
            $wb_wishlist = WbWishlist::where('user_id', Auth::guard('w2bcustomer')->user()->id)
            ->get();
        }
        $wish_products =  WbWishlist::join('w2b_products', 'wb_wishlists.product_id', '=', 'w2b_products.sku')
        ->where('user_id', Auth::guard('w2bcustomer')->user()->id)
        ->select('w2b_products.*')
        ->get();

        // dd($gg);
        return view('front_end.wishlist',compact('wish_products','wb_wishlist'));
    }
    public function removeWishlist($sku)
    {
        $wl = WbWishlist::where('product_id',$sku)->first();
        $wl->delete();
        return redirect()->back()->with('success', 'Product removed from wishlist successfully!');
    }
    public function rating(Request $request)
    {
        $input = $request->all();
        Rating::create($input);
        return redirect()->back();
    }

    public function voteBestSeller(Request $request)
    {
        if (Auth::guard('w2bcustomer')->user()) {
            BestSeller::create([
                'vendor_id' => $request->vendor_id,
                'user_id' => Auth::guard('w2bcustomer')->user()->id
            ]);
        }
        else {
            BestSeller::create([
                'vendor_id' => $request->vendor_id,
                'user_id' => Null
            ]);
        }
        return redirect()->back()->with('success', 'Thank you for voting best seller');


    }
    public function voteBestProduct(Request $request)
    {
        if (Auth::guard('w2bcustomer')->user()) {
            BestProduct::create([
                'product_sku' => $request->product_sku,
                'user_id' => Auth::guard('w2bcustomer')->user()->id
            ]);
        }
        else {
            BestProduct::create([
                'product_sku' => $request->product_sku,
                'user_id' => Null
            ]);
        }
        return redirect()->back()->with('success', 'Thank you for voting best product');
    }
    public function cart()
    {

        $sp1 = DB::table('w2b_products')->inRandomOrder()->limit(2000)->get();
        $sp2 = DB::table('products')->where('status', 'enable')->inRandomOrder()->limit(2000)->get();
        $suggested_products = $sp2->merge($sp1)->paginate(7);
        $suggested_products = $suggested_products->sortBy('title');

        return view('front_end.cart',compact('suggested_products'));
    }
    public function removeEverything()
    {
        session()->forget('cart');
        return redirect('/');
    }
    public function addToCart($sku)
    {
        try {
            $p1 = DB::table('w2b_products')
                ->where('sku', $sku)
                ->first();

            if ($p1 ==  Null) {
                $product = DB::table('products')
                    ->where('sku', $sku)
                    ->first();
            } else {
                $product = DB::table('w2b_products')
                    ->where('sku', $sku)
                    ->first();
            }

            if (!$product) {
                // Product not found, you can handle this situation as needed
                return redirect()->back()->with('error', 'Product not found.');
            }

            $cart = session()->get('cart', []);

            if (isset($cart[$sku])) {
                $cart[$sku]['quantity']++;
            } else {
                $cart[$sku] = [
                    "title" => $product->title,
                    "quantity" => 1,
                    "retail_price" => $product->retail_price,
                    "original_image_url" => $product->original_image_url,
                    "shipping_price" => $product->shipping_price,
                    "sales_tax_pct" => $product->sales_tax_pct,
                    "vendor_id" => $product->vendor_id,
                    "seller_type" => $product->seller_type
                ];
            }

            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        } catch (\Exception $e) {
            // Handle the exception here
            return redirect()->back()->with('error', $e.' An error occurred while adding the product to the cart.');
        }
    }

    public function addToCart1($sku)
    {
        $p1 = DB::table('w2b_products')
        ->where('sku', $sku)
        ->first();
        if ($p1 ==  Null) {
            $product = DB::table('products')
            ->where('sku', $sku)
            ->first();
        }
        else {
            $product = DB::table('w2b_products')
            ->where('sku', $sku)
            ->first();
        }

        $cart = session()->get('cart', []);

        if(isset($cart[$sku])) {
            $cart[$sku]['quantity']++;
        } else {
            $cart[$sku] = [
                "title" => $product->title,
                "quantity" => 1,
                "retail_price" => $product->retail_price,
                "original_image_url" => $product->original_image_url,
                "shipping_price" => $product->shipping_price,
                "sales_tax_pct" => $product->sales_tax_pct,
                "vendor_id" => $product->vendor_id,
                "seller_type" => $product->seller_type
            ];
        }


        session()->put('cart', $cart);

        return redirect('/cart')->with('success', 'Product added to cart successfully!');
    }

    public function updateCart(Request $request)
    {
        if($request->sku && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->sku]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function removeCart(Request $request)
    {
        if($request->sku) {
            $cart = session()->get('cart');
            if(isset($cart[$request->sku])) {
                unset($cart[$request->sku]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }

    public function checkout()
    {
        // $cart = session()->get('cart');
        // dd($cart);

        $states = State::where('country_id',231)->get();
        return view('front_end.checkout',compact('states'));
    }
    public function state($state_id)
    {
        $cities = City::where('state_id',$state_id)->get();
        return response()->json($cities);
    }

    public function postCheckout(Request $request)
    {


            $cart = session()->get('cart');
            // $suppliersIds = collect($cart)->pluck('vendor_id')->unique()->toArray();


            if ($user = Auth::guard('w2bcustomer')->user()) {
                $request->validate([
                    'zip_code' => 'required',
                    'state' => 'required',
                    'city' => 'required',
                    'address' => 'required'
                ]);
                $user->update([
                    'state' => $request->state,
                    'city' => $request->city,
                    'address' => $request->address,
                    'address2' => $request->address2,
                    'zip_code' => $request->zip_code
                ]);
            }
            else
                {

                    if ($request->password)
                    {

                        $request->validate([
                        'first_name' => 'required',
                        'last_name' => 'required',
                        'email' => 'required|email|unique:users',
                        'zip_code' => 'required',
                        'mobile' => 'required',
                        'state' => 'required',
                        'city' => 'required',
                        'address' => 'required',
                        'password' => 'required'
                        ],
                        [
                        'email.unique' => 'The Email has already been taken. Please login first to continue',
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

                    }
                        else {
                            $request->validate([
                            'first_name' => 'required',
                            'last_name' => 'required',
                            'email' => 'required|unique:users',
                            'zip_code' => 'required',
                            'mobile' => 'required',
                            'state' => 'required',
                            'city' => 'required',
                            'address' => 'required'
                            ],
                            [
                            'email.unique' => 'The Email has already been taken. Please login first to continue',
                            ]);

                            $user = new User;
                            $user->first_name = $request->first_name;
                            $user->last_name = $request->last_name;
                            $user->email = $request->email;
                            $user->mobile = $request->mobile;
                            $user->state = $request->state;
                            $user->city = $request->city;
                            $user->zip_code = $request->zip_code;
                            $user->address = $request->address;
                            $user->address2 = $request->address2;
                            $user->save();
                        }
                }
                            $w2border = W2bOrder::create([

                            'total_price' => number_format((float)$request->total_price, 2, '.', ''),
                            'user_id' => $user->id,

                            'order_notes' => $request->order_notes,
                            'order_id' => strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 9))

                            ]);
                            $user_details = $user;

                            // $total_price1 = $w2border->total_price;
                            foreach($cart as $sku => $details) {
                                $tax = ($details['sales_tax_pct'] / 100) *  $details['retail_price'];
                                $tp = $details['retail_price'] * $details['quantity'];
                                $total_price_items = $tax + $tp + $details['shipping_price'];
                                OrderedProduct::create([
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
                                    'seller_type' => $details['seller_type']

                                ]);
                            }
                    session()->put('w2border', $w2border);
                    session()->put('user_details', $user_details);
                    return redirect('/payment-page');
    }

    public function notPaidMail()
    {
        $not_paid = DB::table('w2b_orders')->
        join('users', 'users.id', '=', 'w2b_orders.user_id')->
        where('w2b_orders.is_paid', 'no')
        ->whereDate( 'w2b_orders.created_at', '<=', now()->subDays(60))
        ->select('w2b_orders.*','users.email as user_email')
        ->get();
        // dd($not_paid);
        foreach ($not_paid as $np) {
            $date =  Carbon::parse($np->created_at)->format('d/m/Y');
            $details = [
                'title' => 'Your Application was last active ' . $date,
                'body' => "Hey there you have not orders a while and items are still in cart"
            ];
            Mail::to($np->user_email)->send(new CartOrderMail($details));
        }


    }
    public function paymentPage()
    {

        $sp1 = DB::table('w2b_products')->inRandomOrder()->limit(2000)->get();
        $sp2 = DB::table('products')->where('status', 'enable')->inRandomOrder()->limit(2000)->get();
        $suggested_products = $sp2->merge($sp1)->paginate(7);
        $suggested_products = $suggested_products->sortBy('title');
        $stripe_key = $this->stripe_key;

        return view('front_end.payment',compact('suggested_products','stripe_key'));
    }

    public function orderPayment(Request $request)
    {
        $w2border = session()->get('w2border');
        $user_details = session()->get('user_details');
        $order = W2bOrder::where('id', $w2border->id)->first();
        $order_detail = W2bOrder::where('order_id', $w2border->order_id)->first();

        Stripe::setApiKey($this->stripe_secret);

        $user = User::where('id', $w2border->user_id)->first();
        $customer = Customer::create(array(

            "email" => $user->email,

            "name" => $user->first_name,

            "source" => $request->stripeToken

         ));

        $charge = Charge::create ([

            "amount" => round($w2border->total_price * 100),

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
                'stripe_customer_id' => $customer->id,
            ]);
            $order->update([
                'is_paid' => 'yes',
            ]);
            $fname = ucfirst($user->first_name);
            $lname = ucfirst($user->last_name);

			$state_name = DB::table('states')->where('id',$user->state)->first();
			if(empty($state_name)){
				$state = NULL;
			}else{
				$state = $state_name->name;
			}
			$city_name = DB::table('cities')->where('id',$user->city)->first();
			if(empty($city_name)){
				$city = NULL;
			}else{
				$city = $city_name->name;
			}
            if(empty($user->zip_code)){
				$zip_code = NULL;
			}else{
				$zip_code = $user->zip_code;
			}
            $details = [
                'email' => $user->email,
                'name' => $fname.' '.$lname,
                'order_no' => $order_detail->order_id,
                'address' => $user->address,
                'city' => $city,
                'state' => $state,
                'zip_code' => $zip_code,
                'total_price' => $order_detail->total_price
            ];
            $details2 = [
                'name' => $fname.' '.$lname,
                'order_no' => $order_detail->order_id,
                'total_price' => $order_detail->total_price
            ];

            dispatch(new OrderMailJob($user_details->email, $details));
            // Mail::to($user_details->email)->send(new WbOrderMail($details));

            $admin_email = Config::get('app.admin_email');
            dispatch(new RutiMailJob($admin_email, $details2));
            // Mail::to($admin_email)->send(new WbRutiOrderMail($details2));
            if ($order_detail) {
                // Check if $order_detail is not null

                $orderedProducts = OrderedProduct::where('order_id', $order_detail->order_id)->get();

                foreach ($orderedProducts as $product) {
                    $seller_id = $product->vendor_id; // Assuming you have a relationship set up
                    $seller = Vendor::where('id', $seller_id)->first();

                    $details = [
                        'email' => $user->email,
                        'name' => $fname.' '.$lname,
                        'order_no' => $order_detail->order_id,
                        'address' => $user->address,
                        'city' => $city,
                        'state' => $state,
                        'zip_code' => $zip_code,
                    ];

                    // Send an email to the seller
                    dispatch(new SellerOrderJob($seller->email, $details));
                }
                } else {
                    return back();
                }
        }
        session()->forget('cart');
        session()->forget('w2border');
        session()->forget('user_details');
        return redirect('/thank-you-page');
        return ;
    }

    public function userWalletPayment(Request $request, $amount)
    {
        $w2border = session()->get('w2border');
        $user_details = session()->get('user_details');
        $order = W2bOrder::where('id', $w2border->id)->first();
        $order_detail = W2bOrder::where('order_id', $w2border->order_id)->first();
        $uid = Auth::guard('w2bcustomer')->user()->id;
        $user = User::where('id', $uid)->first();
        if ($user->wallet_amount < $amount) {
            return redirect()->back()->with('error', 'Your balance is not enough');
        }
        else {
            $debit = $user->wallet_amount - $amount;
            $user->update([
                'wallet_amount' => $debit,
            ]);
            $order->update([
                'is_paid' => 'yes',
            ]);
            $fname = ucfirst($user->first_name);
            $lname = ucfirst($user->last_name);
            $state_name = DB::table('states')->where('id',$user->state)->first();
			if(empty($state_name)){
				$state = NULL;
			}else{
				$state = $state_name->name;
			}
			$city_name = DB::table('cities')->where('id',$user->city)->first();
			if(empty($city_name)){
				$city = NULL;
			}else{
				$city = $city_name->name;
			}
            if(empty($user->zip_code)){
				$zip_code = NULL;
			}else{
				$zip_code = $user->zip_code;
			}
            $details = [
                'email' => $user->email,
                'name' => $fname.' '.$lname,
                'order_no' => $order_detail->order_id,
                'address' => $user->address,
                'city' => $city,
                'state' => $state,
                'zip_code' => $zip_code,
                'total_price' => $order_detail->total_price
            ];
            $details2 = [
                'name' => $fname.' '.$lname,
                'order_no' => $order_detail->order_id,
                'total_price' => $order_detail->total_price
            ];

            dispatch(new OrderMailJob($user_details->email, $details));
            // Mail::to($user_details->email)->send(new WbOrderMail($details));

            $admin_email = Config::get('app.admin_email');
            dispatch(new RutiMailJob($admin_email, $details2));
            // Mail::to($admin_email)->send(new WbRutiOrderMail($details2));
            if ($order_detail) {
                // Check if $order_detail is not null

                $orderedProducts = OrderedProduct::where('order_id', $order_detail->order_id)->get();

                foreach ($orderedProducts as $product) {
                    $seller_id = $product->vendor_id; // Assuming you have a relationship set up
                    $seller = Vendor::where('id', $seller_id)->first();

                    $details = [
                        'email' => $user->email,
                        'name' => $fname.' '.$lname,
                        'order_no' => $order_detail->order_id,
                        'address' => $user->address,
                        'city' => $city,
                        'state' => $state,
                        'zip_code' => $zip_code,
                    ];

                    // Send an email to the seller
                    dispatch(new SellerOrderJob($seller->email, $details));
                }
                } else {
                    return back();
                }

            session()->forget('cart');
            session()->forget('w2border');
            session()->forget('user_details');
        }
        return redirect('/thank-you-page');
    }


    public function thankYou()
    {

        $p1 = DB::table('w2b_products')->inRandomOrder()->limit(2000)->get();
        $p2 = DB::table('products')->where('status', 'enable')->inRandomOrder()->limit(2000)->get();
        $products = $p2->merge($p1)->paginate(32);
        $products = $products->sortBy('title');
        return view('front_end.thank-you',compact('products'));
    }


    public function trendingProducts()
    {
    //     $string = 'hEl#lo 1244nabeel 74bu%Tt';
    //     $string = str_replace(' ', '-', $string);

    // // Removes special chars.
    //     $string = preg_replace('/[^A-Za-z\-]/', '', $string);
    // // Replaces multiple hyphens with single one.
    //     $string = preg_replace('/-+/', '-', $string);
    // // Lowercase string
    //     $string = strtolower($string);
    //     // $words = preg_replace('/[0-9]+/', '', $str);

    //     // $words = preg_replace('/[^a-z ]/', '', $str);
    //     // $words = preg_replace('/[^a-z ]/', '', $str);

    //     dd($string);
        // $all_products = W2bProduct::all();
        // foreach ($all_products as $all_p) {
        //     $string = str_replace(' ', '-', $all_p->title);
        // // Removes special chars.
        //     $string = preg_replace('/[^A-Za-z\-]/', '', $string);
        // // Replaces multiple hyphens with single one.
        //     $string = preg_replace('/-+/', '-', $string);
        // // Lowercase string
        //     $string = strtolower($string);
        //     $all_p->update(['slug' => $string]);
        // }


        $p1 = DB::table('w2b_products')->inRandomOrder()->limit(2000)->get();
        $p2 = DB::table('products')->where('status', 'enable')->inRandomOrder()->limit(2000)->get();
        $products = $p2->merge($p1)->paginate(24);

        return view('front_end.trending_products',compact('products'));
    }

    public function specialOffers()
    {

        $p1 = DB::table('w2b_products')->inRandomOrder()->limit(2000)->get();
        $p2 = DB::table('products')->where('status', 'enable')->inRandomOrder()->limit(2000)->get();
        $products = $p2->merge($p1)->paginate(24);

        return view('front_end.special_offers',compact('products'));
    }

    public function paypalPayment(Request $request)
    {
        $w2border = session()->get('w2border');
        $order = W2bOrder::where('id', $w2border->id)->first();
        $user = User::where('id', $w2border->user_id)->first();
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

    	$item_1 = new Item();

        $item_1->setName('Product 1')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->get('amount'));

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request->get('amount'));

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Enter Your transaction description');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('paypal-payment-success'))
            ->setCancelUrl(URL::route('paypal-payment-error'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        try {
            $payment->create($this->_api_context);
        } catch (PPConnectionException $ex) {
            if (Config::get('app.debug')) {
                Session::put('error','Connection timeout');
                return Redirect::route('paywithpaypal');
            } else {
                Session::put('error','Some error occur, sorry for inconvenient');
                return Redirect::route('paywithpaypal');
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        Session::put('paypal_payment_id', $payment->getId());

        if(isset($redirect_url)) {
            return Redirect::away($redirect_url);
        }

        Session::put('error','Unknown error occurred');
    	return Redirect::route('paywithpaypal');
    }

    public function paypalPaymentSuccess(Request $request)
    {
        $payment_id = Session::get('paypal_payment_id');

        Session::forget('paypal_payment_id');
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            Session::put('error','Payment failed');
            return Redirect::route('paywithpaypal');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            \Session::put('success','Payment success !!');
            return Redirect::route('paywithpaypal');
        }

        \Session::put('error','Payment failed !!');
		return Redirect::route('paywithpaypal');
    }
    public function paypalPaymentError()
    {
        dd('error');
    }



    public function sentry()
    {
        throw new Exception('My first Sentry error!');
    }
    public function sessionFlush()
    {
        session()->flush();
    }
}
