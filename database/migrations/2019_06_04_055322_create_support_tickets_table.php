<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupportTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('store_id');
            $table->bigInteger('order_id');
            $table->string('ticket_no');
            $table->string('subject');
            $table->string('message');
            $table->enum('generated_by', ['customer', 'vendor']);
            $table->enum('user_type', ['customer', 'vendor']);
            $table->enum('status', ['open', 'close', 'resolved', 'reopen']);
            $table->text('attachements');
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
        Schema::dropIfExists('support_tickets');
    }
}
