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
        Schema::create('rl_tipo_contrato', function (Blueprint $table) {
            $table->id();
            $table->string('sigla', 50);
            $table->string('nombre', 100);
            $table->string('estado', 20);
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');
            $table->timestamp('deleted_at')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rl_tipo_contrato');
    }
};
