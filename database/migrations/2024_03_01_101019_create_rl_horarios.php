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
         //esto es para los horarios
        Schema::create('rl_horarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique();
            $table->string('descripcion');
            $table->unsignedBigInteger('id_usuario');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');
        });

        //para la parte de los rangos de hora que va tener
        Schema::create('rl_rangos_hora', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->integer('numero');
            $table->time('hora_inicio');
            $table->time('hora_final');
            $table->time('tolerancia')->nullable();
            $table->unsignedBigInteger('id_horario');
            $table->unsignedBigInteger('id_usuario');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');

            $table->foreign('id_horario')
                ->references('id')
                ->on('rl_horarios')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rl_horarios');
        Schema::dropIfExists('rl_rangos_hora');
    }
};
