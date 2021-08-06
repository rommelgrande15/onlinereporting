<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailed_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('report_number');
            $table->string('product_count')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('po_no')->nullable();
            $table->string('model_number')->nullable();
            $table->string('description')->nullable();
            $table->string('package_qty')->nullable();
            $table->string('pieces')->nullable();
            $table->string('material')->nullable();
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
        Schema::dropIfExists('detailed_products');
    }
}
