<?php

use App\Products;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Products::create([
            'sku' => 'AB1122',
            'title' => 'Product One',
            'description' => 'This is first product',
            'original_image_url' => 'https://w2bimg.gumlet.io/simg/Z157/original/9960618872.jpg?mode=fill&fill=solid&width=500&height=500&fill-color=ffffff',
            'large_image_url_250x250' => 'https://w2bimg.gumlet.io/simg/Z157/original/9960618872.jpg?mode=fill&fill=solid&width=500&height=500&fill-color=ffffff',
            'large_image_url_500x500' => 'https://w2bimg.gumlet.io/simg/Z157/original/9960618872.jpg?mode=fill&fill=solid&width=500&height=500&fill-color=ffffff',
            'retail_price' => 460,
            'supplier_id' => 150,
            'vendor_id' => 150,
            'seller_type' => 'supplier',
            'store_id' => 10,
            'w2b_category_1' => 'Grocery',
            'stock' => 40,
            'in_stock' => 'Y',
            'condition' => 'N',
            'shipping_price' => 20,
            'sales_tax_state' => 'Texas',
            'sales_tax_pct' => 5
        ]);

        Products::create([
            'sku' => 'AB5500',
            'title' => 'Product Second',
            'description' => 'This is Second product',
            'original_image_url' => 'https://w2bimg.gumlet.io/simg/Z157/original/9960618872.jpg?mode=fill&fill=solid&width=500&height=500&fill-color=ffffff',
            'large_image_url_250x250' => 'https://w2bimg.gumlet.io/simg/Z157/original/9960618872.jpg?mode=fill&fill=solid&width=500&height=500&fill-color=ffffff',
            'large_image_url_500x500' => 'https://w2bimg.gumlet.io/simg/Z157/original/9960618872.jpg?mode=fill&fill=solid&width=500&height=500&fill-color=ffffff',
            'retail_price' => 460,
            'supplier_id' => 150,
            'vendor_id' => 150,
            'seller_type' => 'supplier',
            'store_id' => 10,
            'w2b_category_1' => 'Grocery',
            'stock' => 40,
            'in_stock' => 'Y',
            'condition' => 'N',
            'shipping_price' => 20,
            'sales_tax_state' => 'Texas',
            'sales_tax_pct' => 5
        ]);
        Products::create([
            'sku' => 'AB3345',
            'title' => 'Product Third',
            'description' => 'This is Third product',
            'original_image_url' => 'https://w2bimg.gumlet.io/simg/Z157/original/9960618872.jpg?mode=fill&fill=solid&width=500&height=500&fill-color=ffffff',
            'large_image_url_250x250' => 'https://w2bimg.gumlet.io/simg/Z157/original/9960618872.jpg?mode=fill&fill=solid&width=500&height=500&fill-color=ffffff',
            'large_image_url_500x500' => 'https://w2bimg.gumlet.io/simg/Z157/original/9960618872.jpg?mode=fill&fill=solid&width=500&height=500&fill-color=ffffff',
            'retail_price' => 460,
            'supplier_id' => 150,
            'vendor_id' => 150,
            'seller_type' => 'supplier',
            'store_id' => 10,
            'w2b_category_1' => 'Electronics',
            'stock' => 40,
            'in_stock' => 'Y',
            'condition' => 'N',
            'shipping_price' => 20,
            'sales_tax_state' => 'Texas',
            'sales_tax_pct' => 5
        ]);
        Products::create([
            'sku' => 'AB9955',
            'title' => 'Product Forth',
            'description' => 'This is Forth product',
            'original_image_url' => 'https://w2bimg.gumlet.io/simg/Z157/original/9960618872.jpg?mode=fill&fill=solid&width=500&height=500&fill-color=ffffff',
            'large_image_url_250x250' => 'https://w2bimg.gumlet.io/simg/Z157/original/9960618872.jpg?mode=fill&fill=solid&width=500&height=500&fill-color=ffffff',
            'large_image_url_500x500' => 'https://w2bimg.gumlet.io/simg/Z157/original/9960618872.jpg?mode=fill&fill=solid&width=500&height=500&fill-color=ffffff',
            'retail_price' => 460,
            'supplier_id' => 150,
            'vendor_id' => 150,
            'seller_type' => 'supplier',
            'store_id' => 10,
            'w2b_category_1' => 'Accessories',
            'stock' => 40,
            'in_stock' => 'Y',
            'condition' => 'N',
            'shipping_price' => 20,
            'sales_tax_state' => 'Texas',
            'sales_tax_pct' => 5
        ]);
        Products::create([
            'sku' => 'AB4488',
            'title' => 'Product Fifth',
            'description' => 'This is Fifth product',
            'original_image_url' => 'https://w2bimg.gumlet.io/simg/Z157/original/9960618872.jpg?mode=fill&fill=solid&width=500&height=500&fill-color=ffffff',
            'large_image_url_250x250' => 'https://w2bimg.gumlet.io/simg/Z157/original/9960618872.jpg?mode=fill&fill=solid&width=500&height=500&fill-color=ffffff',
            'large_image_url_500x500' => 'https://w2bimg.gumlet.io/simg/Z157/original/9960618872.jpg?mode=fill&fill=solid&width=500&height=500&fill-color=ffffff',
            'retail_price' => 460,
            'supplier_id' => 150,
            'vendor_id' => 150,
            'seller_type' => 'supplier',
            'store_id' => 10,
            'w2b_category_1' => 'Grocery',
            'stock' => 40,
            'in_stock' => 'Y',
            'condition' => 'N',
            'shipping_price' => 20,
            'sales_tax_state' => 'Texas',
            'sales_tax_pct' => 5
        ]);

    }
}
