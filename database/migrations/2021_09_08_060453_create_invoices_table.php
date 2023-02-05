<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_number');
            $table->string('subscription_id');
            $table->string('invoice_id');
            $table->string('customer_id');
            $table->string('billing_email');
            $table->string('currency', 50);
            $table->string('invoice_status', 50);
            $table->datetime('invoice_created_date');
            $table->enum('user_type', ['customer', 'vendor']);
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
        Schema::dropIfExists('invoices');
    }
}
