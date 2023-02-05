<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Admin;

class ProductCSV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user = null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle($user)
    {
        $admins = new Admin;
        $admins->name = $user->name;
        $admins->email = $user->email;
        $admins->password = bcrypt($user->password);
        $admins->role_id = $user->role_id;
        $admins->status = $user->status;

        $admins->save();

       /* foreach($this->data as $sale){
            $saleData = array_combine($this->header, $sale);
            foreach ($saleData as $rowData) {

                $title = $rowData[0];
                $description = $rowData[1];
                $sku = $rowData[2];
                $barcode = $rowData[3];
                $tax = $rowData[4];
                $status = $rowData[5];
                $price = $rowData[6];
                $quantity = $rowData[7];
                $lowstock_threshold = $rowData[8];
                $discount = (int)$rowData[9];
                $images = $rowData[10];
                $brand = $rowData[11];
                $categories = $rowData[12];
                $season = $rowData[13];
                $aisle = $rowData[14];
                $shelf = $rowData[15];

                $brand_id = NULL;
                $category_id = NULL;
                $attribute_id = NULL;
                $attribute_value_id = NULL;

                $attribute_count = count($column) - 16;

                $barcode_exists = ProductVariants::where('barcode',$barcode)->exists();

                if($barcode_exists){
                    $exists_barcodes[] = $barcode;
                }else{

                    //attribute
                    for($j=1; $j<=$attribute_count; $j++) {
                        if($j%2 == 1){
                            $attribute = $rowData[15+$j];
                            $attribute_insert_id = NULL;
                            $attribute_exist = Attribute::where(trim(strtolower('name')),trim(strtolower($attribute)))->first();
                            if(empty($attribute_exist)){
                                if(trim(strtolower($attribute))!=''){
                                    $attrbutes = new Attribute;
                                    $attrbutes->name = $attribute;
                                    $attrbutes->save();
                                    $attribute_id .= $attrbutes->id.',';
                                    $attribute_insert_id = $attrbutes->id;
                                }
                            }else{
                                $attribute_id .= $attribute_exist->id.',';
                                $attribute_insert_id = $attribute_exist->id;
                            }

                        }elseif($j%2 == 0){

                            $attribute_values = $rowData[15+$j];

                            $att_value_arr = explode(',', $attribute_values);
                            foreach ($att_value_arr as $key => $value) {
                                  $attribute_value_exist = AttributeValue::where(trim(strtolower('name')),trim(strtolower($value)))->first();

                                if(empty($attribute_value_exist)){
                                    if(trim(strtolower($value))!=''){

                                        $attribute_value = new AttributeValue;
                                        $attribute_value->name = trim(strtolower($value));
                                        $attribute_value->attribute_id = $attribute_insert_id;
                                        $attribute_value->save();
                                        $attribute_value_id .= $attribute_value->id.',';
                                    }
                                }else{
                                    $attribute_value_id .= $attribute_value_exist->id.',';
                                }
                                
                            }
                        }
                    }
                    
                    // brand
                    $brandData = Brand::where(strtolower('name'),strtolower($brand))->first();
                    if(empty($brandData)){
                        $brands = new Brand;
                        $brands->name = $brand;
                        $brands->save();
                        $brand_id = $brands->id;
                    }else{
                        $brand_id = $brandData->id;
                    }
                    
                    //categories
                    if(strpos($categories, '>') !== false) {
                        // explodable
                        $cat_arr = explode('>', $categories);
                        $parent_id = NULL;
                        foreach ($cat_arr as $key => $value) {
                            
                            $category_exist = Category::where(trim(strtolower('name')),trim(strtolower($value)))->first();
                            if(empty($category_exist)){
                                if(trim(strtolower($value))!=''){
                                    $category = new Category;
                                    $category->name = $value;
                                    $category->parent = $parent_id;
                                    $category->save();
                                    $parent_id = $category->id;
                                    $category_id = $category->id;
                                }
                            }else{
                                $parent_id = $category_exist->id;
                                $category_id = $category_exist->id;
                            }
                        }
                    } else {
                        $category_exist = Category::where(trim(strtolower('name')),trim(strtolower($categories)))->first();
                        if(empty($category_exist)){
                            if(trim(strtolower($categories))!=''){
                                $category = new Category;
                                $category->name = $categories;
                                $category->save();
                                $category_id = $category->id;
                            }
                        }else{
                            $category_id = $category_exist->id;
                        }
                    }
                    if($attribute_id == NULL){
                        $type = 'single';
                    }else{
                        $type = 'group';
                    }
                    $product = new Products;
                    $product->title = $title;
                    $product->description = $description;
                    $product->tax = $tax;
                    $product->status = $status;
                    $product->brand_id = $brand_id;
                    $product->category_id = $category_id;
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

                    if(trim(strtolower($images))!='')
                    {
                        $images_arr = explode(',', $images);
                    
                        $i = 1;
                        foreach ($images_arr as $key => $value) {
                            $i++;
                            $file1 = public_path('images/product_images').'/'.$value;
                            $farry1 = explode("/",$file1);
                            $filename1 = end($farry1);
                            $extesion1 = explode('.', $filename1);
                            $extesion1 = end($extesion1);
                            $path1 = public_path('images/product_images');
                            $image1 = date('YmdHis') . $i .'.'.$extesion1;
                            $new_image1 = $path1.'/'.$image1;

                            $product_images = new ProductImages;
                            $product_images->product_id = $product->id;
                            $product_images->variant_id = $product_variant->id;
                            $product_images->created_by =Auth::user()->id;
                            if (!@copy($value, $new_image1)) {
                            
                            }else{
                                $product_images['image'] = $image1;
                            }
                            $product_images->save();
                        }
                    }

                }
            }
        }*/

    }
}
