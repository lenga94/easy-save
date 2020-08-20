<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('clients')) {
            Schema::create('clients', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->nullable();
                $table->string('client_number')->unique();
                $table->string('first_name', 100);
                $table->string('last_name', 100);
                $table->string('other_names', 100)->nullable();
                $table->string('title')->nullable();
                $table->date('dob')->nullable();
                $table->enum('gender', ['Male', 'Female'])->nullable();
                $table->string('marital_status')->nullable();
                $table->string('nationality')->nullable();
                $table->string('tribe')->nullable();
                $table->string('nrc')->unique()->nullable();
                $table->string('birth_place')->nullable();
                $table->string('passport_number')->unique()->nullable();
                $table->string('phone_number')->unique()->nullable();
                $table->string('residential_address')->nullable();
                $table->string('postal_address')->nullable();
                $table->string('status');
                $table->string('profile_photo')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
