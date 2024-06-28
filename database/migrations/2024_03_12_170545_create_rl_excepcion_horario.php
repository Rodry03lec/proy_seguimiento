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
        

        Schema::create('rl_excepcion_horario', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 100);
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->string('estado', 20);
            $table->time('hora');
            $table->unsignedBigInteger('id_rango_hora');
            $table->unsignedBigInteger('id_usuario');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');

            $table->foreign('id_rango_hora')
                ->references('id')
                ->on('rl_rangos_hora')
                ->onDelete('restrict');
        });

        Schema::create('excepcion_dia_sem', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_excepcion');
            $table->unsignedBigInteger('id_dias_sem');

            $table->foreign('id_excepcion')
                ->references('id')
                ->on('rl_excepcion_horario')
                ->onDelete('cascade');
            $table->foreign('id_dias_sem')
                ->references('id')
                ->on('rl_dias_semana')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rl_excepcion_horario');
        Schema::dropIfExists('excepcion_dia_sem');
    }
};
