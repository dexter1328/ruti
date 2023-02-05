<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateW2bOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w2b_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id');
            $table->string('user_id');
            $table->string('total_price');
            $table->string('order_notes')->nullable();
            $table->string('is_paid')->default('no');
            $table->enum('status', ['processing', 'shipped', 'delivered', 'cancelled'])->default('processing');

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
        Schema::dropIfExists('w2b_orders');
    }
}
