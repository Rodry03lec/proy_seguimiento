<?php

namespace App\Http\Controllers\Biometrico;

use App\Http\Controllers\Controller;
use App\Models\Biometrico\Horario_continuo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Controlador_horario_continuo extends Controller
{
    /**
     * @version 1.0
     * @author  Graice Callizaya Chambi <graicecallizaya1234@gmail.com>
     * @param Controlador Administrar LA ADMINISTRACION DEL HORARIO CONTINUO
     * ¡Muchas gracias por preferirnos! Esperamos poder servirte nuevamente
     */

    /**
     * PARA LA ADMINISTRACION DEL HORARIO CONTINUO
     */
    public function  horario_continuo(){
        $data['menu'] = '16';
        return view('administrador.biometrico.horario_continuo.horario_continuo', $data);
    }

    //para guardar el horario continuo programado
    public function hor_continuo_guardar(Request $request){
        $validar = Validator::make($request->all(), [
            'descripcion'       => 'required',
            'fecha_inicial'     => 'required',
            'fecha_final'       => 'required',
            'hora_salida'       => 'required',
        ]);

        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            $horario_continuo               = new Horario_continuo();
            $horario_continuo->descripcion  = $request->descripcion;
            $horario_continuo->fecha_inicio = $request->fecha_inicial;
            $horario_continuo->fecha_final  = $request->fecha_final;
            $horario_continuo->hora_salida  = $request->hora_salida;
            $horario_continuo->estado       = 'activo';
            $horario_continuo->id_usuario   = Auth::user()->id;
            $horario_continuo->save();
            if($horario_continuo->id){
                $data = mensaje_mostrar('success', 'Se guardo con exito el registro');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al guardar el registro');
            }
        }
        return response()->json($data);
    }

    //para listar el registro de los horario programadas
    public function hor_continuo_listar(){
        $listar_horario_continuo = Horario_continuo::OrderBy('id', 'desc')->get();
        return response()->json($listar_horario_continuo);
    }

    //para editar el registro de los horarios continuos prohramados
    public function hor_continuo_editar(Request $request){
        try {
            $horario_continuo = Horario_continuo::find($request->id);
            if($horario_continuo){
                $data = mensaje_mostrar('success', $horario_continuo);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar los datos');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al editar los datos');
        }
        return response()->json($data);
    }

    //para guardar los datos editados de los horarios continuos
    public function hor_continuo_edit_guardar(Request $request){
        $validar = Validator::make($request->all(), [
            'descripcion_'       => 'required',
            'fecha_inicial_'     => 'required',
            'fecha_final_'       => 'required',
            'hora_salida_'       => 'required',
        ]);

        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            $horario_continuo               = Horario_continuo::find($request->id_horario_con);
            $horario_continuo->descripcion  = $request->descripcion_;
            $horario_continuo->fecha_inicio = $request->fecha_inicial_;
            $horario_continuo->fecha_final  = $request->fecha_final_;
            $horario_continuo->hora_salida  = $request->hora_salida_;
            $horario_continuo->id_usuario   = Auth::user()->id;
            $horario_continuo->save();
            if($horario_continuo->id){
                $data = mensaje_mostrar('success', 'Se editó con exito el registro');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al guardar el registro');
            }
        }
        return response()->json($data);
    }

    //para eliminar el registro de los horarios continuos programados
    public function hor_continuo_eliminar(Request $request){
        try {
            $horario_continuo = Horario_continuo::find($request->id);
            if($horario_continuo->delete()){
                $data = mensaje_mostrar('success', 'Se elimino el registro con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar');
        }
        return response()->json($data);
    }

    //para cambiar el estado a los horario continuos
    public function hor_continuo_estado(Request $request){
        try {
            $horario_continuo = Horario_continuo::find($request->id);
            $horario_continuo->estado = ($horario_continuo->estado=='activo') ? 'inactivo' : 'activo';
            $horario_continuo->save();
            if($horario_continuo->id){
                $data = mensaje_mostrar('success', ' Es estado se cambio con éxito!');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado');
        }
        return response()->json($data);
    }

    /**
     * FIN DE LA AMDNISTRACION DEL HORARIO CONTINUO
     */
}
