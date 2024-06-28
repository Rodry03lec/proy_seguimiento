<?php

namespace App\Http\Controllers\Tramite;

use App\Http\Controllers\Controller;
use App\Models\Configuracion\Cargo_mae;
use App\Models\Configuracion\Cargo_sm;
use App\Models\Configuracion_tramite\Tipo_estado;
use App\Models\Configuracion_tramite\Tipo_tramite;
use App\Models\Configuracion_tramite\User_cargo_tramite;
use App\Models\Registro\Persona;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Psy\CodeCleaner\ReturnTypePass;

class Controlador_configuracion extends Controller
{
    /**
     * PARA LA PARTE DEL TIPO DE TRAMITE
        */
    public function tipo_tramite(){
        $data['menu'] = '50';
        return view('administrador.tramite.configuracion_tramite.tipo_tramite', $data);
    }

    //para listar tosos los tramitess
    public function tipo_tramite_listar(){
        $tipo_tramite = Tipo_tramite::OrderBy('id', 'asc')->get();
        return response()->json($tipo_tramite);
    }

    //para guardar nuevo tramite
    public function tipo_tramite_nuevo(Request $request){
        $validar = Validator::make($request->all(),[
            'nombre'        => 'required|unique:rl_tipo_tramite,nombre',
            'sigla'         => 'required'
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $nuevo_tipo_tramite             = new Tipo_tramite();
            $nuevo_tipo_tramite->nombre     = $request->nombre;
            $nuevo_tipo_tramite->sigla      = $request->sigla;
            $nuevo_tipo_tramite->estado     = true;
            $nuevo_tipo_tramite->save();
            if($nuevo_tipo_tramite->id){
                $data = mensaje_mostrar('success', 'Se inserto con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al insertar !');
            }
        }
        return response()->json($data);
    }

    //para cambiar el estados
    public function  tipotramite_estado(Request $request){
        try {
            $tipo_tramite = Tipo_tramite::find($request->id);
            $tipo_tramite->estado = ($tipo_tramite->estado == true) ? false : true;
            $tipo_tramite->save();
            if($tipo_tramite->id){
                $data = mensaje_mostrar('success', 'Se cambio el estado!');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado!');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado!');
        }
        return response()->json($data);
    }

    //para eliminar ele registros
    public function  tipotramite_eliminar(Request $request){
        try {
            $tipo_tramite = Tipo_tramite::find($request->id);
            if($tipo_tramite->delete()){
                $data = mensaje_mostrar('success', 'Se elimino con éxito!');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado!');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar!');
        }
        return response()->json($data);
    }

    //para editar el tipo de tramite
    public function tipotramite_editar(Request $request) {
        try {
            $tipo_tramite = Tipo_tramite::find($request->id);
            if($tipo_tramite){
                $data = mensaje_mostrar('success', $tipo_tramite);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un prblema al editar !');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un prblema al editar !');
        }
        return response()->json($data);
    }

    //para guardar el registro
    public function tipotramite_update(Request $request) {
        $validar = Validator::make($request->all(),[
            'nombre_'        => 'required|unique:rl_tipo_tramite,nombre,'.$request->id_tipotramite,
            'sigla_'         => 'required'
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $nuevo_tipo_tramite             = Tipo_tramite::find($request->id_tipotramite);
            $nuevo_tipo_tramite->nombre     = $request->nombre_;
            $nuevo_tipo_tramite->sigla      = $request->sigla_;
            $nuevo_tipo_tramite->save();
            if($nuevo_tipo_tramite->id){
                $data = mensaje_mostrar('success', 'Se editó con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar !');
            }
        }
        return response()->json($data);
    }

    /**
      * FIN DE LA PARTE DEL TIPO DE TRAMITE
    */


    /**
     * PARA LA PARTE DE LA ADMINISTRACION DEL LOS ESTADOS
     */
    public function tipo_estado_tramite(){
        $data['menu'] = '51';
        return view('administrador.tramite.configuracion_tramite.tipo_estado', $data);
    }
    //para el listado de los registross
    public function  tipo_estado_listar(){
        $tipo_estado = Tipo_estado::OrderBy('id', 'desc')->get();
        return response()->json($tipo_estado);
    }

    //para guardar el registro
    public function  tipo_estado_nuevo(Request $request){
        $validar = Validator::make($request->all(),[
            'color'        => 'required|unique:rl_tipo_estado,color',
            'nombre'         => 'required|unique:rl_tipo_estado,nombre'
        ]);

        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $tipo_estado             = new Tipo_estado();
            $tipo_estado->nombre     = $request->nombre;
            $tipo_estado->color      = $request->color;
            $tipo_estado->save();
            if($tipo_estado->id){
                $data = mensaje_mostrar('success', 'Se inserto con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al insertar !');
            }
        }
        return response()->json($data);

    }

    //para eliminar el registro
    public function tipo_estado_eliminar(Request $request){
        try {
            $tipo_estado = Tipo_estado::find($request->id);
            if($tipo_estado->delete()){
                $data = mensaje_mostrar('success', 'Se elimino el registro con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un problema al eliminar !');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema al eliminar !');
        }
        return response()->json($data);
    }

    //para la edicion del registro
    public function tipo_estado_editar(Request $request){
        try {
            $tipo_estado = Tipo_estado::find($request->id);
            if($tipo_estado){
                $data = mensaje_mostrar('success', $tipo_estado);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un problema al editar');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema al editar');
        }
        return response()->json($data);
    }

    //para guardar lo editado
    public function tipo_estado_update(Request $request){
        $validar = Validator::make($request->all(),[
            'color_'        => 'required|unique:rl_tipo_estado,color,'.$request->id_tipoestado,
            'nombre_'         => 'required|unique:rl_tipo_estado,nombre,'.$request->id_tipoestado
        ]);

        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $tipo_estado             = Tipo_estado::find($request->id_tipoestado);
            $tipo_estado->nombre     = $request->nombre_;
            $tipo_estado->color      = $request->color_;
            $tipo_estado->save();
            if($tipo_estado->id){
                $data = mensaje_mostrar('success', 'Se editó con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar !');
            }
        }
        return response()->json($data);
    }

    /**
     * FIN DE LA PARTE DE ADMINISTRACION DE LOS ESTADOS
     */


    /**ñl
     * PARA LA ADMINISTRACION DEL HABILITAR EL TRAMITE
    */
    public function habilitar_a_tramite(){
        $data['menu'] = '52';
        return view('administrador.tramite.configuracion_tramite.habilitar_persona_tramite', $data);
    }

    //para listar la parte de los usuarios
    public function  habilitar_a_tramite_listar(){
        $usuarios = User::with(['user_cargo_tramite'=>function($userCargo){
            $userCargo->with(['cargo_sm', 'cargo_mae', 'contrato', 'usuario']);
        }])
                    ->where('id', '!=', 1)
                    ->where('estado', 'activo')
                    ->where('deleted_at', null)
                    ->OrderBy('id','desc')
                    ->get();
        return response()->json($usuarios);
    }

    //para la administracion de que si esta o no
    public function  habilitar_a_tramite_validar(Request $request){
        try {
            $usuario = User::find($request->id);
            $persona = Persona::with(['contrato'])->where('ci', $usuario->ci)->first();
            if($persona->contrato && $persona->contrato[0]->estado == 'activo'){
                $data = array(
                    'tipo'      => 'success',
                    'persona'   => $persona,
                    'contrato'  => $persona->contrato[0],
                    'usuario'   => $usuario
                );
            }else{
                $data = mensaje_mostrar('error', 'Registre nuevo contrato o no tiene contrato vigente');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Registre nuevo contrato o no tiene contrato vigente');
        }
        return response()->json($data);
    }

    //para registrar par los tramites
    public function habilitar_a_tramite_habilita(Request $request){
        $validar = Validator::make($request->all(),[
            'id_contrato'   =>  'required',
            'id_persona'    =>  'required',
            'id_usuario'    =>  'required'
        ]);

        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $user_cargo_tramite                 = new User_cargo_tramite();
            $user_cargo_tramite->id_cargo_sm    = $request->id_cargo_sm;
            $user_cargo_tramite->id_cargo_mae   = $request->id_cargo_mae;
            $user_cargo_tramite->id_contrato    = $request->id_contrato;
            $user_cargo_tramite->id_persona     = $request->id_persona;
            $user_cargo_tramite->id_usuario     = $request->id_usuario;
            $user_cargo_tramite->save();
            if($user_cargo_tramite->id){
                $data = mensaje_mostrar('success', 'Se habilito el cargo con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al insertar !');
            }
        }
        return response()->json($data);
    }


    //para vizualizar los cargos que va tener un usuario
    public function habilitar_a_tramite_vizualiza(Request $request){
        try {
            $usuario = User::with(['user_cargo_tramite'=>function($uct){
                $uct->with(['cargo_sm', 'cargo_mae', 'contrato', 'usuario']);
                $uct->OrderBy('id', 'asc');
            }])->find($request->id);
            $usuario_tramite = $usuario->user_cargo_tramite[0];
            $usuario_listar = $usuario->user_cargo_tramite;
            $data = [
                'tipo'              => 'success',
                'usuario_tramite'   => $usuario_tramite,
                'usuario_listar'    => $usuario_listar,
            ];
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Error al svizualizar los cargos');
        }
        return response()->json($data);
    }

    //para listar todo los que tienen cargo
    public function  habilitar_a_tramite_vizualiza_listar(Request $request){
        $usuario_listar_cargos = User_cargo_tramite::with(['cargo_sm', 'cargo_mae', 'contrato', 'usuario'])
            ->where('id_usuario', $request->id_usuario)
            ->where('id_contrato', $request->id_contrato)
            ->OrderBy('id', 'desc')
            ->get();
        return response()->json($usuario_listar_cargos);
    }


    //para el guardado de los cargos que estan pendientes
    public function habilitar_a_tramite_vizualiza_nuevo(Request $request) {
        try {
            $validar = Validator::make($request->all(),[
                'nombre'   =>  'required',
            ]);

            if($validar->fails()){
                $data = mensaje_mostrar('errores', $validar->errors());
            }else{
                //declaramos varables nulas
                $id_cargo_primero = null;
                $id_cargo_segundo = null;
                //consultamos primero de cargo_sm
                if($request->id_cargo_sm != null && $request->id_cargo_sm != ''){
                    $cargos_sm = Cargo_sm::find($request->id_cargo_sm);
                    //creamos el nuevo cargo
                    $new_cargo_sm                  = new Cargo_sm();
                    $new_cargo_sm->nombre          = $request->nombre;
                    $new_cargo_sm->id_direccion    = $cargos_sm->id_direccion;
                    $new_cargo_sm->id_unidad       = $cargos_sm->id_unidad;
                    $new_cargo_sm->save();
                    $id_cargo_primero = $new_cargo_sm->id;
                }
                //conusltamos del cargo_mae
                if($request->id_cargo_mae != null && $request->id_cargo_mae != ''){
                    $cargos_mae = Cargo_mae::find($request->id_cargo_mae);
                    //se debe crear primero el nuevo cargo a lo mismo
                    $new_cargos_mae                 = new Cargo_mae();
                    $new_cargos_mae->nombre         = $request->nombre;
                    $new_cargos_mae->id_unidad      = $cargos_mae->id_unidad;
                    $new_cargos_mae->save();
                    $id_cargo_segundo = $new_cargos_mae->id;
                }

                //aqui creamos un nuevo User_cargo_tramite OK
                $user_cargo_tramite                 = new User_cargo_tramite();
                $user_cargo_tramite->id_cargo_sm    = $id_cargo_primero;
                $user_cargo_tramite->id_cargo_mae   = $id_cargo_segundo;
                $user_cargo_tramite->id_contrato    = $request->id_contrato;
                $user_cargo_tramite->id_persona     = $request->id_persona;
                $user_cargo_tramite->id_usuario     = $request->id_usuario;
                $user_cargo_tramite->save();
                if($user_cargo_tramite->id){
                    $data = [
                        'tipo'              => 'success',
                        'mensaje'           => 'Se creo el cargo con éxito',
                        'id_contrato_lis'   => $request->id_contrato,
                        'id_usuario_lis'    => $request->id_usuario,
                    ];
                }else{
                    $data = mensaje_mostrar('error', 'Ocurrio un error al insertar !');
                }
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error! verifique');
        }

        return response()->json($data);
    }

    //para cambiar del cargo
    public function habilitar_a_tramite_vizualiza_estado(Request $request){
        try {
            $tipo_cargo_usuario = User_cargo_tramite::find($request->id);
            $tipo_cargo_usuario->estado = ($tipo_cargo_usuario->estado==true)? false : true;
            $tipo_cargo_usuario->save();
            if($tipo_cargo_usuario->id){
                $data = [
                    'tipo'      => 'success',
                    'mensaje'   => 'Se guardo con exito el registro!',
                    'id_usu'    => $request->id_usuario,
                    'id_contra' => $request->id_contrato,
                ];
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado');
        }
        return response()->json($data);
    }

    //para la edicion del registro
    public function  habilitar_a_tramite_vizualiza_eliminar(Request $request){
        try {
            $user_cargo_tramite = User_cargo_tramite::with(['cargo_sm', 'cargo_mae'])->find($request->id);

            if($user_cargo_tramite->delete()){
                $data = mensaje_mostrar('success', 'Se elimino el registro con éxito!');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error');
        }
        return response()->json($data);
    }
    /**
     * FIN DE LA ADMINISTRACION DE HABILITAR EL TRAMITE
     */
}
