<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_code');
            $table->string('product_name');
            $table->string('product_category');
            $table->string('product_unit');
            $table->string('po_no');
            $table->string('model_no');
            $table->string('brand');
            $table->string('cmf');
            $table->string('tech_specs');
            $table->string('shipping_mark');
            $table->string('additional_product_info');
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
        Schema::dropIfExists('products');
    }
}
