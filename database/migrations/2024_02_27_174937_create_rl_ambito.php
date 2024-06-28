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
        Schema::create('rl_ambito', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique()->required();
            $table->text('descripcion');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');
        });

        Schema::create('rl_profesion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150)->nullable()->unique();
            $table->string('estado');
            $table->unsignedBigInteger('id_ambito');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');

            $table->foreign('id_ambito')
                ->references('id')
                ->on('rl_ambito')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rl_ambito');
        Schema::dropIfExists('rl_profesion');
    }
};
