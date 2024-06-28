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

        //creamos la gestion
        Schema::create('rl_gestion', function (Blueprint $table) {
            $table->id();
            $table->year('gestion')->default(now()->year);
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');
        });

        //creamos el mes
        Schema::create('rl_mes', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->string('nombre', 100);
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');
        });

        //creamos dias de la semana
        Schema::create('rl_dias_semana', function (Blueprint $table) {
            $table->id();
            $table->string('sigla', 20);
            $table->string('nombre');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');
        });

        Schema::create('rl_fecha_principal', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->unsignedBigInteger('id_gestion');
            $table->unsignedBigInteger('id_mes');
            $table->unsignedBigInteger('id_dia_sem');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');

            //relacion con gestion
            $table->foreign('id_gestion')
                ->references('id')
                ->on('rl_gestion')
                ->onDelete('restrict');
            //relacion con los meses
            $table->foreign('id_mes')
                ->references('id')
                ->on('rl_mes')
                ->onDelete('restrict');
            //relacion con dias de semanales
            $table->foreign('id_dia_sem')
                ->references('id')
                ->on('rl_dias_semana')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rl_gestion');
        Schema::dropIfExists('rl_mes');
        Schema::dropIfExists('rl_dias_semana');
        Schema::dropIfExists('rl_fecha_principal');
    }
};
