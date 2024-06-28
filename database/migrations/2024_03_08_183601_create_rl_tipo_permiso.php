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
        //creamos la tabla de rl_tipo_permiso
        Schema::create('rl_tipo_permiso', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('estado', 20);
            $table->unsignedBigInteger('id_usuario');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');
        });
        //creamos ta tabla de rl_casos
        Schema::create('rl_permiso_desglose', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('descripcion');
            $table->string('estado', 20);
            $table->unsignedBigInteger('id_tipo_permiso');
            $table->unsignedBigInteger('id_usuario');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');

            $table->foreign('id_tipo_permiso')
                    ->references('id')
                    ->on('rl_tipo_permiso')
                    ->onDelete('restrict');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rl_tipo_permiso');
        Schema::dropIfExists('rl_permiso_desglose');
    }
};
