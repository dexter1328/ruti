<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id');
            $table->bigInteger('product_id');
            $table->bigInteger('product_variant_id');
            $table->string('measurement');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->string('discount');
            $table->decimal('actual_price', 10, 2);
            $table->string('barcode_tag');
            $table->string('status');
            $table->string('return_reason');
            $table->string('additional_comment');
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
        Schema::dropIfExists('order_items');
    }
}
