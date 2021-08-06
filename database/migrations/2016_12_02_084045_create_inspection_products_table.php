<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectionProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('qty');
            $table->enum('gen_inspection_level',['N1','N2','N3']);
            $table->integer('gen_sample_size');
            $table->enum('special_inspection_level',['S1','S2','S3', 'S4']);
            $table->integer('special_sample_size');
            $table->string('minor');
            $table->string('major');
            $table->string('critical');
            $table->string('functional');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspection_products');
    }
}
