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
        //para los generos
        Schema::create('rl_genero', function (Blueprint $table) {
            $table->id();
            $table->string('sigla');
            $table->string('nombre', 100)->unique();
            $table->string('estado', 20);
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');
        });
        //para el estado civil
        Schema::create('rl_estado_civil', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('estado');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rl_genero');
        Schema::dropIfExists('rl_estado_civil');
    }
};
