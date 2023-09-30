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
            $table->bigInteger('user_id');
            $table->decimal('total_price', 10, 2);
            $table->string('order_notes')->nullable();
            $table->string('is_paid')->default('no');
            $table->enum('status', ['processing', 'shipped', 'delivered', 'cancelled', 'returned'])->default('processing');
            $table->longText('gift_receipt');

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
