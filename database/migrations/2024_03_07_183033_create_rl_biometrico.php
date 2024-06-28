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
        Schema::create('rl_biometrico', function (Blueprint $table) {
            $table->id();
            $table->time('hora_ingreso_ma')->nullable();
            $table->time('hora_salida_ma')->nullable();
            $table->time('hora_entrada_ta')->nullable();
            $table->time('hora_salida_ta')->nullable();
            $table->unsignedBigInteger('id_fecha');
            $table->unsignedBigInteger('id_persona');
            $table->unsignedBigInteger('id_contrato');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_user_up')->nullable();
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');

            //relacion con la fecha_principal
            $table->foreign('id_fecha')
                ->references('id')
                ->on('rl_fecha_principal')
                ->onDelete('restrict');
            //relacion con persona
            $table->foreign('id_persona')
                ->references('id')
                ->on('rl_persona')
                ->onDelete('restrict');
            //relacion con contrato
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
        Schema::dropIfExists('rl_biometrico');
    }
};
