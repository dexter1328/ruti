<?php

namespace App\Http\Controllers\Vendor;

use DB;
use Auth;
use Schema;
use App\Brand;
use App\Vendor;
use App\CsvData;
use App\Category;
use App\Products;
use App\Attribute;
use App\VendorStore;
use App\W2bCategory;
use App\Notification;
use App\ProductImages;
use App\AttributeValue;
use App\ProductVariants;
use App\Traits\Permission;
use App\VendorsSubCategory;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Imports\ProductImport;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\LogActivity as Helper;
use Maatwebsite\Excel\HeadingRowImport;

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
		$products = Products::where('vendor_id', Auth::user()->id)
        ->where('seller_type', 'vendor')->orderBy('id', 'DESC')
        ->paginate(10);
		return view('vendor.products.index', compact('products'));
	}



	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
        $categories = W2bCategory::where('parent_id', 0)->get();
		// $attributes = Attribute::all();
		// $store_ids = getVendorStore();
		// $vendor_stores = VendorStore::whereIn('id', $store_ids)->get();
		return view('vendor/products/create',compact('categories'));
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
            'title' => 'required',
            'description' => 'required',
            'brand' => 'nullable',
            'category' => 'nullable',
            'retail_price' => 'required',
            'shipping_price' => 'nullable',
            'sku' => 'required|unique:products,sku',
            'stock' => 'required',
            'image' => 'required',
        ]);
        $keywordsString = $request->input('meta_keywords');

        // Split the keywords into an array
        $keywordsArray = preg_split('/\r\n|[\r\n]/', $keywordsString, -1, PREG_SPLIT_NO_EMPTY);

        // Trim whitespace from each keyword
        $keywordsArray = array_map('trim', $keywordsArray);

        // Remove duplicate keywords if needed
        $keywordsArray = array_unique($keywordsArray);

        // Implode the keywords into a comma-separated string
        $finalKeywordsString = implode(', ', $keywordsArray);

        $category = W2bCategory::find($request->input('w2b_category_1'));

        $product = new Products();
        $product->vendor_id = Auth::user()->id;
        $product->seller_type = 'vendor';
        $product->w2b_category_1 = $category->category1 ?? null;
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->brand = $request->input('brand');
        $product->retail_price = $request->input('retail_price');
        $product->sku = $request->input('sku');
        $product->in_stock = 'Y';
        $product->stock = $request->input('stock');
        $product->meta_keywords = $finalKeywordsString;



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

        $this->__completeVendorChecklist(Auth::user()->id, 'add_inventory');

        if($request->btnSubmit == 'close'){
            return redirect('/vendor/products')->with('success',"Products successfully saved.");
        }elseif($request->btnSubmit == 'new'){
            return redirect('/vendor/products/create')->with('success',"Products successfully saved.");
        }elseif($request->btnSubmit == 'edit'){
            return redirect('/vendor/products/'.$product->id.'/edit')->with('success',"Products successfully saved.");
        }

		return redirect()->route('vendor.choose-plan')->with('error', 'You must have a subscription');

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
	public function edit($id)
	{
        $product = Products::find($id);
        // dd($product);

        $brands = Brand::where('vendor_id', auth()->id())->get();
        // $categories = W2bCategory::where('vendor_id', auth()->id())->get();
        $categories = W2bCategory::where('parent_id', 0)->get();

		return view('vendor/products/edit', [
            'product' => $product,
            'brands' => $brands,
            'categories' => $categories
        ]);
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  App\Products product
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request,$product)
	{
        $product = Products::where('sku', $product)->firstOrFail();

        $request->validate([
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

        Products::where('sku', $product->sku)->update($data);
		return redirect('/vendor/products')->with('success',"Product has been updated.");
	}

	/**
	* Remove the specified resource from storage.
	* @param App\Products product
	* @return \Illuminate\Http\Response
	*/
	public function destroy($id)
	{
        $product = Products::find($id);
		// $product_variants = ProductVariants::where('product_id',$product->id)->get()->each->delete();
		// $product_images = ProductImages::where('product_id',$product->id)->get()->each->delete();
		$product->delete();
		return redirect('/vendor/products')->with('success',"Products successfully deleted.");
	}

	public function inventory()
	{
		$store_ids = getVendorStore();
		$stores = VendorStore::whereIn('id', $store_ids)->get();
		return view('vendor.products.inventory', compact('stores'));
	}

    public function inventoryUpload()
    {
        return view('vendor.products.upload');
    }
    public function parseImport(Request $request)
    {

    if ($request->has('header')) {
        $headings = (new HeadingRowImport)->toArray($request->file('csv_file'));
        $data = Excel::toArray(new ProductImport, $request->file('csv_file'))[0];
    } else {
        $data = array_map('str_getcsv', file($request->file('csv_file')->getRealPath()));
    }

    if (count($data) > 0) {
        $csv_data = array_slice($data, 0, 2);

        $csv_data_file = CsvData::create([
            'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
            'csv_header' => $request->has('header'),
            'csv_data' => json_encode($data)
        ]);
    } else {
        return redirect()->back();
    }
    return view('vendor.products.upload_fields', [
        'headings' => $headings ?? null,
        'csv_data' => $csv_data,
        'csv_data_file' => $csv_data_file
    ]);

    }
    public function processImport(Request $request)
    {

        $data = CsvData::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);
        foreach ($csv_data as $row) {

            $product = new Products();
            foreach (config('app.db_fields2') as $index => $field) {
                if ($data->csv_header) {

                    $product->sku = $row[$request->fields['sku']];
                    $product->title = $row[$request->fields['title']];
                    $product->description = $row[$request->fields['description']];
                    $product->w2b_category_1 = $row[$request->fields['w2b_category_1']];
                    $product->brand = $row[$request->fields['brand']];
                    $product->retail_price = $row[$request->fields['retail_price']];
                    $product->stock = $row[$request->fields['stock']];
                    $product->original_image_url = $row[$request->fields['original_image_url']];
                    $product->shipping_price = $row[$request->fields['shipping_price']];
                    $product->vendor_id =Auth::user()->id;
                    $product->seller_type = 'vendor';
                    $product->in_stock = 'Y';

                } else {
                    $product->$field = $row[$request->fields[$index]];
                    $product->vendor_id =Auth::user()->id;
                    $product->seller_type ='vendor';
                    $product->in_stock ='Y';

                }
            }

            $product->save();
        }


        return redirect('/vendor/products')->with('success',"Products successfully saved.");
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
