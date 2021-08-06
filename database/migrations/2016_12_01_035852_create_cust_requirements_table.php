<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cust_requirements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->boolean('no_key_component');
            $table->boolean('no_serial_number');
            $table->boolean('no_rating_label');
            $table->boolean('no_removable_sticker_product');
            $table->boolean('missing_logo_product');
            $table->boolean('no_removable_sticker_carton');
            $table->boolean('no_imp_exp_info');
            $table->boolean('packing_not_finished');
            $table->boolean('production_not_finished');
            $table->enum('report_requirement_1', ['CE', 'CCC','GS','ROHS','FCC','FCT']);
            $table->enum('report_requirement_2', ['CE', 'CCC','GS','ROHS','FCC','FCT']);
            $table->enum('report_requirement_3', ['CE', 'CCC','GS','ROHS','FCC','FCT']);

            $table->boolean('double_sampling');
            $table->boolean('seal_every_product');
            $table->boolean('seal_opened_carton');
            $table->boolean('seal_on_whole_quantity');
            $table->enum('tic_own_report',['TIC','Own']);
            $table->boolean('tic_chop');

            $table->boolean('temperature_test');
            $table->boolean('humidity_test');
            $table->boolean('temp_rise_test');
            $table->boolean('noise_test');
            $table->string('special_requirements');

            $table->text('instructions');
            $table->boolean('blister_packing');
            $table->boolean('carton_packing');
            $table->enum('tape',['PVC','Fibre Tape','PET','PT']);

            $table->text('additional_requirements');
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
        Schema::dropIfExists('cust_requirements');
    }
}
