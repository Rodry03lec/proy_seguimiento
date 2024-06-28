<?php

namespace Database\Seeders;

use App\Models\Configuracion_tramite\Tipo_estado;
use App\Models\Configuracion_tramite\Tipo_prioridad;
use App\Models\Configuracion_tramite\Tipo_tramite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Tramite_seeder_configuracion extends Seeder
{
    public function run(): void
    {
        //para crear el tipo de tramite
        $tipo_tramite = [
            [
                'nombre'=>'TRAMITE INTERNO (TI)',
                'sigla'=>'TI',
            ],
            [
                'nombre'=>'TRAMITE EXTERNO(TE)',
                'sigla'=>'TE',
            ],
            [
                'nombre'=>'MEMORANDUMS',
                'sigla'=>'ME',
            ],
            [
                'nombre'=>'INFORMES',
                'sigla'=>'IN',
            ],
            [
                'nombre'=>'CIRCULAR',
                'sigla'=>'CIR',
            ],
            [
                'nombre'=>'HOJA DE PERMISO',
                'sigla'=>'HP',
            ],
            [
                'nombre'=>'COMUNICACIÓN INTERNA',
                'sigla'=>'CI',
            ],
            [
                'nombre'=>'CERTIFICACION',
                'sigla'=>'CERT',
            ],
            [
                'nombre'=>'COURRIER',
                'sigla'=>'COU',
            ],
            [
                'nombre'=>'FAX',
                'sigla'=>'FAX',
            ],
            [
                'nombre'=>'LEGALIZACIÓN',
                'sigla'=>'LEG',
            ],
            [
                'nombre'=>'DENUNCIA',
                'sigla'=>'DEN',
            ],
            [
                'nombre'=>'INSTRUCTIVO',
                'sigla'=>'INST',
            ],
            [
                'nombre'=>'OTROS TRAMITES',
                'sigla'=>'OT',
            ],
        ];

        foreach ($tipo_tramite as $lis) {
            $nuevo_tipo_tramite         = new Tipo_tramite();
            $nuevo_tipo_tramite->nombre = $lis['nombre'];
            $nuevo_tipo_tramite->sigla  = $lis['sigla'];
            $nuevo_tipo_tramite->estado = true;
            $nuevo_tipo_tramite->save();
        }

        //para el llenado del tipo de prioridad
        $tipos_prioridad = [
            'Alta',
            'Media',
            'Baja',
            'Urgente',
        ];
        foreach ($tipos_prioridad as $lis) {
            $nuevo_tipo_prioridad = new Tipo_prioridad();
            $nuevo_tipo_prioridad->nombre = $lis;
            $nuevo_tipo_prioridad->save();
        }

        //para el llenado de tipo de estado
        $tipos_estado = [
            [
                'nombre'=>'PENDIENTE',
                'color'=>'badge bg-primary bg-glow'
            ],
            [
                'nombre'=>'SIN RECIBIR',
                'color'=>'badge bg-danger bg-glow'
            ],
            [
                'nombre'=>'RECIBIDA',
                'color'=>'badge bg-success bg-glow'
            ],
            [
                'nombre'=>'CONCLUIDA',
                'color'=>'badge bg-warning bg-glow'
            ],
            [
                'nombre'=>'ELIMINADO',
                'color'=>'badge bg-dark bg-glow'
            ],
            [
                'nombre'=>'OBSERVADA',
                'color'=>'badge bg-info bg-glow'
            ],
        ];
        foreach ($tipos_estado as $lis) {
            $nuevo_tipo_estado          = new Tipo_estado();
            $nuevo_tipo_estado->nombre  = $lis['nombre'];
            $nuevo_tipo_estado->color   = $lis['color'];
            $nuevo_tipo_estado->save();
        }
    }
}
