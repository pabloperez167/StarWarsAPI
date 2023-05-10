<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStarshipPilotTable extends Migration
{
    public function up()
    {
        Schema::create('starship_pilot', function (Blueprint $table) {
            $table->unsignedBigInteger('starship_id');
            $table->unsignedBigInteger('pilot_id');
            $table->timestamps();

            $table->foreign('starship_id')->references('id')->on('starships')->onDelete('cascade');
            $table->foreign('pilot_id')->references('id')->on('pilots')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('starship_pilot');
    }
}

