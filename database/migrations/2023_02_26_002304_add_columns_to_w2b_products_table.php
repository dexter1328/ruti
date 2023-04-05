<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToW2bProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('w2b_products', function (Blueprint $table) {
            $table->string('seller_type')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->integer('min_wholesale_qty')->nullable();
            $table->text('wholesale_price_range')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
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
        Schema::table('w2b_products', function (Blueprint $table) {
            $table->dropColumn('seller_type');
            $table->dropColumn('supplier_id');
            $table->dropColumn('min_wholesale_qty');
            $table->dropColumn('wholesale_price_range');
            $table->dropTimestamps();
        });
    }
}
