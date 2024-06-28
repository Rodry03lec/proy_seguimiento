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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('usuario')->required()->unique();
            $table->string('password')->required();
            $table->string('ci', 100);
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('estado', 20);
            $table->unsignedBigInteger('id_persona');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
