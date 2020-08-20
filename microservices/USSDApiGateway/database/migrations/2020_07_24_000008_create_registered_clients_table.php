<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisteredClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('registered_clients')) {
            Schema::create('registered_clients', function (Blueprint $table) {
                $table->increments('id');
                $table->string('first_name');
                $table->string('last_name');
                $table->string('nrc')->unique();
                $table->string('gender');
                $table->string('phone_number')->unique();
                $table->string('residential_address')->nullable();
                $table->string('status');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registered_clients');
    }
}
