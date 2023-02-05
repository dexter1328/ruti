<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->bigInteger('membership_id');
            $table->dateTime('registered_date');
            $table->dateTime('expired_date');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->float('lat');
            $table->float('long');
            $table->string('pincode');
            $table->string('phone_code');
            $table->integer('phone_number');
            $table->integer('mobile_number');
            $table->float('website_link');
            $table->enum('status', ['active', 'deactive']);
            $table->integer('admin_commision');
            $table->string('created_by');
            $table->string('updated_by');
            $table->rememberToken();
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
        Schema::drop('vendors');
    }
}
