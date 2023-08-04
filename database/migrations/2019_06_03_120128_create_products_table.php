<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sku');
            $table->string('title');
            $table->string('slug');
            $table->longText('description');
            $table->bigInteger('supplier_id');
            $table->bigInteger('vendor_id');
            $table->string('seller_type');
            $table->bigInteger('store_id')->nullable();
            $table->string('w2b_category_1');
            $table->string('w2b_category_2')->nullable();
            $table->string('w2b_category_3')->nullable();
            $table->bigInteger('brand')->nullable();
            $table->bigInteger('retail_price');
            $table->bigInteger('wholesale_price')->nullable();
            $table->bigInteger('stock')->nullable();
            $table->string('in_stock')->nullable();
            $table->string('original_image_url');
            $table->string('large_image_url_250x250')->nullable();
            $table->string('large_image_url_500x500')->nullable();
            $table->string('condition')->nullable();
            $table->bigInteger('shipping_price')->nullable();
            $table->string('sales_tax_state')->nullable();
            $table->float('sales_tax_pct')->nullable();
            $table->string('extra_img_1')->nullable();
            $table->string('extra_img_2')->nullable();
            $table->string('extra_img_3')->nullable();
            $table->string('extra_img_4')->nullable();
            $table->string('extra_img_5')->nullable();
            $table->string('extra_img_6')->nullable();
            $table->string('extra_img_7')->nullable();
            $table->string('extra_img_8')->nullable();
            $table->string('extra_img_9')->nullable();
            $table->string('extra_img_10')->nullable();
            $table->string('ship_from')->nullable();
            $table->string('ship_to')->nullable();
            $table->longText('return_policy')->nullable();
            $table->bigInteger('avg_shipping_days')->nullable();
            $table->enum('status', ['enable', 'disable'])->default('enable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
