<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactoryContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factory_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('factory_id')->unsigned();
            $table->string('client_code')->index();
            $table->string('factory_contact_person');
            $table->string('factory_contact_number');
            $table->string('factory_email');
            $table->timestamps();
            
            $table->foreign('client_code')->references('client_code')->on('clients')->onUpdate('cascade');
            $table->foreign('factory_id')->references('id')->on('factories');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factory_contacts');
    }
}
