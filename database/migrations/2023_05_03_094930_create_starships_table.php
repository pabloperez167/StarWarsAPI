<?php

use Illuminate\Database\Migrations\Migration;
//Define la estructura de la tabla 
use Illuminate\Database\Schema\Blueprint;
//Para interactuar con el esquema de la base de datos
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        Schema::create('starships', function (Blueprint $table) {           
            $table->id();
            $table->string('name');
            $table->string('model')->default('')->nullable();
            $table->json('pilotos')->default(json_encode([]))->nullable();
            $table->bigInteger('coste')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * El método down() define la lógica para revertir la migración, es decir, 
     * eliminar la tabla starships de la base de datos. Schema::dropIfExists() se utiliza para eliminar la tabla si existe.
     */
    public function down(): void
    {
        Schema::dropIfExists('starships');
    }
};
