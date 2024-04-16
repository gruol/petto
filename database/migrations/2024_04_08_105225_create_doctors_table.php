<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('picture')->nullable();
            $table->string('clinic_name')->nullable();
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->string('education')->nullable();
            $table->string('experience')->nullable();
            $table->string('expertise')->nullable();
            $table->text('availability')->nullable();
            $table->string('charges')->nullable();
            $table->string('is_approved')->nullable();
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
        Schema::dropIfExists('doctors');
    }
}
