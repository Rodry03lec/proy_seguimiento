<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuracion\Profesion;
use App\Models\Configuracion\Grado_academico;
use Illuminate\Support\Facades\Validator;
use App\Models\Configuracion\Ambito;


class Controlador_ambito_profesional extends Controller
{

    /**
     * @version 1.0
     * @author   Graice Callizaya Chambi <graicecallizaya1234@gmail.com>
     * @param Controlador Administrar la parte de AMBITO PROFESIONALES Y TODAS LAS PROFESIONES QUE EXISTE
     * ¡Muchas gracias por preferirnos! Esperamos poder servirte nuevamente
     */


    //para abrir el ambito profesional
    public function ambito_profesional(){
        $data['menu'] = '7';
        $data['lisambito_profesional'] = Ambito::OrderBy('id','desc')->get();
        return view('administrador.configuracion.profesion.ambito', $data);
    }

    //para guardar el ambito profesional
    public function ambito_profesional_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'nombre'        => 'required|unique:rl_ambito,nombre',
            'descripcion'   => 'required'
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $ambito                 = new Ambito();
            $ambito->nombre         = $request->nombre;
            $ambito->descripcion    = $request->descripcion;
            $ambito->save();
            if($ambito->id){
                $data = mensaje_mostrar('success', 'Se inserto con éxito el ámbito profesional');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al insertar !');
            }
        }
        return response()->json($data);
    }

    //para eliminar el registro de ambitos profesionales
    public function ambito_profesional_eliminar(Request $request){
        try {
            $ambito = Ambito::find($request->id);
            if($ambito->delete()){
                $data = mensaje_mostrar('success', 'Se realizo la eliminación del registro con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar el registro');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar el registro');
        }
        return response()->json($data);
    }

    //para editar el registro de ambito profesional
    public function ambito_profesional_editar(Request $request){
        try {
            $ambito = Ambito::find($request->id);
            if($ambito){
                $data = mensaje_mostrar('success', $ambito);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un problema al editar el registro');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema al editar el registro');
        }
        return response()->json($data);
    }

    //para guardar el ambito profesional editado
    public function ambito_profesional_editar_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'nombre_'        => 'required|unique:rl_ambito,nombre,'.$request->id_ambitoprofesional,
            'descripcion_'   => 'required'
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $ambito                 = Ambito::find($request->id_ambitoprofesional);
            $ambito->nombre         = $request->nombre_;
            $ambito->descripcion    = $request->descripcion_;
            $ambito->save();
            if($ambito->id){
                $data = mensaje_mostrar('success', 'Se editó con éxito el ámbito profesional');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar !');
            }
        }
        return response()->json($data);
    }


    /**
     * ESTA ES LA PARTE DONDE SE ADMINISTRA LAS PROFESIONES
     */
    public function profesiones($id){
        $id_descript = desencriptar($id);
        $data['menu'] = '7';
        $data['id_ambito'] = $id_descript;
        $data['ambito_profesional'] = Ambito::find($id_descript);
        return view('administrador.configuracion.profesion.profesiones', $data);
    }
    //para guardar la profesion
    public function profesiones_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'nombre'        => 'required|unique:rl_profesion,nombre'
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $profesion                 = new Profesion();
            $profesion->nombre         = $request->nombre;
            $profesion->estado         = 'activo';
            $profesion->id_ambito      = $request->id_ambito;
            $profesion->save();
            if($profesion->id){
                $data = mensaje_mostrar('success', 'Se creo la nueva profesion');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al crear !');
            }
        }
        return response()->json($data);
    }
    //para listar las profesiones
    public function profesiones_listar(Request $request){
        $profesion = Profesion::where('id_ambito', $request->id)->OrderBy('id','desc')->get();
        return response()->json($profesion);
    }
    //para eliminar la profesion
    public function profesiones_eliminar(Request $request){
        try {
            $profesion = Profesion::find($request->id);
            if($profesion->delete()){
                $data = mensaje_mostrar('success', 'Se elimino con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al elminar');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al elminar');
        }
        return response()->json($data);
    }
    //para realizar la edicion de las profesiones
    public function profesiones_editar(Request $request){
        try {
            $profesion = Profesion::find($request->id);
            if($profesion){
                $data = mensaje_mostrar('success', $profesion);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al editar');
        }
        return response()->json($data);
    }
    //para guardar lo editado
    public function profesiones_editar_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'nombre_'        => 'required|unique:rl_profesion,nombre,'.$request->id_profesion
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $profesion                 = Profesion::find($request->id_profesion);
            $profesion->nombre         = $request->nombre_;
            $profesion->save();
            if($profesion->id){
                $data = mensaje_mostrar('success', 'Se creo editó la profesion');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar !');
            }
        }
        return response()->json($data);
    }
    /**
     * FIN DE LA PARTE DE LA ADMINISTRACION DE LAS PROFESIONES
     */


    /**
     * PARA LA ADMINISTRACION DE LOS GRADOS PROFESIONALES
     */
    //para abrir el ambito profesional
    public function grado_academico(){
        $data['menu'] = '6';
        return view('administrador.configuracion.profesion.grado_academico', $data);
    }
    //para el guardar de los grados academicos
    public function grado_academico_guardar(Request $request) {
        $validar = Validator::make($request->all(),[
            'abreviatura' => 'required|unique:rl_grado_academico,abreviatura',
            'nombre'      => 'required|unique:rl_grado_academico,nombre'
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $grado_academico                = new Grado_academico();
            $grado_academico->abreviatura   = $request->abreviatura;
            $grado_academico->nombre        = $request->nombre;
            $grado_academico->estado        = 'activo';
            $grado_academico->save();
            if($grado_academico->id){
                $data = mensaje_mostrar('success', 'Se creo el grado académico con éxito ! ');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al guardar !');
            }
        }
        return response()->json($data);
    }
    //para listar los grados academicos
    public function grado_academico_listar(){
        $grado_academicos = Grado_academico::OrderBy('id','desc')->get();
        return response()->json($grado_academicos);
    }

    //para cambiar el estado  de los grados academicos
    public function grado_academico_estado(Request $request){
        try {
            $grado_academico = Grado_academico::find($request->id);
            $grado_academico->estado = ($grado_academico->estado == 'activo') ? 'inactivo' : 'activo';
            $grado_academico->save();
            if($grado_academico->id){
                $data = mensaje_mostrar('success', 'Se cambio el estado con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al cabiar el estado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al cabiar el estado');
        }
        return response()->json($data);
    }
    //para eliminar el registro de grados academicos
    public function grado_academico_eliminar(Request $request){
        try {
            $grado_academico                = Grado_academico::find($request->id);
            if($grado_academico->delete()){
                $data = mensaje_mostrar('success', 'Se elimino el registro con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar el registro ! ');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar el registro ! ');
        }
        return response()->json($data);
    }
    //para editar el registro de grados academicos
    public function grado_academico_editar(Request $request){
        try {
            $grado_academico = Grado_academico::find($request->id);
            if($grado_academico){
                $data = mensaje_mostrar('success', $grado_academico);
            }else{
                $data = mensaje_mostrar('error','Ocurrio un error al editar!');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error','Ocurrio un error al editar!');
        }
        return response()->json($data);
    }
    //para guardar lo editado del grado profesional
    public function grado_academico_edit_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'abreviatura_' => 'required|unique:rl_grado_academico,abreviatura,'.$request->id_grado_academico,
            'nombre_'      => 'required|unique:rl_grado_academico,nombre,'.$request->id_grado_academico,
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $grado_academico                = Grado_academico::find($request->id_grado_academico);
            $grado_academico->abreviatura   = $request->abreviatura_;
            $grado_academico->nombre        = $request->nombre_;
            $grado_academico->save();
            if($grado_academico->id){
                $data = mensaje_mostrar('success', 'Se editó el grado académico con éxito ! ');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al guardar lo editado !');
            }
        }
        return response()->json($data);
    }
    /**
     * FIN DE LA PARTE DE ADMINISTRACION DE GRADOS PROFESIONALES
     */
}
