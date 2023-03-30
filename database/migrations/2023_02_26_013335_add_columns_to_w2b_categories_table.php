<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToW2bCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('w2b_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable()->change();
            $table->unsignedBigInteger('supplier_id')->nullable()->after('parent_id');
            $table->unsignedBigInteger('source_id')->nullable()->after('parent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('w2b_categories', function (Blueprint $table) {
            $table->integer('parent_id')->nullable()->change();
            $table->dropColumn('supplier_id');
            $table->dropColumn('source_id');
        });
    }
}
