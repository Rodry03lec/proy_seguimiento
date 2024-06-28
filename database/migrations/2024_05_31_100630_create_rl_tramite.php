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
        Schema::create('rl_tramite', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_creada');
            $table->time('hora_creada');
            $table->dateTime('fecha_hora_creada');
            $table->string('cite', 100);
            $table->string('cite_texto');
            $table->integer('numero_hojas')->nullable();
            $table->integer('numero_anexos')->nullable();
            $table->string('referencia')->nullable();
            $table->string('remitente_nombre')->nullable();
            $table->string('remitente_cargo')->nullable();
            $table->string('remitente_sigla')->nullable();
            $table->string('remitente_txt')->nullable();
            $table->string('destinatario_nombre')->nullable();
            $table->string('destinatario_cargo')->nullable();
            $table->string('destinatario_sigla')->nullable();
            $table->string('destinatario_txt')->nullable();
            $table->year('gestion');
            $table->string('numero_unico', 50);
            $table->string('codigo', 50);
            $table->string('observacion')->nullable();
            $table->unsignedBigInteger('id_tipo_prioridad'); //1 relacion
            $table->unsignedBigInteger('id_tipo_tramite'); //1 relacion
            $table->unsignedBigInteger('id_estado'); //1 relacion
            $table->unsignedBigInteger('remitente_id')->nullable();
            $table->unsignedBigInteger('destinatario_id')->nullable();
            $table->unsignedBigInteger('user_cargo_id')->nullable();
            $table->timestamps();

            $table->foreign('id_tipo_prioridad')
                    ->references('id')
                    ->on('rl_tipo_prioridad')
                    ->onDelete('restrict');

            $table->foreign('id_tipo_tramite')
                    ->references('id')
                    ->on('rl_tipo_tramite')
                    ->onDelete('restrict');

            $table->foreign('id_estado')
                    ->references('id')
                    ->on('rl_tipo_estado')
                    ->onDelete('restrict');

            $table->foreign('remitente_id')
                    ->references('id')
                    ->on('rl_user_cargo_tram')
                    ->onDelete('restrict');

            $table->foreign('destinatario_id')
                    ->references('id')
                    ->on('rl_user_cargo_tram')
                    ->onDelete('restrict');

            $table->foreign('user_cargo_id')
                    ->references('id')
                    ->on('rl_user_cargo_tram')
                    ->onDelete('restrict');
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rl_tramite');
    }
};
