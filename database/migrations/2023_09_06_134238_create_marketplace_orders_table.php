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
            $table->decimal('wholesale_price', 10, 2);
            $table->decimal('nature_fee', 10, 2);
            $table->decimal('retail_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->decimal('nature_total_fee', 10, 2);
            $table->decimal('supplier_total_price', 10, 2);
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
