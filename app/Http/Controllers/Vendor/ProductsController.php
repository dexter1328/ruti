<?php

namespace App\Http\Controllers\Vendor;

use DB;
use Auth;
use Schema;
use App\Brand;
use App\Vendor;
use App\Category;
use App\Products;
use App\Attribute;
use App\AttributeValue;
use App\VendorStore;
use App\ProductImages;
use App\ProductVariants;
use App\VendorsSubCategory;
use App\Notification;
use App\Traits\Permission;
use App\Helpers\LogActivity as Helper;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
	use Permission;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function __construct()
	{
		$this->middleware('auth:vendor');
		$this->middleware(function ($request, $next) {
			if(!$this->hasVendorPermission(Auth::user())){
				return redirect('vendor/home');
			}
			return $next($request);
		});
	}

	public function index()
	{
		$store_ids = getVendorStore();
		$vendor_stores = VendorStore::whereIn('id', $store_ids)->get();
		/*$products = Products::join('vendors','vendors.id','=','products.vendor_id')
							->leftJoin('vendor_stores','vendor_stores.id','=','products.store_id')
							->leftJoin('categories','categories.id','=','products.category_id')
							->leftJoin('brands','brands.id','=','products.brand_id')
							->select('vendors.name as owner_name','vendor_stores.name as store_name',
									'categories.name as category_name','brands.name as brand_name','products.id','products.title','products.type','products.status')
							->whereIn('vendor_stores.id', $store_ids)
							->get();*/

		return view('vendor/products/index',compact('vendor_stores'));
	}

	public function productDatatable(request $request)
    {
    	$store_ids = getVendorStore();
    	$columns = array(
			0 => 'vendor',
			1 => 'store',
			2 => 'title',
			3 => 'action'
		);
		$totalData = Products::join('vendors','vendors.id','=','products.vendor_id')
							->leftJoin('vendor_stores','vendor_stores.id','=','products.store_id')
							->leftJoin('categories','categories.id','=','products.category_id')
							->leftJoin('brands','brands.id','=','products.brand_id')
							->select('vendors.name as owner_name','vendor_stores.name as store_name',
									'categories.name as category_name','brands.name as brand_name','products.id','products.title','products.type','products.status')
							->whereIn('vendor_stores.id', $store_ids)
							->get()
							->count();

        $totalFiltered = $totalData;

		$limit = $request->input('length');
		$start = $request->input('start');

		$order = $columns[$request->input('order.0.column')];
		$dir = $request->input('order.0.dir');


		if(empty($request->input('search.value'))){

			$products = Products::join('vendors','vendors.id','=','products.vendor_id')
							->leftJoin('vendor_stores','vendor_stores.id','=','products.store_id')
							->leftJoin('categories','categories.id','=','products.category_id')
							->leftJoin('brands','brands.id','=','products.brand_id')
							->select('vendors.name as owner_name','vendor_stores.name as store_name',
									'categories.name as category_name','brands.name as brand_name','products.id','products.title','products.type','products.status')
							->whereIn('vendor_stores.id', $store_ids)
							->offset($start)
							->limit($limit)
							->orderBy('products.id','DESC')
							->get();

		}else{

			$search = $request->input('search.value');


			$products = Products::join('vendors','vendors.id','=','products.vendor_id')
							->leftJoin('vendor_stores','vendor_stores.id','=','products.store_id')
							->leftJoin('categories','categories.id','=','products.category_id')
							->leftJoin('brands','brands.id','=','products.brand_id')
							->select('vendors.name as owner_name','vendor_stores.name as store_name',
									'categories.name as category_name','brands.name as brand_name','products.id','products.title','products.type','products.status')
							->whereIn('vendor_stores.id', $store_ids);

	        	$products = $products->where(function($query) use ($search){
				$query->where('vendors.name', 'LIKE',"%{$search}%")
					->orWhere('vendor_stores.name', 'LIKE',"%{$search}%")
					->orWhere('products.title', 'LIKE',"%{$search}%");
			});
			//$products = $products->orHavingRaw('Find_In_Set("'.$search.'", attribute_value_names) > 0');

			$totalFiltered = $products;
			$totalFiltered = $totalFiltered->get()->count();

			$products = $products->offset($start)
				->limit($limit)
				->orderBy('products.id')
				->get();
		}

        $data = array();
		if($products->isNotEmpty())
		{
			foreach ($products as $key => $product)
			{
				// @if($admin->status=='active')color:#009933;@else color: #ff0000;@endif
				if($product->status == 'enable')
				{
					$color = 'color:#009933;';
				}else{
					$color ='color:#ff0000;';
				}

				$nestedData['vendor'] = $product->owner_name;
				$nestedData['store'] = $product->store_name;
				$nestedData['title'] = $product->title;
				$nestedData['action'] = '<form id="deletefrm_'.$product->id.'" action="'.route('vendor.products.destroy', $product->id).'" method="POST" onsubmit="return confirm(\""Are you sure?"\");">
											<input type="hidden" name="_token" value="'.csrf_token().'">
											<input type="hidden" name="_method" value="DELETE">
											<a href="'.route('vendor.products.edit', $product->id).'" data-toggle="tooltip" data-placement="bottom" title="Edit Vendor">
											<i class="icon-note icons"></i>
											</a>
											<a href="javascript:void(0);" onclick="deleteRow('.$product->id.')" data-toggle="tooltip" data-placement="bottom" title="Delete Vendor">
												<i class="icon-trash icons"></i>
											</a>
											<a href="javascript:void(0);" onclick="changeStatus('.$product->id.')" >
										 		<i class="fa fa-circle status_'.$product->id.'" style="'.$color.'" id="enable_'.$product->id.'" data-toggle="tooltip" data-placement="bottom" title="Change Status" ></i>
											</a>
										</form>';
				$data[] = $nestedData;
			}

		}

		$json_data = array(
			"draw"            => intval($request->input('draw')),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);exit();
    }

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$attributes = Attribute::all();
		$store_ids = getVendorStore();
		$vendor_stores = VendorStore::whereIn('id', $store_ids)->get();
		return view('vendor/products/create',compact('vendor_stores','attributes'));
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request)
	{

		$request->validate([
			'store' => 'required',
			'title' => 'required',
			'regular_price' => 'required',
			'discount' => 'required',
			'sku' => 'required',
			'quantity' => 'required',
			'lowstock_threshold' => 'required',
			'image' => 'required'
		]);

		if($request->attribute)
		{
			$type = 'group';

				$attribute = implode(',',$request->attribute);
				$attribute_value_id = implode(',',$request->attribute_values);



		}else{
			$type = 'single';
			$attribute_value_id = NULL;
			$attribute = NULL;
		}


		$products = new Products;
		$products->vendor_id = Auth::user()->id;
		$products->store_id = $request->input('store');
		$products->title = $request->input('title');
		$products->category_id = implode(",",$request->input('category'));
		$products->description = $request->input('description');
		$products->brand_id = $request->input('brand');
		$products->tax = $request->input('tax');
		$products->season = $request->input('season');
		$products->type = $type;
		$products->aisle = $request->input('aisle');
		$products->shelf = $request->input('shelf');
		$products->created_by = Auth::user()->id;
		$products->save();

		$product_variants = new ProductVariants;
		$product_variants->product_id = $products->id;
		$product_variants->attribute_id = $attribute;
		$product_variants->attribute_value_id = $attribute_value_id;
		$product_variants->sku_uniquecode = $request->sku;
		$product_variants->quantity = $request->quantity;
		$product_variants->price = $request->regular_price;
		$product_variants->discount = $request->discount;
		$product_variants->lowstock_threshold = $request->lowstock_threshold;
		$product_variants->barcode = $products->id;
		$product_variants->created_by = Auth::user()->id;

		$product_variants->save();

		if($request->file('image')){
			foreach($request->file('image') as $key => $images){

				$path = 'public/images/product_images';
				$profileImage = date('YmdHis') .$key ."." . $images->getClientOriginalExtension();
				$images->move($path, $profileImage);
				$product_images = new ProductImages;
				$product_images->product_id = $products->id;
				$product_images->variant_id = $product_variants->id;
				$product_images->created_by =Auth::user()->id;
				$product_images['image'] = $profileImage;
				$product_images->save();
			}
		}

		$this->__completeVendorChecklist(Auth::user()->id, 'add_inventory');

		if($request->btnSubmit == 'close'){
			return redirect('/vendor/products')->with('success',"Products successfully saved.");
		}elseif($request->btnSubmit == 'new'){
			return redirect('/vendor/products/create')->with('success',"Products successfully saved.");
		}elseif($request->btnSubmit == 'edit'){
			return redirect('/vendor/products/'.$products->id.'/edit')->with('success',"Products successfully saved.");
		}
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{

	}

	public function addAttributeSet($lngth)
	{
		$attributes = Attribute::all();
		$view = view("vendor/products/attribute",compact('attributes','lngth'))->render();
		return response()->json(['html'=>$view]);
	}

	public function getAttributeValues($attribute_id, $lngth)
	{
		$attribute = Attribute::where('id',$attribute_id)->first();
		$attribute_values = AttributeValue::select('attributes.name as attribute_name', 'attribute_values.id', 'attribute_values.name', 'attribute_values.attribute_id')
			->join('attributes', 'attributes.id', 'attribute_values.attribute_id')
			->where('attribute_id',$attribute_id)
			->where('attribute_values.store_id',$attribute->store_id)
			->get();
		$first = Arr::first($attribute_values);

		$str = '';
		$str .= '<div class="row">';
			$str .= '<div class="col-xs-12 col-md-6">';
				$str .= '<label>&nbsp;</label>';
				$str .= '<input type="hidden" name="attribute[]" value="'.$attribute_id.'">';
				$str .= '<select class="form-control attribute'.$first['attribute_name'].'" name="attribute_values[]"        id="attribute_values_'.$attribute_id.'">';
					$str .= '<option value="">Select '.$first['attribute_name'].'</option>';
					foreach ($attribute_values as $key => $attribute_value) {
						$str .= '<option value="'.$attribute_value->id.'">'.$attribute_value->name.'</option>';
					}
				$str .= '</select>';
			$str .= '</div>';
			$str .= '<div class="col-xs-12 col-md-6">';
				$str .= '<label>&nbsp;</label>';
				$str .= '<a href="javaScript:void(0);" class="del-button" onclick="$(this).closest(\'.row\').remove();">';
					$str .= '<i class="fa fa-close"></i>';
				$str .= '</a>';
			$str .= '</div>';
		$str .= '</div>';
		echo json_encode(array('data'=>$str));exit();
	}

	public function RemoveImage($id)
	{
		$vendore_store = ProductImages::where('id',$id)->first();
		$vendore_store->delete();
	}

	/**
	* Show the form for editing the specified resource.
	* @param App\Products product
	* @return \Illuminate\Http\Response
	*/
	public function edit(Products $product)
	{

		$store_ids = getVendorStore();
		$product_variants = ProductVariants::where('product_id',$product->id)->get();

		$lngth = $product_variants->count();
		$attributes = Attribute::all();
		$vendor_stores = VendorStore::whereIn('id', $store_ids)->get();
		return view('vendor/products/edit',compact('product', 'product_variants', 'lngth', 'attributes','vendor_stores'));
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  App\Products product
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request,Products $product)
	{
		$request->validate([
			'store' => 'required',
			'title' => 'required',
			'regular_price' => 'required',
			'discount' => 'required',
			'sku' => 'required',
			'quantity' => 'required',
			'lowstock_threshold' => 'required'
		]);

		if($request->attribute)
		{
			$type = 'group';
			$attribute = implode(',',$request->attribute);
			$attribute_value_id = implode(',',$request->attribute_values);

		}else{
			$type = 'single';
			$attribute_value_id = NULL;
			$attribute = NULL;
		}

		$product->vendor_id = Auth::user()->id;
		$product->store_id = $request->input('store');
		$product->title = $request->input('title');
		$product->category_id = implode(",", $request->input('category'));
		$product->description = $request->input('description');
		$product->brand_id = $request->input('brand');
		$product->type = $type;
		$product->tax = $request->input('tax');
		$product->season = $request->input('season');
		$product->created_by = Auth::user()->id;
		$product->aisle = $request->input('aisle');
		$product->shelf = $request->input('shelf');
		$product->save();

		$product_variant = ProductVariants::find($request->group_product_variants_id);

		$id = $request->group_product_variants_id;
		$title = $product->title;
		$old_price = $product_variant->price;
		$old_discount = $product_variant->discount;
		$new_price = $request->regular_price;
		$new_discount = $request->discount;
		$this->priceDropAlertNotification($id, $title, $old_price, $old_discount, $new_price, $new_discount);

		$product_variant->attribute_id = $attribute;
		$product_variant->attribute_value_id = $attribute_value_id;
		$product_variant->sku_uniquecode = $request->sku;
		$product_variant->quantity = $request->quantity;
		$product_variant->price = $request->regular_price;
		$product_variant->discount = $request->discount;
		$product_variant->lowstock_threshold = $request->lowstock_threshold;
		$product_variant->save();

		if($request->file('image')){
			ProductImages::where('variant_id',$request->group_product_variants_id)->delete();
			foreach($request->file('image') as $key => $images){

				$path = 'public/images/product_images';
				$profileImage = date('YmdHis') .$key ."." . $images->getClientOriginalExtension();
				$images->move($path, $profileImage);
				$product_images = new ProductImages;
				$product_images->product_id = $product->id;
				$product_images->variant_id = $request->group_product_variants_id;
				$product_images->created_by =Auth::user()->id;
				$product_images['image'] = $profileImage;
				$product_images->save();
			}
		}
		return redirect('/vendor/products')->with('success',"Product has been updated.");
	}

	/**
	* Remove the specified resource from storage.
	* @param App\Products product
	* @return \Illuminate\Http\Response
	*/
	public function destroy(Products $product)
	{
		$product_variants = ProductVariants::where('product_id',$product->id)->get()->each->delete();
		$product_images = ProductImages::where('product_id',$product->id)->get()->each->delete();
		$product->delete();
		return redirect('/vendor/products')->with('success',"Products successfully deleted.");
	}

	public function inventory()
	{
		$store_ids = getVendorStore();
		$stores = VendorStore::whereIn('id', $store_ids)->get();
		return view('vendor.products.inventory', compact('stores'));
	}

	public function getInventory(Request $request)
	{
		$columns = array(
			//0 => 'id',
			0 => 'title',
			1 => 'variants',
			2 => 'sku',
			3 => 'price',
			4 => 'discount',
			5 => 'quantity'
		);

		$totalData = ProductVariants::select(
					'products.title',
					'product_variants.id',
					'product_variants.sku_uniquecode',
					'product_variants.quantity',
					'product_variants.price',
					'product_variants.discount',
					DB::raw("GROUP_CONCAT(attribute_values.name SEPARATOR ' | ') as attribute_value_names")
				)
				->join('products', 'products.id', 'product_variants.product_id')
				->leftjoin("attribute_values",DB::raw("FIND_IN_SET(attribute_values.id,product_variants.attribute_value_id)"), ">", DB::raw("'0'"))
				->where('products.vendor_id', Auth::user()->id)
				->groupBy('product_variants.id')
				->get()
				->count();

		$totalFiltered = $totalData;

		$limit = $request->input('length');
		$start = $request->input('start');
		$order = $columns[$request->input('order.0.column')];
		$dir = $request->input('order.0.dir');

		//$vendor_id = ($request->has('vendor_id') ? $request->vendor_id : '');
		$store_id = ($request->has('store_id') ? $request->store_id : '');
		$brand_id = ($request->has('brand_id') ? $request->brand_id : '');
		$category_id = ($request->has('category_id') ? $request->category_id : '');

		if(empty($request->input('search.value')) && $store_id == '' && $brand_id == '' && $category_id == ''){
			$products = ProductVariants::select(
					'products.title',
					'product_variants.id',
					'product_variants.sku_uniquecode',
					'product_variants.quantity',
					'product_variants.price',
					'product_variants.discount',
					DB::raw("GROUP_CONCAT(attribute_values.name SEPARATOR ' | ') as attribute_value_names")
				)
				->join('products', 'products.id', 'product_variants.product_id')
				->leftjoin("attribute_values",DB::raw("FIND_IN_SET(attribute_values.id,product_variants.attribute_value_id)"), ">", DB::raw("'0'"))
				->where('products.vendor_id', Auth::user()->id)
				->groupBy('product_variants.id')
				->offset($start)
				->limit($limit)
				->orderBy($order,$dir)
				->get();

		}else{

			$search = $request->input('search.value');

			$products = ProductVariants::select(
					'products.title',
					'product_variants.id',
					'product_variants.sku_uniquecode',
					'product_variants.quantity',
					'product_variants.price',
					'product_variants.discount',
					DB::raw("GROUP_CONCAT(attribute_values.name SEPARATOR ' | ') as attribute_value_names")
				)
				->join('products', 'products.id', 'product_variants.product_id')
				->leftjoin("attribute_values",DB::raw("FIND_IN_SET(attribute_values.id,product_variants.attribute_value_id)"), ">", DB::raw("'0'"))
				->where('products.vendor_id', Auth::user()->id);

			/*if($request->vendor_id != ''){
				$products = $products->where('products.vendor_id', $request->vendor_id);
			}*/

			if($request->store_id != ''){
				$products = $products->where('products.store_id', $request->store_id);
			}

			if($request->brand_id != ''){
				$products = $products->where('products.brand_id', $request->brand_id);
			}

			if($request->category_id != ''){
				$products = $products->where('products.category_id', $request->category_id);
			}

			$products = $products->where(function($query) use ($search){
				$query->where('products.title', 'LIKE',"%{$search}%")
					->orWhere('product_variants.sku_uniquecode', 'LIKE',"%{$search}%")
					->orWhere('product_variants.quantity', 'LIKE',"%{$search}%")
					->orWhere('product_variants.price', 'LIKE',"%{$search}%")
					->orWhere('product_variants.discount', 'LIKE',"%{$search}%")
					->orWhere('attribute_values.name', 'LIKE',"%{$search}%");
					//->orWhereRaw("GROUP_CONCAT(attribute_values.name) LIKE ". "%{$search}%");
			});
			$products = $products->groupBy('product_variants.id');
			//$products = $products->orHavingRaw('Find_In_Set("'.$search.'", attribute_value_names) > 0');

			$totalFiltered = $products;
			$totalFiltered = $totalFiltered->get()->count();

			$products = $products->offset($start)
				->limit($limit)
				->orderBy($order,$dir)
				->get();
		}

		$data = array();
		if($products->isNotEmpty())
		{
			foreach ($products as $product)
			{
				//$nestedData['id'] = $product->id;
				$nestedData['title'] = $product->title;
				$nestedData['variants'] = ($product->attribute_value_names ? : '-');
				$nestedData['sku'] = ($product->sku_uniquecode ? : '-');
				//$nestedData['price'] = $product->price;
				$nestedData['price'] = '<input type="number" id="price_'.$product->id.'" value="'.($product->price ? : 0).'" onblur="updatePrice('.$product->id.')" style="width: 7em">';
				//$nestedData['discount'] = $product->discount;
				$nestedData['discount'] = '<input type="number" id="discount_'.$product->id.'" value="'.($product->discount ? : 0).'" onblur="updateDiscount('.$product->id.')" style="width: 7em">';
				//$nestedData['quantity'] = $product->quantity;
				$nestedData['quantity'] = '<input type="number" id="quantity_'.$product->id.'" value="'.($product->quantity ? : 0).'" onblur="updateQuatity('.$product->id.')" style="width: 7em">';
				$data[] = $nestedData;
			}
		}

		$json_data = array(
			"draw"            => intval($request->input('draw')),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);
		echo json_encode($json_data);exit();
	}

	public function updateQuantity(Request $request)
	{
		if($request->has('id') && $request->get('id') != ''){

			$product = ProductVariants::find($request->get('id'));
			if($request->has('quantity') && $request->get('quantity')!=''){

				$product->quantity = $request->get('quantity');
				$product->save();
			}
		}
		echo 1;exit();
	}

	public function updateDiscount(Request $request)
	{
		if($request->has('id') && $request->get('id') != ''){

			if($request->has('discount') && $request->get('discount')!=''){

				$product_variant = ProductVariants::select('product_variants.*', 'products.title')
					->join('products', 'products.id', 'product_variants.product_id')
					->find($request->get('id'));

				$id = $request->id;
				$title = $product_variant->title;
				$old_price = $product_variant->price;
				$old_discount = $product_variant->discount;
				$new_price = $product_variant->price;
				$new_discount = $request->discount;
				$this->priceDropAlertNotification($id, $title, $old_price, $old_discount, $new_price, $new_discount);

				$product_variant->discount = $request->get('discount');
				$product_variant->save();
			}
		}
		echo 1;exit();
	}

	public function updatePrice(Request $request)
	{
		if($request->has('id') && $request->get('id') != ''){

			if($request->has('price') && $request->get('price')!=''){

				$product_variant = ProductVariants::select('product_variants.*', 'products.title')
					->join('products', 'products.id', 'product_variants.product_id')
					->find($request->get('id'));

				$id = $request->id;
				$title = $product_variant->title;
				$old_price = $product_variant->price;
				$old_discount = $product_variant->discount;
				$new_price = $request->price;
				$new_discount = $product_variant->discount;
				$this->priceDropAlertNotification($id, $title, $old_price, $old_discount, $new_price, $new_discount);

				$product_variant->price = $request->get('price');
				$product_variant->save();
			}
		}
		echo 1;exit();
	}

	private function priceDropAlertNotification($id, $title, $old_price, $old_discount, $new_price, $new_discount)
	{
		$product_exist_in_wishlist = DB::table('user_wishlists')->where('product_id', $id)->exists();

		if($product_exist_in_wishlist) {

			$old_selling_price = $old_price - ($old_price * ($old_discount / 100));
			$new_selling_price = $new_price - ($new_price * ($new_discount / 100));

			if($new_selling_price < $old_selling_price) {

				$percentChange = (($new_selling_price - $old_selling_price)  / $old_selling_price) * 100;
				$percentChange = abs(number_format($percentChange, 2));

				$price_drop_prcnt_setting = DB::table('settings')->where('key','price_drop_alert')->first();
				if(!empty($price_drop_prcnt_setting) && isset($price_drop_prcnt_setting->value) && $price_drop_prcnt_setting->value <= $percentChange) {

					Notification::updateOrCreate([
							'reference_id' => $id,
							'type' => 'price_drop',
						], [
							'title' => 'Price Drop Alert',
							'description' => 'Price dropped for your wishlist item "'.$title.'", Buy it before it goes.',
							'user_type' => 'customer'
						]);
				}
			}
		}
	}

	public function generateBarcodes()
	{
		$store_ids = getVendorStore();
		$vendor_stores = VendorStore::whereIn('id', $store_ids)->get();
		return view('vendor.products.barcode', compact('vendor_stores'));
	}

	public function getBarcodeProducts(Request $request)
	{
		$store_id = ($request->has('store_id') ? $request->store_id : '');

		$store_ids = getVendorStore();

		$columns = array(
			//0 => 'id',
			0 => 'checkbox',
			1 => 'products',
			2 => 'quantity',
		);

		$totalData = Products::join('product_variants','product_variants.product_id','=','products.id')
							->join('vendor_stores','vendor_stores.id','=','products.store_id')
							->whereIn('vendor_stores.id', $store_ids)
							->get()
							->count();

		$totalFiltered = $totalData;

		$limit = $request->input('length');
		$start = $request->input('start');
		$order = $columns[$request->input('order.0.column')];
		if ($order == 'products') {
			$order = 'products.title';
		}
		$dir = $request->input('order.0.dir');

		if(empty($request->input('search.value')) && $store_id == ''){

			$products = Products::select('products.id','products.title','product_variants.barcode','product_variants.quantity')
				->join('product_variants','product_variants.product_id','products.id')
				->join('vendor_stores','vendor_stores.id','=','products.store_id')
				->whereIn('vendor_stores.id', $store_ids)
				->offset($start)
				->limit($limit)
				->orderBy($order,$dir)
				->get();

		}else{

			$search = $request->input('search.value');
			$products = Products::select('products.id','products.title','product_variants.barcode','product_variants.quantity')
				->join('product_variants','product_variants.product_id','products.id')
				->join('vendor_stores','vendor_stores.id','=','products.store_id')
				->whereIn('vendor_stores.id', $store_ids);

			if($request->store_id != ''){
				$products = $products->where('products.store_id', $request->store_id);
			}

			$products = $products->where(function($query) use ($search){
				$query->where('products.title', 'LIKE', "%{$search}%")
					->orWhere('product_variants.quantity', 'LIKE', "%{$search}%");
			});

			$totalFiltered = $products;
			$totalFiltered = $totalFiltered->get()->count();

			$products = $products->offset($start)
				->limit($limit)
				->orderBy($order,$dir)
				->get();
		}

		$data = array();
		if($products->isNotEmpty())
		{
			foreach ($products as $key => $product) {

				$nestedData['checkbox'] = '<input class="check-row" type="checkbox" name="barcode" value="'.$product->barcode.'"/>';
				$nestedData['products'] = $product->title;
				$nestedData['quantity'] = $product->quantity;

				$data[] = $nestedData;
			}
		}

		$json_data = array(
			"draw"            => intval($request->input('draw')),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);exit();
	}

	public function printBarcode(Request $request)
	{
		$products = [];
		$barcodes = $request->barcodes;
		if(!empty($barcodes)){
			$products = ProductVariants::select('products.title', 'product_variants.price', 'product_variants.barcode')
				->join('products','products.id','product_variants.product_id')
				->whereIn('product_variants.barcode',$barcodes)
				->get();
		}
		return view('vendor.products.print_barcode',compact('products'));
	}

	public function importProduct(Request $request)
	{
		$chk_barcodes = [];

		$this->validate($request, [
			'import_file'  => 'required|mimes:csv,txt',
            'store' => 'required'
        ]);

		$import_file = $request->file('import_file');
		$extension = $import_file->getClientOriginalExtension();

		if(strtolower($extension) == 'csv'){

	        $file = file($request->import_file->getRealPath());
			$data = array_slice($file, 1);

			$file_open = fopen($request->import_file->getRealPath(),"r");
			while ($rowData = fgetcsv($file_open)) {

				if(!empty($rowData)) {
					$chk_barcodes[] = $rowData[3];
				}
			}

			$exists_barcodes = ProductVariants::select('barcode')->whereIn('barcode',$chk_barcodes)->get()->pluck('barcode')->all();

			$parts = array_chunk($data, 300);
			foreach ($parts as $index => $part) {
				$fileName = resource_path('pending_files/'.date('Y-m-d-H-i-s').$index.'-'.Auth()->user->id.'.csv');
				file_put_contents($fileName, $part);
				$product_csv = new ProductCSV;
				$product_csv->user_id = Auth()->user->id;
				$product_csv->store_id = $request->store;
				$product_csv->type = 'vendor';
				$product_csv->filename = date('Y-m-d-H-i-s').$index.'-'.Auth()->user->id.'.csv';
				$product_csv->save();
			}

			return redirect('/vendor/products')->with('success-data', array('barcodes' => $exists_barcodes, 'message' => 'Your imported product has been queued.') );
		} else {
			return redirect('/vendor/products')->with('error-data','The import file must be a file of type: csv.');

		}
	}

	public function productStatus($id)
	{
		$products = Products::find($id);
		if($products->status == 'enable'){
			Products::where('id',$id)->update(array('status' => 'disable'));
			echo json_encode('disable');
		}else{
			Products::where('id',$id)->update(array('status' => 'enable'));
			echo json_encode('enable');
		}
	}

	public function getImportPreview(Request $request)
	{
		// print_r($request->all()); exit();
		$file = $request->file('file');
		$extension = $file->getClientOriginalExtension();
		$data = [];
		if(strtolower($extension) == 'csv') {

	        $fileD = fopen($request->file('file'),"r");
	        $column = fgetcsv($fileD);
	        // if(count($column) == 11) {

		        while(!feof($fileD)) {

		            $rowData = fgetcsv($fileD);

					if(!empty($rowData)) {

						$row = array(
							'title' => $rowData[0],
							'description' => $rowData[1],
							'sku' => $rowData[2],
							'barcode' => $rowData[3],
							'tax' => $rowData[4],
							'price' => $rowData[5],
							'quantity' => $rowData[6],
							'lowstock_threshold' => $rowData[7],
							'discount' => (int)$rowData[8],
							'images' => $rowData[9],
							'brand' => $rowData[10],
							'categories' => $rowData[11],
							'season' => $rowData[12],
							'aisle' => $rowData[13],
							'shelf' => $rowData[14]
						);

						$j = 1;
						$attribute_count = count($column) - 15;
						for($i=1; $i<=$attribute_count; $i++) {

							if (array_key_exists(14+$i,$rowData)) {

								if($i%2 == 1) {
									$row['Attribute '.$j] = $rowData[14+$i];
								} elseif($i%2 == 0) {
									$row['Attribute '.$j.' value'] = $rowData[14+$i];
									$j++;
								}
							}
						}

						$data[] = $row;
					}
				}
				echo json_encode(array('error' => '', 'data' => $data));exit();
			/*} else {
				echo json_encode(array('error' => "Your uploaded CSV column does not match with the sample CSV", 'data' => null));exit();
			}*/
		} else {
			echo json_encode(array('error' => "Please upload comma seprated CSV file", 'data' => null));exit();
		}
	}

	public function exportProduct()
	{
		$filename = "products.csv";
		$fp = fopen('php://output', 'w');

		$header = array(
			'Title',
			'Description',
			'Sku',
			'Barcode',
			'Tax',
			'Price',
			'Quantity',
			'Lowstock Threshold',
			'Discount',
			'Status',
			'Brand',
			'Categories',
			'Season',
			'Aisle',
			'Shelf',
			'Attribute',
			'Attribute Value',
			'Images'
		);

		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		fputcsv($fp, $header);

		$store_ids = getVendorStore();
		$products_data = Products::select(
				'products.id',
				'products.title',
				'products.description',
				'products.tax',
				'products.status',
				'brands.name',
				'categories.name as category',
				'product_variants.sku_uniquecode',
				'product_variants.barcode',
				'product_variants.price',
				'product_variants.quantity',
				'product_variants.price',
				'product_variants.lowstock_threshold',
				'product_variants.discount',
				'product_variants.attribute_id',
				'products.aisle',
				'products.shelf',
				'products.season',
				'attributes.name as attribute',
				'attribute_values.name as attribute_value'
			)
			->leftjoin('brands','brands.id','products.brand_id')
			->leftjoin('categories','categories.id','products.category_id')
			->join('product_variants','product_variants.product_id','products.id')
			->leftjoin('attributes','attributes.id','product_variants.attribute_id')
			->leftjoin('attribute_values','attribute_values.id','product_variants.attribute_value_id')
			->whereIn('products.store_id', $store_ids)
			->get();

		$image_url = url('/public/images/product_images/');
		foreach ($products_data as $key => $value) {

			$images = DB::table('product_images')
				->select(DB::raw("CONCAT('".$image_url."/', image) AS image"))
				->where('product_id',$value->id)
				->get()
				->implode('image', ', ');

			$data = array(
				'Title' => $value->title,
				'Description' => $value->description,
				'sku' => $value->sku_uniquecode,
				'barcode' => $value->barcode,
				'Tax' => $value->tax,
				'price' => $value->price,
				'quantity' => $value->quantity,
				'lowstock_threshold' => $value->lowstock_threshold,
				'discount' => $value->discount,
				'Status' => $value->status,
				'Brand' => $value->name,
				'category' => $value->category,
				'season' => $value->season,
				'aisle' => $value->aisle,
				'shelf' => $value->shelf,
				'attribute' => $value->attribute,
				'attribute_value' => $value->attribute_value,
				'Images' => $images
			);

			fputcsv($fp, $data);
		}
		Helper::addToLog('Export Product',Auth::user()->id);
		exit();
	}

}
