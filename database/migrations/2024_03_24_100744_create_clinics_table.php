<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->string('manager_name')->nullable();
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->string('clinic_name')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('password')->nullable();
            $table->integer('otp')->default(0);
            $table->tinyInteger('is_otp_verified')->default(0);
            $table->timestamp('otp_created_at')->nullable();
            $table->string('token')->nullable();
            $table->integer('is_deleted')->default(0);
            $table->tinyInteger('is_approved')->default(0);
            $table->integer('approved_at')->nullable();
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
        Schema::dropIfExists('clinics');
    }
}
