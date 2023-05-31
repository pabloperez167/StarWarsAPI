<?php

use Carbon\Traits\ToStringFormat;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
     */
    public function down(): void
    {
        Schema::dropIfExists('starships');
    }
};
