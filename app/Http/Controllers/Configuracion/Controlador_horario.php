<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use App\Models\Configuracion\Excepcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Configuracion\Horario;
use App\Models\Configuracion\Rango_hora;
use App\Models\Fechas\Dias_semana;
use App\Models\Fechas\Fecha_principal;

class Controlador_horario extends Controller
{
    /**
     * @version 1.0
     * @author  Graice Callizaya Chambi <graicecallizaya1234@gmail.com>
     * @param Controlador Administrar la parte los horarios y los rangos
     * ¡Muchas gracias por preferirnos! Esperamos poder servirte nuevamente
     */


    /** PARA LA PARTE DE LA ADMINSTRACION DE LOS HORARIOS
     */

    //para abrir el ambito profesional
    public function horarios(){
        $data['menu'] = '11';
        return view('administrador.configuracion.horarios.horarios', $data);
    }

    //para crear un nuevo registro de horarios
    public function horarios_nuevo(Request $request){
        $validar = Validator::make($request->all(),[
            'nombre'        => 'required|unique:rl_horarios,nombre',
            'descripcion'   => 'required'
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $horario_nuevo               = new Horario();
            $horario_nuevo->nombre       = $request->nombre;
            $horario_nuevo->descripcion  = $request->descripcion;
            $horario_nuevo->id_usuario   = Auth::user()->id;
            $horario_nuevo->save();
            if($horario_nuevo->id){
                $data = mensaje_mostrar('success', 'Se realizo el registro con éxito ! ');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al registrar ! ');
            }
        }
        return response()->json($data);
    }
    //para listar los horarios
    public function horarios_listar(){
        $listar_horarios = Horario::OrderBy('id','asc')->get();
        return response()->json($listar_horarios);
    }
    //para eliminar el registro de los horarios
    public function horarios_eliminar(Request $request){
        try {
            $horario = Horario::find($request->id);
            if($horario->delete()){
                $data = mensaje_mostrar('success', 'Se elimino el registro con éxito ! ');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar !');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar !');
        }
        return response()->json($data);
    }
    //para editar los horarios
    public function horarios_editar(Request $request){
        try {
            $horario = Horario::find($request->id);
            if($horario){
                $data = mensaje_mostrar('success', $horario);
            }else{
                $data = mensaje_mostrar('error','Ocurrio un error al editar');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error','Ocurrio un error al editar');
        }
        return response()->json($data);
    }
    //para guardar lo editado del horario
    public function horarios_editar_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'nombre_'        => 'required|unique:rl_horarios,nombre,'.$request->id_horario,
            'descripcion_'   => 'required'
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $horario_edit               = Horario::find($request->id_horario);
            $horario_edit->nombre       = $request->nombre_;
            $horario_edit->descripcion  = $request->descripcion_;
            $horario_edit->save();
            if($horario_edit->id){
                $data = mensaje_mostrar('success', 'Se editó con éxito ! ');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar ! ');
            }
        }
        return response()->json($data);
    }
    /**
     * FIN DE LA PARTE DE ADMINISTRACION DE LOS HORARIOS
     */


