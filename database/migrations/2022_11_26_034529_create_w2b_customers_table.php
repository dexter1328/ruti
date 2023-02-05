<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateW2bCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w2b_customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('about')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('address')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('state')->nullable();
            $table->string('Country')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('pincode')->nullable();
            $table->string('phone_code')->nullable();
            $table->bigInteger('mobile');
            $table->integer('passcode')->nullable();
            $table->date('dob')->nullable();
            $table->date('anniversary_date')->nullable();
            $table->string('image')->nullable();
            $table->string('receive_newsletter')->nullable();
            $table->enum('terms_conditions', ['yes', 'no'])->nullable();
            $table->enum('is_online', ['yes', 'no'])->default('no');
            $table->double('wallet_amount', 8, 2)->default(0.00);
            $table->bigInteger('reward_points')->default(0);
            $table->enum('status', ['active', 'deactive']);
            $table->bigInteger('device_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('w2b_customers');
    }
}
