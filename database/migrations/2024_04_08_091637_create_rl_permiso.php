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
        Schema::create('rl_permiso', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->date('fecha');
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->time('hora_inicio');
            $table->time('hora_final');
            $table->boolean('aprobado')->default(true);
            $table->boolean('constancia')->default(false);
            $table->unsignedBigInteger('id_permiso_desglose');
            $table->unsignedBigInteger('id_us_create');
            $table->unsignedBigInteger('id_us_update')->nullable();
            $table->unsignedBigInteger('id_persona');
            $table->unsignedBigInteger('id_contrato');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('id_permiso_desglose')
                    ->references('id')
                    ->on('rl_permiso_desglose')
                    ->onDelete('restrict');

            $table->foreign('id_persona')
                    ->references('id')
                    ->on('rl_persona')
                    ->onDelete('restrict');

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
        Schema::dropIfExists('rl_permiso');
    }
};
