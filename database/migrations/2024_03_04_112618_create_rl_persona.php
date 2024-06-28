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
        //para las personas
        Schema::create('rl_persona', function (Blueprint $table) {
            $table->id();
            $table->string('ci', 20)->required()->unique();
            $table->string('complemento')->nullable();
            $table->string('nit', 20)->nullable()->unique();
            $table->string('nombres')->required();
            $table->string('ap_paterno')->nullable();
            $table->string('ap_materno')->nullable();
            $table->date('fecha_nacimiento')->required();
            $table->string('gmail', 100)->nullable();
            $table->string('celular', 20)->required();
            $table->text('direccion')->required();
            $table->string('estado', 20);
            $table->unsignedInteger('id_genero');
            $table->unsignedInteger('id_estado_civil');
            $table->unsignedInteger('id_usuario');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');

            $table->foreign('id_genero')
                ->references('id')
                ->on('rl_genero')
                ->onDelete('restrict');

            $table->foreign('id_estado_civil')
                ->references('id')
                ->on('rl_estado_civil')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rl_persona');
    }
};
