<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('stripe_customer_id');
            $table->string('stripe_subscription_id');
            $table->string('stripe_price_id');
            $table->double('plan_amount', 8, 2);
            $table->string('plan_interval', 50);
            $table->integer('plan_interval_count');
            $table->datetime('plan_period_start');
            $table->datetime('plan_period_end');
            $table->string('status', 50);
            $table->enum('user_type', ['customer', 'vendor']);
            $table->enum('action', ['created', 'updated']);
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
        Schema::dropIfExists('subscription_histories');
    }
}
