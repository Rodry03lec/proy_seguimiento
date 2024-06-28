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
        Schema::create('rl_tipo_tramite', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('sigla', 20);
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });

        Schema::create('rl_tipo_prioridad', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 20);
            $table->timestamps();
        });

        Schema::create('rl_tipo_estado', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 30);
            $table->string('color')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rl_tipo_tramite');
        Schema::dropIfExists('rl_tipo_prioridad');
        Schema::dropIfExists('rl_tipo_estado');
    }
};
