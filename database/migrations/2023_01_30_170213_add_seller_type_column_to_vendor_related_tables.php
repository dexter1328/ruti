<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSellerTypeColumnToVendorRelatedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('seller_type')->default('vendor');
        });
        Schema::table('vendor_stores', function (Blueprint $table) {
            $table->string('seller_type')->default('vendor');
        });
        Schema::table('vendor_coupons', function (Blueprint $table) {
            $table->string('seller_type')->default('vendor');
        });
        Schema::table('vendor_paid_modules', function (Blueprint $table) {
            $table->string('seller_type')->default('vendor');
        });
        Schema::table('vendor_payments', function (Blueprint $table) {
            $table->string('seller_type')->default('vendor');
        });
        Schema::table('vendor_roles', function (Blueprint $table) {
            $table->string('seller_type')->default('vendor');
        });
        Schema::table('vendor_role_permissions', function (Blueprint $table) {
            $table->string('seller_type')->default('vendor');
        });
        Schema::table('vendor_settings', function (Blueprint $table) {
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
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('seller_type');
        });
        Schema::table('vendor_stores', function (Blueprint $table) {
            $table->dropColumn('seller_type');
        });
        Schema::table('vendor_coupons', function (Blueprint $table) {
            $table->dropColumn('seller_type');
        });
        Schema::table('vendor_paid_modules', function (Blueprint $table) {
            $table->dropColumn('seller_type');
        });
        Schema::table('vendor_payments', function (Blueprint $table) {
            $table->dropColumn('seller_type');
        });
        Schema::table('vendor_roles', function (Blueprint $table) {
            $table->dropColumn('seller_type');
        });
        Schema::table('vendor_role_permissions', function (Blueprint $table) {
            $table->dropColumn('seller_type');
        });
        Schema::table('vendor_settings', function (Blueprint $table) {
            $table->dropColumn('seller_type');
        });
    }
}
