<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Configuracion\Unidad_mae;
use App\Models\Configuracion\Mae;

class Seeder_mae extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mae = array(
            'DESPACHO ALCALDE MUNICIPAL',
            'SECRETARÍA GENERAL',
        );
        foreach ($mae as $lis) {
            $mae_guardar = new Mae();
            $mae_guardar->nombre = $lis;
            $mae_guardar->save();
        }

        $cargos = array(
            [
                'descripcion'   => 'CHÓFER DESPACHO',
                'id_mae'        => '1'
            ],
            [
                'descripcion'   => 'SECRETARIA DESPACHO',
                'id_mae'        => '1'
            ],
            [
                'descripcion'   => 'AUDITORÍA INTERNA',
                'id_mae'        => '1'
            ],
            [
                'descripcion'   => 'UNIDAD DE TRANSPARENCIA',
                'id_mae'        => '1'
            ],
            [
                'descripcion'   => 'ASUNTOS JURÍDICOS',
                'id_mae'        => '1'
            ],
            [
                'descripcion'   => 'DIRECTOR JURIDICO',
                'id_mae'        => '1'
            ],
            [
                'descripcion'   => 'DIRECCIÓN DE PLANIFICACIÓN',
                'id_mae'        => '1'
            ],
            [
                'descripcion'   => 'SEGURIDAD CIUDADANA',
                'id_mae'        => '2'
            ],
            [
                'descripcion'   => 'TRÁFICO Y  VIALIDAD',
                'id_mae'        => '2'
            ],
            [
                'descripcion'   => 'INTENDENTE MUNICIPAL ',
                'id_mae'        => '2'
            ],
            [
                'descripcion'   => 'GUARDIAS MUNICIPALES ',
                'id_mae'        => '2'
            ],
            [
                'descripcion'   => 'UNIDAD DE COMUNICACIONES ',
                'id_mae'        => '2'
            ],
            [
                'descripcion'   => 'ODECO',
                'id_mae'        => '2'
            ],
        ); 
        foreach ($cargos as $lis) {
            $cargos_guardar                 = new Unidad_mae();
            $cargos_guardar->descripcion    = $lis['descripcion'];
            $cargos_guardar->id_mae         = $lis['id_mae'];
            $cargos_guardar->save();
        }
    }
}
