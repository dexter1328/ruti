<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierSubscriptionTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_subscription_temps', function (Blueprint $table) {
            $table->bigIncrements('id');
                $table->bigInteger('vendor_id');
                $table->string('card_id')->nullable();
                $table->string('subscription_id');
                $table->string('subscription_item_id');
                $table->string('membership_id');
                $table->string('membership_code');
                $table->string('membership_item_id');
                $table->datetime('start_date');
                $table->datetime('end_date');
                $table->enum('status', ['active', 'inactive']);
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
        Schema::dropIfExists('supplier_subscription_temps');
    }
}
