<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateW2bPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w2b_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payment_id');
            $table->string('payer_email');
            $table->float('amount', 10, 2);
            $table->string('currency');
            $table->string('payment_status');
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
        Schema::dropIfExists('w2b_payments');
    }
}
