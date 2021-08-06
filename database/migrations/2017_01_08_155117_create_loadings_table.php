<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loadings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('report_number');
            $table->string('container_number_photo')->nullable();
            $table->string('empty_container')->nullable();
            $table->string('quarter_loaded_container')->nullable();
            $table->string('half_loaded_container')->nullable();
            $table->string('threefourth_loaded_container')->nullable();
            $table->string('full_loaded_container')->nullable();
            $table->string('container_closed_seals')->nullable();
            $table->string('shipping_seal_number')->nullable();
            $table->string('sera_seal_number')->nullable();
            $table->string('warehouse')->nullable();
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
        Schema::dropIfExists('loadings');
    }
}
