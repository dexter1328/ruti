<?php

namespace App\Http\Controllers\API\VendorApi;

use App\Brand;
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

class ShopController extends BaseController
{
    public function createProduct(Request $request)
    {

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
                'image' => 'required|mimes:jpeg,png,jpg|max:2048',
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


}
