<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->bigInteger('vendor_id');
            $table->string('payment_gateway');
            $table->bigInteger('client_id');
            $table->string('client_secret');
            $table->string('access_token');
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
        Schema::dropIfExists('vendor_configurations');
    }
}
