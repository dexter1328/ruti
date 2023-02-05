<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('label');
            $table->string('link');
            $table->enum('type', ['page', 'custom']);
            $table->enum('target', ['_self', '_blank']);
            $table->enum('position', ['header', 'footer']);
            $table->bigInteger('parent');
            $table->integer('sort');
            $table->enum('status', ['active', 'deactive']);
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
        Schema::dropIfExists('menus');
    }
}
