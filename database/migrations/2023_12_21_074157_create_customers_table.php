<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('password');
            $table->string('contact_no');
            $table->string('email')->unique();
            $table->string('dob');
            // $table->string('pet_category');
            // $table->string('pet_name');
            // $table->string('pet_age');
            // $table->string('pet_breed');
            $table->string('country');
            $table->integer('otp')->default(0);
            $table->tinyInteger('is_otp_verified')->default(0);
            $table->timestamp('otp_created_at')->nullable();
            $table->string('token')->nullable();
            $table->integer('is_deleted')->default(0);
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
        Schema::dropIfExists('agents');
    }
}
