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

        //para el tipo de licencias
        Schema::create('rl_tipo_licencia', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->string('normativa', 100);
            $table->string('motivo');
            $table->string('jornada_laboral');
            $table->string('requisitos');
            $table->string('plazos');
            $table->string('observaciones');
            $table->string('estado', 20);
            $table->unsignedBigInteger('id_usuario');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');
        });


        Schema::create('rl_licencia', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('descripcion')->nullable();
            $table->time('hora_inicio');
            $table->time('hora_final');
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->boolean('aprobado')->default(true);
            $table->boolean('constancia')->default(false);
            $table->unsignedBigInteger('id_us_create');
            $table->unsignedBigInteger('id_us_update')->nullable();
            $table->unsignedBigInteger('id_tipo_licencia');
            $table->unsignedBigInteger('id_persona');
            $table->unsignedBigInteger('id_contrato');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');

            //relacion con tipo de licencia
            $table->foreign('id_tipo_licencia')
                    ->references('id')
                    ->on('rl_tipo_licencia')
                    ->onDelete('restrict');

            //relacion con persona
            $table->foreign('id_persona')
                    ->references('id')
                    ->on('rl_persona')
                    ->onDelete('restrict');

            //relacion con el contrato
            $table->foreign('id_contrato')
                    ->references('id')
                    ->on('rl_contrato')
                    ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rl_licencia');
    }
};
