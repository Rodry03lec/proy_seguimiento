<?php

namespace App\Http\Controllers\Biometrico;

use App\Http\Controllers\Controller;
use App\Models\Biometrico\Licencia\Tipo_licencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Controlador_licencia extends Controller
{
    /**
     * PARA LA ADMINISTRACION DE LA CONFIGURACION DE LOS PERMISOS
     */
    public function configuracion_licencia(){
        $data['menu'] = '16';
        return view('administrador.biometrico.licencias.configuracion', $data);
    }

    //para listar los tipos de licencia que existe
    public function tipo_licencia_listar(){
        $tipo_licencia = Tipo_licencia::OrderBy('numero', 'asc')->get();
        return response()->json($tipo_licencia);
    }

    //para cambiar el estado de los tipos de licencia
    public function  tipo_licencia_estado(Request $request){
        try {
            $tipo_licencia = Tipo_licencia::find($request->id);
            $tipo_licencia->estado = ($tipo_licencia->estado=='activo') ? 'inactivo' : 'activo';
            $tipo_licencia->save();
            if($tipo_licencia->id){
                $data = mensaje_mostrar('success', 'El estado se cambio con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado');
        }
        return response()->json($data);
    }

    //para guardar los tipos de licencia
    public function tipo_licencia_nuevo(Request $request){
        $validar = Validator::make($request->all(), [
            'numero'            => 'required',
            'normativa'         => 'required',
            'motivo'            => 'required',
            'jornada_laboral'   => 'required',
            'requisitos'        => 'required',
            'plazos'            => 'required',
            'observaciones'     => 'required',
        ]);

        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            $tipo_licencia                  = new Tipo_licencia();
            $tipo_licencia->numero          = $request->numero;
            $tipo_licencia->normativa       = $request->normativa;
            $tipo_licencia->motivo          = $request->motivo;
            $tipo_licencia->jornada_laboral = $request->jornada_laboral;
            $tipo_licencia->requisitos      = $request->requisitos;
            $tipo_licencia->plazos          = $request->plazos;
            $tipo_licencia->observaciones   = $request->observaciones;
            $tipo_licencia->estado          = 'activo';
            $tipo_licencia->id_usuario      = Auth::user()->id;
            $tipo_licencia->save();

            if($tipo_licencia->id){
                $data = mensaje_mostrar('success', 'Se inserto con éxito el registro');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al insertar la licencia ');
            }
        }
        return response()->json($data);
    }

    //para editar el registro de licencias
    public function tipo_licencia_editar(Request $request){
        try {
            $tipo_licencia = Tipo_licencia::find($request->id);
            if($tipo_licencia){
                $data = mensaje_mostrar('success', $tipo_licencia);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error ala editar los datos');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error ala editar los datos');
        }
        return response()->json($data);
    }

    //para guardar lo editado
    public function tipo_licencia_editar_save(Request $request){
        $validar = Validator::make($request->all(), [
            'numero_'            => 'required',
            'normativa_'         => 'required',
            'motivo_'            => 'required',
            'jornada_laboral_'   => 'required',
            'requisitos_'        => 'required',
            'plazos_'            => 'required',
            'observaciones_'     => 'required',
        ]);

        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            $tipo_licencia                  = Tipo_licencia::find($request->id_tipo_licencia);
            $tipo_licencia->numero          = $request->numero_;
            $tipo_licencia->normativa       = $request->normativa_;
            $tipo_licencia->motivo          = $request->motivo_;
            $tipo_licencia->jornada_laboral = $request->jornada_laboral_;
            $tipo_licencia->requisitos      = $request->requisitos_;
            $tipo_licencia->plazos          = $request->plazos_;
            $tipo_licencia->observaciones   = $request->observaciones_;
            $tipo_licencia->estado          = 'activo';
            $tipo_licencia->id_usuario      = Auth::user()->id;
            $tipo_licencia->save();

            if($tipo_licencia->id){
                $data = mensaje_mostrar('success', 'Se inserto con éxito el registro');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al insertar la licencia ');
            }
        }
        return response()->json($data);
    }

    //para eliminar el registro de los ripos de licencias
    public function tipo_licencia_eliminar(Request $request){
        try {
            $tipo_licencia = Tipo_licencia::find($request->id);
            if($tipo_licencia->delete()){
                $data = mensaje_mostrar('success', 'Se elimino el registro con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar');
        }
        return response()->json($data);
    }
    /**
     * FIN PARA LA ADMINISTRACION DE LA CONFIGURACION DE LOS PERMISOS
     */
}
