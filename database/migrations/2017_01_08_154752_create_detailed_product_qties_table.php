<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailedProductQtiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailed_product_qties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('report_number');
            $table->enum('match',['yes','no'])->nullable();
            $table->string('boxes_opened_photos')->nullable();
            $table->string('boxes_opened_revision')->nullable();
            $table->string('total_boxes_opened')->nullable();
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
        Schema::dropIfExists('detailed_product_qties');
    }
}
