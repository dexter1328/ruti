<?php

namespace App\Http\Controllers\API;

use DB;
use Validator;
use App\User;
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
use App\DiscountOffers;
use App\Orders;
use App\UserCart;
use App\ActiveUser;
use App\Setting;
use App\RewardPoint;
use App\CustomerEarnRewardPoint;
use App\CustomerRewardPoint;
use App\UserDevice;
use App\Traits\AppNotification;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

class ShopController extends BaseController
{
	use AppNotification;
	

	public function getStore(Request $request)
	{
		if($request->has('lat') && $request->lat != '' && $request->has('long') && $request->long != '') {
			$lat = $request->lat;
			$lon = $request->long;
		} else {
			$lat = 0;
			$lon = 0;
		}

		$store_data = DB::table("vendor_stores")
            ->select("vendor_stores.id",
            	"vendor_stores.name",
            	"vendor_stores.email",
				"vendor_stores.address1",
				"vendor_stores.lat",
				"vendor_stores.long",
				"vendor_stores.pincode",
				"vendor_stores.phone_number",
				"vendor_stores.open_status",
				"vendor_stores.status",
				"countries.name as country",
				"states.name as state",
				"cities.name as city",
                DB::raw(
                    "6371 * acos(cos(radians(" . $lat . ")) 
                    * cos(radians(vendor_stores.lat)) 
                    * cos(radians(vendor_stores.long) - radians(" . $lon . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(vendor_stores.lat))) AS distance"
                )
            )
           	->join('countries','countries.id','=','vendor_stores.country')
            ->join('states','states.id','=','vendor_stores.state')
            ->join('cities','cities.id','=','vendor_stores.city')
            ->orderBy('distance', 'asc')
            ->first();

		// print_r($store_data->toArray());die();
        $store = array(
        	"store_id" => $store_data->id,
			"name" => $store_data->name,
			"email" => $store_data->email,
			"address" => $store_data->address1,
			"city" => $store_data->city,
			"state" => $store_data->state,
			"country" => $store_data->country,
			"lat" => $store_data->lat,
			"long" => $store_data->long,
			"pincode" => $store_data->pincode,
			"phone_number" => $store_data->phone_number,
			"current_status" => $store_data->open_status,
			"status" => $store_data->status,
    	);

        return $this->sendResponse($store,'Store near by you');
	}

	public function bestSellingProduct(Request $request)
	{
		if($request->has('lat') && $request->lat != '' && $request->has('long') && $request->long != '') {
			$lat = $request->lat;
			$lon = $request->long;
		} else {
			$lat = 0;
			$lon = 0;
		}

		$selling_products = Products::join('vendor_stores','vendor_stores.id','=','products.store_id')
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
							'vendor_stores.id as store_id',
							DB::raw(
								"6371 * acos(cos(radians(" . $lat . ")) 
								* cos(radians(vendor_stores.lat)) 
								* cos(radians(vendor_stores.long) - radians(" . $lon . ")) 
								+ sin(radians(" .$lat. ")) 
								* sin(radians(vendor_stores.lat))) AS distance"
							)
						)
						->join('categories','categories.id','=','products.category_id')
						->join('brands','brands.id','=','products.brand_id')
						->join('product_variants','product_variants.product_id','=','products.id')
						->join('order_items','order_items.product_variant_id','=','product_variants.id')
						->groupBy('order_items.product_variant_id')
						->orderBy('distance', 'ASC')
                		->orderBy('count', 'DESC')
						->paginate(10);

		if($selling_products->isNotEmpty())
		{	
			$current_page = $selling_products->currentPage();
			$total_pages  = $selling_products->lastPage();		
			foreach ($selling_products as $key => $value) {

				$wish_list = UserWishlist::where('product_id',$value['id'])->where('user_id',$request->current_user)->exists();
				$rating = $this->product_ave_rating($value['id']);
				$product_images = ProductImages::where('variant_id',$value['id'])->get();
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
								'store' => $store,
								"rating" => $rating
							);
			}
			return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'products'=>$success),'Data retrieved successfully');
		}else{
			$success =[];
			return $this->sendResponse(array('page'=> 1,'totalPage'=>1,'products'=>$success),'We can\'t find proper data to display');
		}
	}

	public function storeBestSellingProduct(Request $request , $id)
	{
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
							'product_variants.discount'
						)
						->join('categories','categories.id','=','products.category_id')
						->join('brands','brands.id','=','products.brand_id')
						->join('product_variants','product_variants.product_id','=','products.id')
						->join('order_items','order_items.product_variant_id','=','product_variants.id')
						->where('vendor_stores.id',$id)
						->groupBy('order_items.product_variant_id')
                		->orderBy('count', 'DESC')
						->paginate(10);

						//print_r($selling_products->toArray());die();
		if($selling_products->isNotEmpty())
		{	
			$current_page = $selling_products->currentPage();
			$total_pages  = $selling_products->lastPage();		
			foreach ($selling_products as $key => $value) {
				$wishlist = UserWishlist::where('product_id',$value['id'])->where('user_id',$request->current_user)->exists();
				$rating = $this->product_ave_rating($value['id']);
				$product_images = ProductImages::where('variant_id',$value['id'])->get();
				$image=[];
				foreach ($product_images as $key) {

					$image[] = array('image' => ($key['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/product_images/'.$key['image'])) );

				}

				$success[] = array('id'=>$value['id'],
								'product_id'=>$value['product_id'],
								'name' => $value['product'],
								'brand' =>  $value['brand'],
								'price'=>$value['price'],
								'discount'=>$value['discount'],
								'category' =>  $value['category'],
								'status'=>$value['status'],
								'wishlist'=>$wishlist,
								'image'=>$image,
								'rating' => $rating
							);
			}
			return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'products'=>$success),'Data retrieved successfully');
		}else{
			return $this->sendError('We can\'t find proper data to display');
		}
	}

	public function bestTrendingProduct(Request $request)
	{
		$end_date = date('Y-m-d');
		$start_date =  date('Y-m-d', strtotime('-7 days'));
		if($request->has('lat') && $request->lat != '' && $request->has('long') && $request->long != '') {
			$lat = $request->lat;
			$lon = $request->long;
		} else {
			$lat = 0;
			$lon = 0;
		}

		$trending_products = Products::join('vendor_stores','vendor_stores.id','=','products.store_id')
						->select('product_variants.id',
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
							DB::raw('count(order_items.product_variant_id) as count'),
							'order_items.created_at',
							DB::raw(
								"6371 * acos(cos(radians(" . $lat . ")) 
								* cos(radians(vendor_stores.lat)) 
								* cos(radians(vendor_stores.long) - radians(" . $lon . ")) 
								+ sin(radians(" .$lat. ")) 
								* sin(radians(vendor_stores.lat))) AS distance"
							)
						)
						->join('categories','categories.id','=','products.category_id')
						->join('brands','brands.id','=','products.brand_id')
						->join('product_variants','product_variants.product_id','=','products.id')
						->join('order_items','order_items.product_variant_id','=','product_variants.id')
						->whereBetween(DB::raw('DATE(order_items.created_at)'), [$start_date, $end_date])
						->groupBy('order_items.product_variant_id')
						->orderBy('distance', 'ASC')
		        		->orderBy('count', 'DESC')
						->paginate(10);
		if($trending_products->isNotEmpty())
		{	
			$current_page = $trending_products->currentPage();
			$total_pages  = $trending_products->lastPage();		
			foreach ($trending_products as $key => $value) {
				$wishlist = UserWishlist::where('product_id',$value['id'])->where('user_id',$request->current_user)->exists();
				$rating = $this->product_ave_rating($value['id']);
				$product_images = ProductImages::where('product_id',$value['product_id'])->get();
				$product_variants = ProductVariants::where('product_id',$value['product_id'])->first();
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

				$success[] = array( 'id'=>$value['id'],
								'product_id'=>$value['product_id'],
								'name' => $value['product'],
								'brand' =>  $value['brand'],
								'price'=>$value['price'],
								'discount'=>$value['discount'],
								'category' =>  $value['category'],
								'status'=>$value['status'],
								'wishlist'=>$wishlist,
								'image'=>$image,
								'store'=>$store,
								'rating' => $rating
							);
			}
			return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'products'=>$success),'Data retrieved successfully');
		}else{
			return $this->sendError('We can\'t find proper data to display');
		}
	}

	public function storeBestTrendingProduct(Request $request, $id)
	{
		$end_date = date('Y-m-d');
		$start_date =  date('Y-m-d', strtotime('-7 days'));

		$trending_products = Products::join('vendor_stores','vendor_stores.id','=','products.store_id')
						->select('product_variants.id',
								'products.title as product',
								'products.id as product_id',
								'products.status',
								'categories.name as category',
								'brands.name as brand',
								'product_variants.price',
								'product_variants.discount',
								DB::raw('count(order_items.product_variant_id) as count'),
								'order_items.created_at'
								)
						->join('categories','categories.id','=','products.category_id')
						->join('brands','brands.id','=','products.brand_id')
						->join('product_variants','product_variants.product_id','=','products.id')
						->join('order_items','order_items.product_variant_id','=','product_variants.id')
						->where('vendor_stores.id',$id)
						->whereBetween(DB::raw('DATE(order_items.created_at)'), [$start_date, $end_date])
						->groupBy('order_items.product_variant_id')
		        		->orderBy('count', 'DESC')
						->paginate(10);

		if($trending_products->isNotEmpty())
		{	
			$current_page = $trending_products->currentPage();
			$total_pages  = $trending_products->lastPage();		
			foreach ($trending_products as $key => $value) {
				$wishlist = UserWishlist::where('product_id',$value['id'])->where('user_id',$request->current_user)->exists();
				$rating = $this->product_ave_rating($value['id']);
				$product_images = ProductImages::where('product_id',$value['product_id'])->get();
				$image=[];
				foreach ($product_images as $key) {

					$image[] = array('image' => ($key['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/product_images/'.$key['image'])) );

				}

				$success[] = array('id'=>$value['id'],
								'product_id'=>$value['product_id'],
								'name' => $value['product'],
								'brand' =>  $value['brand'],
								'price'=>$value['price'],
								'discount'=>$value['discount'],
								'category' =>  $value['category'],
								'status'=>$value['status'],
								'wishlist'=>$wishlist,
								'image'=>$image,
								'rating' => $rating
							);
			}
			return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'products'=>$success),'Data retrieved successfully');
		}else{
			return $this->sendError('We can\'t find proper data to display');
		}
	}

	public function bestSeasonalProduct(Request $request)
	{
		$season = getCurrentSeason(date('F'));
		if($request->has('lat') && $request->lat != '' && $request->has('long') && $request->long != '') {
			$lat = $request->lat;
			$lon = $request->long;
		} else {
			$lat = 0;
			$lon = 0;
		}

		if($season){
			$seasonal_products = Products::join('vendor_stores','vendor_stores.id','=','products.store_id')
							->select('product_variants.id',
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
								DB::raw(
									"6371 * acos(cos(radians(" . $lat . ")) 
									* cos(radians(vendor_stores.lat)) 
									* cos(radians(vendor_stores.long) - radians(" . $lon . ")) 
									+ sin(radians(" .$lat. ")) 
									* sin(radians(vendor_stores.lat))) AS distance"
								)
							)
							->join('categories','categories.id','=','products.category_id')
							->join('product_variants','product_variants.product_id','=','products.id')
							->join('brands','brands.id','=','products.brand_id')
							->where('products.season', $season)
							->orderBy('distance', 'ASC')
							->paginate(10);
			
			if($seasonal_products->isNotEmpty()){	
				$current_page = $seasonal_products->currentPage();
				$total_pages  = $seasonal_products->lastPage();		
				foreach ($seasonal_products as $key => $value) {
					$wishlist = UserWishlist::where('product_id',$value['id'])->where('user_id',$request->current_user)->exists();
					$rating = $this->product_ave_rating($value['id']);
					$product_images = ProductImages::where('product_id',$value['product_id'])->get();
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
					$success[] = array('id'=>$value['id'],
									'product_id'=>$value['product_id'],
									'name' => $value['product'],
									'brand' =>  $value['brand'],
									'price'=>$value['price'],
									'discount'=>$value['discount'],
									'category' =>  $value['category'],
									'status'=>$value['status'],
									'wishlist'=>$wishlist,
									'image'=>$image,
									'store'=>$store,
									'rating'=>$rating
								);
				}
				return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'products'=>$success),'Data retrieved successfully');
			}else{
				return $this->sendError('We can\'t find proper data to display');
			}
		}else{
			return $this->sendError('We can\'t find proper data to display');
		}
	}

	public function storebestSeasonalProduct(Request $request, $id)
	{
		$season = getCurrentSeason(date('F'));
		if($season){
			$seasonal_products = Products::join('vendor_stores','vendor_stores.id','=','products.store_id')
							->select('product_variants.id',
								'products.title as product',
								'products.id as product_id',
								'products.status',
								'categories.name as category',
								'brands.name as brand',
								'product_variants.price',
								'product_variants.discount'
							)
							->join('categories','categories.id','=','products.category_id')
							->join('brands','brands.id','=','products.brand_id')
							->join('product_variants','product_variants.product_id','=','products.id')
							->where('products.season', $season)
							->where('vendor_stores.id',$id)
							->paginate(10);
			if($seasonal_products->isNotEmpty())
			{	
				$current_page = $seasonal_products->currentPage();
				$total_pages  = $seasonal_products->lastPage();		
				foreach ($seasonal_products as $key => $value) {
					$wishlist = UserWishlist::where('product_id',$value['id'])->where('user_id',$request->current_user)->exists();
					$rating = $this->product_ave_rating($value['id']);
					$product_images = ProductImages::where('product_id',$value['product_id'])->get();
					$image=[];
					foreach ($product_images as $key) {

						$image[] = array('image' => ($key['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/product_images/'.$key['image'])) );

					}

					$success[] = array('id'=>$value['id'],
									'product_id'=>$value['product_id'],
									'name' => $value['product'],
									'brand' =>  $value['brand'],
									'price'=>$value['price'],
									'discount'=>$value['discount'],
									'category' =>  $value['category'],
									'status'=>$value['status'],
									'wishlist'=>$wishlist,
									'image'=>$image,
									'rating' => $rating
								);
				}
				return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'products'=>$success),'Best selling product');
			}else{
				return $this->sendError('We can\'t find proper data to display');
			}
		}else{
			return $this->sendError('We can\'t find proper data to display');
		}
	}

	public function storeProductList(Request $request, $id)
	{
		$store_products = Products::join('vendor_stores','vendor_stores.id','=','products.store_id')
						->select('products.title as product','products.id as product_id',
							'products.status','categories.name as category','brands.name as brand'
							)
						->join('categories','categories.id','=','products.category_id')
						->join('brands','brands.id','=','products.brand_id')
						->where('vendor_stores.id',$id)
						->get();
						
		foreach ($store_products as $key => $value) {
			$wishlist = UserWishlist::where('product_id',$value['product_id'])->where('user_id',$request->current_user)->exists();
			$product_images = ProductImages::where('product_id',$value['product_id'])->get();
			$image=[];
			foreach ($product_images as $key) {

				$image[] = array('image' => ($key['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/product_images/'.$key['image'])) );

			}

			$success[] = array('name' => $value['product'],
							'brand' =>  $value['brand'],
							'category' =>  $value['category'],
							'status'=>$value['status'],
							'wishlist'=>$wishlist,
							'image'=>$image
						);
		}
		return $this->sendResponse(array('products'=>$success),'All product');
	}

	public function categoryList(Request $request)
	{
		if($request->has('lat') && $request->lat != '' && $request->has('long') && $request->long != '') {
			$lat = $request->lat;
			$lon = $request->long;
		} else {
			$lat = 0;
			$lon = 0;
		}

		$category_products = DB::table('categories as a')
			->select(
				'a.id', 
				'a.name', 
				'a.description', 
				'b.name as parent',
				'a.image',
				DB::raw(
					"6371 * acos(cos(radians(" . $lat . ")) 
					* cos(radians(vendor_stores.lat)) 
					* cos(radians(vendor_stores.long) - radians(" . $lon . ")) 
					+ sin(radians(" .$lat. ")) 
					* sin(radians(vendor_stores.lat))) AS distance"
				)
			)
			->join('vendor_stores', 'vendor_stores.id', 'a.store_id')
		 	->leftjoin('categories AS b', 'b.id', '=', 'a.parent');

		if($request->id) {
			$category_products = $category_products->where('a.parent', $request->id);;
		} else { 
			$category_products = $category_products->whereNull('a.parent');
		}

		if($request->store_id) {
			$category_products = $category_products->where('vendor_stores.id', $request->store_id);
		}

		$category_products = $category_products->orderBy('distance', 'ASC')->paginate(10);
		if($category_products->isNotEmpty()) {

			$current_page = $category_products->currentPage();
			$total_pages  = $category_products->lastPage();

			foreach ($category_products as $key => $value) {

				$subcategory = Category::where('parent',$value->id)->exists();
				$success[] = array(
					'category_id' =>  $value->id,
					'name' =>  $value->name,
					'has_subcategory'=>$subcategory,
		 			'image' => ($value->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/categories/'.$value->image)),
				);
			}
			return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'categories'=>$success),'Data retrieved successfully');
		}else{
			return $this->sendError('We can\'t find any data to display.');
		}
	}

	public function bannerList()
	{
		$banners = Banner::where('status','active')->get();
		foreach ($banners as $key => $banner) {
			$success[] = array('banner_id' =>  $banner['id'],
							'name' =>  $banner['banner_title'],
							'position'=>$banner['position'],
			 				'image' => ($banner['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/banners/'.$banner['image'])),
						);
		}
		return $this->sendResponse(array('banner'=>$success),'All banners');
	}

	public function storeList(Request $request)
	{
		if($request->has('lat') && $request->lat != '' && $request->has('long') && $request->long != '') {
			$lat = $request->lat;
			$lon = $request->long;
		} else {
			$lat = 0;
			$lon = 0;
		}

		/*$neab_by = false;
		$near_by_limit = 0;
		$near_by_error = null;
		$customer_store_radius = Setting::where('key','customer_store_radius')->first();
		if(!empty($customer_store_radius)){
			$near_by_limit = miles2kms($customer_store_radius->value);
		}*/
		
		$vendor_stores = VendorStore::select(
				'vendor_stores.*',
				DB::raw(
                    "6371 * acos(cos(radians(" . $lat . ")) 
                    * cos(radians(vendor_stores.lat)) 
                    * cos(radians(vendor_stores.long) - radians(" . $lon . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(vendor_stores.lat))) AS distance"
                )
			)
			->where('status','enable')
			->orderBy('distance', 'ASC')
			->paginate(10);
		if($vendor_stores->isNotEmpty())
		{
			$current_page = $vendor_stores->currentPage();
			$total_pages  = $vendor_stores->lastPage();
			foreach ($vendor_stores as $key => $vendor_store) {

				$success[] = array(
					'store_id' =>  $vendor_store['id'],
					'name' =>  $vendor_store['name'],
					'branch_admin' =>$vendor_store['branch_admin'],
					'phone_number' =>$vendor_store['phone_number'],
					'email' =>$vendor_store['email'],
					'current_status' =>$vendor_store['open_status'],
					'image' => ($vendor_store['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$vendor_store['image'])),
				);

				/*if(!empty($vendor_store->distance) && $vendor_store->distance < $near_by_limit && (!isset($page) || $page == 1)) {

					$neab_by = true;
				}*/
			}

			/*if($neab_by == false) {

				$near_by_error = 'Stores near by are yet to join us. Thank you for your patience. We will notify you as soon as one becomes available. Meanwhile, suggest to us a store you frequently visit.';
			}*/

			$result = array(
				'page' => $current_page,
				'totalPage' =>$total_pages,
				'stores' => $success/*,
				'near_by_error' => $near_by_error*/
			);

			return $this->sendResponse($result,'Data retrieved successfully');
		}else{

			return $this->sendError('We can\'t find proper data to display.');
		}
	}

	public function productSearch(Request $request)
	{
		$json_data = $request->all();
		//echo '<pre>'; print_r($json_data); exit();

		$products = ProductVariants::select(
					'product_variants.*',
					'products.title',
					'products.store_id',
					'products.category_id',
					'vendor_stores.name as store_name',
					'vendor_stores.branch_admin',
					'vendor_stores.email',
					'vendor_stores.phone_number',
					'vendor_stores.image as store_image',
					'vendor_stores.open_status',
					'brands.name as brand_name',
					DB::raw("GROUP_CONCAT(categories.name) as categorie_names")
					//DB::raw("GROUP_CONCAT(attribute_values.name) as attribute_value_names")
				)
			->join('products','products.id', 'product_variants.product_id')
			->join('vendor_stores','vendor_stores.id', 'products.store_id')
			->join('brands','brands.id', 'products.brand_id')
			->join("categories",DB::raw("FIND_IN_SET(categories.id,products.category_id)"), ">" ,DB::raw("'0'"))
			->leftjoin('product_reviews','product_reviews.product_id', 'products.id')
			//->leftjoin("attribute_values",DB::raw("FIND_IN_SET(attribute_values.id,product_variants.attribute_value_id)"), ">" ,DB::raw("'0'"))
			->where('products.status','enable');

		if (array_key_exists("filter",$json_data)){
			foreach($json_data['filter'] as $filter){

				if($filter['key'] == 'categories'){
					$products = $products->whereIn('categories.id', $filter['value']);
				}
				if($filter['key'] == 'brands'){
					$products = $products->whereIn('brands.id', $filter['value']);
				}
				if($filter['key'] == 'discount'){
					if(strpos($filter['value'][0], '|') !== false){
						$discount = explode('|', $filter['value'][0]);
						$products = $products->where('product_variants.discount', '<=', $discount[0]);
					}else{
						$products = $products->where('product_variants.discount', '>=', $filter['value'][0]);
					}
				}
				if($filter['key'] == 'prices'){
					$min_prices = explode(',', $filter['value'][0]);
					$max_prices = explode(',', $filter['value'][1]);
					
					$products = $products->where('product_variants.price','<' ,$max_prices)->where('product_variants.price','>',$min_prices);
				}
			}
		}

		if (array_key_exists("query", $json_data)){
			$products = $products->where(function ($query) use ($json_data) {
				$query->where('products.title', 'like', '%' . $json_data['query'] . '%')
				->orWhere('categories.name', 'like', '%' . $json_data['query'] . '%')
				->orWhere('brands.name', 'like', '%' . $json_data['query'] . '%');
			});
		}
		
		if (array_key_exists("sorting",$json_data)){
			if($json_data['sorting'] == 'high_to_low'){
				$products = $products->orderBy('product_variants.price', 'DESC');
			}elseif($json_data['sorting'] == 'low_to_high'){
				$products = $products->orderBy('product_variants.price', 'ASC');
			}elseif($json_data['sorting'] == 'new_arrival'){
				$products = $products->orderBy('products.created_at', 'DESC');
			}elseif($json_data['sorting'] == 'customer_review'){
				$products = $products->orderBy('product_reviews.rating', 'DESC');
			}
		}
		
		$products = $products->groupBy('product_variants.id');
		$products = $products->paginate(10);
		//var_dump($products->toSql());exit();
		//print_r($products->toArray()); exit();
		if($products->isNotEmpty()){
			$current_page = $products->currentPage();
			$total_pages  = $products->lastPage();
			foreach ($products as $product) {
				$rating = $this->product_ave_rating($product->id);
	      		$wishlist = false;
				if(isset($json_data['current_user']) && $json_data['current_user']!= ''){
	      			$wishlist = UserWishlist::where('product_id',$product->id)->where('user_id', $json_data['current_user'])->exists();
	      		}
				$product_images = ProductImages::where('variant_id',$product->id)->get();
				$attribute_values = AttributeValue::select('name')
					->whereIn('id', explode(',', $product->attribute_value_id))
					->orderBy('attribute_id', 'asc')
					->get();
				$attribute_value_names = Arr::pluck($attribute_values, 'name');
				$attribute_value_names = implode(' ', $attribute_value_names);
				
				$image = [];
				foreach ($product_images as $product_image) {
					$image[] = array('image' => ($product_image['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/product_images/'.$product_image['image'])) );
				}
				$store = array('store_id' => $product->store_id,
							'name' => $product->store_name,
							'branch_admin' => $product->branch_admin,
							'phone_number' => $product->phone_number,
							'email' => $product->email,
							'current_status' => $product->open_status,
							'image' => ($product->store_image == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$product->store_image))
						);
				$success[] = array('id' => $product->id,
								'product_id' => $product->product_id,
								'name' => $product->title.' '.$attribute_value_names,
								'price' => $product->price,
								'discount' => $product->discount,
								'brand' =>  $product->brand_name,
								'category_id' => $product->category_id,
								'category' =>  explode(',', $product->categorie_names),
								'wishlist' => $wishlist,
								'created' => 1000 * strtotime($product->created_at),
								'image' => $image,
								'store' => $store,
								'rating' => $rating
							);
			}
			return $this->sendResponse(array('page' => $current_page, 'totalPage' => $total_pages, 'product' => $success),'Data retrieved successfully');
		}else{
			return $this->sendResponse(array('page' => 1, 'totalPage' => 1, 'product' => array()), 'We can\'t find proper data to display');
		}
	}

	public function storeProductSearch(Request $request, $id)
	{
		$json_data = $request->all();

		$products = ProductVariants::select(
					'product_variants.*',
					'products.title',
					'products.store_id',
					'products.category_id',
					'vendor_stores.name as store_name',
					'vendor_stores.branch_admin',
					'vendor_stores.email',
					'vendor_stores.phone_number',
					'vendor_stores.image as store_image',
					'vendor_stores.open_status',
					'brands.name as brand_name',
					DB::raw("GROUP_CONCAT(categories.name) as categorie_names")
					//DB::raw("GROUP_CONCAT(attribute_values.name) as attribute_value_names")
				)
			->join('products','products.id', 'product_variants.product_id')
			->join('vendor_stores','vendor_stores.id', 'products.store_id')
			->join('brands','brands.id', 'products.brand_id')
			->join("categories",DB::raw("FIND_IN_SET(categories.id,products.category_id)"), ">" ,DB::raw("'0'"))
			->leftjoin('product_reviews','product_reviews.product_id', 'products.id')
			//->leftjoin("attribute_values",DB::raw("FIND_IN_SET(attribute_values.id,product_variants.attribute_value_id)"), ">" ,DB::raw("'0'"))
			->where('products.status','enable')
			->where('vendor_stores.id',$id);

		if (array_key_exists("filter",$json_data)){
			foreach($json_data['filter'] as $filter){
				if($filter['key'] == 'categories'){
					$products = $products->whereIn('categories.id', $filter['value']);
				}
				if($filter['key'] == 'brands'){
					$products = $products->whereIn('brands.id', $filter['value']);
				}
				if($filter['key'] == 'discount'){
					if(strpos($filter['value'][0], '|') !== false){
						$discount = explode('|', $filter['value'][0]);
						$products = $products->where('product_variants.discount', '<=', $discount[0]);
					}else{
						$products = $products->where('product_variants.discount', '>=', $filter['value'][0]);
					}
				}
				if($filter['key'] == 'prices'){
					// $prices = explode('-', $filter['value'][0]);

					$min_prices = explode('-', $filter['value'][0]);
					$max_prices = explode('-', $filter['value'][1]);
					$products = $products->where('product_variants.price','<' ,$max_prices)->where('product_variants.price','>',$min_prices);
					// $products = $products->whereBetween('product_variants.price', $prices);
				}
			}
		}

		if (array_key_exists("query", $json_data)){
			$products = $products->where(function ($query) use ($json_data) {
				$query->where('products.title', 'like', '%' . $json_data['query'] . '%')
				->orWhere('categories.name', 'like', '%' . $json_data['query'] . '%')
				->orWhere('brands.name', 'like', '%' . $json_data['query'] . '%');
			});
		}
		
		if (array_key_exists("sorting",$json_data)){
			if($json_data['sorting'] == 'high_to_low'){
				$products = $products->orderBy('product_variants.price', 'DESC');
			}elseif($json_data['sorting'] == 'low_to_high'){
				$products = $products->orderBy('product_variants.price', 'ASC');
			}elseif($json_data['sorting'] == 'new_arrival'){
				$products = $products->orderBy('products.created_at', 'DESC');
			}elseif($json_data['sorting'] == 'customer_review'){
				$products = $products->orderBy('product_reviews.rating', 'DESC');
			}
		}
		
		$products = $products->groupBy('product_variants.id');
		$products = $products->paginate(10);
		//$products = $products->toSql();
		//print_r($products->toArray()); exit();
		if($products->isNotEmpty()){
			$current_page = $products->currentPage();
			$total_pages  = $products->lastPage();
			foreach ($products as $product) {
				$rating = $this->product_ave_rating($product->id);
	      		$wishlist = false;
				if(isset($json_data['current_user']) && $json_data['current_user']!= ''){
	      			$wishlist = UserWishlist::where('product_id',$product->id)->where('user_id', $json_data['current_user'])->exists();
	      		}
				$product_images = ProductImages::where('variant_id',$product->id)->get();
				$attribute_values = AttributeValue::select('name')
					->whereIn('id', explode(',', $product->attribute_value_id))
					->orderBy('attribute_id', 'asc')
					->get();
				$attribute_value_names = Arr::pluck($attribute_values, 'name');
				$attribute_value_names = implode(' ', $attribute_value_names);
				
				$image = [];
				foreach ($product_images as $product_image) {
					$image[] = array('image' => ($product_image['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/product_images/'.$product_image['image'])) );
				}
				$store = array('store_id' => $product->store_id,
							'name' => $product->store_name,
							'branch_admin' => $product->branch_admin,
							'phone_number' => $product->phone_number,
							'email' => $product->email,
							'current_status' => $product->open_status,
							'image' => ($product->store_image == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$product->store_image))
						);
				$success[] = array('id' => $product->id,
								'product_id' => $product->product_id,
								'name' => $product->title.' '.$attribute_value_names,
								'price' => $product->price,
								'discount' => $product->discount,
								'brand' =>  $product->brand_name,
								'category_id' => $product->category_id,
								'category' =>  explode(',', $product->categorie_names),
								'wishlist' => $wishlist,
								'created' => 1000 * strtotime($product->created_at),
								'image' => $image,
								'store' => $store,
								'rating' => $rating
							);
			}
			return $this->sendResponse(array('page' => $current_page, 'totalPage' => $total_pages, 'product' => $success),'Data retrieved successfully');
		}else{
			return $this->sendResponse(array('page' => 1, 'totalPage' => 1, 'product' => array()), 'We can\'t find proper data to display');
		}
	}

	public function dashboard(Request $request)
	{

		if($request->has('lat') && $request->lat != '' && $request->has('long') && $request->long != '' ) {

			DB::table('users')
				->where('id', $request->current_user)
				->update(
					array(
						'lat' => $request->lat,
						'long' => $request->long
					)
				);
		}

		//category list
		$categories = DB::table("categories")
            ->select(
                "categories.id","categories.name","categories.image",
                DB::raw(
                    "6371 * acos(cos(radians(" . $request->lat . ")) 
                    * cos(radians(vendor_stores.lat)) 
                    * cos(radians(vendor_stores.long) - radians(" . $request->long . ")) 
                    + sin(radians(" .$request->lat. ")) 
                    * sin(radians(vendor_stores.lat))) AS distance"
                ))
            ->join('vendor_stores','vendor_stores.id','=','categories.store_id')
            ->whereNull('categories.parent')
            ->where('categories.status','=','enable')
            ->orderBy('distance', 'asc')
            ->limit(5)
            ->get();

            foreach ($categories as $key => $cateory) {

           	$subcategory = Category::where('parent',$cateory->id)->exists();

				$category[] = array('category_id' =>  $cateory->id,
								'name' =>  $cateory->name,
								'has_subcategory'=>$subcategory,
					 			'image' => ($cateory->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/categories/'.$cateory->image)),
							);
			}
		//best selling product
		

		$selling_prodcts = DB::table("products")
        		->select('product_variants.id',
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
			            DB::raw(
			                "6371 * acos(cos(radians(" . $request->lat . ")) 
			                * cos(radians(vendor_stores.lat)) 
			                * cos(radians(vendor_stores.long) - radians(" . $request->long . ")) 
			                + sin(radians(" .$request->lat. ")) 
			                * sin(radians(vendor_stores.lat))) AS distance"
			            ),
			            DB::raw('count(order_items.product_variant_id) as count')
	            	)
	        ->join('product_variants','product_variants.product_id','=','products.id')
	        ->join('vendor_stores','vendor_stores.id','=','products.store_id')
	        ->join('categories','categories.id','=','products.category_id')
			->join('brands','brands.id','=','products.brand_id')
			->join('order_items','order_items.product_variant_id','=','product_variants.id')
	        ->where('products.status','=','enable')
			->groupBy('order_items.product_variant_id')
    		->orderBy('count', 'DESC')
	        ->orderBy('distance', 'asc')
	        ->limit(5)
	        ->get();
          	
          	// print_r($selling_prodcts->toArray());die();
	      	foreach ($selling_prodcts as $key => $value) {
	      		$wishlist = UserWishlist::where('product_id',$value->id)->where('user_id',$request->current_user)->exists();
				$product_images = ProductImages::where('product_id',$value->product_id)->get();
				//$product_variants = ProductVariants::where('product_id',$value->product_id)->first();
				$image=[];
				$rating = $this->product_ave_rating($value->id);
				
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


				$best_selling_product[] = array('id'=>$value->id,
											'product_id'=>$value->product_id,
											'name' => $value->product,
											'price'=>$value->price,
											'discount'=>$value->discount,
											'brand' =>  $value->brand,
											'category' =>  $value->category,
											'status'=>$value->status,
											'wishlist'=>$wishlist,
											'image'=>$image,
											'store'=>$store,
											'rating'=>$rating
										);
			}
				
		$end_date = date('Y-m-d');
		$start_date =  date('Y-m-d', strtotime('-7 days'));
			
		//trending product
		$best_trending_prodcts = [];
		$trending_prodcts = DB::table("products")
		            ->select(
		                'product_variants.id',
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
		                'order_items.created_at',
		                DB::raw('count(order_items.product_variant_id) as count'),
		                DB::raw(
		                    "6371 * acos(cos(radians(" . $request->lat . ")) 
		                    * cos(radians(vendor_stores.lat)) 
		                    * cos(radians(vendor_stores.long) - radians(" . $request->long . ")) 
		                    + sin(radians(" .$request->lat. ")) 
		                    * sin(radians(vendor_stores.lat))) AS distance"
		                ))
		            ->join('product_variants','product_variants.product_id','=','products.id')
		            ->join('vendor_stores','vendor_stores.id','=','products.store_id')
		            ->join('categories','categories.id','=','products.category_id')
					->join('brands','brands.id','=','products.brand_id')
					->join('order_items','order_items.product_variant_id','=','product_variants.id')
					->whereBetween(DB::raw('DATE(order_items.created_at)'), [$start_date, $end_date])
					->groupBy('order_items.product_variant_id')
	        		->orderBy('count', 'DESC')
		            ->where('products.status','=','enable')
		            ->orderBy('distance', 'asc')
		            ->limit(5)
		            ->get();
          	
          	foreach ($trending_prodcts as $key => $value) {

          		$wishlist = UserWishlist::where('product_id',$value->id)->where('user_id',$request->current_user)->exists();
				$product_images = ProductImages::where('product_id',$value->product_id)->get();
				//$product_variants = ProductVariants::where('product_id',$value->product_id)->first();
				$image=[];
				$rating = $this->product_ave_rating($value->id);
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
				$best_trending_prodcts[] = array('id'=>$value->id,
											'product_id'=>$value->product_id,
											'name' => $value->product,
											'price'=>$value->price,
											'discount'=>$value->discount,
											'brand' =>  $value->brand,
											'category' =>  $value->category,
											'status'=>$value->status,
											'wishlist'=>$wishlist,
											'image'=>$image,
											'store'=>$store,
											'rating'=>$rating
											);
				// print_r($best_trending_prodcts);

			}
			// die();

			//seasonal items
			$best_seasonal_items = null;
			$season = getCurrentSeason(date('F'));
			if($season){
				$seasonal_items = DB::table("products")
			        ->select(
			           'product_variants.id',"products.title as product","products.id as product_id","products.status","categories.name as category","brands.name as brand","vendor_stores.name","vendor_stores.branch_admin","vendor_stores.email","vendor_stores.phone_number","vendor_stores.open_status","vendor_stores.image","vendor_stores.id as store_id","product_variants.price","product_variants.discount",
			            DB::raw(
			                "6371 * acos(cos(radians(" . $request->lat . ")) 
			                * cos(radians(vendor_stores.lat)) 
			                * cos(radians(vendor_stores.long) - radians(" . $request->long . ")) 
			                + sin(radians(" .$request->lat. ")) 
			                * sin(radians(vendor_stores.lat))) AS distance"
			            ))
			        ->join('product_variants','product_variants.product_id','=','products.id')
			        ->join('vendor_stores','vendor_stores.id','=','products.store_id')
			        ->join('categories','categories.id','=','products.category_id')
					->join('brands','brands.id','=','products.brand_id')
			        ->where('products.status','=','enable')
			        ->where('products.season',$season)
			        ->orderBy('distance', 'asc')
			        ->limit(5)
			        ->get();
	          	
	          	foreach ($seasonal_items as $key => $value) {

	          		$wishlist = UserWishlist::where('product_id',$value->id)->where('user_id',$request->current_user)->exists();

					$product_images = ProductImages::where('product_id',$value->product_id)->get();
					//$product_variants = ProductVariants::where('product_id',$value->product_id)->first();
					$image=[];
					$rating = $this->product_ave_rating($value->id);
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
					$best_seasonal_items[] = array('id'=>$value->id,
												'product_id'=>$value->product_id,
												'name' => $value->product,
												'price'=>$value->price,
												'discount'=>$value->discount,
												'brand' =>  $value->brand,
												'category' =>  $value->category,
												'status'=>$value->status,
												'wishlist'=>$wishlist,
												'image'=>$image,
												"store"=>$store,
												'rating'=>$rating
											);
				}
			}

			//banner list
		$banners = DB::table("banners")
            ->select(
                "banners.id","banners.banner_title","banners.position","banners.image",
                DB::raw(
                    "6371 * acos(cos(radians(" . $request->lat . ")) 
                    * cos(radians(vendor_stores.lat)) 
                    * cos(radians(vendor_stores.long) - radians(" . $request->long . ")) 
                    + sin(radians(" .$request->lat. ")) 
                    * sin(radians(vendor_stores.lat))) AS distance"
                ))
            ->join('vendor_stores','vendor_stores.id','=','banners.store_id')
            ->where('banners.status','=','active')
            ->orderBy('distance', 'asc')
            ->limit(5)
            ->get();

            foreach ($banners as $key => $banner) {
				$banner_list[] = array('banner_id' =>  $banner->id,
									'name' =>  $banner->banner_title,
									'position'=>$banner->position,
					 				'image' => ($banner->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/banners/'.$banner->image)),
								);
			}

		// store list
		$neab_by = false;
		$near_by_limit = 0;
		$near_by_error = null;
		$customer_store_radius = Setting::where('key','customer_store_radius')->first();
		if(!empty($customer_store_radius)){
			$near_by_limit = miles2kms($customer_store_radius->value);
		}

		$vendor_stores = DB::table("vendor_stores")
            ->select(
                "vendor_stores.id","vendor_stores.name","vendor_stores.branch_admin","vendor_stores.phone_number","vendor_stores.email","vendor_stores.open_status","vendor_stores.image",
                DB::raw(
                    "6371 * acos(cos(radians(" . $request->lat . ")) 
                    * cos(radians(vendor_stores.lat)) 
                    * cos(radians(vendor_stores.long) - radians(" . $request->long . ")) 
                    + sin(radians(" .$request->lat. ")) 
                    * sin(radians(vendor_stores.lat))) AS distance"
                ))
            ->where('vendor_stores.status','=','enable')
            ->orderBy('distance', 'asc')
            ->limit(5)
            ->get();

        foreach($vendor_stores as $vendor_store)
        {
        	$success[] = array(
        		'store_id' =>  $vendor_store->id,
				'name' =>  $vendor_store->name,
				'branch_admin' =>$vendor_store->branch_admin,
				'phone_number' =>$vendor_store->phone_number,
				'email' =>$vendor_store->email,
				'current_status' =>$vendor_store->open_status,
				'image' => ($vendor_store->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$vendor_store->image)),
			);	

			if(!empty($vendor_store->distance) && $vendor_store->distance < $near_by_limit) {

				$neab_by = true;
			}
        }

        if($neab_by == false) {

			$near_by_error = 'Stores near by are yet to join us. Thank you for your patience. We will notify you as soon as one becomes available. Meanwhile, suggest to us a store you frequently visit.';
		}

		$result = array(
			'categories' => $category,
			'best_selling_items' => $best_selling_product,
			'stores' => $success,
			'best_trending_items' => $best_trending_prodcts,
			'seasonal_items' => $best_seasonal_items,
			'banners'=> $banner_list,
			'near_by_error' => $near_by_error
		);
        return $this->sendResponse($result,'Data retrieved successfully');
	}

	public function productDetail(Request $request, $id)
	{
		$data=[];
		$attr = [];
		
		$products = Products::join("product_variants",'product_variants.product_id','=',
							'products.id')
						->select('products.id as id',
								'products.title',
								'products.description',
								'product_variants.price',
								'product_variants.discount',
								'product_variants.attribute_id',
								'product_variants.attribute_value_id',
								'product_variants.id as variants_id',
								'products.store_id'
							)
						->where('product_variants.id',$id)
						->where('products.status','=','enable')
				        ->first();

		 $vendor_store = VendorStore::where('id',$products->store_id)->first();
            
            $store = array('store_id' => $vendor_store['id'],
                    'name' => $vendor_store['name'],
                    'branch_admin' => $vendor_store['branch_admin'],
                    'phone_number' => $vendor_store['phone_number'],
                    'email' => $vendor_store['email'],
                    'current_status' => $vendor_store['open_status'],
                    'image' => ($vendor_store['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$vendor_store['image']))
                );


		$product_attr_val = explode(',', $products->attribute_value_id);
	    $wishlist = UserWishlist::where('product_id',$products->variants_id)->where('user_id',$request->current_user)->exists();
	    $rating = $this->product_ave_rating($products->variants_id);
		$product_variants = ProductVariants::where('product_id',$products->id)->get();
		foreach ($product_variants as $key) {

			$value_id = explode(',',$key->attribute_value_id);
			foreach ($value_id as $value) {
				
				$attribute_value = AttributeValue::join('attributes','attributes.id',
							'attribute_values.attribute_id')
							->select('attributes.name as attribute','attribute_values.id','attribute_values.name')
							->where('attribute_values.id',$value)
							->get();

				foreach ($attribute_value as $attribute) {
					$default = (in_array($attribute->id, $product_attr_val) ? true : false);
					$data[$attribute->attribute][] = array('id'=>$attribute->id, 'name'=>$attribute->name, 'default'=> $default);
				}
			}
		}
	
		foreach ($data as $key => $value) {

			$attr[] = array('label'=>$key,'option'=>$value);
		}
		
		$image=[];	
		$product_images = ProductImages::where('product_id',$products->id)->get();
		foreach ($product_images as $key) {
			$image[] = array('image' => ($key['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/product_images/'.$key['image'])) );
		}

		$product = array('id'=>$products->variants_id,
						'product_id'=>$products->id,
						'name' => $products->title,
						'description' => $products->description,
						'price' => $products->price,
						'discount' => $products->discount,
						'wishlist'=>$wishlist,
						'attributes'=>$attr,
						'image'=>$image,
						'rating'=>$rating,
						'store' => $store
					);

		return $this->sendResponse(array('product'=>$product),'Data retrieved successfully');
	}

	public function productVariantDetail(Request $request)
	{
		$product = [];
		$products = Products::join("product_variants",'product_variants.product_id','=',
							'products.id')
						->select('products.id as id',
								'products.store_id',
								'products.title',
								'products.description',
								'product_variants.price',
								'product_variants.discount',
								'product_variants.attribute_id',
								'product_variants.attribute_value_id',
								'product_variants.id as variants_id'
							)
						//->whereIn('product_variants.attribute_value_id',$request->option)
						->where('product_variants.attribute_value_id', implode(',', $request->option))
						->where('products.id',$request->product_id)
						->where('products.status','=','enable')
				        ->first();
		if (!empty($products)) {
		    $product_attr_val = explode(',', $products->attribute_value_id);
		    $wishlist = UserWishlist::where('product_id',$products->variants_id)->where('user_id',$request->current_user)->exists();
		   	$rating = $this->product_ave_rating($products->variants_id);
			$product_variants = ProductVariants::where('product_id',$products->id)->get();
			foreach ($product_variants as $key) {

				$value_id = explode(',',$key->attribute_value_id);
				foreach ($value_id as $value) {
					
					$attribute_value = AttributeValue::join('attributes','attributes.id',
								'attribute_values.attribute_id')
								->select('attributes.name as attribute','attribute_values.id','attribute_values.name')
								->where('attribute_values.id',$value)
								->get();

					foreach ($attribute_value as $attribute) {
						$default = (in_array($attribute->id, $product_attr_val) ? true : false);
						$data[$attribute->attribute][] = array('id'=>$attribute->id, 'name'=>$attribute->name, 'default'=> $default);
					}
				}
			}
		
			foreach ($data as $key => $value) {
				$attr[] = array('label' => $key, 'option' => $value);
			}
			
			$image=[];
			$product_images = ProductImages::where('product_id',$products->id)->get();
			foreach ($product_images as $key) {
				$image[] = array('image' => ($key['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/product_images/'.$key['image'])) );
			}

			$store = array();
			$vendor_store = VendorStore::find($products->store_id);
            if(!empty($vendor_store)){
	            $store = array(
	            	'store_id' => $vendor_store->id,
	                'name' => $vendor_store->name,
	                'branch_admin' => $vendor_store->branch_admin,
	                'phone_number' => $vendor_store->phone_number,
	                'email' => $vendor_store->email,
	                'current_status' => $vendor_store->open_status,
	                'image' => ($vendor_store->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$vendor_store->image))
                );
            }

			$product = array(
				'id' => $products->variants_id,
				'product_id' => $products->id,
				'name' => $products->title,
				'description' => $products->description,
				'price' => $products->price,
				'discount' => $products->discount,
				'wishlist' => $wishlist,
				'attributes' => $attr,
				'image' => $image,
				'rating'=>$rating,
				'store' => $store
			);
		}

		if (!empty($product)) {
			return $this->sendResponse(array('product' => $product),'Data retrieved successfully');
		}else{
			return $this->sendError('Product not available');
		}
	}

	public function productList(Request $request)
	{
		$selling_products = DB::table("products")
    		->select(
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
	            'products.created_at',
	            'product_variants.id as variant_id'
           	)
	        ->join('vendor_stores','vendor_stores.id','=','products.store_id')
	        ->join('categories','categories.id','=','products.category_id')
			->join('brands','brands.id','=','products.brand_id')
			->join('product_variants','product_variants.product_id','=','products.id')
			->join('product_reviews','product_reviews.product_id','=','products.id');

		if($request->category != ''){
            $selling_products = $selling_products->where('categories.id',$request->category);
        }elseif($request->brand != ''){
        	$selling_products = $selling_products->where('brands.id',$request->brand);
        }elseif($request->sorting == 'high_to_low'){
        	$selling_products = $selling_products->orderBy('product_variants.price', 'DESC');
        }elseif($request->sorting == 'low_to_high'){
        	$selling_products = $selling_products->orderBy('product_variants.price', 'ASC');
        }elseif($request->sorting == 'new_arrival'){
        	$selling_products = $selling_products->orderBy('products.created_at', 'DESC');
        }elseif($request->sorting == 'customer_review'){
        	$selling_products = $selling_products->orderBy('product_reviews.rating', 'DESC');
        }
     
	   	$selling_products = $selling_products->where('products.status','=','enable')
	        ->get();

        //print_r($selling_products->toArray());die();
        if($selling_products->isNotEmpty())
        {
	      	foreach ($selling_products as $key => $value) {
	      		$wishlist = UserWishlist::where('product_id',$value->variant_id)->exists();
				$product_images = ProductImages::where('product_id',$value->product_id)->get();
				$product_variants = ProductVariants::where('product_id',$value->product_id)->first();
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
				if(is_float($product_variants->price)){

				}
				$products[] = array('product_id'=>$value->product_id,
									'name' => $value->product,
									'price'=> $product_variants->price,
									'discount'=>$product_variants->discount,
									'brand' =>  $value->brand,
									'category' =>  $value->category,
									'status'=>$value->status,
									'wishlist'=>$wishlist,
									'created'=>1000 * strtotime($value->created_at),
									'image'=>$image,
									'store'=>$store
								);
				 //print_r($products); 	
			}
		}else{
			$products=null;
		}
		//die(); 
		return $this->sendResponse(array('products'=> $products),'All stores');
	}

	public function storeDashboard(Request $request, $id)
	{
		//category list
		$categories = DB::table("categories")
            ->select(
                "categories.id","categories.name","categories.image")
            ->join('vendor_stores','vendor_stores.id','=','categories.store_id')
            ->whereNull('categories.parent')
            ->where('categories.status','=','enable')
            ->where('vendor_stores.id','=',$id)
            ->limit(5)
            ->get();
        if($categories->isNotEmpty())
		{
            foreach ($categories as $key => $cateory) {
            	$subcategory = Category::where('parent',$cateory->id)->exists();
				$category[] = array(
							'category_id' =>  $cateory->id,
							'name' =>  $cateory->name,
							'has_subcategory'=>$subcategory,
				 			'image' => ($cateory->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/categories/'.$cateory->image)),
						);
			}
		}else{
			 $category =null;
			// $category =[];
		}
		//best selling product
		$selling_products = DB::table("products")
        		->select('product_variants.id',
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
        			DB::raw('count(order_items.product_variant_id) as count')
	           	)
        	->join('product_variants','product_variants.product_id','=','products.id')
	        ->join('vendor_stores','vendor_stores.id','=','products.store_id')
	        ->join('categories','categories.id','=','products.category_id')
			->join('brands','brands.id','=','products.brand_id')
			->join('order_items','order_items.product_variant_id','=','product_variants.id')
			->where('vendor_stores.id','=',$id)
	        ->where('products.status','=','enable')
	        ->groupBy('order_items.product_variant_id')
  			->orderBy('count', 'DESC')
	        ->limit(5)
	        ->get();

        if($selling_products->isNotEmpty())
		{  	
          	// print_r($selling_prodcts->toArray());die();
	      	foreach ($selling_products as $key => $value) {
	      		$wishlist = UserWishlist::where('product_id',$value->id)->where('user_id',$request->current_user)->exists();
				$product_images = ProductImages::where('product_id',$value->product_id)->get();
				$product_variants = ProductVariants::where('product_id',$value->product_id)->first();
				$image=[];
				$rating = $this->product_ave_rating($value->id);
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

				$best_selling_product[] = array('id'=>$value->id,
											'product_id'=>$value->product_id,
											'name' => $value->product,
											'price'=>$value->price,
											'discount'=>$value->discount,
											'brand' =>  $value->brand,
											'category' =>  $value->category,
											'status'=>$value->status,
											'wishlist'=>$wishlist,
											'image'=>$image,
											'rating' => $rating,
											'store'=>$store
										);
			}
		}else{
			$best_selling_product = null;
		}
		$end_date = date('Y-m-d');
		$start_date =  date('Y-m-d', strtotime('-7 days'));
			
		
		//trending product
		$trending_prodcts = DB::table("products")
		            ->select(
		                'product_variants.id',
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
		                DB::raw('count(order_items.product_variant_id) as count'),
		                'order_items.created_at'
		                )
		            ->join('product_variants','product_variants.product_id','=','products.id')
		            ->join('vendor_stores','vendor_stores.id','=','products.store_id')
		            ->join('categories','categories.id','=','products.category_id')
					->join('brands','brands.id','=','products.brand_id')
					->join('order_items','order_items.product_variant_id','=','product_variants.id')
					->whereBetween(DB::raw('DATE(order_items.created_at)'), [$start_date, $end_date])
					->groupBy('order_items.product_variant_id')
	        		->orderBy('count', 'DESC')
					->where('vendor_stores.id','=',$id)
		            ->where('products.status','=','enable')
		            ->limit(5)
		            ->get();
        if($trending_prodcts->isNotEmpty())
		{   	
          	foreach ($trending_prodcts as $key => $value) {
          		$wishlist = UserWishlist::where('product_id',$value->id)->where('user_id',$request->current_user)->where('user_id',$request->current_user)->exists();

				$product_images = ProductImages::where('product_id',$value->product_id)->get();
				$product_variants = ProductVariants::where('product_id',$value->product_id)->first();
				$image=[];
				$rating = $this->product_ave_rating($value->id);
				foreach ($product_images as $key) {

					$image[] = array('image' => ($key['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/product_images/'.$key['image'])) );

				}
				$best_trending_prodcts[] = array('id'=>$value->id,
											'product_id'=>$value->product_id,
											'name' => $value->product,
											'price'=>$value->price,
											'discount'=>$value->discount,
											'brand' =>  $value->brand,
											'category' =>  $value->category,
											'status'=>$value->status,
											'wishlist'=>$wishlist,
											'image'=>$image,
											'rating' => $rating
											// 'store'=>$store
										);
			}
		}else{
			$best_trending_prodcts = null;
		}
	
		//seasonal items
		$best_seasonal_items =null;
		$season = getCurrentSeason(date('F'));
		if($season){
			$seasonal_items = DB::table("products")
		        ->select('product_variants.id',
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
		        		'product_variants.discount'
		            )
		        ->join('product_variants','product_variants.product_id','=','products.id')
		        ->join('vendor_stores','vendor_stores.id','=','products.store_id')
		        ->join('categories','categories.id','=','products.category_id')
				->join('brands','brands.id','=','products.brand_id')
				->where('vendor_stores.id','=',$id)
		        ->where('products.status','=','enable')
		        ->where('products.season',$season)
		        ->limit(5)
		        ->get();
	        if($seasonal_items->isNotEmpty())
			{  	
	          	foreach ($seasonal_items as $key => $value) {
	          		$wishlist = UserWishlist::where('product_id',$value->id)->where('user_id',$request->current_user)->exists();

					$product_images = ProductImages::where('product_id',$value->product_id)->get();
					$product_variants = ProductVariants::where('product_id',$value->product_id)->first();
					$image=[];
					$rating = $this->product_ave_rating($value->id);
					foreach ($product_images as $key) {

						$image[] = array('image' => ($key['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/product_images/'.$key['image'])) );

					}
					$best_seasonal_items[] = array('id'=>$value->id,
												'product_id'=>$value->product_id,
												'name' => $value->product,
												'price'=> $value->price,
												'discount'=>$value->discount,
												'brand' =>  $value->brand,
												'category' =>  $value->category,
												'status'=>$value->status,
												'wishlist'=>$wishlist,
												'image'=>$image,
												'rating' => $rating
												// "store"=>$store
											);
				}
			}
		}
			
        return $this->sendResponse(array('categories'=>$category,'best_selling_items'=>$best_selling_product,'best_trending_items'=>$best_trending_prodcts,'seasonal_items'=>$best_seasonal_items),'Data retrieved successfully');
	}

	public function filterOption(Request $request)
	{
		$categories = array("title"=>'Categories',"key"=>'categories',"type"=>'LIST_SUB_SELECTION');
		$brands = array("title"=>'Brands',"key"=>'brands',"type"=>'LIST_MULTIPLE_SELECTION');
		$price = array("title"=>'Prices',"key"=>'prices',"type"=>'RANGE');
		$discount = array("title"=>'Discount',"key"=>'discount',"type"=>'LIST_SINGLE_SELECTION');
		return $this->sendResponse(array($categories,$brands,$price,$discount),'Data retrieved successfully');
	}
	
	public function filterList(Request $request)
	{
		$false = false;
		if($request->store_id)
		{	
			if($request->key == 'categories')
			{
				if($request->selected_option){

					$categories = Category::where('store_id',$request->store_id)->where('parent','=',$request->selected_option)->get();
					if($categories->isNotEmpty()){
						foreach ($categories as $key => $value) {
							$subcategory = Category::where('parent',$value->id)->exists();
							$category[] = array('key'=>(string)$value->id,'value'=>$value->name,'has_child'=>$subcategory);
						}
						return $this->sendResponse(array('options'=>$category),'Category List');
					}else{
						$category=[];
						return $this->sendResponse(array('options'=>$category),'Category List');
					}
				}
				
				$categories = Category::where('store_id',$request->store_id)->where('parent','=',null)->get();
				foreach ($categories as $key => $value) {
					$subcategory = Category::where('parent',$value->id)->exists();
					$category[] = array('key'=>(string)$value->id,'value'=>$value->name,'has_child'=>$subcategory);
				}
				return $this->sendResponse(array('options'=>$category),'Category List');

			}elseif($request->key == 'brands'){

				$brands = Brand::where('store_id',$request->store_id)->where('status','=','enable')->get();
				foreach ($brands as $key => $value) {
					$brand[] = array('key'=>(string)$value->id,'value'=>$value->name,'has_child'=>$false);
				}
				return $this->sendResponse(array('options'=>$brand),'Brand List');

			}elseif($request->key == 'discount'){
				$product = Products::select(DB::raw('max(product_variants.discount) as max_discount'),
						DB::raw('min(product_variants.discount) as min_discount'))
						->join('product_variants','product_variants.product_id','products.id')
						->where('products.store_id',$request->store_id)
						->where('product_variants.discount','>',0)
						->first();
		
		  		$discount_type = [];
		  		if($product->min_discount <10){
		  			$discount_type1[] = array("key" =>"10|below", "value" => '10% below', 'has_child' => $false);
		  		}
		  		else{
		  			$discount_type1[] = array();
		  		}
		  		for ($n =10; $n <= $product->max_discount ; $n=$n+10) {
		  			if($n == 80){
		  				$discount = $n.' % above';
		  			}else{
		  				$discount = $n.'% more';
		  			}
			    	$discount_type[] = array("key" => (string)$n, "value" => $discount, 'has_child' => $false);
		  		}
		  		$discounts = array_merge($discount_type1,$discount_type);
				
				return $this->sendResponse(array('options'=>$discounts),'Discount List');
			}elseif($request->key == 'prices'){

				$product_price = Products::select(DB::raw('max(product_variants.price) as max_price'),
						DB::raw('min(product_variants.price) as min_price'))
						->join('product_variants','product_variants.product_id','products.id')
						->where('products.store_id',$request->store_id)
						->where('product_variants.discount','>',0)
						->first();
		
				$price1 = array("key" => 'max', "value" => number_format($product_price->max_price,2,'.',''), 'has_child' => $false);
				$price2 = array("key" => 'min', "value" => number_format($product_price->min_price,2,'.',''), 'has_child' => $false);
				/*$price3 = array("key" => '200-250', "value" => '$200 to $250', 'has_child' => $false);
				$price4 = array("key" => '250-300', "value" => '$250 to $300', 'has_child' => $false);
				$price5 = array("key" => '300-350', "value" => '$300 to $350', 'has_child' => $false);*/

	        	$price = array($price1,$price2);
				return $this->sendResponse(array('options'=>$price),'Price List List');
			}
		}else{
			if($request->key == 'categories')
			{
				if($request->selected_option){

					$categories = Category::where('parent','=',$request->selected_option)->get();
					if($categories->isNotEmpty()){
						foreach ($categories as $key => $value) {
							$subcategory = Category::where('parent',$value->id)->exists();
							$category[] = array('key'=>(string)$value->id,'value'=>$value->name,'has_child'=>$subcategory);
						}
						return $this->sendResponse(array('options'=>$category),'Category List');
					}else{
						$category=[];
						return $this->sendResponse(array('options'=>$category),'Category List');
					}
				}
				
				$categories = Category::where('parent','=',null)->get();
				foreach ($categories as $key => $value) {
					$subcategory = Category::where('parent',$value->id)->exists();
					$category[] = array('key'=>(string)$value->id,'value'=>$value->name,'has_child'=>$subcategory);
				}
				return $this->sendResponse(array('options'=>$category),'Category List');

			}elseif($request->key == 'brands'){

				$brands = Brand::where('status','=','enable')->get();
				foreach ($brands as $key => $value) {
					$brand[] = array('key'=>(string)$value->id,'value'=>$value->name,'has_child'=>$false);
				}
				return $this->sendResponse(array('options'=>$brand),'Brand List');

			}elseif($request->key == 'discount'){
			
				$product = Products::select(DB::raw('max(product_variants.discount) as max_discount'),
						DB::raw('min(product_variants.discount) as min_discount'))
						->join('product_variants','product_variants.product_id','products.id')
						->where('product_variants.discount','>',0)
						->first();
		
		  		$discount_type = [];
		  		if($product->min_discount <10){
		  			$discount_type1[] = array("key" =>"10|below", "value" => '10% below', 'has_child' => $false);
		  		}
		  		else{
		  			$discount_type1[] = array();
		  		}
		  		for ($n =10; $n <= $product->max_discount ; $n=$n+10) {
		  			if($n == 80){
		  				$discount = $n.' % above';
		  			}else{
		  				$discount = $n.'% more';
		  			}
			    	$discount_type[] = array("key" => (string)$n, "value" => $discount, 'has_child' => $false);
		  		}
		  		$discounts = array_merge($discount_type1,$discount_type);
				
				return $this->sendResponse(array('options'=>$discounts),'Discount List');
			}elseif($request->key == 'prices'){
				$product_price = Products::select(DB::raw('max(product_variants.price) as max_price'),
						DB::raw('min(product_variants.price) as min_price'))
						->join('product_variants','product_variants.product_id','products.id')
						->where('product_variants.discount','>',0)
						->first();
				
				$price1 = array("key" => 'max', "value" => number_format($product_price->max_price,2,'.',''), 'has_child' => $false);
				$price2 = array("key" => 'min', "value" => number_format($product_price->min_price,2,'.',''), 'has_child' => $false);

				// $price1 = array("key" => 'max', "value" => $product_price->max_price, 'has_child' => $false);
				// $price2 = array("key" => 'min', "value" => $product_price->min_price, 'has_child' => $false);
				/*$price3 = array("key" => '200-250', "value" => '$200 to $250', 'has_child' => $false);
				$price4 = array("key" => '250-300', "value" => '$250 to $300', 'has_child' => $false);
				$price5 = array("key" => '300-350', "value" => '$300 to $350', 'has_child' => $false);*/

	        	$price = array($price1,$price2);
				/*$price1 = array("key" => '50-100', "value" => '$50 to $100', 'has_child' => $false);
				$price2 = array("key" => '100-200', "value" => '$100 to $200', 'has_child' => $false);
				$price3 = array("key" => '200-250', "value" => '$200 to $250', 'has_child' => $false);
				$price4 = array("key" => '250-300', "value" => '$250 to $300', 'has_child' => $false);
				$price5 = array("key" => '300-350', "value" => '$300 to $350', 'has_child' => $false);

	        	$price = array($price1,$price2,$price3,$price4,$price5);*/
				return $this->sendResponse(array('options'=>$price),'Price List');
			}	
		}
	}

	public function addremoveWishlist(Request $request)
	{
		if($request->status == 'true')
		{
			$user_wishlist = new UserWishlist;
			$user_wishlist->product_id = $request->product_id;
			$user_wishlist->user_id = $request->user_id;
			$user_wishlist->save();
			return $this->sendResponse(null,'Product added to your wishlist successfully');
		}elseif($request->status == 'false'){
			
			UserWishlist::where('product_id',$request->product_id)->where('user_id',$request->user_id)->delete();

			return $this->sendResponse(null,'Product removed from your wishlist successfully');
		}
	}

	public function wishList($id)
	{
		$wish_list = DB::table("products")
		            ->select('product_variants.id',
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
		            		'product_variants.discount'
		                )
		            ->join('product_variants','product_variants.product_id','=','products.id')
		            ->join('vendor_stores','vendor_stores.id','=','products.store_id')
		            ->join('categories','categories.id','=','products.category_id')
					->join('brands','brands.id','=','products.brand_id')
					->join('user_wishlists','user_wishlists.product_id','=','product_variants.id')
					->where('user_wishlists.user_id',$id)
		            ->where('products.status','=','enable')
		            ->get();

		// print_r($wish_list->toArray());die();

        if($wish_list->isNotEmpty())
		{   	
          	foreach ($wish_list as $key => $value) {

				$product_images = ProductImages::where('product_id',$value->product_id)->get();
				$product_variants = ProductVariants::where('product_id',$value->product_id)->first();
				$image=[];
				$rating = $this->product_ave_rating($value->id);
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
				$wish_list_prodcts[] = array('id'=>$value->id,
										'name' => $value->product,
										'price'=> $value->price,
										'discount'=>$value->discount,
										'brand' =>  $value->brand,
										'category' =>  $value->category,
										'status'=>$value->status,
										'image'=>$image,
										'store'=>$store,
										'rating' => $rating
									);
			}
		}else{
			$wish_list_prodcts = [];
		}
		return $this->sendResponse($wish_list_prodcts,'Data retrieved successfully');
	}

	public function autoSearch(Request $request, $id = null)
	{
		$data = [];
		$products = Products::select('products.id','products.title')
			->where('products.title', 'like', '%' . $request->key . '%');
		if($id){
			$products = $products->join('vendor_stores','vendor_stores.id','=','products.store_id')->where('products.store_id',$id);
		}
		$products = $products->get()->toArray();

		$brands = Brand::select('brands.id','brands.name as title')
		->where('brands.name', 'like', '%' . $request->key . '%');
		if($id){
			$brands = $brands->join('vendor_stores','vendor_stores.id','=','brands.store_id')->where('brands.store_id',$id);
		}
		$brands = $brands->get()->toArray();

		$category = Category::select('categories.id','categories.name as title')
		->where('categories.name', 'like', '%' . $request->key . '%');
		if($id){
			$category = $category->join('vendor_stores','vendor_stores.id','=','categories.store_id')->where('categories.store_id',$id);
		}
		$category = $category->get()->toArray();
		
		$final_data = array_merge($products,$brands,$category);

		foreach ($final_data as $value) {

			if(array_search($value['title'], array_column($data, 'title')) === False) {
				$data[] = array('title'=>$value['title']);
			}
		}
		
		// $data = array_map("unserialize", array_unique(array_map("serialize", $data)));

		if(empty($data))
		{
			return $this->sendResponse($data,'We can\'t find proper data to display');
		}else{

			return $this->sendResponse($data,'Data retrieved successfully');
		}
	}

	public function productListById(Request $request)
	{
		$data = [];
		foreach ($request->variants_id as $key => $value) {
			# code...
			$products = ProductVariants::join('products','products.id','product_variants.product_id')
								->select('product_variants.id',
									'product_variants.quantity',
									'product_variants.price',
									'product_variants.sku_uniquecode',
									'product_variants.discount',
									'products.tax'
								)
								->where('product_variants.id',$value)->get();
			foreach ($products as $key => $product) {

				$data[] = array(
					'id' => $product->id,
					'price'=>$product->price,
					'quantity'=>$product->quantity,
					'discount'=>$product->discount,
					'tax'=>$product->tax
				);
			}
		}

		$customer_gems_reward_points = CustomerRewardPoint::where('user_id',$request->current_user)
			->where('reward_type','invite')
			->first();

		$customer_coins_reward_points = CustomerRewardPoint::where('user_id',$request->current_user)
		->where('reward_type','transaction')
		->first();

		if(empty($customer_gems_reward_points))
		{
			$gems_points = 0;
		}else{
			$gems_points = $customer_gems_reward_points->total_point;

		}
		if(empty($customer_coins_reward_points))
		{
			$coins_points = 0;
		}else{
			$coins_points = $customer_coins_reward_points->total_point;
		}

		/*$gem_setting = Setting::where('key','reward_gems_exchagne_rate')->first();
		$coin_setting = Setting::where('key','reward_coins_exchagne_rate')->first();*/
		$gem_setting = RewardPoint::select('reward_point_exchange_rate as value')->where('reward_type','invite')->first();
		$coin_setting = RewardPoint::select('reward_point_exchange_rate as value')->where('reward_type','transaction')->first();

		$max_order = Setting::where('key','reward_point_max_per_order')->first();
				
		$currencyValue = $gems_points/$gem_setting->value + $coins_points/$coin_setting->value;

		$coinBalance = array('gems' => (int)$gems_points,
			'coins' => (int)$coins_points,
			'currencyValue' => $currencyValue,
			'gemsPerDollar' => (int)$gem_setting->value,
			'coinsPerDollar' => (int)$coin_setting->value,
			'maxPointsPerOrder' => (int)$max_order->value
			);
		return $this->sendResponse(array('productsData'=>$data,'coinBalance'=> $coinBalance),'Data retrieved successfully');

	}

	public function productByCategory(Request $request , $id)
	{
		$selling_products = Products::join('vendor_stores','vendor_stores.id','=','products.store_id')
						->select('product_variants.id',
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
								'product_variants.discount'
							)
						->join('categories','categories.id','=','products.category_id')
						->join('brands','brands.id','=','products.brand_id')
						->join('product_variants','product_variants.product_id','=','products.id')
						->where('categories.id',$id);

		if($request->store_id)
		{
			$selling_products = $selling_products->where('vendor_stores.id',$request->store_id);
		}
		
		$selling_products = $selling_products->paginate(10);
					
		if($selling_products->isNotEmpty())
		{	
			$current_page = $selling_products->currentPage();
			$total_pages  = $selling_products->lastPage();		
			foreach ($selling_products as $key => $value) {

				$wish_list = UserWishlist::where('product_id',$value['id'])->where('user_id',$request->current_user)->exists();
				$rating = $this->product_ave_rating($value['id']);
				$product_images = ProductImages::where('product_id',$value['product_id'])->get();
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
				$success[] = array('id' => $value['id'],
								'product_id' => $value['product_id'],
								'name' => $value['product'],
								'brand' =>  $value['brand'],
								'price' => $value['price'],
								'discount' => $value['discount'],
								'category' =>  $value['category'],
								'status' => $value['status'],
								'wishlist' => $wish_list,
								'image' => $image,
								'store' => $store,
								'rating' => $rating
							);
			}
			return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'products'=>$success),'Data retrieved successfully');
		}else{
			$success =[];
			return $this->sendResponse(array('page'=> 1,'totalPage'=>1,'products'=>$success),'We can\'t find proper data to display');
		}
	}

	public function discountOffer(Request $request)
	{
		$stores = VendorStore::join('products','products.store_id','vendor_stores.id')
							->join('product_variants','product_variants.product_id','=','products.id')
						 	->join('countries','countries.id','=','vendor_stores.country')
            				->join('states','states.id','=','vendor_stores.state')
            				->join('cities','cities.id','=','vendor_stores.city')
							->groupBy('vendor_stores.id');

		if($request->lat && $request->long)
		{
			$stores = $stores->select('vendor_stores.id as store_id',
									'vendor_stores.lat',
									'vendor_stores.long',
									'vendor_stores.name',
									'vendor_stores.email',
									'countries.name as country',
									'states.name as state',
									'cities.name as city',
									'vendor_stores.address1',
									'vendor_stores.lat',
									'vendor_stores.long',
									'vendor_stores.pincode',
									'vendor_stores.phone_number',
									'vendor_stores.open_status',
									'vendor_stores.image',
									'vendor_stores.status',
									DB::raw('max(product_variants.discount) as discount'),
									DB::raw(
					                    "6371 * acos(cos(radians(" . $request->lat . ")) 
					                    * cos(radians(vendor_stores.lat)) 
					                    * cos(radians(vendor_stores.long) - radians(" . $request->long . ")) 
					                    + sin(radians(" .$request->lat. ")) 
					                    * sin(radians(vendor_stores.lat))) AS distance")
		                		)
								->orderBy('distance', 'asc');

		}else{
			$stores = $stores->selectRaw('max(product_variants.discount) as discount,
									vendor_stores.id as store_id,
									vendor_stores.lat,
									vendor_stores.long,
									vendor_stores.name,
									vendor_stores.email,
									countries.name as country,
									states.name as state,
									cities.name as city,
									vendor_stores.address1,
									vendor_stores.lat,
									vendor_stores.long,
									vendor_stores.image,
									vendor_stores.pincode,
									vendor_stores.phone_number,
									vendor_stores.open_status,
									vendor_stores.status'
								);
		}

		$stores = $stores->paginate(10);

		$current_page = $stores->currentPage();
		$total_pages  = $stores->lastPage();

		$storeData = [];
		foreach ($stores as $key => $store) {
			
			$storeData [] = array("store_id" => $store->store_id,
			        	"name" => $store->name,
			        	"email" => $store->email,
			        	"address" => $store->address1,
			        	"city" => $store->city,
			        	"state" => $store->state,
			        	"country" => $store->country,
			        	"lat" => $store->lat,
			        	"long" => $store->long,
			        	"pincode" => $store->pincode,
			        	"phone_number" => $store->phone_number,
			        	"current_status" => $store->open_status,
			        	"status" => $store->status,
			        	'image' => ($store->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$store->image)),
			        	"max_discount" => $store->discount
    				);

		}

		return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'stores'=>$storeData),'Data retrieved successfully');
	}

	public function discountOfferCategory($id)
	{
		$success = [];

		$category  = Category::selectRaw('max(product_variants.discount) as max_discount,categories.id,categories.name as category,categories.image')
							->join('products','products.category_id','categories.id')
							->join('product_variants','product_variants.product_id','=','products.id')
							->where('products.store_id',$id)
							->groupBy('products.category_id')
							->paginate(10);

		if($category->isNotEmpty()){

			$current_page = $category->currentPage();
		    $total_pages  = $category->lastPage();
			foreach ($category as $key => $value) {
				$subcategory = Category::where('parent',$value->id)->exists();		
				$success[] = array(
							'category_id' =>  $value->id,
							'name' =>  $value->category,
							'has_subcategory'=>$subcategory,
				 			'image' => ($value->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/categories/'.$value->image)),
				 			'max_discount' => $value->max_discount,
						);
			}
			return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'category'=>$success),'Data retrieved successfully');
		}else{
			return $this->sendResponse(array('page'=> 1,'totalPage'=>1,'category'=>$success),'We can\'t find proper data to display');
		}
	}

	public function discountProduct($id)
	{
		$discount_offers =DB::table('discount_offer_products')
							->select('product_id')
							->where('discount_id',$id)
							->get();

		// $current_page = $discount_offers->currentPage();
		// $total_pages  = $discount_offers->lastPage();	

		foreach ($discount_offers as $key => $discount_offer) {
		
			$products = Products::select('products.title',
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
						'product_variants.id',
						'product_variants.price',
						'product_variants.discount',
						'product_variants.attribute_value_id'
					)
					->join('categories','categories.id','=','products.category_id')
					->join('vendor_stores','vendor_stores.id','=','products.store_id')
					->join('brands','brands.id','=','products.brand_id')
					->join('product_variants','product_variants.product_id','=','products.id')
					->where('products.id','=',$discount_offer->product_id)
					->get();

			foreach ($products as $key => $product) {

				$product_images = ProductImages::where('variant_id',$product->id)->get();
				$image=[];
				foreach ($product_images as $key) {

					$image[] = ($key['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/product_images/'.$key['image'])) ;

				}
					$title = $product->title;
					// $attribute_values = AttributeValue::select('name')->whereIn('id', explode(',', $product->attribute_value_id))->get();
					// $attribute_values = Arr::pluck($attribute_values, 'name');
					// $title .= ' '.implode(' ', $attribute_values);

				$success[] = array( 
							'id' => $product['id'],
							'product_id' => $product['product_id'],
							'name' => $title,
							'brand' =>  $product['brand'],
							'price' => $product['price'],
							'discount' => $product['discount'],
							'category' =>  $product['category'],
							'status' => $product['status'],
							'image' => $image
							
						);
			}

		}

		// return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'products'=>$data),'Discount product');

		return $this->sendResponse($success,'Products');
	}

	public function inShop(Request $request)
	{
		// 50 meter.
	    $success = [];

		$vendor_stores = DB::table("vendor_stores")
            	->select(
	                "vendor_stores.id",
	                "vendor_stores.name",
	                "vendor_stores.branch_admin",
	                "vendor_stores.phone_number",
	                "vendor_stores.email",
	                "vendor_stores.open_status",
	                "vendor_stores.image",
	                DB::raw(
	                    "6371 * acos(cos(radians(" . $request->lat . ")) 
	                    * cos(radians(vendor_stores.lat)) 
	                    * cos(radians(vendor_stores.long) - radians(" . $request->long . ")) 
	                    + sin(radians(" .$request->lat. ")) 
	                    * sin(radians(vendor_stores.lat))) AS distance"
	                )
	            )
            ->where('vendor_stores.status','=','enable')
            // ->having('distance', '<', 0.05)
            ->orderBy('distance', 'asc')
            // ->limit(5)
            ->get();

        if($vendor_stores->isNotEmpty())
		{   
	       	foreach($vendor_stores as $vendor_store)
	        {
	        	$success[] = array(
					'store_id' =>  $vendor_store->id,
					'name' =>  $vendor_store->name,
					'branch_admin' =>$vendor_store->branch_admin,
					'phone_number' =>$vendor_store->phone_number,
					'email' =>$vendor_store->email,
					'current_status' =>$vendor_store->open_status,
					'image' => ($vendor_store->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$vendor_store->image)),
				);	
	        }
	        return $this->sendResponse($success,'Data retrieved successfully');

	    }else{

        	return $this->sendResponse($success,'OOPS!!! There are no stores available on your current location');
	    }
	}

	/*public function scanBarcodeProduct(Request $request)
	{
		$product_variants = ProductVariants::select(
							'products.title',
							'product_variants.id',
							'product_variants.price',
							'product_variants.discount',
							'product_variants.attribute_value_id',
							'product_variants.quantity',
							'product_variants.barcode',
							'brands.name',
							'vendor_stores.name as store',
							'categories.name as category',
							'products.id as product_id',
							'products.status'
						)
						->join('products','products.id','product_variants.product_id')
						->leftjoin('brands','brands.id','=','products.brand_id')
						->join('vendor_stores','vendor_stores.id','=','products.store_id')
						->leftjoin('categories','categories.id','=','products.category_id')
						->where('barcode',$request->barcode)
						->where('vendor_stores.id',$request->store_id)
						->first();
						
	    if(!empty($product_variants)){

			$product_images = ProductImages::where('variant_id',$product_variants->id)->get();

			$image=[];

			foreach ($product_images as $key) {

				$image[] = array('image' => ($key['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/product_images/'.$key['image'])) );
			}

			$productData = array('id' => $product_variants->id,
				'product_id' => $product_variants->product_id,
				'name' => $product_variants->title,
				'price' => $product_variants->price,
				'discount' => $product_variants->discount,
				'brand' => $product_variants->name,
				'category' => $product_variants->category,
				'status' => $product_variants->status,
				'image' => $image
			);

			return $this->sendResponse($productData,'Product Details.');
		
		}else{

			$response = (object)array();
			return $this->sendError('Product is not avaliable in store.');
		}
	}*/

	public function scanBarcodeProduct(Request $request)
	{
		$product_variants = ProductVariants::select(
							'products.title',
							'product_variants.id',
							'product_variants.price',
							'product_variants.discount',
							'product_variants.attribute_value_id',
							'product_variants.quantity',
							'product_variants.barcode',
							'brands.name',
							'vendor_stores.name as store',
							'categories.name as category',
							'products.id as product_id',
							'products.status',
							'products.vendor_id',
							'vendor_stores.id as store_id'
						)
						->join('products','products.id','product_variants.product_id')
						->leftjoin('brands','brands.id','=','products.brand_id')
						->join('vendor_stores','vendor_stores.id','=','products.store_id')
						->leftjoin('categories','categories.id','=','products.category_id')
						->where('barcode',$request->barcode)
						->where('vendor_stores.id',$request->store_id)
						->first();
						
	    if(!empty($product_variants)){
	    	$user_cart = UserCart::where('user_id' , $request->current_user)->where('product_variant_id',$product_variants->id)->first();

	    	if($product_variants->quantity - 1 > 0)
	    	{
	    		if(!empty($user_cart)){
		    		$user_cart->product_variant_id = $product_variants->id;
		    		$user_cart->quantity = $user_cart->quantity+1;
		    		$user_cart->save(); 
		    	}else{
		    		$user_cart = new UserCart;
		    		$user_cart->user_id = $request->current_user;
		    		$user_cart->product_variant_id = $product_variants->id;
		    		$user_cart->quantity = 1;
		    		$user_cart->save();
		    	}
		    	$product_images = ProductImages::where('variant_id',$product_variants->id)->get();

				$image=[];

				foreach ($product_images as $key) {

					$image[] = array('image' => ($key['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/product_images/'.$key['image'])) );
				}

				$productData = array('id' => $product_variants->id,
					'product_id' => $product_variants->product_id,
					'name' => $product_variants->title,
					'price' => $product_variants->price,
					'discount' => $product_variants->discount,
					'brand' => $product_variants->name,
					'category' => $product_variants->category,
					'status' => $product_variants->status,
					'image' => $image
				);

				// update user active
				$active_user = ActiveUser::where('user_id',$request->current_user)->where('store_id',$request->store_id)->first();
				if(empty($active_user)){
					$user = new ActiveUser;
					$user->user_id = $request->current_user;
					$user->store_id = $request->store_id;
					$user->save();
				}
				//active user notification to vendor.
				/*$id = $product_variants->store_id;
				$type = 'success_order';
			    $title = 'Order';
			    $message = 'Your order has been Successfully.';
			    $devices = UserDevice::where('user_id',$product_variants->vendor_id)->where('user_type','vendor')->get();
			    $this->sendVendorNotification($title, $message, $devices, $type, $id);*/

				return $this->sendResponse($productData,'Data retrieved successfully');
	    	}else{
	    		$productData = [];
	    		return $this->sendError('Product is out of stock',$productData);
	    		// return $this->sendResponse(false,$productData,'Not sufficient quantity');
	    	}
		
		}else{
			$response = (object)array();
			return $this->sendError('The product is not available in the store.');
		}
	}
	
	public function product_ave_rating($id)
	{
		$product_review = ProductReview::where('product_id',$id)->avg('rating');

		if(!empty($product_review)){
			$review = $product_review;
		}else{
			$review=0.0;
		}
		return  $review;
	}
}