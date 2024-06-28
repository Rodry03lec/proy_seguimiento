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
        //crear la mae
        Schema::create('rl_mae', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable()->unique();
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');
        });

        //crear la unidad de la mae
        Schema::create('rl_unidad_mae', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 100);
            $table->unsignedBigInteger('id_mae');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');

            $table->foreign('id_mae')
                ->references('id')
                ->on('rl_mae')
                ->onDelete('restrict');
        });

        //crear el cargo de mae
        Schema::create('rl_cargo_mae', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->unsignedBigInteger('id_unidad');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');

            $table->foreign('id_unidad')
                ->references('id')
                ->on('rl_unidad_mae')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rl_mae');
        Schema::dropIfExists('rl_unidad_mae');
        Schema::dropIfExists('rl_cargo_mae');
    }
};
