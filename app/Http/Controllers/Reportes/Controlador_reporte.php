<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Models\Biometrico\Biometrico;
use App\Models\Biometrico\Licencia\Licencia;
use App\Models\Biometrico\Permiso\Permiso;
use App\Models\Fechas\Dias_semana;
use App\Models\Fechas\Fecha_principal;
use App\Models\Registro\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;



use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use Dompdf\Options;
use Barryvdh\DomPDF\Facade\Pdf;

class Controlador_reporte extends Controller
{

    //para la vista de la asistencia
    public function  vista_asistencia() {
        $data['listar_dias'] = Dias_semana::get();
        return view('asistencia.vista_asistencia', $data);
    }

    public function asitencia_reporte(Request $request){

        $requ_dias = ['1','2','3','4','5'];
        // Define las reglas de validación
        $rules = [
            'ci'            => 'required',
            'fecha_inicial' => 'required|date',
            'fecha_final'   => 'required|date',
        ];

        // Crea un validador con los datos y reglas
        $validator = Validator::make($request->all(), $rules);

        // Verifica si la validación falla
        if ($validator->fails()) {
            // Redirige de vuelta con los errores y los datos antiguos
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        } else {
            $data['menu'] = '17';
            $data['ci_persona'] = $request->ci;
            $data['fecha_inicio'] = $request->fecha_inicial;
            $data['fecha_final'] = $request->fecha_final;
            $data['dias'] = $request->dias;

            // Identificamos la persona por CI
            $persona = Persona::where('ci', $request->ci)->first();

            // Verificar si la persona existe
            if (!$persona) {
                return redirect()->back()->withErrors(['ci' => 'Persona no encontrada'])->withInput();
            }

            // Identificamos las fechas inicial y final en la tabla principal
            $fecha_inicial_emp = Fecha_principal::where('fecha', $request->fecha_inicial)->first();
            $fecha_final_emp = Fecha_principal::where('fecha', $request->fecha_final)->first();

            //vamos a enviar para ver los datos
            $data['fecha_inicial']  = $fecha_inicial_emp;
            $data['fecha_final']    = $fecha_final_emp;


            // Listamos las fechas dentro del rango
            $fecha_principal_listar = Fecha_principal::with(['dias_semana'])
                ->where('id', '>=', $fecha_inicial_emp->id)
                ->where('id', '<=', $fecha_final_emp->id)
                ->get();

            // Consulta los permisos y licencias de la persona
            $permiso_listar = Permiso::where('id_persona', $persona->id)
                ->where(function($query) use ($request) {
                    $query->whereBetween('fecha_inicio', [$request->fecha_inicial, $request->fecha_final])
                        ->orWhereBetween('fecha_final', [$request->fecha_inicial, $request->fecha_final]);
                })
                ->where('constancia', true)
                ->get(['id', 'fecha_inicio', 'fecha_final', 'hora_inicio', 'hora_final', 'descripcion']);

            $licencia_listar = Licencia::where('id_persona', $persona->id)
                ->where(function($query) use ($request) {
                    $query->whereBetween('fecha_inicio', [$request->fecha_inicial, $request->fecha_final])
                        ->orWhereBetween('fecha_final', [$request->fecha_inicial, $request->fecha_final]);
                })
                ->where('constancia', true)
                ->get(['id', 'fecha_inicio', 'fecha_final', 'hora_inicio', 'hora_final', 'descripcion']);

            $biometricos_lis = [];

            foreach ($fecha_principal_listar as $lis) {
                if (in_array($lis->id_dia_sem, $requ_dias)) {
                    $biometrico = Biometrico::with(['usuario', 'usuario_edit', 'fecha_principal'=>function($fp1){
                        $fp1->with(['dias_semana', 'feriado']);
                    },'contrato'=>function($c1){
                        $c1->with(['horario'=>function($h1){
                            $h1->with(['rango_hora'=>function($rh1){
                                $rh1->with(['excepcion_horario'=>function($exh1){
                                    $exh1->with(['dias_semana_excepcion']);
                                },'horarios']);
                            }]);
                        }]);
                    }])->where('id_persona', $persona->id)
                        ->where('id_fecha', $lis->id)
                        ->get();

                    $biometricos_lis[] = $biometrico;
                }
            }

            // Añadir permisos y licencias a los datos
            $data['permisos_lis'] = $permiso_listar;
            $data['licencia_lis'] = $licencia_listar;

            $data['listar_biometrico'] = $biometricos_lis;

            $data['persona'] = Persona::with(['contrato'=>function($co){
                $co->with(['profesion', 'grado_academico', 'cargo_sm'=>function($cs){
                    $cs->with(['unidades_admnistrativas', 'direccion'=>function($dir){
                        $dir->with(['secretaria_municipal']);
                    }]);
                }, 'cargo_mae'=>function($cm){
                    $cm->with(['unidad_mae']);
                }]);
                $co->where('estado', 'activo');
            }])->find($persona->id);



            // Crear el objeto Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isFontSubsettingEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('tempDir', '/path/to/temp');
        $options->set('chroot', '/path/to/chroot');
        $options->set('logOutputFile', '/path/to/logfile');
        $options->set('defaultPaperSize', 'letter');
        $options->set('defaultPaperOrientation', 'portrait');
        $dompdf = new Dompdf($options);


        // Crear el contexto HTTP para Dompdf
        $context = stream_context_create([
            'ssl' => [
                'allow_self_signed' => true,
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]);

        // Agregar el contexto HTTP
        $dompdf->setHttpContext($context);

        // Renderizar la vista como HTML
        $html = view('asistencia.reporte_asistencia', $data)->render();

        // Cargar el HTML en Dompdf y renderizar el PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'portrait');

        // Registrar el evento para agregar el número de página
        $dompdf->setCallbacks([
            'pageNumber' => function() use ($dompdf) {
                return $dompdf->getCanvas()->get_page_number();
            },
            'totalPages' => function() use ($dompdf) {
                return $dompdf->getCanvas()->get_page_count();
            },
        ]);

        // Renderizar el PDF
        $dompdf->render();

        // Obtener el contenido del PDF como una cadena
        $pdfContent = $dompdf->output();

        $persona_detalle = $persona->ci.'-'.$persona->nombres.'-'.$persona->ap_paterno.'-'.$persona->ap_materno;
        $nombre_archivo = 'reporte_asistencia-' . $persona_detalle . '.pdf';

        // Retornar el PDF como una respuesta HTTP con el encabezado adecuado para mostrar en el navegador
        return response($pdfContent)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="'.$nombre_archivo.'"');
        }
    }
}
