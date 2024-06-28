<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuracion\Unidades_administrativas;
use Illuminate\Support\Facades\Validator;

class Controlador_unidades_administrativas extends Controller
{
    /**
     * @version 1.0
     * @author  Graice Callizaya Chambi <graicecallizaya1234@gmail.com>
     * @param Controlador Administrar el registro de todas las unidades administrativas que existe en aqui
     * ¡Muchas gracias por preferirnos! Esperamos poder servirte nuevamente
     */

    public function unidades_administrativas(){
        $data['menu'] = '9';
        return view('administrador.configuracion.unidades_administrativas', $data);
    }
    //para registrar la nueva unidad administrativa
    public function unidades_admin_nuevo(Request $request){
        $validar = Validator::make($request->all(),[
            'nombre'=>'required|unique:rl_unidades_admin,nombre',
            'sigla'=>'required'
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $unidades_admin = new Unidades_administrativas();
            $unidades_admin->nombre = $request->nombre;
            $unidades_admin->sigla  = $request->sigla;
            $unidades_admin->estado = 'activo';
            $unidades_admin->save();
            if($unidades_admin->id){
                $data = mensaje_mostrar('success', 'Se inserto con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al insertar !');
            }
        }
        return response()->json($data);
    }
    //para listar las unidades administrativas
    public function unidades_admin_listar(){
        $unidades_admin = Unidades_administrativas::OrderBy('id','desc')->get();
        return response()->json($unidades_admin);
    }
    //para editar el registro de unidades administrativas
    public function unidades_admin_editar(Request $request){
        try {
            $unidades_admin = Unidades_administrativas::find($request->id);
            if($unidades_admin){
                $data = mensaje_mostrar('success', $unidades_admin);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al editar');
        }
        return response()->json($data);
    }

    //para el guardado de la unidad administrativa editado
    public function unidades_admin_edit_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'nombre_' =>'required|unique:rl_unidades_admin,nombre,'.$request->id_unidad_admin,
            'sigla_' =>'required'
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $unidades_admin = Unidades_administrativas::find($request->id_unidad_admin);
            $unidades_admin->nombre = $request->nombre_;
            $unidades_admin->sigla = $request->sigla_;
            $unidades_admin->save();
            if($unidades_admin->id){
                $data = mensaje_mostrar('success', 'Se editó con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar !');
            }
        }
        return response()->json($data);
    }

    //para eliminar la unidad administrativa seleccionada
    public function unidades_admin_eliminar(Request $request){
        try {
            $unidades_admin = Unidades_administrativas::find($request->id);
            if($unidades_admin->delete()){
                $data = mensaje_mostrar('success', 'Se elimino el registro con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un problema al eliminar');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema al eliminar');
        }
        return response()->json($data);
    }
    //para cambiar el estado de las unidades adminitrativas
    public function  unidades_admin_estado(Request $request){
        try {
            $unidades_admin = Unidades_administrativas::find($request->id);
            // Cambiar el estado usando un operador ternario
            $unidades_admin->estado = ($unidades_admin->estado == 'activo') ? 'inactivo' : 'activo';
            // Guardar los cambios en la base de datos
            $unidades_admin->save();
            if($unidades_admin->id){
                $data = mensaje_mostrar('success','Se cambio el estado con éxito!');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado');
        }
        return response()->json($data);
    }
}
