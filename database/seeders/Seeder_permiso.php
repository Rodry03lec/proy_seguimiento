<?php

namespace Database\Seeders;

use App\Models\Biometrico\Permiso\Desglose_permiso;
use App\Models\Biometrico\Permiso\Tipo_permiso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Seeder_permiso extends Seeder{
    public function run(): void
    {
        //CREAR LA PARTE DE LOS TIPOS DE PERMISOS
        $tipo_permiso = [
            'PERMISOS OFICIALES',
            'PERMISOS PERSONALES',
        ];
        foreach ($tipo_permiso as $lis) {
            $nuevo_tipo_permiso             = new Tipo_permiso();
            $nuevo_tipo_permiso->nombre     = $lis;
            $nuevo_tipo_permiso->estado     = 'activo';
            $nuevo_tipo_permiso->id_usuario = 1;
            $nuevo_tipo_permiso->save();
        }

        //para crear el desglose de los permisos
        $desglose_permiso = [
            [
                'nombre'            => 'Comisión',
                'descripcion'       => 'La Comisión deberá ser dispuesta por el jefe inmediato superior o superior jerárquico para la realización de funciones y/o actividades, en representación del Gobierno Autónomo Municipal, cuando la misma se encuentre dentro de los plazos establecidos por el Reglamento de Permisos Oficiales, Permisos Personales y Becas Estatales,',
                'estado'            => 'activo',
                'id_tipo_permiso'   => 1
            ],
            [
                'nombre'            => 'Permiso oficial por horas',
                'descripcion'       => 'El Permiso Oficial por Horas deberá ser dispuesto por el jefe inmediato superior o superior jerárquico, para la realización de actividades inherentes al carg o u otras que el Gobierno Autónomo Municipal requiera, debiendo en estos casos registrar las salidas e ingresos en el instrumento de control determ inado para el efecto.',
                'estado'            => 'activo',
                'id_tipo_permiso'   => 1
            ],
            [
                'nombre'            => 'Permiso para Beca Estatal',
                'descripcion'       => 'La Becas estatales no son aplicables para las Entidades Territoriales Autónomas.',
                'estado'            => 'inactivo',
                'id_tipo_permiso'   => 1
            ],
            [
                'nombre'            => 'Tolerancia',
                'descripcion'       => 'Las tolerancias otorgadas por el Gobierno Autónomo Municipal, sean individuales, grupales o institucionales, se habilitarán m ediante Formulario de Solicitud o com unicado respectivo, mismo que también deberá definir si la tolerancia es o no susceptible de com pensación laboral.',
                'estado'            => 'activo',
                'id_tipo_permiso'   => 1
            ],

            [
                'nombre'            => 'PERMISO PERSONAL CON GOCE DE HABERES',
                'descripcion'       => 'El Permiso Personal con G o ce de Haberes será solicitado por el beneficiario, mediante el Formulario de Solicitud, por horas laborales fraccio nad as hasta en treinta (30) minutos, por lapsos inferiores a una jornada laboral; siendo facultad del jefe inmediato superior o superior jerárquico otorgar o no este permiso. En el Formulario de Solicitud se especificará los horarios de salida y d e retorno, el nombre de quien usa el permiso y la autoridad que lo ha otorgado. En los casos en que el Permiso consigne horarios de salida o de retorno que coincidan con los horarios de ingreso o salida del Gobierno Autónomo Municipal respectivam ente, éstos deberán ser señalados en el Formulario de Solicitud.',
                'estado'            => 'activo',
                'id_tipo_permiso'   => 2
            ],

            [
                'nombre'            => 'SOLICITUD EXCEPCIONAL DEL PERMISO PERSONAL CON GOCE DE HABERES',
                'descripcion'       => 'I. Cuando la persona que requiera el permiso se vea imposibilitada de solicitarlo personalmente, podrá hacerlo excepcionalm ente m ediante algún familiar o persona alleg ad a, ante el jefe inmediato superior o superior jerárquico m ediante una com unicación escrita.
                II. Cuando el permiso no pueda ser solicitado personalmente por la persona que lo requiera, ni por algún familiar o persona alleg ad a, el mismo podrá ser solicitado ante el jefe inmediato superior o superior jerárquico por cualquier medio de comunicación o al siguiente día hábil por el interesado. En ambos casos, la regularizacíón de la solicitud deberá hacérsela mediante el Formulario de Solicitud.
                III. C uando la autoridad ante quien se hayan tramitado las solicitudes de permiso señaladas en los parágrafos precedentes determíne no otorgarlos, solicitará a la Unidad de Recursos Humanos registrarla com o inasistencia injustificada.',
                'estado'            => 'activo',
                'id_tipo_permiso'   => 2
            ],

            [
                'nombre'            => 'PERMISO PERSONAL SIN GOCE DE HABERES',
                'descripcion'       => 'El personal del Gobierno Autónomo Municipal podrá a cceder a la otorgación de Permiso Personal sin Goce de Haberes, mediante la presentación del Formulario de Solicitud por el interesado ante su jefe inmediato superior para su tramitación. En el Formulario de Solicitud deberá señalarse el plazo solicitado para el permiso especificando las fechas de inicio y finalización, así como la causal, conforme lo establecido por el Artículo 15 del Reglamento de Permisos Oficíales, Permisos Personales y Becas Estatales',
                'estado'            => 'activo',
                'id_tipo_permiso'   => 2
            ],
        ];

        foreach ($desglose_permiso as $lis) {
            $nuevo_desglose_permiso                     = new Desglose_permiso();
            $nuevo_desglose_permiso->nombre             = $lis['nombre'];
            $nuevo_desglose_permiso->descripcion        = $lis['descripcion'];
            $nuevo_desglose_permiso->estado             = $lis['estado'];
            $nuevo_desglose_permiso->id_tipo_permiso    = $lis['id_tipo_permiso'];
            $nuevo_desglose_permiso->id_usuario         = 1;
            $nuevo_desglose_permiso->save();
        }
    }
}
