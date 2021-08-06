<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectionInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('report_number');
            $table->string('inspection_date')->nullable();
            $table->string('factory_address')->nullable();
            $table->string('client_name')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_number')->nullable();
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
        Schema::dropIfExists('inspection_infos');
    }
}
