<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_summaries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('service_type');
            $table->string('reference_number')->nullable();
            $table->date('inspection_date');
            $table->boolean('change_date');
            $table->date('shipment_date')->nullable();
            $table->integer('factory_id')->unsigned();
            $table->string('products'); //store id's of products in an array
            $table->string('photos'); //store id's of photos in an array
            $table->string('reference_sample')->nullable();
            $table->string('courier')->nullable();
            $table->string('tracking_number')->nullable();
            $table->boolean('change_inspection_schedule')->default(0);
            $table->string('more_info')->nullable();
            $table->string('manday');
            $table->string('booking_status');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_summaries');
    }
}