     /**
     * PARA LA ADMINISTRACION DE LOS RANGOS DE LOS HORARIOS
     */
    //para guardar los datos de los horarios especificos
    public function horarios_especificos(Request $request){
        //para editar
        if($request->id_especifico){
            $validar = Validator::make($request->all(),[
                'nombre__'          => 'required',
                'numero'            => 'required',
                'hora_inicio'       => 'required',
                'hora_final'        => 'required|after:hora_inicio',
            ]);
            if($validar->fails()){
                $data = mensaje_mostrar('errores', $validar->errors());
            }else{
                $rango_hora               = Rango_hora::find($request->id_especifico);
                $rango_hora->nombre       = $request->nombre__;
                $rango_hora->numero       = $request->numero;
                $rango_hora->hora_inicio  = $request->hora_inicio;
                $rango_hora->hora_final   = $request->hora_final;
                $rango_hora->tolerancia   = $request->tolerancia;
                $rango_hora->save();
                if($rango_hora->id){
                    $data = array(
                        'tipo'          => 'success',
                        'mensaje'       => 'Se editó con éxito ! ',
                        'id_horario'    => $request->id_horario_esp
                    );
                }else{
                    $data = mensaje_mostrar('error', 'Ocurrio un error al editar ! ');
                }
            }
        }else{
            //para guardar nuevo
            $validar = Validator::make($request->all(),[
                'nombre__'          => 'required',
                'numero'            => 'required',
                'hora_inicio'       => 'required|date_format:H:i',
                'hora_final'        => 'required|date_format:H:i|after:hora_inicio',
            ]);
            if($validar->fails()){
                $data = mensaje_mostrar('errores', $validar->errors());
            }else{
                $rango_hora               = new Rango_hora();
                $rango_hora->nombre       = $request->nombre__;
                $rango_hora->numero       = $request->numero;
                $rango_hora->hora_inicio  = $request->hora_inicio;
                $rango_hora->hora_final   = $request->hora_final;
                $rango_hora->tolerancia   = $request->tolerancia;
                $rango_hora->id_horario   = $request->id_horario_esp;
                $rango_hora->id_usuario   = Auth::user()->id;
                $rango_hora->save();
                if($rango_hora->id){
                    $data = array(
                        'tipo'          => 'success',
                        'mensaje'       => 'Se guardo con éxito ! ',
                        'id_horario'    => $request->id_horario_esp
                    );
                }else{
                    $data = mensaje_mostrar('error', 'Ocurrio un error al guardar ! ');
                }
            }
        }
        return response()->json($data);
    }
    //para el listado de los datos de los horarios especificos
    public function horarios_especificos_listar(Request $request){
        $horarios_especificos = Rango_hora::where('id_horario',$request->id)->OrderBy('numero', 'asc')->get();
        return response()->json($horarios_especificos);
    }
    //para la edicion de los datos de los horarios especificos
    public function horarios_especificos_editar(Request $request){
        try {
            $horarios_especificos = Rango_hora::find($request->id);
            if($horarios_especificos){
                $data = mensaje_mostrar('success', $horarios_especificos);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error','Ocurrio un error al editar');
        }
        return response()->json($data);
    }
    //para eliminar el registro
    public function horarios_especificos_eliminar(Request $request) {
        try {
            $horarios_especificos = Rango_hora::find($request->id);
            if($horarios_especificos->delete()){
                $data = mensaje_mostrar('success', 'Se elimino el registro con éxito !');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar');
        }
        return response()->json($data);
    }
    /**
     * FIN DE LA PARTE DE LA ADMINISTRACION DE LOS HORARIOS
     */


    /**
     * EXCEPCION DE HORARIO
     */
    public function excepcion_horario($id){
        $data['menu']           = '11';
        $id_rango_hora          = desencriptar($id);
        $data['id_rango_hora']  = $id_rango_hora;
        $data['rango_hora']     = Rango_hora::find($id_rango_hora);
        $data['dias_semana']    = Dias_semana::OrderBy('id','asc')->take(6)->get();
        return view('administrador.configuracion.horarios.excepcion_horario', $data);
    }

    //para el guardado de la excepcion
    public function excepcion_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'descripcion'     => 'required',
            'hora'            => 'required',
            'fecha_inicial'   => 'required',
            'fecha_final'     => 'required',
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            //preguntamos si existe con el mismo ID activo ok!
            $validar_excepcion = Excepcion::where('id_rango_hora', $request->id_rango_hora)
                                    ->where('estado', 'activo')
                                    ->first();
            if(!$validar_excepcion){
                $nueva_excepcion                = new Excepcion();
                $nueva_excepcion->descripcion   = $request->descripcion;
                $nueva_excepcion->fecha_inicio  = $request->fecha_inicial;
                $nueva_excepcion->fecha_final   = $request->fecha_final;
                $nueva_excepcion->estado        = 'activo';
                $nueva_excepcion->hora          = $request->hora;
                $nueva_excepcion->id_rango_hora = $request->id_rango_hora;
                $nueva_excepcion->id_usuario    = Auth::user()->id;
                $nueva_excepcion->save();

                $nueva_excepcion->dias_semana_excepcion()->sync($request->dia_semana);

                if($nueva_excepcion->id){
                    $data = mensaje_mostrar('success', 'Se guardo con exito la excepción ! ');
                }else{
                    $data = mensaje_mostrar('error', 'Ocurrio un error al insertar la excepción ! ');
                }
            }else{
                $data = mensaje_mostrar('error', 'Ya existe una excepcion activa, porfavor de inactivo al que esta y registre nuevamente!');
            }
        }
        return response()->json($data);
    }

    //para el listado de la excepcion del horario
    public function excepcion_listar(Request $request){
        $listar_excepcion = Excepcion::with(['dias_semana_excepcion'])->where('id_rango_hora', $request->id_rang_hora)->OrderBy('id','desc')->get();
        return response()->json($listar_excepcion);
    }

    //para el cambiado del estado del excepcion del horario
    public function excepcion_estado(Request $request){
        try {
            $excepcion_horario = Excepcion::find($request->id);
            $excepcion_horario->estado = ($excepcion_horario->estado == 'activo')? 'inactivo':'activo';
            $excepcion_horario->save();
            if($excepcion_horario->id){
                $data = mensaje_mostrar('success', 'Se desbilito con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un problema interno');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema interno');
        }
        return response()->json($data);
    }
    //para la edicion del editar la excepcion
    public function excepcion_edit(Request $request){
        try {
            $excepcion_horario = Excepcion::with(['rango_hora', 'dias_semana_excepcion'])->find($request->id);
            if($excepcion_horario){
                $data = mensaje_mostrar('success', $excepcion_horario);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un problema al obtener los datos');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema al obtener los datos');
        }
        return response()->json($data);
    }
    //par aguardar lo editado de la excepcion
    public function excepcion_edit_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'descripcion_'     => 'required',
            'hora_'            => 'required',
            'fecha_inicial_'   => 'required',
            'fecha_final_'     => 'required',
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $editar_excepcion                = Excepcion::find($request->id_excepcion);
            $editar_excepcion->descripcion   = $request->descripcion_;
            $editar_excepcion->fecha_inicio  = $request->fecha_inicial_;
            $editar_excepcion->fecha_final   = $request->fecha_final_;
            $editar_excepcion->hora          = $request->hora_;
            $editar_excepcion->id_usuario    = Auth::user()->id;
            $editar_excepcion->save();

            $editar_excepcion->dias_semana_excepcion()->sync($request->dia_semana, true);

            if($editar_excepcion->id){
                $data = mensaje_mostrar('success', 'Se editó con exito la excepción ! ');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar la excepción ! ');
            }
        }
        return response()->json($data);
    }
    /**
     * FIN DE EXCEPCION DE HORARIO
     */
}
