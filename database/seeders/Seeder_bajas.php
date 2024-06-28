<?php

namespace Database\Seeders;

use App\Models\Configuracion\Tipo_baja;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Seeder_bajas extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeder_baja = array(
            'ABANDONO',
            'AGRADECIMIENTO',
            'DESTITUCIÓN',
            'FINAL CONTRATO',
            'RENUNCIA'
        );
        foreach ($seeder_baja as $lis) {
            $tipo_baja = new Tipo_baja();
            $tipo_baja->nombre = $lis;
            $tipo_baja->estado = 'activo';
            $tipo_baja->save();
        }
    }
}
