<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerPetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_pets', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('category')->nullable();
            $table->string('name')->nullable();
            $table->string('breed')->nullable();
            $table->string('age')->nullable();


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
        Schema::dropIfExists('customer_pets');
    }
}
