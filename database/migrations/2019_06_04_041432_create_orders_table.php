<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->time('time');
            $table->bigInteger('customer_id');
            $table->bigInteger('vendor_id');
            $table->bigInteger('store_id');
            $table->enum('type', ['pickup', 'inshop']);
            $table->date('pickup_time');
            $table->date('completed_date');
            $table->string('order_status');
            $table->enum('is_verified', ['yes', 'no']);
            $table->string('payment_type');
            $table->string('verification_code');
            $table->string('status');
            $table->enum('favourite', ['yes', 'no']);
            $table->string('cancel_reason');
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
        Schema::dropIfExists('orders');
    }
}
