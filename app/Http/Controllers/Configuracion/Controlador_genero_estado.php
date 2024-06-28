<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Configuracion\Estado_civil;
use App\Models\Configuracion\Genero;

class Controlador_genero_estado extends Controller
{
    /**
     * @version 1.0
     * @author  Graice Callizaya Chambi <graicecallizaya1234@gmail.com>
     * @param Controlador Administrar la parte de EL GENERO Y EL ESTADO CIVL DE CADA PERSONA
     * ¡Muchas gracias por preferirnos! Esperamos poder servirte nuevamente
     */

    public function genero_estado(){
        $data['menu'] = '12';
        return view('administrador.configuracion.genero_estado', $data);
    }

    /**
     * PARA LA ADMINISTRACION DE LOS GENEROS
     */
    //para listar los generos
    public function genero_listar(){
        $genero = Genero::OrderBy('id', 'asc')->get();
        return response()->json($genero);
    }
    //para guardar los generos
    public function genero_nuevo(Request $request){
        $validar = Validator::make($request->all(),[
            'sigla'     => 'required',
            'nombre'    => 'required|unique:rl_genero,nombre',
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $genero         = new Genero();
            $genero->sigla  = $request->sigla;
            $genero->nombre = $request->nombre;
            $genero->estado = 'activo';
            $genero->save();
            if($genero->id){
                $data = mensaje_mostrar('success', 'Se inserto con éxito genero');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al insertar !');
            }
        }
        return response()->json($data);
    }
    //para eliminar los generos
    public function genero_eliminar(Request $request){
        try {
            $genero = Genero::find($request->id);
            if($genero->delete()){
                $data = mensaje_mostrar('success', 'Se elimino el genero con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error eliminar!');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error eliminar!');
        }
        return response()->json($data);
    }
    //para cambiar el estado de los generos
    public function genero_estados(Request $request){
        try {
            $genero = Genero::find($request->id);
            $genero->estado = ($genero->estado == 'activo') ? 'inactivo' : 'activo';
            $genero->save();
            if($genero->id){
                $data = mensaje_mostrar('success','Se cambio el estado con éxito ! ');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado');
        }
        return response()->json($data);
    }
    //para editar los generos
    public function genero_editar(Request $request){
        try {
            $genero = Genero::find($request->id);
            if($genero){
                $data = mensaje_mostrar('success', $genero);
            }else{
                $data = mensaje_mostrar('error', 'Ocurio un problema al editar !');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurio un problema al editar !');
        }
        return response()->json($data, 200);
    }
    //para guardar lo editado
    public function genero_editar_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'sigla_'     => 'required',
            'nombre_'    => 'required|unique:rl_genero,nombre,'.$request->id_genero,
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $genero         = Genero::find($request->id_genero);
            $genero->sigla  = $request->sigla_;
            $genero->nombre = $request->nombre_;
            $genero->estado = 'activo';
            $genero->save();
            if($genero->id){
                $data = mensaje_mostrar('success', 'Se editó con éxito genero');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar !');
            }
        }
        return response()->json($data);
    }
    /**
     * FIN PARA LA ADMINISTRACION DE LOS GENEROS
     */




    /**
     * PARA LA ADMINISTRACION DE LOS ESTADOS CIVILES
     */
    public function estado_civil_listar(){
        $estado_civil = Estado_civil::OrderBy('id','asc')->get();
        return response()->json($estado_civil);
    }
    //para guardar el estado civil
    public function estado_civil_nuevo(Request $request){
        $validar = Validator::make($request->all(),[
            'nombre__'    => 'required|unique:rl_estado_civil,nombre',
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $estado_civil         = new Estado_civil();
            $estado_civil->nombre = $request->nombre__;
            $estado_civil->estado = 'activo';
            $estado_civil->save();
            if($estado_civil->id){
                $data = mensaje_mostrar('success', 'Se inserto con éxito estado civil');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al insertar !');
            }
        }
        return response()->json($data);
    }
    //para eliminar el estado civil
    public function estado_civil_eliminar(Request $request) {
        try {
            $estado_civil = Estado_civil::find($request->id);
            if($estado_civil->delete()){
                $data = mensaje_mostrar('success', 'Se elimino el estado civil con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error eliminar!');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error eliminar!');
        }
        return response()->json($data);
    }
    //para cambiar el estado de estado civil
    public function estado_civil_estado(Request $request){
        try {
            $estado_civil = Estado_civil::find($request->id);
            $estado_civil->estado = ($estado_civil->estado == 'activo') ? 'inactivo' : 'activo';
            $estado_civil->save();
            if($estado_civil->id){
                $data = mensaje_mostrar('success','Se cambio el estado con éxito ! ');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado');
        }
        return response()->json($data);
    }

    //para editar el estado civil
    public function estado_civil_editar(Request $request){
        try {
            $estado_civil = Estado_civil::find($request->id);
            if($estado_civil){
                $data = mensaje_mostrar('success', $estado_civil);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar los datos');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al editar los datos');
        }
        return response()->json($data);
    }
    //para guardar lo editado
    public function estado_civil_editar_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'nombre___'    => 'required|unique:rl_estado_civil,nombre,'.$request->id_estado_civil,
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $estado_civil         = Estado_civil::find($request->id_estado_civil);
            $estado_civil->nombre = $request->nombre___;
            $estado_civil->save();
            if($estado_civil->id){
                $data = mensaje_mostrar('success', 'Se editó con éxito estado civil');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al insertar !');
            }
        }
        return response()->json($data);
    }

    /**
     * FIN DE LA ADMINISTRACION DE LOS ESTADOS CIVILES
     */
}
