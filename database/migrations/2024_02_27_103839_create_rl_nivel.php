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
        Schema::create('rl_nivel', function (Blueprint $table) {
            $table->id();
            $table->string('nivel', 10)->required();
            $table->string('descripcion', 100);
            $table->decimal('haber_basico', 10, 2)->required();
            $table->unsignedBigInteger('id_categoria');
            $table->timestamp('creado_el');
            $table->timestamp('editado_el');

            $table->foreign('id_categoria')
                ->references('id')
                ->on('rl_categoria')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rl_nivel');
    }
};
