<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePilotStarshipTable extends Migration
{
    public function up()
    {
        Schema::create('pilot_starship', function (Blueprint $table) {

            $table->unsignedBigInteger('starship_id');
            $table->unsignedBigInteger('pilot_id');
        
            // Definir las claves primarias y las restricciones de clave externa
            $table->primary(['pilot_id', 'starship_id']);
            $table->foreign('pilot_id')->references('id')->on('pilots')->onDelete('cascade');
            $table->foreign('starship_id')->references('id')->on('starships')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pilot_starship');
    }
}

