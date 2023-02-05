<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ProductCsv;
use Excel;
use DB;
use Auth;
use App\Products;
use App\VendorsSubCategory;
use App\Category;
use App\VendorStore;
use App\Vendor;
use App\Brand;
use App\ProductVariants;
use App\ProductImages;
use App\Attribute;
use App\AttributeValue;

class ProductImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For Product Import.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $product_csv = ProductCsv::limit(1)->first();

        if(!empty($product_csv)) {

            $filepath = resource_path('pending_files/'.$product_csv->filename);

            $file = fopen($filepath,"r");
            $header = fgetcsv($file);
            while ($rowData = fgetcsv($file)) {

                if(!empty($rowData)) {  

                    $title = $rowData[0];
                    $description = $rowData[1];
                    $sku = $rowData[2];
                    $barcode = $rowData[3];
                    $tax = $rowData[4];
                    $price = $rowData[5];
                    $quantity = $rowData[6];
                    $lowstock_threshold = $rowData[7];
                    $discount = (int)$rowData[8];
                    $images = $rowData[9];
                    $brand = $rowData[10];
                    $categories = $rowData[11];
                    $season = $rowData[12];
                    $aisle = $rowData[13];
                    $shelf = $rowData[14];

                    $brand_id = NULL;
                    $category_id = NULL;
                    $attribute_id = NULL;
                    $attribute_value_id = NULL;

                    $attribute_count = count($header) - 15;
                    $barcode_exists = ProductVariants::where('barcode',$barcode)->exists();

                    if($barcode_exists) {
                        $exists_barcodes[] = $barcode;
                    } else {

                        //attribute
                        for($j=1; $j<=$attribute_count; $j++) {
                            if($j%2 == 1) {

                                $attribute = $rowData[14+$j];
                                $attribute_exist = Attribute::where(trim(strtolower('name')),trim(strtolower($attribute)))
                                                    ->where('store_id',$product_csv->store_id)->first();

                                if(empty($attribute_exist)) {
                                    if(trim(strtolower($attribute))!='') {
                                        $attrbutes = new Attribute;
                                        $attrbutes->name = $attribute;
                                        $attrbutes->vendor_id = $product_csv->user_id;
                                        $attrbutes->store_id = $product_csv->store_id;
                                        $attrbutes->save();
                                        $attribute_id .= $attrbutes->id.',';
                                    }
                                } else {
                                    $attribute_id .= $attribute_exist->id.',';
                                }
                            } elseif($j%2 == 0) {

                                $attribute_values = $rowData[14+$j];

                                $att_value_arr = explode(',', $attribute_values);
                                foreach ($att_value_arr as $key => $value) {
                                      $attribute_value_exist = AttributeValue::where(trim(strtolower('name')),trim(strtolower($value)))->first();

                                    if(empty($attribute_value_exist)) {
                                        if(trim(strtolower($value))!='') {

                                            $attribute_value = new AttributeValue;
                                            $attribute_value->name = trim(strtolower($value));
                                            $attribute_value->attribute_id = $attribute_id;
                                            $attribute_value->save();
                                            $attribute_value_id .= $attribute_value->id.',';
                                        }
                                    } else {
                                        $attribute_value_id .= $attribute_value_exist->id.',';
                                    }
                                    
                                }
                            }
                        }
                        
                        // brand
                        $brandData = Brand::where(strtolower('name'),strtolower($brand))->first();
                        if(empty($brandData)) {
                            $brands = new Brand;
                            $brands->vendor_id = $product_csv->user_id;
                            $brands->store_id = $product_csv->store_id;
                            $brands->name = $brand;
                            $brands->save();
                            $brand_id = $brands->id;
                        } else {
                            $brand_id = $brandData->id;
                        }
                        
                        //categories
                        if(strpos($categories, '>') !== false) {
                            // explodable
                            $cat_arr = explode('>', $categories);
                            $parent_id = NULL;
                            foreach ($cat_arr as $key => $value) {
                                
                                $category_exist = Category::where(trim(strtolower('name')),trim(strtolower($value)))->where('store_id',$product_csv->store_id)->first();
                                if(empty($category_exist)) {
                                    if(trim(strtolower($value))!='') {
                                        $category = new Category;
                                        $category->vendor_id = $product_csv->user_id;
                                        $category->store_id = $product_csv->store_id;
                                        $category->name = $value;
                                        $category->parent = $parent_id;
                                        $category->save();
                                        $parent_id = $category->id;
                                        $category_id = $category->id;
                                    }
                                } else {
                                    $parent_id = $category_exist->id;
                                    $category_id = $category_exist->id;
                                }
                            }
                        } else {
                            $category_exist = Category::where(trim(strtolower('name')),trim(strtolower($categories)))->where('store_id',$product_csv->store_id)->first();
                            if(empty($category_exist)) {
                                if(trim(strtolower($categories))!='') {
                                    $category = new Category;
                                    $category->vendor_id = $product_csv->user_id;
                                    $category->store_id = $product_csv->store_id;
                                    $category->name = $categories;
                                    $category->save();
                                    $category_id = $category->id;
                                }
                            } else {
                                $category_id = $category_exist->id;
                            }
                        }

                        if($attribute_id == NULL) {
                            $type = 'single';
                        } else {
                            $type = 'group';
                        }

                        $product = new Products;
                        $product->title = $title;
                        $product->description = $description;
                        $product->tax = $tax;
                        $product->status = 'enable';
                        $product->brand_id = $brand_id;
                        $product->category_id = $category_id;
                        $product->vendor_id = $product_csv->user_id;
                        $product->store_id = $product_csv->store_id;
                        $product->type = $type;
                        $product->shelf = $shelf;
                        $product->aisle = $aisle;
                        $product->season = strtolower($season);
                        $product->save();
                        
                        $product_variant = new ProductVariants;
                        $product_variant->product_id = $product->id;
                        $product_variant->attribute_id =($attribute_id!='' ? substr($attribute_id, 0 , -1) : NULL);
                        $product_variant->attribute_value_id =($attribute_value_id!='' ? substr($attribute_value_id, 0 , -1) : NULL);
                        $product_variant->price = $price;
                        $product_variant->barcode = $barcode;
                        $product_variant->sku_uniquecode = $sku;
                        $product_variant->quantity = $quantity;
                        $product_variant->discount = $discount;
                        $product_variant->lowstock_threshold = $lowstock_threshold;
                        $product_variant->save();

                        if(trim(strtolower($images))!='') {
                            $images_arr = explode(',', $images);
                        
                            $i = 1;
                            foreach ($images_arr as $key => $image) {

                                $i++;
                                if (!filter_var($image, FILTER_VALIDATE_URL) === false) {

                                    $ext = pathinfo($image, PATHINFO_EXTENSION);
                                    $path = public_path('images/product_images');
                                    $image_name = date('YmdHis') . $i . '.' . $ext;
                                    $new_image = $path . '/' . $image_name;
                                    
                                    if (!@copy($image, $new_image)) {
                                        
                                    } else {

                                        $product_images = new ProductImages;
                                        $product_images->product_id = $product->id;
                                        $product_images->variant_id = $product_variant->id;
                                        $product_images->created_by = $product_csv->user_id;
                                        $product_images['image'] = $image_name;
                                        $product_images->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }

            ProductCsv::where('id',$product_csv->id)->delete();
        }
    }
}
