<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembershipCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('vendor_id');
            $table->bigInteger('store_id');
            $table->string('stripe_coupon_id')->nullable();
            //$table->string('code');
            $table->string('name');
            //$table->enum('type', ['percentage_discount', 'fixed_amount_discount']);
            //$table->double('amount', 8, 2);
            $table->double('discount', 8, 2);
            //$table->enum('duration', ['forever', 'once', 'repeating']);
            //$table->integer('number_of_month')->nullable();
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
        Schema::dropIfExists('membership_coupons');
    }
}
