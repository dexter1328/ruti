<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSuppliersOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('suppliers_orders', function (Blueprint $table) {
            $table->string('status')->nullable()->default('processing')->after('supplier_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('suppliers_orders', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
