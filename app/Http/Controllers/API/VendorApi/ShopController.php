<?php

namespace App\Http\Controllers\API\VendorApi;

use App\Brand;
use App\CustomerWallet;
use Exception;
use App\Products;
use App\W2bCategory;
use App\OrderedProduct;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;
use App\Jobs\ProductReviewJob;
use App\Mail\AdminWithdrawMail;
use App\Mail\WithdrawMail;
use App\UserDevice;
use App\Vendor;
use App\WithdrawRequest;
use Illuminate\Support\Facades\Mail;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Exception\ApiConnectionException;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\AuthenticationException;
use Stripe\Exception\CardException;
use Stripe\Exception\InvalidRequestException;
use Stripe\Exception\RateLimitException;
use Stripe\Stripe;

class ShopController extends BaseController
{

    private $stripe_secret;

	public function __construct()
	{
		$this->stripe_secret = config('services.stripe.secret');
	}


    public function createProduct(Request $request)
    {
            // dd($request->all());
            // dd($request->file('image'));
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'meta_title' => 'required',
                'description' => 'required',
                'meta_description' => 'required',
                'meta_keywords' => 'nullable',
                'brand' => 'nullable',
                'category_name' => 'required',
                'retail_price' => 'required',
                'shipping_price' => 'required',
                'sku' => 'required|unique:products,sku',
                'stock' => 'required',
                'image' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }


            if($request->input('meta_keywords'))
            {
                $keywordsString = $request->input('meta_keywords');
                $keywordsArray = preg_split('/\r\n|[\r\n]/', $keywordsString, -1, PREG_SPLIT_NO_EMPTY);
                $keywordsArray = array_map('trim', $keywordsArray);
                $keywordsArray = array_unique($keywordsArray);
                $finalKeywordsString = implode(', ', $keywordsArray);
            }


            $category = W2bCategory::where('category1', $request->category_name)->first();

            $product = new Products();
            $product->vendor_id = Auth::guard('vendor-api')->user()->id;
            $product->seller_type = 'vendor';
            $product->w2b_category_1 = $category->category1 ?? null;
            $product->title = $request->input('title');
            $product->description = $request->input('description');
            $product->brand = $request->input('brand');
            $product->retail_price = $request->input('retail_price');
            $product->sku = $request->input('sku');
            $product->in_stock = 'Y';
            $product->shipping_price = $request->input('shipping_price');
            $product->stock = $request->input('stock');
            $product->meta_title = $request->input('meta_title');
            $product->meta_description = $request->input('meta_description');
            $product->meta_keywords = $finalKeywordsString ?? null;

            if($request->file('image')){
                foreach($request->file('image') as $key => $images){

                    $path = 'public/images/product_images';
                    $profileImage = date('YmdHis') .$key ."." . $images->getClientOriginalExtension();
                    $images->move($path, $profileImage);

                    if ($key == 0) {
                        $product->original_image_url = asset("$path/$profileImage");
                    }
                    if ($key == 1) {
                        $product->extra_img_1 = asset("$path/$profileImage");
                    }
                    if ($key == 2) {
                        $product->extra_img_2 = asset("$path/$profileImage");
                    }
                    if ($key == 3) {
                        $product->extra_img_3 = asset("$path/$profileImage");
                    }
                    if ($key == 4) {
                        $product->extra_img_4 = asset("$path/$profileImage");
                    }
                    if ($key == 5) {
                        $product->extra_img_5 = asset("$path/$profileImage");
                    }
                    if ($key == 6) {
                        $product->extra_img_6 = asset("$path/$profileImage");
                    }
                    if ($key == 7) {
                        $product->extra_img_7 = asset("$path/$profileImage");
                    }
                    if ($key == 8) {
                        $product->extra_img_8 = asset("$path/$profileImage");
                    }
                    if ($key == 9) {
                        $product->extra_img_9 = asset("$path/$profileImage");
                    }
                    if ($key == 10) {
                        $product->extra_img_10 = asset("$path/$profileImage");
                    }

                }
                //$product->where('sku', $request->input('sku'))->save();
                $product->save();
            }


