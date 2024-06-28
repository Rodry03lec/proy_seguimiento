<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            Seeder_permision::class,
            Seeder_roles::class,
            Seeder_usuario::class,
            Seeder_configuracion::class,
            Seeder_profesiones::class,
            Seeder_mae::class,
            Seeder_secretaria::class,
            Seeder_horarios::class,
            Seeder_persona::class,
            Seeder_bajas::class,
            Seeder_fecha_principal::class,
            Seeder_licencias::class,
            Seeder_permiso::class,
            Tramite_seeder_configuracion::class,
        ]);
    }
}
