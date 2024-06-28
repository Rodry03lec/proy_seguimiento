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
        //para la secretaria municipal
        Schema::create('rl_secretaria_municipal', function (Blueprint $table) {
            $table->id();
            $table->string('sigla', 50)->unique()->required();
            $table->string('nombre', 150)->unique()->required();
            $table->string('estado');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');
        });
        //para las direcciones de la secretaria municipal
        Schema::create('rl_direccion', function (Blueprint $table) {
            $table->id();
            $table->string('sigla', 20)->unique()->required();
            $table->string('nombre', 150)->unique()->required();
            $table->string('estado', 20);
            $table->unsignedBigInteger('id_secretaria');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');

            $table->foreign('id_secretaria')
                ->references('id')
                ->on('rl_secretaria_municipal')
                ->onDelete('restrict');
        });

        //para los cargos
        Schema::create('rl_cargo_sm', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150)->unique()->required();
            $table->unsignedBigInteger('id_direccion')->required();
            $table->unsignedBigInteger('id_unidad')->nullable();
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');

            //relacionamos con rl_direcion
            $table->foreign('id_direccion')
                ->references('id')
                ->on('rl_direccion')
                ->onDelete('restrict');
            //relaxcion con rl_unidades_administrativas
            $table->foreign('id_unidad')
                ->references('id')
                ->on('rl_unidades_admin')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rl_secretaria_municipal');
        Schema::dropIfExists('rl_direccion');
        Schema::dropIfExists('rl_cargo_sm');
    }
};
