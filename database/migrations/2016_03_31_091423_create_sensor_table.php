<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensors', function (Blueprint $table) {
            $table->string('sensor_id')->unique();
            $table->string('state');
            $table->string('user_id');
            $table->integer('battery');
            $table->string('location')->default('generic');
            $table->string('description')->default('Sensor description');
            $table->string('name')->default('New sensor');
            $table->boolean('text_enabled')->default(0);
            $table->boolean('call_enabled')->default(0);
            $table->boolean('email_enabled')->default(1);
            $table->string('phone_number')->nullable();
            $table->primary('sensor_id');
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
        Schema::drop('sensors');
    }
}
