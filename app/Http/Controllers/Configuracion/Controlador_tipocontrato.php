<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Configuracion\Tipo_contrato;
use App\Models\Configuracion\Tipo_categoria;
use App\Models\Configuracion\Nivel;

class Controlador_tipocontrato extends Controller
{
    /**
     * @version 1.0
     * @author  Graice Callizaya Chambi <graicecallizaya1234@gmail.com>
     * @param Controlador Administrar los TIPOS DE CONTRATO - TIPOS DE CATEGORIA - NIVELES GERARQUICOS
     * ¡Muchas gracias por preferirnos! Esperamos poder servirte nuevamente
     */

    /**
     * PARA LA ADMINISTRACION DE LOS TIPOS DE CONTRATO
     */
    private $menu_tipoconfiguracion = '4';

    public function tipoContrato(){
        $data['menu'] = 4;
        return view('administrador.configuracion.tipo_contrato', $data);
    }
    //para guardar el regisrto de el tipo de contrato
    public function tipocontrato_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'sigla'=>'required|unique:rl_tipo_contrato,sigla',
            'nombre'=>'required'
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $tipo_contrato = new Tipo_contrato();
            $tipo_contrato->sigla = $request->sigla;
            $tipo_contrato->nombre = $request->nombre;
            $tipo_contrato->estado = 'activo';
            $tipo_contrato->save();
            if($tipo_contrato->id){
                $data = mensaje_mostrar('success', 'Se inserto con éxito el tipo de contrato');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al insertar !');
            }
        }
        return response()->json($data);
    }
    //para listar el registr de tipos de contrato
    public function tipocontrato_listar(Request $request){
        $listar_tipocontrato =  Tipo_contrato::OrderBy('id', 'asc')->get();
        return response()->json($listar_tipocontrato);
    }
    //para eliminar el registro
    public function tipocontrato_eliminar(Request $request){
        try {
            $eliminar_registro = Tipo_contrato::find($request->id);
            if($eliminar_registro->delete()){
                $data = mensaje_mostrar('success', 'Se elimino con exito el registro');
            }else{
                $data = mensaje_mostrar('error','Ocurrio un problema al eliminar el registro');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error','Ocurrio un problema al eliminar el registro');
        }
        return response()->json($data);
    }
    //para editar el registro
    public function tipocontrato_editar(Request $request){
        try {
            $editar_registro = Tipo_contrato::find($request->id);
            if($editar_registro){
                $data = mensaje_mostrar('success', $editar_registro);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un  problema al editar!');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un  problema al editar!');
        }
        return response()->json($data);
    }
    //para guardar lo editado
    public function tipocontrato_editar_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'sigla_'=>'required|unique:rl_tipo_contrato,sigla,'.$request->id_tipocontrato,
            'nombre_'=>'required'
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $tipo_contrato = Tipo_contrato::find($request->id_tipocontrato);
            $tipo_contrato->sigla = $request->sigla_;
            $tipo_contrato->nombre = $request->nombre_;
            $tipo_contrato->save();
            if($tipo_contrato->id){
                $data = mensaje_mostrar('success', 'Se editó con éxito el tipo de contrato');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al insertar !');
            }
        }
        return response()->json($data);
    }
    /**
     * FIN PARA LA PARTE DE ADMINISTRACION DE LOS TIPOS DE CONTRATO
     */


    /**
     * PARA LA ADMINISTRACION DEL LOS TIPOS DE CATEGORIA
    */
    public function tipocategoria(){
        $data['menu'] = '5';
        return view('administrador.configuracion.tipo_categoria', $data);
    }
    //para guardar el tipo de categoria
    public function tipocategoria_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'nombre'=>'required|unique:rl_categoria,nombre'
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $tipo_contrato = new Tipo_categoria();
            $tipo_contrato->nombre = $request->nombre;
            $tipo_contrato->save();
            if($tipo_contrato->id){
                $data = mensaje_mostrar('success', 'Se inserto con éxito el tipo de categoría');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al insertar !');
            }
        }
        return response()->json($data);
    }
    //para listar el tipo de categoria
    public function tipocategoria_listar(Request $request){
        $tipo_categoria = Tipo_categoria::OrderBy('id', 'ASC')->get();
        return response()->json($tipo_categoria);
    }
    //para eliminar el tipo de categoria
    public function tipocategoria_eliminar(Request $request){
        try {
            $tipo_categoria = Tipo_categoria::find($request->id);
            if($tipo_categoria->delete()){
                $data = mensaje_mostrar('success', 'Se eliminó la categoría con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar el registro');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar el registro');
        }
        return response()->json($data);
    }
    //para editar el tipo de categoria
    public function tipocategoria_editar(Request $request){
        try {
            $tipo_categoria = Tipo_categoria::find($request->id);
            if($tipo_categoria){
                $data = mensaje_mostrar('success',$tipo_categoria);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar los datos');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al editar los datos');
        }
        return response()->json($data);
    }
    //para guardar el editado del tipo de categoria
    public function tipocategoria_editar_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'nombre_'=>'required|unique:rl_categoria,nombre,'.$request->id_tipocategoria
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $tipo_contrato = Tipo_categoria::find($request->id_tipocategoria);
            $tipo_contrato->nombre = $request->nombre_;
            $tipo_contrato->save();
            if($tipo_contrato->id){
                $data = mensaje_mostrar('success', 'Se edito con éxito el tipo de categoría');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar !');
            }
        }
        return response()->json($data);
    }
    /**
     * FIN PARA ADMINISTRAR LOS TIPOS DE CATEGORIA
     */

    /**
     * PARA LA ADMINISTRACION DE LOS TIPOS DE NIVEL
     */
    //para listar el tipo de nivel
    public function tiponivel_abrir(Request $request){
        try {
            $tipo_categoria = Tipo_categoria::find($request->id);
            if($tipo_categoria){
                $data = mensaje_mostrar('success', $tipo_categoria);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al mostrar los datos');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al mostrar los datos');
        }
        return response()->json($data);
    }
    //para listar todos lo sniveles segun pertenescan a una categoria
    public function nivel_lista(Request $request){
        $lista_nivel = Nivel::where('id_categoria', $request->id)->OrderBy('nivel','ASC')->get();
        return response()->json($lista_nivel);
    }

    //para crear un nuevo registro
    public function nivel_nuevo(Request $request){
        //primero para agregar por eso negamos
        if(!$request->id_nivel){
            $validar = Validator::make($request->all(),[
                'nivel'         => 'required',
                'descripcion'   => 'required|unique:rl_nivel,descripcion',
                'haber_basico'  => 'required',
            ]);
            if($validar->fails()){
                $data = mensaje_mostrar('errores', $validar->errors());
            }else{
                $nivel                = new Nivel();
                $nivel->nivel         = $request->nivel;
                $nivel->descripcion   = $request->descripcion;
                $nivel->haber_basico  = sin_separador_comas($request->haber_basico);
                $nivel->id_categoria  = $request->id_categoria;
                $nivel->save();
                if($nivel->id){
                    $data = mensaje_mostrar('success', 'Se inserto con éxito el nivel');
                }else{
                    $data = mensaje_mostrar('error', 'Ocurrio un error al insertar !');
                }
            }
        }else{
            $validar = Validator::make($request->all(),[
                'nivel'         => 'required',
                'descripcion'   => 'required|unique:rl_nivel,descripcion,'.$request->id_nivel,
                'haber_basico'  => 'required',
            ]);
            if($validar->fails()){
                $data = mensaje_mostrar('errores', $validar->errors());
            }else{
                $nivel                = Nivel::find($request->id_nivel);
                $nivel->nivel         = $request->nivel;
                $nivel->descripcion   = $request->descripcion;
                $nivel->haber_basico  = sin_separador_comas($request->haber_basico);
                $nivel->save();
                if($nivel->id){
                    $data = mensaje_mostrar('success', 'Se editó con éxito el nivel');
                }else{
                    $data = mensaje_mostrar('error', 'Ocurrio un error al insertar !');
                }
            }
        }
        return response()->json($data);
    }
    //para editar el registro
    public function nivel_editar(Request $request){
        try {
            $nivel = Nivel::find($request->id);
            if($nivel){
                $data = array(
                    'tipo'=>'success',
                    'id_nivel_edi'      => $nivel->id,
                    'nivel_edi'         => $nivel->nivel,
                    'descripcion_edi'   => $nivel->descripcion,
                    'haber_basico_edi'  => con_separador_comas($nivel->haber_basico)
                );
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al mostrar los datos');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al mostrar los datos');
        }
        return response()->json($data);
    }
    //para eliminar el registro
    public function nivel_eliminar(Request $request){
        try {
            $nivel = Nivel::find($request->id);
            if($nivel->delete()){
                $data = mensaje_mostrar('success','Se eliminó con éxito el registro');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar');
        }
        return response()->json($data);
    }
    /**
     * FIN PARA LA ADMINISTRACION DE LOS TIPOS DE NIVEL
     */
}
