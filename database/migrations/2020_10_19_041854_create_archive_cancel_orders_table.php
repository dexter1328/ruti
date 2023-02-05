<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchiveCancelOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archive_cancel_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id');
            $table->bigInteger('vendor_id');
            $table->bigInteger('store_id');
            $table->string('order_no');
            $table->string('type');
            $table->string('pickup_time');
            $table->string('pickup_date');
            $table->string('order_status');
            $table->double('total_price',8,2);
            $table->double('promo_code',8,2);
            $table->double('item_total',8,2);
            $table->bigInteger('coupon_id');
            $table->decimal('tax',8,2);
            $table->string('cancel_reason');
            $table->string('additional_comment');
            $table->string('completed_date');
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
        Schema::dropIfExists('archive_cancel_orders');
    }
}
