<?php

namespace App\Http\Controllers\Biometrico;

use App\Http\Controllers\Controller;
use App\Models\Biometrico\Biometrico;
use App\Models\Biometrico\Horario_continuo;
use App\Models\Configuracion\Excepcion;
use App\Models\Fechas\Fecha_principal;
use App\Models\Registro\Contrato;
use App\Models\Registro\Persona;
use FontLib\Table\Type\fpgm;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Controlador_biometrico extends Controller
{
    /**
     * @version 1.0
     * @author  Graice Callizaya Chambi <graicecallizaya1234@gmail.com>
     * @param Controlador Administrar la parte de SUBIDA DEL BIOMETRICO AL REGISTRO A LA BASE DE DATOS
     * ¡Muchas gracias por preferirnos! Esperamos poder servirte nuevamente
     */

    /**
     * PARA LA ADMINISTRACION DEL BIOMETRICO
     */
    public function biometrico(){
        $data['menu'] = '15';
        return view('administrador.biometrico.subir_biometrico', $data);
    }

    //para el subido al biometrico
    public function biometrico_subir(Request $request){
        $validar = Validator::make($request->all(), [
            'fecha_inicio'  => 'required|date',
            'fecha_final'   => 'required|date',
            //'archivo'       => 'required|file|regex:/\.dat$/i'
        ]);

        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            $fechaInicio    = strtotime($request->fecha_inicio);
            $fechaFinal     = strtotime($request->fecha_final);



            // Leer el archivo .dat
            $datos = file_get_contents($request->file('archivo')->path());
            $lineas = explode("\n", $datos);
            $arregloPrincipal = [];
            $areglocarnet = [];

            foreach ($lineas as $linea) {
                // Dividir la línea en sus componentes usando el delimitador "\t" (tabulación)
                $campos = explode("\t", $linea);

                // Verificar si hay al menos 3 campos antes de intentar acceder a ellos
                if (count($campos) >= 3) {
                    // Extraer el número de carnet, la fecha y la hora
                    $numeroCarnet = trim($campos[0]);
                    $fechaCompleta = $campos[1];
                    // Separar la fecha y la hora
                    list($fecha, $hora) = explode(' ', $fechaCompleta);

                    // Aquí vamos a validar de qué fecha a qué fecha seleccionamos
                    if (strtotime($fecha) >= $fechaInicio && strtotime($fecha) <= $fechaFinal) {
                        // Agregar el arreglo asociativo al arreglo principal
                        $arregloPrincipal[] = $this->guardar_datos($numeroCarnet, $fecha, $hora);
                        $areglocarnet[] = $numeroCarnet;
                    }
                }
            }

            $array_unique_ci = array_unique($areglocarnet);

            // Recorrer todas las fechas en el rango
            for ($fecha1 = $fechaInicio; $fecha1 <= $fechaFinal; $fecha1 = strtotime('+1 day', $fecha1)) {
                foreach ($array_unique_ci as $ci) {
                    $this->incorporar_fechas(date('Y-m-d', $fecha1), $ci );
                }
            }

            // Filtrar el arreglo para eliminar elementos nulos
            $arregloFiltrado = array_unique(array_filter($arregloPrincipal, function ($valor) {
                return $valor !== null;
            }));



            $data = mensaje_mostrar('success', $arregloFiltrado);
        }
        return response()->json($data);
    }

    //funcion para guardar los registros según número de carnet
    public function guardar_datos($carnet, $fecha, $hora){
        $fecha_principal = Fecha_principal::whereDate('fecha', $fecha)->firstOrFail();
        $persona = Persona::where('ci', $carnet)->first();

        if ($persona) {
            $contrato = Contrato::with(['horario' => function ($h1) {
                $h1->with(['rango_hora'=>function($r1){
                    $r1->with(['excepcion_horario'=>function($eh1){
                        $eh1->with(['dias_semana_excepcion']);
                    }]);
                }]);
            }])
                ->where('id_persona', $persona->id)
                ->where('estado', 'activo')
                ->first();

            if ($contrato) {
                //verificamos si hay un registro creado en la tabla biometrico
                $tabla_biometrico = Biometrico::where('id_fecha', $fecha_principal->id)
                    ->where('id_persona', $persona->id)
                    //->where('id_contrato', $contrato->id)
                    ->first();

                if ($tabla_biometrico) {
                    $biometrico_editar                  = Biometrico::find($tabla_biometrico->id);
                    $biometrico_editar->id_usuario      = Auth::user()->id;
                    $this->actualizarHoras($biometrico_editar, $contrato, $hora, $fecha_principal->id);
                    $biometrico_editar->save();

                    $mensaje = null;
                } else {
                    //CREAMOS UNO NUEVO
                    $biometrico_guardar                 = new Biometrico();
                    $biometrico_guardar->id_fecha       = $fecha_principal->id;
                    $biometrico_guardar->id_persona     = $persona->id;
                    $biometrico_guardar->id_contrato    = $contrato->id;
                    $biometrico_guardar->id_usuario     = Auth::user()->id;
                    $this->actualizarHoras($biometrico_guardar, $contrato, $hora, $fecha_principal->id);
                    $biometrico_guardar->save();
                    $mensaje = null;
                }
            } else {
                $mensaje = $carnet . ' PERSONA SIN CONTRATO O VENCIDO ACTUALIZE ';
            }
        } else {
            $mensaje = $carnet . ' PERSONA NO REGISTRADA';
        }
        return $mensaje;
    }

    private function actualizarHoras($biometrico, $contrato, $hora, $id_fecha_principal){
        // CONSULTAMOS SI EXISTE LA FECHA PRINCIPAL
        $fecha_principal = Fecha_principal::with(['dias_semana'])->find($id_fecha_principal);

        // PRIMERO VAMOS A PREGUNTAR SI TENEMOS UNA EXCEPCIÓN DE HORARIO PARA EL PRIMER RANGO DE HORAS 1 OJO
        $excepcion_horario_primero = Excepcion::with(['dias_semana_excepcion'])
                                        ->where('id_rango_hora', $contrato->horario->rango_hora[0]->id)
                                        ->where('estado', 'activo')
                                        ->first();

        // Obtener el rango de hora de ingreso de la mañana por defecto
        $hora_inicio_default1       = $contrato->horario->rango_hora[0]->hora_inicio;
        $hora_final_default1        = $contrato->horario->rango_hora[0]->hora_final;
        $hora_final_default_new1    = date("H:i:s", strtotime($hora_final_default1) + 30 * 60);

        // Inicializar las variables de hora con los valores por defecto
        $hora_inicio1       = $hora_inicio_default1;
        $hora_final1        = $hora_final_default1;
        $hora_final_new1    = $hora_final_default_new1;

        // Verificar si existe una excepción de horario
        if ($excepcion_horario_primero) {
            // Verificar si la fecha principal está dentro del rango de la excepción
            if ($fecha_principal->fecha >= $excepcion_horario_primero->fecha_inicio && $fecha_principal->fecha <= $excepcion_horario_primero->fecha_final) {
                // Convertir la colección a un array
                $dias_semana_excepcion1 = $excepcion_horario_primero->dias_semana_excepcion->toArray();

                // Verificar si el día de la semana coincide con la excepción
                $dia_semana_excepcion1 = array_filter($dias_semana_excepcion1, function($excepcion) use ($fecha_principal) {
                    return $excepcion['id'] == $fecha_principal->dias_semana->id;
                });

                // Si coincide, utilizar el horario de excepción
                if (!empty($dia_semana_excepcion1)) {
                    $hora_inicio1 = $contrato->horario->rango_hora[0]->hora_inicio;
                    $hora_final1 = $excepcion_horario_primero->hora;
                    $hora_final_new1 = date("H:i:s", strtotime($hora_final1) + 30 * 60);
                }
            }
        }

        // Verificar si la hora actual está dentro del rango de ingreso de la mañana
        if ($hora >= $hora_inicio1 && $hora <= $hora_final_new1) {
            $biometrico->hora_ingreso_ma = $hora;
        }

        //AQUI AUMENTAREMOS SI HAY HORARIOS CONTINUOS PROGRAMADOS O NO SEGUN FECHA
        $horario_continuo = Horario_continuo::where('estado', 'activo')->get();
        $array_hor_continuo = [];
        //aqui extraemos que horarios continuos estan activos segun fecha seleccionada
        foreach ($horario_continuo as $horcon) {
            if($fecha_principal->fecha >= $horcon->fecha_inicio && $fecha_principal->fecha <= $horcon->fecha_final){
                $array_hor_continuo[] = [
                    'fecha_inicio_hc'   => $horcon->fecha_inicio,
                    'fecha_final_hc'    => $horcon->fecha_final,
                    'hora_salida_hc'    => $horcon->hora_salida,
                ];
            }
        }

        //dd($array_hor_continuo[0]['fecha_inicio_hc']);

        //ahora preguntamos si hay un horario continuo activo y que este en la fecha seleccionada
        if(!empty($array_hor_continuo)){
            //entra si existe
            //capturamos los datos
            //$fecha_ini_hc   = $array_hor_continuo[0]['fecha_inicio_hc'];
            //$fecha_fin_hc   = $array_hor_continuo[0]['fecha_final_hc'];
            $hora_sal_hc    = $array_hor_continuo[0]['hora_salida_hc'];

            $biometrico->hora_salida_ma  = '00:00:00';
            $biometrico->hora_entrada_ta = '00:00:00';

            $hora_inicio_horario_continuo = $hora_sal_hc;
            if ($hora >= $hora_inicio_horario_continuo && $hora <= '23:59:59') {
                $biometrico->hora_salida_ta = $hora;
            }


            /*  // PRIMERO VAMOS A PREGUNTAR SI TENEMOS UNA EXCEPCIÓN DE HORARIO PARA EL CUARTO RANGO DE HORAS 4 OJO
            $excepcion_horario_cuarto = Excepcion::with(['dias_semana_excepcion'])
                                    ->where('id_rango_hora', $contrato->horario->rango_hora[3]->id)
                                    ->where('estado', 'activo')
                                    ->first();
            // Obtener el rango de hora de ingreso de la mañana por defecto
            $hora_inicio_default4       = $contrato->horario->rango_hora[3]->hora_inicio;
            $hora_final_default4        = $contrato->horario->rango_hora[3]->hora_final;

            // Inicializar las variables de hora con los valores por defecto
            $hora_inicio4       = $hora_inicio_default4;
            $hora_final4        = $hora_final_default4;

            // Verificar si existe una excepción de horario
            if ($excepcion_horario_cuarto) {
                // Verificar si la fecha principal está dentro del rango de la excepción
                if ($fecha_principal->fecha >= $excepcion_horario_cuarto->fecha_inicio && $fecha_principal->fecha <= $excepcion_horario_cuarto->fecha_final) {
                    // Convertir la colección a un array
                    $dias_semana_excepcion4 = $excepcion_horario_cuarto->dias_semana_excepcion->toArray();
                    // Verificar si el día de la semana coincide con la excepción
                    $dia_semana_excepcion4 = array_filter($dias_semana_excepcion4, function($excepcion) use ($fecha_principal) {
                        return $excepcion['id'] == $fecha_principal->dias_semana->id;
                    });

                    // Si coincide, utilizar el horario de excepción
                    if (!empty($dia_semana_excepcion4)) {
                        $hora_inicio4       = $contrato->horario->rango_hora[3]->hora_inicio;
                        $hora_final4        = $excepcion_horario_cuarto->hora;
                    }
                }
            }

            // Verificar si la hora actual está dentro del rango de salida de la tarde
            if ($hora >= $hora_inicio4 && $hora <= $hora_final4) {
                $biometrico->hora_salida_ta = $hora;
            } */

        }else{
            //no existe la fecha creada del horario continuo
            // PRIMERO VAMOS A PREGUNTAR SI TENEMOS UNA EXCEPCIÓN DE HORARIO PARA EL SEGUNDO RANGO DE HORAS 2 OJO
            $excepcion_horario_segundo = Excepcion::with(['dias_semana_excepcion'])
                                            ->where('id_rango_hora', $contrato->horario->rango_hora[1]->id)
                                            ->where('estado', 'activo')
                                            ->first();
            // Obtener el rango de hora de ingreso de la mañana por defecto
            $hora_inicio_default2       = $contrato->horario->rango_hora[1]->hora_inicio;
            $hora_final_default2        = $contrato->horario->rango_hora[1]->hora_final;

            // Inicializar las variables de hora con los valores por defecto
            $hora_inicio2       = $hora_inicio_default2;
            $hora_final2        = $hora_final_default2;
            $hora_final_new2    = $hora_final_default2;
            // Verificar si existe una excepción de horario
            if ($excepcion_horario_segundo) {
                // Verificar si la fecha principal está dentro del rango de la excepción creada
                if ($fecha_principal->fecha >= $excepcion_horario_segundo->fecha_inicio && $fecha_principal->fecha <= $excepcion_horario_segundo->fecha_final) {
                    // Convertir la colección a un array
                    $dias_semana_excepcion2 = $excepcion_horario_segundo->dias_semana_excepcion->toArray();
                    // Verificar si el día de la semana coincide con la excepción
                    $dia_semana_excepcion = array_filter($dias_semana_excepcion2, function($excepcion) use ($fecha_principal) {
                        return $excepcion['id'] == $fecha_principal->dias_semana->id;
                    });

                    // Si coincide, utilizar el horario de excepción
                    if (!empty($dia_semana_excepcion)) {
                        $hora_inicio2       = $excepcion_horario_segundo->hora;
                        $hora_final2        = $contrato->horario->rango_hora[1]->hora_final;
                        $hora_final_new2    = date("H:i:s", strtotime($hora_final2) + 30 * 60);
                    }
                }
            }

            // Verificar si la hora actual está dentro del rango de ingreso de la mañana
            if ($hora >= $hora_inicio2 && $hora <= $hora_final_new2) {
                $biometrico->hora_salida_ma = $hora;
            }




            // PRIMERO VAMOS A PREGUNTAR SI TENEMOS UNA EXCEPCIÓN DE HORARIO PARA EL TERCERO RANGO DE HORAS 3 OJO
            $excepcion_horario_tercero = Excepcion::with(['dias_semana_excepcion'])
                    ->where('id_rango_hora', $contrato->horario->rango_hora[2]->id)
                    ->where('estado', 'activo')
                    ->first();
            // Obtener el rango de hora de ingreso de la mañana por defecto
            $hora_inicio_default3       = $contrato->horario->rango_hora[2]->hora_inicio;
            $hora_final_default3        = $contrato->horario->rango_hora[2]->hora_final;
            $hora_final_default_new3    = date("H:i:s", strtotime($hora_final_default3) + 30 * 60);

            // Inicializar las variables de hora con los valores por defecto
            $hora_inicio3       = $hora_inicio_default3;
            $hora_final3        = $hora_final_default3;
            $hora_final_new3    = $hora_final_default_new3;

            // Verificar si existe una excepción de horario
            if ($excepcion_horario_tercero) {
                // Verificar si la fecha principal está dentro del rango de la excepción
                if ($fecha_principal->fecha >= $excepcion_horario_tercero->fecha_inicio && $fecha_principal->fecha <= $excepcion_horario_tercero->fecha_final) {
                    // Convertir la colección a un array
                    $dias_semana_excepcion3 = $excepcion_horario_tercero->dias_semana_excepcion->toArray();

                    // Verificar si el día de la semana coincide con la excepción
                    $dia_semana_excepcion3 = array_filter($dias_semana_excepcion3, function($excepcion) use ($fecha_principal) {
                        return $excepcion['id'] == $fecha_principal->dias_semana->id;
                    });

                    // Si coincide, utilizar el horario de excepción
                    if (!empty($dia_semana_excepcion3)) {
                        $hora_inicio3       = $contrato->horario->rango_hora[2]->hora_inicio;
                        $hora_final3        = $excepcion_horario_tercero->hora;
                        $hora_final_new3    = date("H:i:s", strtotime($hora_final3) + 30 * 60);
                    }
                }
            }

            // Verificar si la hora actual está dentro del rango de salida de la mañana
            if ($hora >= $hora_inicio3 && $hora <= $hora_final_new3) {
                $biometrico->hora_entrada_ta = $hora;
            }



            // PRIMERO VAMOS A PREGUNTAR SI TENEMOS UNA EXCEPCIÓN DE HORARIO PARA EL CUARTO RANGO DE HORAS 4 OJO
            $excepcion_horario_cuarto = Excepcion::with(['dias_semana_excepcion'])
                    ->where('id_rango_hora', $contrato->horario->rango_hora[3]->id)
                    ->where('estado', 'activo')
                    ->first();
            // Obtener el rango de hora de ingreso de la mañana por defecto
            $hora_inicio_default4       = $contrato->horario->rango_hora[3]->hora_inicio;
            $hora_final_default4        = $contrato->horario->rango_hora[3]->hora_final;

            // Inicializar las variables de hora con los valores por defecto
            $hora_inicio4       = $hora_inicio_default4;
            $hora_final4        = $hora_final_default4;
            $hora_final_new4	= $hora_final_default4;
            // Verificar si existe una excepción de horario
            if ($excepcion_horario_cuarto) {
                // Verificar si la fecha principal está dentro del rango de la excepción
                if ($fecha_principal->fecha >= $excepcion_horario_cuarto->fecha_inicio && $fecha_principal->fecha <= $excepcion_horario_cuarto->fecha_final) {
                    // Convertir la colección a un array
                    $dias_semana_excepcion4 = $excepcion_horario_cuarto->dias_semana_excepcion->toArray();
                    // Verificar si el día de la semana coincide con la excepción
                    $dia_semana_excepcion4 = array_filter($dias_semana_excepcion4, function($excepcion) use ($fecha_principal) {
                        return $excepcion['id'] == $fecha_principal->dias_semana->id;
                    });

                    // Si coincide, utilizar el horario de excepción
                    if (!empty($dia_semana_excepcion4)) {
                        $hora_inicio4       = $excepcion_horario_cuarto->hora;
                        $hora_final4        = $contrato->horario->rango_hora[3]->hora_final;
                        $hora_final_new4    = date("H:i:s", strtotime($hora_final4) + 30 * 60);
                    }
                }
            }

            // Verificar si la hora actual está dentro del rango de salida de la tarde
            if ($hora >= $hora_inicio4 && $hora <= $hora_final_new4) {
                $biometrico->hora_salida_ta = $hora;
            }
        }

    }

    // Función para incorporar fechas faltantes
    private function incorporar_fechas($fecha, $ci) {
        // Buscar la fecha principal
        $fecha_principal = Fecha_principal::whereDate('fecha', $fecha)->first();

        // Buscar la persona por su CI
        $persona = Persona::where('ci', $ci)->first();

        if($persona){
            $contrato = Contrato::with(['horario' => function ($h1) {
                $h1->with(['rango_hora'=>function($r1){
                    $r1->with(['excepcion_horario'=>function($eh1){
                        $eh1->with(['dias_semana_excepcion']);
                    }]);
                }]);
            }])
                ->where('id_persona', $persona->id)
                ->where('estado', 'activo')
                ->first();

            if ($contrato) {
                //verificamos si hay un registro creado en la tabla biometrico
                $tabla_biometrico = Biometrico::where('id_fecha', $fecha_principal->id)
                    ->where('id_persona', $persona->id)
                    //->where('id_contrato', $contrato->id)
                    ->first();
                    if ($tabla_biometrico) {

                    } else {
                        //CREAMOS UNO NUEVO
                        $biometrico_guardar                 = new Biometrico();
                        $biometrico_guardar->id_fecha       = $fecha_principal->id;
                        $biometrico_guardar->id_persona     = $persona->id;
                        $biometrico_guardar->id_contrato    = $contrato->id;
                        $biometrico_guardar->id_usuario     = Auth::user()->id;
                        $biometrico_guardar->save();
                    }
            }else{
                //echo "Persona no existe  =====> ".$ci. "\n";
                return null;
            }
        }else{
            //echo "Sin contrato  =====> ".$ci. "\n";return null;
            return null;
        }
    }
    /**
     * FIN PARA LA ADMINISTRACION DEL BIOMETRICO
     */


    /**
      * PARA LA ADMINISTRACION DE ESPECIAL
    */
    public function especial(){
        $data['menu'] = '16';
        $data['biometrico']=Biometrico::get();
        return view('administrador.biometrico.especial', $data);
    }
    /**
     * FIN PARA LA ADMINISTRACION DE ESPECIAL
     */
}
