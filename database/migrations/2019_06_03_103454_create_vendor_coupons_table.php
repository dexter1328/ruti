<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('coupon_code');
            $table->bigInteger('vender_id');
            $table->bigInteger('store_id');
            $table->bigInteger('brand_id')->nullable();
            $table->string('category_id')->nullable();
            $table->string('image');
            $table->string('type');
            $table->integer('discount');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['enable', 'disable']);
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
        Schema::dropIfExists('vendor_coupons');
    }
}
