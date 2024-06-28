<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Configuracion\Horario;
use App\Models\Configuracion\Rango_hora;

class Seeder_horarios extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //para llenar los horarios
        $horario = array(
            [
                'nombre'        => 'NORMAL',
                'descripcion'   => 'HORA DE ENTRADA 08:00 SALIDA DE MAÑANA 12:00; ENTRADA TARDE 14:30  Y SALIDA TARDE 18:30'
            ],
            [
                'nombre'        => 'ESPECIAL CIRECA',
                'descripcion'   => 'HORA DE ENTRADA 08:00 SALIDA DE MAÑANA 12:00; ENTRADA TARDE 14:00  Y SALIDA TARDE 18:00'
            ],/* 
            [
                'nombre'        => 'ESPECIAL HOSPITAL',
                'descripcion'   => 'HORAS ESPECIALES'
            ], */
        );
        foreach ($horario as $lis) {
            $horario_save               = new Horario();
            $horario_save->nombre       = $lis['nombre'];
            $horario_save->descripcion  = $lis['descripcion'];
            $horario_save->id_usuario   = 1;
            $horario_save->save();
        }

        //para llenar los rangos de hora
        $rango_horarios = array(
            [
                'nombre'        => 'ENTRADA MAÑANA',
                'numero'        => '1',
                'hora_inicio'   => '04:00',
                'hora_final'    => '08:00',
                'tolerancia'    => '00:05',
                'id_horario'    => 1,
            ],
            [
                'nombre'        => 'SALIDA MAÑANA',
                'numero'        => '2',
                'hora_inicio'   => '12:00',
                'hora_final'    => '13:15',
                'tolerancia'    => '00:00',
                'id_horario'    => 1,
            ],
            [
                'nombre'        => 'ENTRADA TARDE',
                'numero'        => '3',
                'hora_inicio'   => '13:45',
                'hora_final'    => '14:30',
                'tolerancia'    => '00:05',
                'id_horario'    => 1,
            ],
            [
                'nombre'        => 'SALIDA TARDE',
                'numero'        => '4',
                'hora_inicio'   => '18:30',
                'hora_final'    => '23:59',
                'tolerancia'    => '00:00',
                'id_horario'    => 1,
            ],
            [
                'nombre'        => 'ENTRADA MAÑANA',
                'numero'        => '1',
                'hora_inicio'   => '04:00',
                'hora_final'    => '08:00',
                'tolerancia'    => '00:05',
                'id_horario'    => 2,
            ],
            [
                'nombre'        => 'SALIDA MAÑANA',
                'numero'        => '2',
                'hora_inicio'   => '12:00',
                'hora_final'    => '13:20',
                'tolerancia'    => '00:00',
                'id_horario'    => 2,
            ],
            [
                'nombre'        => 'ENTRADA TARDE',
                'numero'        => '3',
                'hora_inicio'   => '13:30',
                'hora_final'    => '14:00',
                'tolerancia'    => '00:05',
                'id_horario'    => 2,
            ],
            [
                'nombre'        => 'SALIDA TARDE',
                'numero'        => '4',
                'hora_inicio'   => '18:00',
                'hora_final'    => '23:59',
                'tolerancia'    => '00:00',
                'id_horario'    => 2,
            ]
        );
        foreach ($rango_horarios as $lis) {
            $rango_horarios_save                = new Rango_hora();
            $rango_horarios_save->nombre        = $lis['nombre'];
            $rango_horarios_save->numero        = $lis['numero'];
            $rango_horarios_save->hora_inicio   = $lis['hora_inicio'];
            $rango_horarios_save->hora_final    = $lis['hora_final'];
            $rango_horarios_save->tolerancia    = $lis['tolerancia'];
            $rango_horarios_save->id_horario    = $lis['id_horario'];
            $rango_horarios_save->id_usuario    = 1;
            $rango_horarios_save->save();
        }
    }
}
