<?php

namespace App\Http\Controllers\Biometrico;

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

class Controlador_asistencias extends Controller
{
    /**
     * @version 1.0
     * @author  Graice Callizaya Chambi <graicecallizaya1234@gmail.com>
     * @param Controlador Administrar la parte de VER O MODIFICAR LAS ASISTENCIAS OJO SOLO PARA PERSONAL AUTORIZADO
     * ¡Muchas gracias por preferirnos! Esperamos poder servirte nuevamente
     */

    //PARA LA PARTE DE LA ADMINISTRACION DE LAS ASISTENCIAS
    public function asistencia()
    {
        $data['menu'] = '17';
        $data['listar_dias'] = Dias_semana::OrderBy('id', 'asc')->get();
        return view('administrador.biometrico.asistencia.listar_asistencia', $data);
    }


    public function generar_asistencia(Request $request)
    {
        // Define las reglas de validación
        $rules = [
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
                ->where(function ($query) use ($request) {
                    $query->whereBetween('fecha_inicio', [$request->fecha_inicial, $request->fecha_final])
                        ->orWhereBetween('fecha_final', [$request->fecha_inicial, $request->fecha_final]);
                })
                ->where('constancia', true)
                ->get(['id', 'fecha_inicio', 'fecha_final', 'hora_inicio', 'hora_final', 'descripcion']);

            $licencia_listar = Licencia::where('id_persona', $persona->id)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('fecha_inicio', [$request->fecha_inicial, $request->fecha_final])
                        ->orWhereBetween('fecha_final', [$request->fecha_inicial, $request->fecha_final]);
                })
                ->where('constancia', true)
                ->get(['id', 'fecha_inicio', 'fecha_final', 'hora_inicio', 'hora_final', 'descripcion']);

            $biometricos_lis = [];

            foreach ($fecha_principal_listar as $lis) {
                if (in_array($lis->id_dia_sem, $request->dias)) {
                    $biometrico = Biometrico::with(['usuario', 'usuario_edit', 'fecha_principal' => function ($fp1) {
                        $fp1->with(['dias_semana', 'feriado']);
                    }, 'contrato' => function ($c1) {
                        $c1->with(['horario' => function ($h1) {
                            $h1->with(['rango_hora' => function ($rh1) {
                                $rh1->with(['excepcion_horario' => function ($exh1) {
                                    $exh1->with(['dias_semana_excepcion']);
                                }, 'horarios']);
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

            $data['persona'] = Persona::with(['contrato' => function ($co) {
                $co->with(['profesion', 'grado_academico', 'cargo_sm' => function ($cs) {
                    $cs->with(['unidades_admnistrativas', 'direccion' => function ($dir) {
                        $dir->with(['secretaria_municipal']);
                    }]);
                }, 'cargo_mae' => function ($cm) {
                    $cm->with(['unidad_mae']);
                }]);
                $co->where('estado', 'activo');
            }])->find($persona->id);

            return view('administrador.biometrico.asistencia.vista_asistencia', $data);
        }
    }







    //para editar la parte de las asistenciass
    public function editar_asistencia(Request $request)
    {
        try {
            $biometrico = Biometrico::find($request->id);
            if ($biometrico) {
                $data = mensaje_mostrar('success', $biometrico);
            } else {
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar los datos');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al editar los datos');
        }
        return response()->json($data);
    }

    //para guardar lo editado de la asistencia
    public function guardar_asist_editado(Request $request)
    {
        try {
            $biometrico_asistencia                      = Biometrico::find($request->id_biometrico);
            $biometrico_asistencia->hora_ingreso_ma     = $request->entrada_maniana;
            $biometrico_asistencia->hora_salida_ma      = $request->salida_maniana;
            $biometrico_asistencia->hora_entrada_ta     = $request->entrada_tarde;
            $biometrico_asistencia->hora_salida_ta      = $request->salida_tarde;
            $biometrico_asistencia->id_user_up          = Auth::user()->id;
            $biometrico_asistencia->save();
            if ($biometrico_asistencia->id) {
                $data = mensaje_mostrar('success', 'Se guardo con exito el registro');
            } else {
                $data = mensaje_mostrar('error', 'Ocurrio un error al insertar los datos');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al insertar los datos');
        }
        return response()->json($data);
    }
}
