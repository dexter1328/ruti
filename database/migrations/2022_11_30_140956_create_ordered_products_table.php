<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordered_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id');
            $table->string('sku');
            $table->string('title');
            $table->string('image');
            $table->string('price');
            $table->string('quantity');
            $table->string('sales_tax');
            $table->string('shipping_price');
            $table->string('total_price');
            $table->enum('status', ['processing', 'shipped', 'delivered', 'cancelled', 'returned'])->default('processing');
            $table->bigInteger('vendor_id');
            $table->string('seller_type');
            $table->string('tracking_no');
            $table->string('tracking_link');

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
        Schema::dropIfExists('ordered_products');
    }
}
