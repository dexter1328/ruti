<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('device_id');
            $table->bigInteger('reference_id');
            $table->string('title');
            $table->longText('description');
            $table->enum('user_type',['customer', 'vendor']);
            $table->string('type');
            $table->integer('is_send')->default(0);
            $table->integer('is_read')->default(0);
            $table->integer('resend')->default(0);
            $table->string('priority')->nullable();
            $table->string('display')->nullable();
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
        Schema::dropIfExists('user_notifications');
    }
}
