<?php

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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('owner'); // usuario de GitHub
            $table->string('repo');
            $table->string('path'); // ruta local donde se clonó
            $table->string('language'); // php, javascript, python, etc
            $table->json('rules')->nullable(); // reglas a ejecutar
            $table->json('config')->nullable(); // configuración del proyecto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
