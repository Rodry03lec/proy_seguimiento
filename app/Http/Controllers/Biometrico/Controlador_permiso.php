<?php

namespace App\Http\Controllers\Biometrico;

use App\Http\Controllers\Controller;
use App\Models\Biometrico\Permiso\Desglose_permiso;
use App\Models\Biometrico\Permiso\Tipo_permiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Controlador_permiso extends Controller
{
    /**
     * @version 1.0
     * @author  Graice Callizaya Chambi <graicecallizaya1234@gmail.com>
     * @param Controlador Administrar la parte de LA ADMINISTRACION DE LOS TIPOS DE PERMISOS
     * ¡Muchas gracias por preferirnos! Esperamos poder servirte nuevamente
     */

    /**
     * PARA LA ADMINISTRACION DE LOS TIPOS DE PERMISOS
     */
    public function tipo_permiso(){
        $data['menu'] = '16';
        return view('administrador.biometrico.permiso.tipo_permiso', $data);
    }
    //para listar los tipos de licencia
    public function tipo_permiso_listar(){
        $tipo_permiso = Tipo_permiso::OrderBy('id', 'asc')->get();
        return response()->json($tipo_permiso);
    }
    //para cambiar el estado de la licencia
    public function tipo_permiso_estado(Request $request){
        try {
            $tipo_permiso = Tipo_permiso::find($request->id);
            $tipo_permiso->estado = ($tipo_permiso->estado==='activo') ? 'inactivo' : 'activo';
            $tipo_permiso->save();
            if($tipo_permiso->id){
                $data = mensaje_mostrar('success', 'El estado se cambio con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado!');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado!');
        }
        return response()->json($data);
    }

    //para crear nuevo tipod e permiso
    public function  tipo_permiso_nuevo(Request $request){
        $validar = Validator::make($request->all(), [
            'nombre'       => 'required',
        ]);

        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            $tipo_permiso               = new Tipo_permiso();
            $tipo_permiso->nombre       = $request->nombre;
            $tipo_permiso->estado       = 'activo';
            $tipo_permiso->id_usuario   = Auth::user()->id;
            $tipo_permiso->save();

            if($tipo_permiso->id){
                $data = mensaje_mostrar('success', 'Se creo con exito el tipo permiso');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un problema al insertar los datos');
            }
        }
        return response()->json($data);
    }

    //para eliminar el registro de los tipos de permisos
    public function  tipo_permiso_eliminar(Request $request) {
        try {
            $tipo_permiso = Tipo_permiso::find($request->id);
            if($tipo_permiso->delete()){
                $data = mensaje_mostrar('success', 'Se elimino el registro con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar el registro');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar el registro');
        }
        return response()->json($data);
    }

    //para editar el registro de los tipos de permisos
    public function  tipo_permiso_editar(Request $request){
        try {
            $tipo_permiso = Tipo_permiso::find($request->id);
            if($tipo_permiso){
                $data = mensaje_mostrar('success', $tipo_permiso);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar los datos');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al editar los datos');
        }
        return response()->json($data);
    }
    //para guardar lo edtiado de los tipos de permiso
    public function tipo_permiso_editar_save(Request $request) {
        $validar = Validator::make($request->all(), [
            'nombre_'       => 'required',
        ]);

        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            $tipo_permiso               = Tipo_permiso::find($request->id_tipo_permiso);
            $tipo_permiso->nombre       = $request->nombre_;
            $tipo_permiso->save();

            if($tipo_permiso->id){
                $data = mensaje_mostrar('success', 'Se editó con éxito el tipo permiso');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un problema al editar los datos');
            }
        }
        return response()->json($data);
    }

    /**
     * FIN PARA LA ADMINISTRACION DE LOS TIPOS DE PERMISOS
     */



    /**
      * PARA LA ADMINISTRACION DEL DESGLOSE DE LOS PERMISOS
    */
    public function  desglose_permiso_listar(Request $request) {
        $desglose_permiso = Desglose_permiso::where('id_tipo_permiso', $request->id)
                            ->OrderBy('id','asc')
                            ->get();
        return response()->json($desglose_permiso);
    }
    //para guardar nuevo registro de desglose permiso
    public function desglose_permiso_guardar(Request $request){
        $validar = Validator::make($request->all(), [
            'nombre__'       => 'required',
            'descripcion'    => 'required',
        ]);

        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            if($request->id_desglose_permiso != null){
                //para editar
                $desglose_permiso           = Desglose_permiso::find($request->id_desglose_permiso);
            }else{
                //para nuevo
                $desglose_permiso           = new Desglose_permiso();
                $desglose_permiso->id_tipo_permiso  = $request->id_tipo_permiso_;
                $desglose_permiso->estado   = 'activo';
            }
            $desglose_permiso->nombre           = $request->nombre__;
            $desglose_permiso->descripcion      = $request->descripcion;
            $desglose_permiso->id_usuario       = Auth::user()->id;
            $desglose_permiso->save();
            if($desglose_permiso->id){
                $data = mensaje_mostrar('success', 'Se realizo la operacion con éxito');
                $data = array(
                    'tipo'              =>'success',
                    'mensaje'           => 'Se realizo la operacion con éxito',
                    'id_tipo_permiso'   => $desglose_permiso->id_tipo_permiso
                );
            }else{
                $data = mensaje_mostrar('error', 'Ourrio un problema inesperado');
            }
        }
        return response()->json($data);
    }

    //para eliminar el registro
    public function desglose_permiso_eliminar(Request $request){
        try {
            $desglose_permiso = Desglose_permiso::find($request->id);
            if($desglose_permiso->delete()){
                $data = mensaje_mostrar('success', 'Se elimino con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar');
        }
        return response()->json($data);
    }

    //para editar el registro del desglose
    public function desglose_permiso_editar(Request $request){
        try {
            $desglose_permiso = Desglose_permiso::find($request->id);
            if($desglose_permiso){
                $data = mensaje_mostrar('success', $desglose_permiso);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un problema al editar los datos');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema al editar los datos');
        }
        return response()->json($data);
    }

    //para cambiar el estado del desglose
    public function desglose_permiso_estado(Request $request){
        try {
            $desglose_permiso = Desglose_permiso::find($request->id);
            $desglose_permiso->estado = ($desglose_permiso->estado=='activo') ? 'inactivo' : 'activo';
            $desglose_permiso->save();
            if($desglose_permiso->id){
                $data = array(
                    'tipo'=>'success',
                    'mensaje'=>'Se cambio el estado con éxito',
                    'id_tipo_permiso'=> $desglose_permiso->id_tipo_permiso
                );
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado');
        }
        return response()->json($data);
    }
    /**
     * FIN PARA LA ADMINISTRACION DEL DESGLOSE DE LOS PERMISOS
     */
}
