<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
             $table->bigInteger('order_id');
            $table->bigInteger('customer_id');
            $table->float('total_amount');
            $table->string('coupon_code');
            $table->integer('reward_points');
            $table->float('net_amount');
            $table->longText('description');
            $table->enum('status', ['verified', 'unverified']);
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
        Schema::dropIfExists('orders_payments');
    }
}
