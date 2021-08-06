<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('report_number');
            $table->time('inspector_arrival_time')->nullable();
            $table->time('cargo_ready_time')->nullable();
            $table->time('container_arrival_time')->nullable();
            $table->time('loading_started')->nullable();
            $table->time('inspection_finished')->nullable();
            $table->enum('loading_facility_cooperation',['good','bad','average'])->nullable();
            $table->string('container_number')->nullable();
            $table->string('shipping_seal_number')->nullable();
            $table->string('sera_seal_number')->nullable();
            $table->enum('container_size',['20st','40st','40hc','45hc'])->nullable();
            $table->enum('container_status',['good','damaged','seriously damaged'])->nullable();
            $table->string('container_damage_1')->nullable();
            $table->string('container_damage_2')->nullable();
            $table->enum('holes',['no','yes'])->nullable();
            $table->string('cargo_holes')->nullable();
            $table->enum('dents',['no','yes'])->nullable();
            $table->string('cargo_dents')->nullable();
            $table->enum('floor_condition',['good','scratched','broken'])->nullable();
            $table->enum('doors_condition',['good','bad'])->nullable();
            $table->enum('light_proof',['good','bad'])->nullable();
            $table->string('loading_area')->nullable();
            $table->string('front_doors')->nullable();
            $table->string('left_side')->nullable();
            $table->string('right_side')->nullable();
            $table->string('container_floor_and_joint')->nullable();
            $table->string('container_wall_and_joint')->nullable();
            $table->string('container_ceiling')->nullable();
            $table->string('container_doors_closed')->nullable();
            $table->string('equipment_interchange_receipt')->nullable();
            $table->enum('palletized_cargo',['yes','no'])->nullable();
            $table->string('specify_pallet_material')->nullable();
            $table->string('pallet_material')->nullable();
            $table->string('fumigation_stamp')->nullable();
            $table->string('number_of_pallets_loaded')->nullable();
            $table->string('from_pallet_number')->nullable();
            $table->string('to_pallet_number')->nullable();
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
        Schema::dropIfExists('cargos');
    }
}
