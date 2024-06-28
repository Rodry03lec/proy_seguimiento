<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Configuracion\Direccion_municipal;
use App\Models\Configuracion\Secretaria_municipal;

class Controlador_secretaria extends Controller
{
    /**
     * @version 1.0
     * @author  Graice Callizaya Chambi <graicecallizaya1234@gmail.com>
     * @param Controlador Administrar los ADMINISTRACIÓN DE LAS SECRETARIAS MUNICIPALES - Y DIRECCIONES
     * ¡Muchas gracias por preferirnos! Esperamos poder servirte nuevamente
     */

    private $menu_tipoconfiguracion = 'configuracion';

    //para la administracion de la secretaria municipal
    public function secretaria_municipal()
    {
        $data['menu'] = '10';
        return view('administrador.configuracion.secretaria_municipal.secretaria_municipal', $data);
    }
    //para guardar el nuevo registro de las secretarias municipales
    public function secretaria_municipal_guardar(Request $request)
    {
        $validar = Validator::make($request->all(), [
            'sigla' => 'required|unique:rl_secretaria_municipal,sigla',
            'nombre' => 'required|unique:rl_secretaria_municipal,nombre',
        ]);
        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            $secretaria_municipal = new Secretaria_municipal();
            $secretaria_municipal->sigla   = $request->sigla;
            $secretaria_municipal->nombre  = $request->nombre;
            $secretaria_municipal->estado  = 'activo';
            $secretaria_municipal->save();
            if ($secretaria_municipal->id) {
                $data = mensaje_mostrar('success', 'Se inserto con éxito la nueva Secretaria Municipal');
            } else {
                $data = mensaje_mostrar('error', 'Ocurrio un error al insertar !');
            }
        }
        return response()->json($data);
    }


    //para el listado de las secretarias municipales
    public function secretaria_municipal_listar()
    {
        $secretaria_municipal = Secretaria_municipal::OrderBy('id', 'asc')->get();
        return response()->json($secretaria_municipal);
    }

    //para eliminar la secretarias municipales
    public function secretaria_municipal_eliminar(Request $request)
    {
        try {
            $secretaria_municipal = Secretaria_municipal::find($request->id);
            if ($secretaria_municipal->delete()) {
                $data = mensaje_mostrar('success', 'Se elimino el registro con éxito');
            } else {
                $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar');
        }
        return response()->json($data);
    }

    //para editar el registro de las secretarias municipales

    public function secretaria_municipal_editar(Request $request)
    {
        try {
            $secretaria_municipal = Secretaria_municipal::find($request->id);
            if ($secretaria_municipal) {
                $data = mensaje_mostrar('success', $secretaria_municipal);
            } else {
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al editar');
        }
        return response()->json($data);
    }

    //para guardar lo editado
    public function secretaria_municipal_edit_guardar(Request $request)
    {
        $validar = Validator::make($request->all(), [
            'sigla_'    =>  'required|unique:rl_secretaria_municipal,sigla,' . $request->id_secretaria_mun,
            'nombre_'   =>  'required|unique:rl_secretaria_municipal,nombre,' . $request->id_secretaria_mun,
        ]);
        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            $secretaria_municipal           = Secretaria_municipal::find($request->id_secretaria_mun);
            $secretaria_municipal->sigla    = $request->sigla_;
            $secretaria_municipal->nombre   = $request->nombre_;
            $secretaria_municipal->save();
            if ($secretaria_municipal->id) {
                $data = mensaje_mostrar('success', 'Se editó con éxito la nueva Secretaria Municipal');
            } else {
                $data = mensaje_mostrar('error', 'Ocurrio un error al insertar !');
            }
        }
        return response()->json($data);
    }

    //para cambiar los estado de las secretarias
    public function secretaria_municipal_estado(Request $request)
    {
        try {
            $secretaria_municipal = Secretaria_municipal::find($request->id);
            $secretaria_municipal->estado = ($secretaria_municipal->estado == 'activo') ? 'inactivo' : 'activo';
            $secretaria_municipal->save();
            if ($secretaria_municipal->id) {
                $data = mensaje_mostrar('success', 'Se camnio el estado con éxito');
            } else {
                $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado');
        }
        return response()->json($data);
    }


    /**
     * PARA LA PARTE DE LAS DIRECCINES
    */
    public function direccion_vista(Request $request){
        try {
            $secretaria_municipal = Secretaria_municipal::find($request->id);
            if($secretaria_municipal){
                $data = mensaje_mostrar('success', $secretaria_municipal);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al listar');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al listar');
        }
        return response()->json($data);
    }

    //para guardar lo nuevo de las direcciones
    public function direccion_guardar(Request $request){
        if(!$request->id_direccion){
            $validar = Validator::make($request->all(),[
                'sigla__'    =>  'required',
                'nombre__'   =>  'required|unique:rl_direccion,nombre',
            ]);
            if($validar->fails()){
                $data = mensaje_mostrar('errores', $validar->errors());
            }else{
                $direccion                  = new Direccion_municipal();
                $direccion->sigla           = $request->sigla__;
                $direccion->nombre          = $request->nombre__;
                $direccion->id_secretaria   = $request->id_secretaria_new;
                $direccion->estado          = 'activo';
                $direccion->save();
                if($direccion->id){
                    $data = array(
                        'tipo'                  => 'success',
                        'mensaje'               => 'Se creo la nueva Dirección con éxito',
                        'id_secretaria_nuevo'   => $request->id_secretaria_new
                    );
                }else{
                    $data = mensaje_mostrar('error', 'Ocurrio un error al insertar !');
                }
            }
        }else{
            $validar = Validator::make($request->all(),[
                'sigla__'    =>  'required',
                'nombre__'   =>  'required|unique:rl_direccion,nombre,'.$request->id_direccion,
            ]);
            if($validar->fails()){
                $data = mensaje_mostrar('errores', $validar->errors());
            }else{
                $direccion           = Direccion_municipal::find($request->id_direccion);
                $direccion->sigla    = $request->sigla__;
                $direccion->nombre   = $request->nombre__;
                $direccion->save();
                if($direccion->id){
                    $data = array(
                        'tipo'                  => 'success',
                        'mensaje'               => 'Se creo la nueva Dirección con éxito',
                        'id_secretaria_nuevo'   => $request->id_secretaria_new
                    );
                }else{
                    $data = mensaje_mostrar('error', 'Ocurrio un error al editar !');
                }
            }
        }
        return response()->json($data);
    }


    //para el listado de las direcciones
    public function direccion_listar(Request $request){
        $listar_direccion = Direccion_municipal::where('id_secretaria', $request->id)->OrderBy('id', 'desc')->get();
        return response()->json($listar_direccion);
    }

    //para editar el registro de la direcciones
    public function direccion_editar(Request $request){
        try {
            $direccion = Direccion_municipal::find($request->id);
            if($direccion){
                $data = mensaje_mostrar('success', $direccion);
            }else{
                $data = mensaje_mostrar('error', 'Ocurio un error al editar los datos');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurio un error al editar los datos');
        }
        return response()->json($data);
    }

    //para eliminar el registro de las direcciones municipales
    public function direccion_eliminar(Request $request){
        try {
            $direccion = Direccion_municipal::find($request->id);
            if($direccion->delete()){
                $data = mensaje_mostrar('success', 'Se elimino el registro con éxito!');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al realizar la eliminacion del registro');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al realizar la eliminacion del registro');
        }
        return response()->json($data);
    }
    //para cambiar el estado de las direcciones municipales
    public function direccion_estado(Request $request){
        try {
            $direccion_municipal = Direccion_municipal::find($request->id);
            $direccion_municipal->estado = ($direccion_municipal->estado == 'activo') ? 'inactivo' : 'activo';
            $direccion_municipal->save();
            if($direccion_municipal->id){
                $data = mensaje_mostrar('success', 'Se camnio el estado con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema al cambiar el estadi');
        }
        return response()->json($data);
    }
    /**
      * FIN DE LA PARTE DE LAS DIRECCIONES
    */
}
