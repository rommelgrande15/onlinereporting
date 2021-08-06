<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_id')->index();
            $table->integer('contact_person')->unsigned();
            $table->integer('factory')->unsigned();
            $table->integer('factory_contact_person')->unsigned();  
            $table->integer('inspector_id')->unsigned();
            $table->date('inspection_date');
            $table->string('service');
            $table->string('reference_number');
            $table->string('supplier_name')->nullable();
            $table->string('client_name')->nullable();
            $table->string('requirement')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('client_code')->on('clients')->onUpdate('cascade');
            $table->foreign('contact_person')->references('id')->on('client_contacts');
            $table->foreign('factory')->references('id')->on('factories');
            $table->foreign('factory_contact_person')->references('id')->on('factory_contacts');
            //$table->foreign('inspector_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspections');
    }
}
