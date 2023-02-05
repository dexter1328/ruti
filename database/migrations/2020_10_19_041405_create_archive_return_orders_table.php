<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchiveReturnOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archive_return_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id');
            $table->bigInteger('product_variant_id');
            $table->bigInteger('customer_id');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('actual_price', 10, 2);
            $table->string('discount');
            $table->string('status');
            $table->longText('return_reason');
            $table->longText('additional_Comment');
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
        Schema::dropIfExists('archive_return_orders');
    }
}
