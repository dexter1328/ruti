<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsOutwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_outwards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->bigInteger('vendor_id');
            $table->bigInteger('store_id');
            $table->bigInteger('customer_id');
            $table->bigInteger('order_id');
            $table->bigInteger('product_variant_id');
            $table->bigInteger('product_id');
            $table->integer('quantity');
            $table->enum('status', ['done', 'cancel']);
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
        Schema::dropIfExists('products_outwards');
    }
}
