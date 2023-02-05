<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('vendor_id');
            $table->string('name');
            $table->string('image');
            $table->string('address1');
            $table->string('address2');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->float('lat');
            $table->float('long');
            $table->string('pincode');
            $table->string('phone_code');
            $table->string('branch_admin');
            $table->integer('phone_number');
            $table->integer('mobile_number');
            $table->string('email')->unique();
            $table->string('password');
            $table->float('website_link');
            $table->enum('open_status', ['open', 'close']);
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
        Schema::dropIfExists('vendor_stores');
    }
}
