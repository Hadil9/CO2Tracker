<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('mode_id')->unsigned();
            $table->foreign('mode_id')->references('id')->on('modes');
            $table->double('co2emission');
            $table->double('fromlatitude');
            $table->double('fromlongitude');
            $table->double('tolatitude');
            $table->double('tolongitude');
            $table->double('distance');
            $table->double('traveltime');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
