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
        Schema::create('rl_hojas_ruta', function (Blueprint $table) {
            $table->id();
            $table->integer('paso');
            $table->string('paso_txt');
            $table->string('instructivo')->nullable();
            $table->string('nro_hojas_ingreso')->nullable();
            $table->string('nro_anexos_ingreso')->nullable();
            $table->string('nro_hojas_salida')->nullable();
            $table->string('nro_anexos_salida')->nullable();
            $table->dateTime('fecha_ingreso')->nullable();
            $table->dateTime('fecha_salida')->nullable();
            $table->dateTime('fecha_envio')->nullable();
            $table->boolean('actual');
            $table->unsignedBigInteger('remitente_id')->nullable();
            $table->unsignedBigInteger('destinatario_id')->nullable();
            $table->unsignedBigInteger('estado_id');
            $table->unsignedBigInteger('tramite_id');
            $table->timestamps();

            $table->foreign('remitente_id')
                ->references('id')
                ->on('rl_user_cargo_tram')
                ->onDelete('restrict');

            $table->foreign('destinatario_id')
                ->references('id')
                ->on('rl_user_cargo_tram')
                ->onDelete('restrict');

            $table->foreign('estado_id')
                ->references('id')
                ->on('rl_tipo_estado')
                ->onDelete('restrict');

            $table->foreign('tramite_id')
                ->references('id')
                ->on('rl_tramite')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rl_hojas_ruta');
    }
};
