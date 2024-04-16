<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->integer('time_id');
            $table->integer('customer_id');
            $table->string('query_status')->nullable();
            $table->string('shipment_status')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('quotation')->nullable();
            $table->string('remarks')->nullable();
            $table->string('category')->nullable();
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();
            $table->string('pet_ids')->nullable();
            $table->string('gross_weight')->nullable();
            $table->string('pet_dimensions')->nullable();
            $table->string('have_cage')->nullable();
            $table->string('cage_dimensions')->nullable();
            $table->string('want_booking')->nullable();
           
            $table->string('shipper_name')->nullable();
            $table->string('shipper_address')->nullable();
            $table->string('shipper_cnic')->nullable();
            $table->string('shipper_contact')->nullable();
            $table->string('shipper_email')->nullable();

            $table->string('consignee_name')->nullable();
            $table->string('consignee_address')->nullable();
            $table->string('consignee_contact')->nullable();
            $table->string('consignee_email')->nullable();

            $table->string('pet_photo1')->nullable();
            $table->string('pet_photo2')->nullable();
            $table->string('pet_passport')->nullable();
            $table->string('microchip')->nullable();
            $table->string('microchip_no')->nullable();
            $table->string('health_certificate')->nullable();
            $table->string('import_permit')->nullable();
            $table->string('titer_report')->nullable();

            $table->string('passport_copy')->nullable();
            $table->string('cnic_copy')->nullable();
            $table->string('ticket_copy')->nullable();
            $table->string('visa_copy')->nullable();

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
        Schema::dropIfExists('shipments');
    }
}
