<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderReturndetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_returndetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('return_id');
            $table->bigInteger('order_id');
            $table->bigInteger('customer_id');
            $table->bigInteger('vendor_id');
            $table->bigInteger('store_id');
            $table->bigInteger('product_id');
            $table->bigInteger('product_variant_id');
            $table->string('measurement');
            $table->integer('quantity');
            $table->float('price');
            $table->string('discount');
            $table->string('barcode_tag');
            $table->string('created_by');
            $table->string('updated_by');
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
        Schema::dropIfExists('order_returndetails');
    }
}