            // You may want to return a JSON response with a success status code (e.g., 201)
            return $this->sendResponse($product, 'Product Created Successfully');

    }

    public function getProducts()
    {
        $products = Products::where('vendor_id' , Auth::guard('vendor-api')->user()->id)->where('seller_type', 'vendor')->get();
        return $this->sendResponse($products, 'All products of authenticated vendor Fetched Successfully');

    }


    public function allCategories()
    {
        $categories = W2bCategory::all();
        return $this->sendResponse($categories, 'All Categories Fetched Successfully');
    }

    public function singleCategory($category_name)
    {
        $category = W2bCategory::where('category1', $category_name)->first();

        return $this->sendResponse($category, 'Single Category Fetched Successfully');

    }


    public function updateProduct(Request $request,$sku)
	{
        $product = Products::where('sku', $sku)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'brand' => 'nullable',
            'w2b_category_1' => 'required',
            'retail_price' => 'required',
            'shipping_price' => 'nullable',
            "sku" => [
                "regex:/^[a-zA-Z0-9]+$/",
                "required", "min:2","max:20",
                Rule::unique('products')->ignore($product),
            ],
            'stock' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $category = W2bCategory::find($request->input('w2b_category_1'));

        $data['seller_type'] = 'vendor';
        $data['w2b_category_1'] = $request->input('w2b_category_1');
        $data['title'] = $request->input('title');
        $data['description'] = $request->input('description');
        $data['brand'] = $request->input('brand');
        $data['retail_price'] = $request->input('retail_price');
        $data['shipping_price'] = $request->input('shipping_price');
        $data['sku'] = $request->input('sku');
        $data['stock'] = $request->input('stock');
		if($request->file('image')){
            foreach($request->file('image') as $key => $images){

                $path = 'public/images/product_images';
                $profileImage = date('YmdHis') .$key ."." . $images->getClientOriginalExtension();
                $images->move($path, $profileImage);

                if ($key == 0) {
                    $data['original_image_url'] = asset("$path/$profileImage");
                }
                if ($key == 1) {
                    $data['extra_img_1'] = asset("$path/$profileImage");
                }
                if ($key == 2) {
                    $data['extra_img_2'] = asset("$path/$profileImage");
                }
                if ($key == 3) {
                    $data['extra_img_3'] = asset("$path/$profileImage");
                }
                if ($key == 4) {
                    $data['extra_img_4'] = asset("$path/$profileImage");
                }
                if ($key == 5) {
                    $data['extra_img_5'] = asset("$path/$profileImage");
                }
                if ($key == 6) {
                    $data['extra_img_6'] = asset("$path/$profileImage");
                }
                if ($key == 7) {
                    $data['extra_img_7'] = asset("$path/$profileImage");
                }
                if ($key == 8) {
                    $data['extra_img_8'] = asset("$path/$profileImage");
                }
                if ($key == 9) {
                    $data['extra_img_9'] = asset("$path/$profileImage");
                }
                if ($key == 10) {
                    $data['extra_img_10'] = asset("$path/$profileImage");
                }
            }


        }

        $product1 = Products::where('sku', $product->sku)->update($data);
        $product2 = Products::where('sku', $product->sku)->first();
		return $this->sendResponse($product2, 'Product Updated Successfully');
	}

    public function deleteProduct($sku)
    {
        $product2 = Products::where('sku', $sku)->delete();

        return response()->json(['message' => 'Product deleted successfully'], 201);
    }

    public function getBrands()
    {
        $brands = Brand::select('name','image','description')
        ->where('vendor_id', Auth::guard('vendor-api')->user()->id)->get();

        return $this->sendResponse($brands, 'Brands of auth vendor Fetched Successfully');


    }

    public function createBrand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'nullable',
            'image' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = array(
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'vendor_id' => Auth::guard('vendor-api')->user()->id,
            'created_by' => Auth::guard('vendor-api')->user()->id,
        );
        if ($files = $request->file('image')){

            $path = 'public/images/brands';
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($path, $profileImage);
            $data['image'] = $profileImage;
        }

        $brand = Brand::create($data);

        return $this->sendResponse($brand, 'Brand Created Successfully');

    }

    public function updateBrand(Request $request, $id)
    {
        $brand = Brand::where('id', $id)->firstOrFail();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = array(
            'name' => $request->input('name'),
            'description' => $request->input('description')
        );
        if ($files = $request->file('image')){

            $path = 'public/images/brands';
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($path, $profileImage);
            $data['image'] = $profileImage;
        }

        $brand1 = Brand::where('id', $brand->id)->update($data);
        $brand2 = Brand::where('id', $brand->id)->first();

        return $this->sendResponse($brand2, 'Brand Updated Successfully');
    }

    public function deleteBrand($id)
    {
        $brand = Brand::where('id', $id)->delete();

        return response()->json(['message' => 'Brand deleted successfully'], 201);
    }

    public function getOrders()
    {
        $op = OrderedProduct::join('w2b_orders', 'ordered_products.order_id', 'w2b_orders.order_id')
        ->join('users', 'w2b_orders.user_id', 'users.id')
        ->where('ordered_products.vendor_id', Auth::guard('vendor-api')->user()->id)
        ->where('w2b_orders.is_paid', 'yes')
        ->where('ordered_products.seller_type', 'vendor')
        ->groupBy('ordered_products.order_id')
        ->orderBy('ordered_products.id', 'DESC')
        ->select('w2b_orders.*', 'users.first_name as user_name', 'users.id as user_id', DB::raw('SUM(ordered_products.total_price) as o_total_price'))
        ->get();

        return response()->json(['data' => $op], 200);
    }

    public function orderDetail($orderId)
    {
        $od = OrderedProduct::join('w2b_orders', 'ordered_products.order_id', 'w2b_orders.order_id')
        ->join('users', 'w2b_orders.user_id', 'users.id')
        ->where('ordered_products.vendor_id', Auth::guard('vendor-api')->user()->id)
        ->where('w2b_orders.order_id', $orderId)
        ->select('ordered_products.*')
        ->get();

        $grandTotal = OrderedProduct::where('order_id', $orderId)
            ->where('vendor_id', Auth::guard('vendor-api')->user()->id)
            ->sum('total_price');

        $order1 = OrderedProduct::join('w2b_orders', 'ordered_products.order_id', 'w2b_orders.order_id')
            ->join('users', 'w2b_orders.user_id', 'users.id')
            ->join('states', 'states.id', 'users.state')
            ->join('cities', 'cities.id', 'users.city')
            ->where('ordered_products.vendor_id', Auth::guard('vendor-api')->user()->id)
            ->where('w2b_orders.order_id', $orderId)
            ->select('ordered_products.order_id','ordered_products.vendor_id',
                'users.first_name as user_fname', 'users.last_name as user_lname',
                'users.address as user_address',
                'users.mobile as user_phone',
                'states.name as state_name',
                'cities.name as city_name')
            ->first();

        $response = [
            'ordered_products' => $od,
            'grand_total' => $grandTotal,
            'order_details' => $order1,
        ];

        return response()->json(['data' => $response], 200);
    }


    public function updateOrderStatus(Request $request, $order_id)
    {
        $orderId = $order_id;
        $sku = $request->input('sku');
        $status = $request->input('status');

        $product = OrderedProduct::where('order_id', $orderId)
            ->where('sku', $sku)
            ->update(['status' => $status]);

        // Check if the updated status is 'delivered'
        if ($status === 'delivered') {
            // Get the order details
            $order = OrderedProduct::join('w2b_orders', 'ordered_products.order_id', 'w2b_orders.order_id')
                ->join('users', 'w2b_orders.user_id', 'users.id')
                ->join('products', 'ordered_products.sku', 'products.sku')
                ->where('ordered_products.order_id', $orderId)
                ->where('ordered_products.sku', $sku)
                ->select('users.email', 'users.first_name', 'users.last_name', 'products.title', 'ordered_products.price', 'products.slug')
                ->first();
            $details = [
                'name' => $order->first_name . ' ' . $order->last_name,
                'product_title' => $order->title,
                'product_sku' => $sku,
                'order_no' => $orderId,
                'price' => $order->price,
                'slug' => $order->slug
            ];

            // Send an email to the seller
            // Mail::to($order->email)->send(new ProductReviewMail($details));
            dispatch(new ProductReviewJob($order->email, $details));

            // You can also perform additional actions here if needed
        }

        return response()->json(['message' => 'Order status updated successfully'], 200);
    }


    public function postShippingDetails(Request $request, $orderId, $productSku)
    {
        $request->validate([
            'tracking_no' => 'required',
            'tracking_link' => 'required',
        ]);

        $order = OrderedProduct::where('order_id', $orderId)
            ->where('sku', $productSku)
            ->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Update the tracking information
        $order->update([
            'tracking_no' => $request->input('tracking_no'),
            'tracking_link' => $request->input('tracking_link'),
        ]);

        return response()->json(['message' => 'Tracking information updated successfully'], 200);
    }

    public function shippedOrders($orderId)
    {
        $orders = OrderedProduct::join('w2b_orders', 'ordered_products.order_id', 'w2b_orders.order_id')
        ->join('users', 'w2b_orders.user_id', 'users.id')
        ->where('ordered_products.order_id', $orderId)
        ->where('ordered_products.status', 'shipped')
        ->select('ordered_products.*','users.email', 'users.first_name', 'users.last_name',)
        ->get();

        return response()->json(['shipped_orders' => $orders], 200);
    }

    public function deliveredOrders($orderId)
    {
        $orders = OrderedProduct::join('w2b_orders', 'ordered_products.order_id', 'w2b_orders.order_id')
        ->join('users', 'w2b_orders.user_id', 'users.id')
        ->where('ordered_products.order_id', $orderId)
        ->where('ordered_products.status', 'delivered')
        ->select('ordered_products.*','users.email', 'users.first_name', 'users.last_name',)
        ->get();

        return response()->json(['shipped_orders' => $orders], 200);
    }


    public function cancelledOrders($orderId)
    {
        $orders = OrderedProduct::join('w2b_orders', 'ordered_products.order_id', 'w2b_orders.order_id')
        ->join('users', 'w2b_orders.user_id', 'users.id')
        ->where('ordered_products.order_id', $orderId)
        ->where('ordered_products.status', 'cancelled')
        ->select('ordered_products.*','users.email', 'users.first_name', 'users.last_name',)
        ->get();

        return response()->json(['shipped_orders' => $orders], 200);
    }

    public function returnedOrders($orderId)
    {
        $orders = OrderedProduct::join('w2b_orders', 'ordered_products.order_id', 'w2b_orders.order_id')
        ->join('users', 'w2b_orders.user_id', 'users.id')
        ->where('ordered_products.order_id', $orderId)
        ->where('ordered_products.status', 'returned')
        ->select('ordered_products.*','users.email', 'users.first_name', 'users.last_name',)
        ->get();

        return response()->json(['shipped_orders' => $orders], 200);
    }


    public function addToWallet(Request $request)
    {
        // Get the authenticated vendor's ID
        $uid = Auth::user()->id;
        $wallet = Vendor::find($uid);

        Stripe::setApiKey($this->stripe_secret);

        try {
            if ($wallet->stripe_customer_id) {
                $customer = $wallet->stripe_customer_id;
            } else {
                $customer = Customer::create([
                    "email" => $wallet->email,
                    "name" => $wallet->first_name,
                    "source" => $request->stripeToken,
                ]);
                $wallet->update(['stripe_customer_id' => $customer->id]);
            }

            Charge::create([
                "amount" => $request->amount * 100,
                "currency" => "usd",
                "customer" => $wallet->stripe_customer_id,
                "description" => "Money added in your wallet.",
            ]);

            $closing_amount = $wallet->wallet_amount + $request->amount;

            $customer_wallet = new CustomerWallet;
            $customer_wallet->customer_id = $uid;
            $customer_wallet->amount = $request->amount;
            $customer_wallet->closing_amount = $closing_amount;
            $customer_wallet->type = 'credit';
            $customer_wallet->save();

            if (empty($wallet->wallet_amount)) {
                Vendor::where('id', $uid)->update(['wallet_amount' => $request->amount]);
            } else {
                $amount = $wallet->wallet_amount + $request->amount;
                Vendor::where('id', $uid)->update(['wallet_amount' => $amount]);
            }

            // notification
            $id = $customer_wallet->id;
            $type = 'wallet_transaction';
            $title = 'Wallet';
            $message = 'Money has been added to your wallet';
            $devices = UserDevice::where('user_id', $wallet->id)->where('user_type', 'vendor')->get();

            // Return a JSON response for success
            return response()->json(['success' => 'Money added to wallet']);

        } catch (CardException $e) {
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

        // Return a JSON response for errors
        return response()->json(['error' => $errors], 500);
    }


    public function withdrawToBank(Request $request)
    {
        // Define validation rules
        $rules = [
            'bank_name' => 'required|string',
            'routing_number' => 'required|string',
            'account_title' => 'required|string',
            'account_no' => 'required|string',
            'amount' => 'required|numeric|min:0.01', // Adjust the minimum amount as needed
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Validation failed, return error response with validation errors
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $uid = auth()->user()->id;
        $vendor = Vendor::find($uid);

        if ($vendor->wallet_amount < $request->amount) {
            // Return an error response if the wallet balance is not enough
            return response()->json(['error' => 'Your balance is not enough'], 400);
        } else {
            $debit = $vendor->wallet_amount - $request->amount;
            $vendor->update(['wallet_amount' => $debit]);
        }

        WithdrawRequest::create([
            'vendor_id' => $uid,
            'bank_name' => $request->bank_name,
            'routing_number' => $request->routing_number,
            'account_title' => $request->account_title,
            'account_no' => $request->account_no,
            'amount' => $request->amount,
        ]);

        $contact_data = [
            'name' => $vendor->name,
            'email' => $vendor->email,
            'account_title' => $request->account_title,
            'account_no' => $request->account_no,
            'bank_name' => $request->bank_name,
            'routing_number' => $request->routing_number,
            'amount' => $request->amount,
        ];

        // Send withdrawal confirmation emails
        Mail::to($vendor->email)->send(new WithdrawMail($contact_data));
        $admin_email = config('app.admin_email');
        Mail::to($admin_email)->send(new AdminWithdrawMail($contact_data));

        // Return a success response
        return response()->json(['message' => 'Withdrawal successful'], 200);
    }

    public function walletAmount()
    {
        $user_id = Auth::user()->id;
        $vendor = Vendor::where('id', $user_id)
        ->select('id','name','email','wallet_amount')->first();

        return $this->sendResponse($vendor,'Vendor Wallet amount');

    }

    public function withdrawHistory()
    {
        $uid = auth()->user()->id;
        $vendor = Vendor::find($uid);

        $withdraw_history = WithdrawRequest::where('vendor_id', $uid)->get();
        return $this->sendResponse($withdraw_history,'Vendor Withdraw history');
    }



}
