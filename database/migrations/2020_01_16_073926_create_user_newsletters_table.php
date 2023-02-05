<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserNewslettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_newsletters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('newsletter_id');
            $table->bigInteger('user_id');
            $table->enum('is_send', [0, 1])->default(0);
            $table->enum('type', ['vendor', 'user']);
            $table->bigInteger('send_by');
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
        Schema::dropIfExists('user_newsletters');
    }
}
