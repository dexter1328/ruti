<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketplaceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketplace_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id');
            $table->bigInteger('vendor_id');
            $table->bigInteger('supplier_id');
            $table->string('product_sku');
            $table->bigInteger('quantity');
            $table->bigInteger('wholesale_price');
            $table->bigInteger('nature_fee');
            $table->bigInteger('retail_price');
            $table->bigInteger('total_price');
            $table->bigInteger('nature_total_fee');
            $table->bigInteger('supplier_total_price');
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
        Schema::dropIfExists('marketplace_orders');
    }
}
