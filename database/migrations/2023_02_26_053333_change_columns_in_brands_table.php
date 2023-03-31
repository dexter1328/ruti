<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsInBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->bigInteger('store_id')->nullable()->change();
            $table->unsignedBigInteger('vendor_id')->change();
            $table->string('seller_type')->default('vendor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->bigInteger('store_id')->change();
            $table->bigInteger('vendor_id')->change();
            $table->dropColumn('seller_type');
        });
    }
}
