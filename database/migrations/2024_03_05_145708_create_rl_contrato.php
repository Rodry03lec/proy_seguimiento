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
        Schema::create('rl_tipo_baja', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique();
            $table->string('estado', 20);
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');
        });
        //para los generos
        Schema::create('rl_baja', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->required();
            $table->text('descripcion');
            $table->unsignedBigInteger('id_tipo_baja');
            $table->unsignedBigInteger('id_usuario');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');

            $table->foreign('id_tipo_baja')
                ->references('id')
                ->on('rl_tipo_baja')
                ->onDelete('restrict');
        });

        //aqui iniciamos los datos para el contrato de cada persona
        Schema::create('rl_contrato', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_inicio')->required();
            $table->date('fecha_conclusion')->nullable();
            $table->string('numero_contrato')->nullable();
            $table->decimal('haber_basico', 10, 2)->required()->nullable();
            $table->string('estado', 20);
            $table->unsignedBigInteger('id_nivel');
            $table->unsignedBigInteger('id_tipo_contrato');
            $table->unsignedBigInteger('id_persona');
            $table->unsignedBigInteger('id_cargo_mae')->nullable();
            $table->unsignedBigInteger('id_cargo_sm')->nullable();
            $table->unsignedBigInteger('id_profesion')->nullable();
            $table->unsignedBigInteger('id_grado_academico');
            $table->unsignedBigInteger('id_horario');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_baja')->nullable();
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');
            $table->timestamp('delete_at')->nullable();


            //relacionamos con nivel
            $table->foreign('id_nivel')
                ->references('id')
                ->on('rl_nivel')
                ->onDelete('restrict');
            //relacionamos con tipo de contrato
            $table->foreign('id_tipo_contrato')
                ->references('id')
                ->on('rl_tipo_contrato')
                ->onDelete('restrict');
            //relacionamos con persona
            $table->foreign('id_persona')
                ->references('id')
                ->on('rl_persona')
                ->onDelete('restrict');
            //relacionamos con cargo mae
            $table->foreign('id_cargo_mae')
                ->references('id')
                ->on('rl_cargo_mae')
                ->onDelete('restrict');
            //relacionamos con cargo_sm
            $table->foreign('id_cargo_sm')
                ->references('id')
                ->on('rl_cargo_sm')
                ->onDelete('restrict');
            //relacionamos con rl_profesion
            $table->foreign('id_profesion')
                ->references('id')
                ->on('rl_profesion')
                ->onDelete('restrict');
            //relacionamos con el grado academico
            $table->foreign('id_grado_academico')
                ->references('id')
                ->on('rl_grado_academico')
                ->onDelete('restrict');
            //relacionamos con rl_horarios
            $table->foreign('id_horario')
                ->references('id')
                ->on('rl_horarios')
                ->onDelete('restrict');
            //relacionamos con el usuario
            $table->foreign('id_usuario')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
            //relacionamos con rl_baja
            $table->foreign('id_baja')
                ->references('id')
                ->on('rl_baja')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rl_tipo_baja');
        Schema::dropIfExists('rl_baja');
        Schema::dropIfExists('rl_contrato');
    }
};
