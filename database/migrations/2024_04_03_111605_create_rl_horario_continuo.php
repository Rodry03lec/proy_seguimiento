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
        Schema::create('rl_horario_continuo', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 100);
            $table->date('fecha_inicio')->unique();
            $table->date('fecha_final')->unique();
            $table->time('hora_salida');
            $table->string('estado', 20);
            $table->unsignedBigInteger('id_usuario');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rl_horario_continuo');
    }
};
