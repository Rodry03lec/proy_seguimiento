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
        Schema::create('rl_user_cargo_tram', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_cargo_sm")->nullable();
            $table->unsignedBigInteger("id_cargo_mae")->nullable();
            $table->unsignedBigInteger("id_contrato");
            $table->unsignedBigInteger("id_usuario");
            $table->unsignedBigInteger("id_persona");
            $table->boolean('estado')->default(true);
            $table->timestamps();

            //relacion con el cargo sm
            $table->foreign('id_cargo_sm')
                    ->references('id')
                    ->on('rl_cargo_sm')
                    ->onDelete('restrict');
            //relacion con el cargo mae
            $table->foreign('id_cargo_mae')
                    ->references('id')
                    ->on('rl_cargo_mae')
                    ->onDelete('restrict');
            //relacion con el contrato
            $table->foreign('id_contrato')
                    ->references('id')
                    ->on('rl_contrato')
                    ->onDelete('restrict');
            //relacion con persona
            $table->foreign('id_persona')
                    ->references('id')
                    ->on('rl_persona')
                    ->onDelete('restrict');
            //relacion con el usuarios
            $table->foreign('id_usuario')
                    ->references('id')
                    ->on('users')
                    ->onDelete('restrict');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rl_user_cargo_tram');
    }
};
