<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerIncentiveQualifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_incentive_qualifiers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('month_year');
            $table->string('membership_code');
            $table->enum('type', ['tier_1', 'tier_2', 'tier_3']);
            $table->enum('sub_type', ['college_scholarship', 'europe_trip', 'caribbean_trip', 'stay_in_hotel', 'adventure_park', 'theme_park', 'gift_card', 'laptop', 'tablet'])->nullable();
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
        Schema::dropIfExists('customer_incentive_qualifiers');
    }
}
