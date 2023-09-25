<?php

namespace App\Http\Controllers\Supplier;

use DB;
use Auth;
use App\Brand;
use App\CsvData;
use App\Products;
use App\Membership;
use App\W2bProduct;
use Stripe\Product;
use App\VendorStore;
use App\W2bCategory;
use App\Notification;
use App\ProductImages;
use App\ProductVariants;
use App\Imports\CsvImport;
use App\Traits\Permission;
use Illuminate\Http\Request;
use App\Imports\ProductImport;
use Illuminate\Validation\Rule;
use App\SupplierSubscriptionTemp;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\LogActivity as Helper;
use Maatwebsite\Excel\HeadingRowImport;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{
	use Permission;

	/**
	* Display a listing of the resource.
	*/
	public function __construct()
	{
		$this->middleware('auth:vendor');
		$this->middleware(function ($request, $next) {
			if(!$this->hasVendorPermission(Auth::user())){
				return redirect('supplier/home');
			}
			return $next($request);
		});
	}

	public function index()
	{
     $products = Products::where('vendor_id', Auth::user()->id)
     ->where('seller_type', 'supplier')->orderBy('id', 'DESC')
     ->paginate(10);

		return view('supplier.products.index', compact('products'));
	}


    // public function productDatatable(Request $request)
    // {
    //     $query = W2bProduct::query()->where('vendor_id', auth()->id());

    //     return DataTables::of($query)
    //         ->addIndexColumn()
    //         ->addColumn('action', function ($product) {
    //             $edit = route('supplier.products.edit', $product->sku);
    //             $delete = route('supplier.products.destroy', $product->sku);

    //             return '<form id="deletefrm_'.$product->sku.'" action="'.$delete.'" method="POST" onsubmit="return confirm(\""Are you sure?"\");">
    //                         <input type="hidden" name="_token" value="'.csrf_token().'">
    //                         <input type="hidden" name="_method" value="DELETE">
    //                         <a href="'.$edit.'" data-toggle="tooltip" data-placement="bottom" title="Edit">
    //                         <i class="icon-note icons"></i>
    //                         </a>
    //                         <a href="javascript:void(0);" onclick="deleteRow(\''.$product->sku.'\')" data-toggle="tooltip" data-placement="bottom" title="Delete">
    //                             <i class="icon-trash icons"></i>
    //                         </a>
    //                     </form>';
    //         })->toJson();
    // }

	/**
	* Show the form for creating a new resource.
	*/
	public function create()
	{
        if (!boolval(Auth::user()->is_approved)) {
            return back()->with('error', 'Your account is not approved.');
        }

		$premium_id = Membership::where('name','Sprout')->select('id')->pluck('id')->first();

		$check_premium_subs = SupplierSubscriptionTemp::where('vendor_id', Auth::user()->id)->where('membership_id',$premium_id)->first();

		$products_count = W2bProduct::where('vendor_id', Auth::user()->id)->count();

		if(!$check_premium_subs && $products_count>=20 ){
		    return redirect()->route('supplier.choose-plan')->with('error', 'You must upgrade subscription to add more products.');
		}

        $brands = Brand::where('vendor_id', auth()->id())->get();
        // $categories = W2bCategory::where('vendor_id', auth()->id())->get();
        $categories = W2bCategory::where('parent_id', 0)->get();

        return view('supplier/products/create', [
            'brands' => $brands,
            'categories' => $categories
        ]);


	}

	/**
	* Store a newly created resource in storage.
	*/
	public function store(Request $request)
	{
        // dd($request->all());

        if (!boolval(Auth::user()->is_approved)) {
            return back()->with('error', 'Your account is not approved.');
        }


        $premium_id = Membership::where('name','Sprout')->select('id')->pluck('id')->first();

        $check_premium_subs = SupplierSubscriptionTemp::where('vendor_id', Auth::user()->id)->where('membership_id',$premium_id)->first();

        $products_count = W2bProduct::where('vendor_id', Auth::user()->id)->count();

        if(!$check_premium_subs && $products_count>=20 ){
            return redirect()->route('supplier.choose-plan')->with('error', 'You must upgrade subscription to add more products.');
        }

        $request->validate([
            'title' => 'required',
            'meta_title' => 'required',
            'description' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'nullable',
            'brand' => 'nullable',
            'w2b_category_1' => 'required',
            'retail_price' => 'required',
            'wholesale_price' => 'required',
            'shipping_price' => 'required',
            "sku" => [
                "regex:/^[a-zA-Z0-9]+$/",
                "required", "min:2","max:20","unique:products",
            ],
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
        $product->seller_type = 'supplier';
        $product->w2b_category_1 = $category->category1 ?? null;
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->brand = $request->input('brand');
        $product->retail_price = $request->input('retail_price');
        $product->wholesale_price = $request->input('wholesale_price');
        $product->shipping_price = $request->input('shipping_price');
        $product->sku = $request->input('sku');
        $product->in_stock = 'Y';
        $product->stock = $request->input('stock');
        $product->meta_title = $request->input('meta_title');
        $product->meta_description = $request->input('meta_description');
        $product->meta_keywords = $finalKeywordsString;
        // $product->save();

        // $wholesale_price_range = [];
        // foreach ($request->input('wholesale')['min_order_qty'] as $key => $value) {
        //     $wholesale_price_range[] = [
        //         'min_order_qty' => $request->input('wholesale')['min_order_qty'][$key],
        //         'max_order_qty' => $request->input('wholesale')['max_order_qty'][$key],
        //         'wholesale_price' => $request->input('wholesale')['wholesale_price'][$key],
        //     ];
        // }


        // $product->wholesale_price_range = json_encode($wholesale_price_range);
        //$product->where('sku', $request->input('sku'))->save();


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
            return redirect('/supplier/products')->with('success',"Products successfully saved.");
        }elseif($request->btnSubmit == 'new'){
            return redirect('/supplier/products/create')->with('success',"Products successfully saved.");
        }elseif($request->btnSubmit == 'edit'){
            return redirect('/supplier/products/'.$product->id.'/edit')->with('success',"Products successfully saved.");
        }

		return redirect()->route('supplier.choose-plan')->with('error', 'You must have a subscription');


	}

	/**
	* Display the specified resource.
	*/
	public function show($id)
	{

	}

	public function RemoveImage($id)
	{
		$vendore_store = ProductImages::where('id',$id)->first();
		$vendore_store->delete();
	}

	/**
	* Show the form for editing the specified resource.
	*/
	public function edit($id)
	{
        $product = Products::find($id);
        // dd($product);

        $brands = Brand::where('vendor_id', auth()->id())->get();
        // $categories = W2bCategory::where('vendor_id', auth()->id())->get();
        $categories = W2bCategory::where('parent_id', 0)->get();

		return view('supplier/products/edit', [
            'product' => $product,
            'brands' => $brands,
            'categories' => $categories
        ]);
	}

	/**
	* Update the specified resource in storage.
	*/
	public function update(Request $request, $product)
	{
        // dd($request->all());
        $product = Products::where('sku', $product)->firstOrFail();

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'brand' => 'nullable',
            'w2b_category_1' => 'required',
            'retail_price' => 'required',
            'wholesale_price' => 'nullable',
            'shipping_price' => 'nullable',
            "sku" => [
                "regex:/^[a-zA-Z0-9]+$/",
                "required", "min:2","max:20",
                Rule::unique('products')->ignore($product),
            ],
            'stock' => 'required',
        ]);

        $category = W2bCategory::find($request->input('w2b_category_1'));

        $data['seller_type'] = 'supplier';
        $data['w2b_category_1'] = $request->input('w2b_category_1');
        $data['title'] = $request->input('title');
        $data['description'] = $request->input('description');
        $data['brand'] = $request->input('brand');
        $data['retail_price'] = $request->input('retail_price');
        $data['wholesale_price'] = $request->input('wholesale_price');
        $data['shipping_price'] = $request->input('shipping_price');
        $data['sku'] = $request->input('sku');
        $data['stock'] = $request->input('stock');
        // $data['min_wholesale_qty'] = $request->input('min_wholesale_qty');

        // $wholesale_price_range = [];
        // foreach ($request->input('wholesale')['min_order_qty'] as $key => $value) {
        //     $wholesale_price_range[] = [
        //         'min_order_qty' => $request->input('wholesale')['min_order_qty'][$key],
        //         'max_order_qty' => $request->input('wholesale')['max_order_qty'][$key],
        //         'wholesale_price' => $request->input('wholesale')['wholesale_price'][$key],
        //     ];
        // }

        // $data['wholesale_price_range'] = json_encode($wholesale_price_range);


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

		return redirect('/supplier/products')->with('success',"Product has been updated.");
	}

	/**
	* Remove the specified resource from storage.
	*/
	public function destroy($id)
	{
        $product = Products::find($id);
		$product_variants = ProductVariants::where('product_id',$product->id)->get()->each->delete();
		$product_images = ProductImages::where('product_id',$product->id)->get()->each->delete();
		$product->delete();
		return redirect('/supplier/products')->with('success',"Products successfully deleted.");
	}

	public function inventory()
	{
		return view('supplier.products.inventory');
	}
    public function inventoryUpload()
    {
        return view('supplier.products.upload');
    }
    public function parseImport(Request $request)
    {
    // $path = $request->file('csv_file')->getRealPath();
    // $data = array_map('str_getcsv', file($path));
    // $json = mb_convert_encoding($data, 'UTF-8');
    // $json2 = json_encode($json);

    // $csv_data_file = CsvData::create([
    //     'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
    //     'csv_header' => $request->has('header'),
    //     'csv_data' => $json2
    // ]);

    // $csv_data = array_slice($data, 0, 2);
    // $path = $request->file('csv_file')->getRealPath();

    // if ($request->has('header')) {
    //     // $data = Excel::import($path, function($reader) {})->get()->toArray();
    //     $data = Excel::load($path)->get()->toArray();
    //     // $data = Excel::load(new CsvImport, $path);
    //      dd($data);
    // } else {
    //     $data = array_map('str_getcsv', file($path));
    // }
    // $csv_header_fields = [];

    // if (count($data) > 0) {
    //     if ($request->has('header')) {
    //         foreach ($data[0][0] as $key => $value) {
    //             $csv_header_fields[] = $key;
    //         }
    //     }
    //     $json = mb_convert_encoding($data[0], 'UTF-8');
    //     $json2 = json_encode($json);
    //     // dd($json2);
    //     $csv_data = array_slice($data[0], 0, 2);

    //     $csv_data_file = CsvData::create([
    //         'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
    //         'csv_header' => $request->has('header'),
    //         'csv_data' =>  $json2
    //     ]);
    // } else {
    //     return redirect()->back();
    // }

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
    return view('supplier.products.upload_fields', [
        'headings' => $headings ?? null,
        'csv_data' => $csv_data,
        'csv_data_file' => $csv_data_file
    ]);
    // return view('supplier.products.upload_fields', compact('headings','csv_data', 'csv_data_file'));

    }
    public function processImport(Request $request)
    {

        $data = CsvData::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);
        $stock = 'in_stock';
        // dd($data);
        foreach ($csv_data as $row) {

            $product = new Products();
            foreach (config('app.db_fields') as $index => $field) {
                if ($data->csv_header) {

                    $product->sku = $row[$request->fields['sku']];
                    $product->title = $row[$request->fields['title']];
                    $product->description = $row[$request->fields['description']];
                    $product->w2b_category_1 = $row[$request->fields['w2b_category_1']];
                    $product->brand = $row[$request->fields['brand']];
                    $product->retail_price = $row[$request->fields['retail_price']];
                    $product->wholesale_price = $row[$request->fields['wholesale_price']];
                    $product->stock = $row[$request->fields['stock']];
                    $product->original_image_url = $row[$request->fields['original_image_url']];
                    $product->shipping_price = $row[$request->fields['shipping_price']];
                    $product->vendor_id =Auth::user()->id;
                    $product->seller_type ='supplier';
                    $product->in_stock = 'Y';

                } else {
                    $product->$field = $row[$request->fields[$index]];
                    $product->vendor_id =Auth::user()->id;
                    $product->seller_type ='supplier';
                    $product->in_stock ='Y';

                }

            }
            // dd($product);

            $product->save();
        }


        return redirect('/supplier/products')->with('success',"Products successfully saved.");
    }

	public function getInventory(Request $request)
	{
        $query = W2bProduct::query()->where('vendor_id', auth()->id());

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('retail_price', function ($product) {
                return '<input type="number" id="price_'.$product->sku.'" value="'.($product->retail_price ? : 0).'" onblur="updatePrice(\''.$product->sku.'\')" style="width: 7em">';
            })
            ->addColumn('wholesale', function ($product) {
                return '<input type="number" id="discount_'.$product->sku.'" value="'.($product->wholesale ? : 0).'" onblur="updateDiscount(\''.$product->sku.'\')" style="width: 7em">';
            })
            ->addColumn('stock', function ($product) {
                return '<input type="number" id="quantity_'.$product->sku.'" value="'.($product->stock ? : 0).'" onblur="updateQuatity(\''.$product->sku.'\')" style="width: 7em">';
            })
            ->rawColumns(['retail_price', 'wholesale', 'stock'])
            ->toJson();
	}

	public function updateQuantity(Request $request)
	{
		if($request->has('id') && $request->get('id') != ''){

			if($request->has('quantity') && $request->get('quantity')!=''){
                $product = W2bProduct::find($request->id);
				$product->stock = $request->get('quantity');
				$product->save();
			}
		}
		echo 1;exit();
	}

	public function updateDiscount(Request $request)
	{
		if($request->has('id') && $request->get('id') != ''){

			if($request->has('discount') && $request->get('discount')!=''){

                $product = W2bProduct::find($request->id);

                $id = $request->id;
                $title = $product->title;
                $old_price = $product->wholesale;
                $new_price = $request->discount;
                $product->wholesale = $request->discount;
                $product->save();

				$this->priceDropAlertNotification($id, $title, $old_price, 0, $new_price, 0);

			}
		}
		echo 1;exit();
	}

	public function updatePrice(Request $request)
	{
		if($request->has('id') && $request->get('id') != ''){

			if($request->has('price') && $request->get('price')!=''){

				$product = W2bProduct::find($request->id);

				$id = $request->id;
				$title = $product->title;
				$old_price = $product->retail_price;
				$new_price = $request->price;
                $product->retail_price = $request->get('price');
                $product->save();

				$this->priceDropAlertNotification($id, $title, $old_price, 0, $new_price, 0);
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
		$store_ids = getSupplierStore();
		$vendor_stores = VendorStore::whereIn('id', $store_ids)->get();
		return view('supplier.products.barcode', compact('vendor_stores'));
	}

	public function getBarcodeProducts(Request $request)
	{
		$store_id = ($request->has('store_id') ? $request->store_id : '');

		$store_ids = getSupplierStore();

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
		return view('supplier.products.print_barcode',compact('products'));
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

			return redirect('/supplier/products')->with('success-data', array('barcodes' => $exists_barcodes, 'message' => 'Your imported product has been queued.') );
		} else {
			return redirect('/supplier/products')->with('error-data','The import file must be a file of type: csv.');

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

		$store_ids = getSupplierStore();
		$products_data = Products::select([
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
			])
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
