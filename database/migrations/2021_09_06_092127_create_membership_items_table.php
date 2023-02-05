<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembershipItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('membership_id');
            $table->string('stripe_price_id')->nullable();
            $table->longText('description')->nullable();
            $table->string('billing_period');
            $table->double('price', 8, 2);
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
        Schema::dropIfExists('membership_items');
    }
}
