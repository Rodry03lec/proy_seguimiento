<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuracion\Mae;
use Illuminate\Support\Facades\Validator;
use App\Models\Configuracion\Unidad_mae;

class Controlador_mae extends Controller
{
    /**
     * @version 1.0
     * @author  Graice Callizaya Chambi <graicecallizaya1234@gmail.com>
     * @param Controlador Administrar la parte de LA MAE que seria el DESPACHO MUNICIPAL, Y LA SECRETARIA GENERAL
     * ¡Muchas gracias por preferirnos! Esperamos poder servirte nuevamente
     */


    //para el listado de mae
    public function mae(){
        $data['menu'] = '8';
        return view('administrador.configuracion.mae.mae', $data);
    }
    //para guardar los registro de mae
    public function mae_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'nombre'=>'required|unique:rl_mae,nombre',
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $mae = new Mae();
            $mae->nombre = $request->nombre;
            $mae->save();
            if($mae->id){
                $data = mensaje_mostrar('success', 'Se inserto con éxito el mae');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al insertar !');
            }
        }
        return response()->json($data);
    }
    //para listar los registros de mae
    public function mae_listar(){
        $listar_mae = Mae::OrderBy('id','desc')->get();
        return response()->json($listar_mae);
    }
    //para realizar la edicion de mae_editar
    public function mae_editar(Request $request){
        try {
            $mae = Mae::find($request->id);
            if($mae){
                $data = mensaje_mostrar('success', $mae);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un problema al editar los datos');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema al editar los datos');
        }
        return response()->json($data);
    }

    //para realizar el guardado de lo editado
    public function mae_editar_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'nombre_'=>'required|unique:rl_mae,nombre,'.$request->id_mae,
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $mae = Mae::find($request->id_mae);
            $mae->nombre = $request->nombre_;
            $mae->save();
            if($mae->id){
                $data = mensaje_mostrar('success', 'Se editó con éxito el mae');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar !');
            }
        }
        return response()->json($data);
    }
    //para eliminar el registro de mae
    public function mae_eliminar(Request $request){
        try {
            $mae = Mae::find($request->id);
            if($mae->delete()){
                $data = mensaje_mostrar('success', 'Se elimino el registro con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un problema al eliminar el registro');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema al eliminar el registro');
        }
        return response()->json($data);
    }


    /**
     * PARA LA ADMINISTRACION DE CARGOS
     */
    //para la administracion de los cargos
    public function mae_unidad(Request $request){
        try {
            $cargos = Mae::find($request->id);
            if($cargos){
                $data = mensaje_mostrar('success', $cargos);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al mostrar los datos');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al mostrar los datos');
        }
        return response()->json($data);
    }
    //para el listado de los cargos
    public function mae_unidad_listar(Request $request){
        $cargo = Unidad_mae::where('id_mae', $request->id)->OrderBy('id','desc')->get();
        return response()->json($cargo);
    }
    //para guardar un nuevo cargo
    public function mae_unidad_nuevo(Request $request){
        if($request->id_cargo){
            $validar = Validator::make($request->all(),[
                'descripcion'=>'required|unique:rl_unidad_mae,descripcion,'.$request->id_cargo,
            ]);
            if($validar->fails()){
                $data = mensaje_mostrar('errores', $validar->errors());
            }else{
                $cargo                  = Unidad_mae::find($request->id_cargo);
                $cargo->descripcion     = $request->descripcion;
                $cargo->save();
                if($cargo->id){
                    $data = array(
                        'tipo'              => 'success',
                        'mensaje'           => 'Se editó con éxito el cargo',
                        'id_mae_registro'   => $request->id_mae_new
                    );
                }else{
                    $data = mensaje_mostrar('error', 'Ocurrio un error al editar !');
                }
            }
        }else{
            $validar = Validator::make($request->all(),[
                'descripcion'=>'required|unique:rl_unidad_mae,descripcion',
            ]);
            if($validar->fails()){
                $data = mensaje_mostrar('errores', $validar->errors());
            }else{
                $cargo                  = new Unidad_mae();
                $cargo->descripcion     = $request->descripcion;
                $cargo->id_mae          = $request->id_mae_new;
                $cargo->save();
                if($cargo->id){
                    $data = array(
                        'tipo'              => 'success',
                        'mensaje'           => 'Se registro con éxito',
                        'id_mae_registro'   => $request->id_mae_new
                    );
                }else{
                    $data = mensaje_mostrar('error', 'Ocurrio un error al registrar !');
                }
            }
        }

        return response()->json($data);
    }

    //para editar el cargo
    public function mae_unidad_editar(Request $request){
        try {
            $cargo = Unidad_mae::find($request->id);
            if($cargo){
                $data = mensaje_mostrar('success', $cargo);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al querer editar!');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al querer editar!');
        }
        return response()->json($data);
    }

    //para eliminar el cargo
    public function mae_unidad_eliminar(Request $request){
        try {
            $cargo = Unidad_mae::find($request->id);
            if($cargo->delete()){
                $data = mensaje_mostrar('success', 'Se elimino el cargo con exito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un problema al eliminar el registro');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema al eliminar el registro');
        }
        return response()->json($data);
    }
    /**
     * FIN PARA LA ADMINISTRACION DE LOS CARGOS
     */
}
