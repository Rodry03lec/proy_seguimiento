<?php

namespace Database\Seeders;

use App\Models\Biometrico\Licencia\Tipo_licencia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Seeder_licencias extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //ahora vamos a guardar los tipos de licencias que existen
        $tipo_licencia = [
            [
                'numero'            => '1',
                'normativa'         => 'D.S. Nro. 1212 de 01/05/2015',
                'motivo'            => 'PETERNIDAD',
                'jornada_laboral'   => '3 DIAS LABORABLES A PARTIR DEL NACIMIENTOS',
                'requisitos'        => 'Presentar después Certificado que acredite el Nacimiento',
                'plazos'            => 'Presentar cuando vuelva al trabajo',
                'observaciones'     => 'Casado o no, corresponde el beneficio',
            ],
            [
                'numero'            => '2',
                'normativa'         => 'Ley Nro. 798 de 25/04/16 y D.S. 3164 del 03/05/17',
                'motivo'            => 'EXAMEN FISICO DE MAMA Y PAPANICOLAU',
                'jornada_laboral'   => '1 dia laboral para Papanicolau y 1 dia laboral para mamografia. Coordinar el día',
                'requisitos'        => 'Presentar después el examen medico',
                'plazos'            => '2 días hábiles antes presentar una carta a la MAE con V°B°" del inmediato superior.',
                'observaciones'     => 'El examen puede ser en la caja de salud o en clínica privada. Debe coordinar fecha con Empleador',
            ],
            [
                'numero'            => '3',
                'normativa'         => 'Ley Nro. 798 de 25/04/16 y D.S. 3164 del 03/05/17',
                'motivo'            => 'EXAMEN FISICO DE PROSTATA HOMBRES MAYORES DE 40 AÑOS',
                'jornada_laboral'   => '1 día laboral para el examen de prostata y 1/2 dia laboral si necesita examen de laboratorio',
                'requisitos'        => 'Presentar después el examen',
                'plazos'            => '2 días hábiles antes presentar una carta a la MAE con V°B° del inmediato superior.',
                'observaciones'     => 'El examen puede seres la caja de salud o en clínica privada. Debe coordina fecha con Empleador',
            ],
            [
                'numero'            => '4',
                'normativa'         => 'Ley Nro. 798 de 25/04/16 y D.S. 3164 de 03/05/17',
                'motivo'            => 'CONSULTA MEDICA ANAMNESIS 1" EXAMEN FISICO DE COLON, HOMBRES Y MUJERES MAYORES DE 40 AÑOS',
                'jornada_laboral'   => '1/2 día Laboral para consulta médica anamnesis y examen físico de colon y más 1/2 día laboral, si necesita exámenes complementarios',
                'requisitos'        => 'Presentar después el examen',
                'plazos'            => '2 días hábiles antes presentar una carta a la 1VLNE con V°B° del inmediato superior.',
                'observaciones'     => 'El examen puede ser en la caja de salud o en clínica privada. Debe coordinar fecha con Empleador',
            ],
            [
                'numero'            => '5',
                'normativa'         => 'D.S. 3462 del 18/04/18',
                'motivo'            => 'ACCIDENTE GRAVE Y CONDICIONES O ESTADO CRITICO DE SALUD DE HIJOS MENORES DE EDAD YADOLESCENTES ',
                'jornada_laboral'   => 'variable de hasta 30 días laborables de acuerdo a la condición critica, pueden ser continuos o discontinuos',
                'requisitos'        => 'Respaldos que acrediten condición',
                'plazos'            => 'Presentar día después de exámenes',
                'observaciones'     => 'Exámenes puede serde cualquier institución de salud. no solo para Padres, sino también para Tutores',
            ],
            [
                'numero'            => '6',
                'normativa'         => 'D.S. 4708 de 01/05/22, ley 2027 de27/10/1999',
                'motivo'            => 'FALLECIMIENTO DE PADRES, CONYUGE, ESPOS@ HERNIANOS E HIJOS',
                'jornada_laboral'   => '3 días laborables',
                'requisitos'        => 'Presentar el certificado de Defunción',
                'plazos'            => 'Presentar certificado de defunción después del suceso',
                'observaciones'     => 'Debe llamar al Empleador para comunicar el suceso',
            ],
            [
                'numero'            => '7',
                'normativa'         => 'D.S. 4708 de 01/05/22 ley 2027 de 27/10/1999',
                'motivo'            => 'MATRIMONIO',
                'jornada_laboral'   => '3 días laborables',
                'requisitos'        => 'Presentar certificado de inscripción y después Certificado de Matrimonio',
                'plazos'            => '3 días hábiles antes presentar una carta a la MAE con V°B° del inmediato superior.',
                'observaciones'     => 'corresponde cuantas veces llegue a casarse',
            ],
            [
                'numero'            => '8',
                'normativa'         => 'U.S. 4708 de 01/05/22 ley 2027 de 27/10/1999',
                'motivo'            => 'CUMPLEAÑOS',
                'jornada_laboral'   => '1/2 jornada Laboral solo para los que trabajan el día Completo de 8 Horas',
                'requisitos'        => 'Cedula de identidad',
                'plazos'            => '2 días hábiles antes presentar una carta a la MAE con V°B° del inmediato superior.',
                'observaciones'     => 'Coordinar con Empleador su beneficio',
            ],
            [
                'numero'            => '9',
                'normativa'         => 'D.S. 4927 de 01/05/23',
                'motivo'            => 'DIA DEL PADRE 0 MADRE',
                'jornada_laboral'   => '1/2 jornada Laboral de asueto',
                'requisitos'        => 'Documento idóneo que demuestre que son Padres',
                'plazos'            => '2 días hábiles antes presentar una carta a la MAE con V°B° del inmediato superior.',
                'observaciones'     => 'Entregar al Empleador documento que certifique que son Padres',
            ],
            [
                'numero'            => '10',
                'normativa'         => 'D.S. 4926 de 01/05/23',
                'motivo'            => 'LICENCIA ESPECIAL POR CAPACITACIÓN Y FORMACIÓN PROFESIONAL SIN DESCUENTOS',
                'jornada_laboral'   => '2 horas diarias de su jornada laboral',
                'requisitos'        => 'Licencia Especial por Capacitación y Formación Profesional a favor de los trabajadores que acrediten ser estudiantes en Universidades,',
                'plazos'            => 'instituciones de Educación Superior de Formación Profesional, Institutos Técnicos y Tecnológicos e Instituciones de Educación Alternativa',
                'observaciones'     => 'dicho beneficio deberá ser compensado en la misma jornada laboral, con igual cantidad de horas de trabajo a las recibidas como licencia',
            ],
        ];

        //para insertar los datos de los tipos de licencia
        foreach ($tipo_licencia as $lis) {
            $nuevo_tipo_licencia                    = new Tipo_licencia();
            $nuevo_tipo_licencia->numero            = $lis['numero'];
            $nuevo_tipo_licencia->normativa         = $lis['normativa'];
            $nuevo_tipo_licencia->motivo            = $lis['motivo'];
            $nuevo_tipo_licencia->jornada_laboral   = $lis['jornada_laboral'];
            $nuevo_tipo_licencia->requisitos        = $lis['requisitos'];
            $nuevo_tipo_licencia->plazos            = $lis['plazos'];
            $nuevo_tipo_licencia->observaciones     = $lis['observaciones'];
            $nuevo_tipo_licencia->estado            = 'activo';
            $nuevo_tipo_licencia->id_usuario        = 1;
            $nuevo_tipo_licencia->save();
        }

    }
}
