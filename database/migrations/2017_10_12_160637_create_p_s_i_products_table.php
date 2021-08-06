<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePSIProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_s_i_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inspection_id')->unsigned();
            $table->string('product_name')->nullable();
            $table->string('brand')->nullable();
            $table->string('po_no')->nullable();
            $table->string('model_no')->nullable();
            $table->integer('aql_qty')->nullable();
            $table->string('aql_normal_level')->nullable();
            $table->string('aql_special_level')->nullable();
            $table->integer('aql_major')->nullable();
            $table->integer('max_allowed_major')->nullable();
            $table->integer('aql_minor')->nullable();
            $table->integer('max_allowed_minor')->nullable();
            $table->string('aql_normal_letter')->nullable();
            $table->integer('aql_normal_sampsize')->nullable();
            $table->string('aql_special_letter')->nullable();
            $table->integer('aql_special_sampsize')->nullable();
            $table->timestamps();

            $table->foreign('inspection_id')->references('id')->on('inspections')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p_s_i_products');
    }
}
