<?php

namespace App\Http\Controllers\Biometrico;

use App\Http\Controllers\Controller;
use App\Models\Biometrico\Feriado;
use App\Models\Fechas\Fecha_principal;
use App\Models\Fechas\Gestion;
use App\Models\Fechas\Mes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Controlador_feriado extends Controller
{
    /**
     * @version 1.0
     * @author  Graice Callizaya Chambi <graicecallizaya1234@gmail.com>
     * @param Controlador Administrar la parte de LA ADMINISTRACION DE FERIADOS
     * ¡Muchas gracias por preferirnos! Esperamos poder servirte nuevamente
     */

    //PARA LISTAR PARA INGRESAR A LOS PERMISOS
    public function  feriado()  {
        $data['menu']       = '16';
        $data['gestion']    = Gestion::get();
        $data['mes']        = Mes::OrderBy('id', 'asc')->get();
        return view('administrador.biometrico.feriado.feriado', $data);
    }
    //para el listado de las fechas
    public function lista_fechas(Request $request){
        $validar = Validator::make($request->all(), [
            'id_gestion'    => 'required',
            'id_mes'        => 'required',
        ]);

        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            $listar_fechas = Fecha_principal::with(['feriado'])->where('id_gestion', $request->id_gestion)
                                            ->where('id_mes', $request->id_mes)
                                            ->OrderBy('id','asc')
                                            ->get();
            $gestion = Gestion::find($request->id_gestion);
            $mes = Mes::find($request->id_mes);
            $data = array(
                'tipo'          =>  'success',
                'gestion'       =>  $gestion,
                'mes'           =>  $mes,
                'listar_fechas' =>  $listar_fechas
            );
        }
        return response()->json($data);
    }

    //para mostrar las fechas principal detalles
    public function mostrar_fecha_principal(Request $request){
        $fecha_principal = Fecha_principal::find($request->id);
        if($fecha_principal){
            $data = mensaje_mostrar('success', $fecha_principal);
        }else{
            $data = mensaje_mostrar('error', 'Ocurrio un error');
        }
        return response()->json($data);
    }

    //para guardar el feriado
    public function feriado_guardar(Request $request){
        $validar = Validator::make($request->all(), [
            'descripcion'    => 'required',
        ]);

        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            $feriado_nuevo                      = new Feriado();
            $feriado_nuevo->descripcion         = $request->descripcion;
            $feriado_nuevo->id_fecha_principal  = $request->id_fecha_principal;
            $feriado_nuevo->id_usuario          = Auth::user()->id;
            $feriado_nuevo->save();
            //para optener los datos para actualizar la tabla
            $fecha_principal = Fecha_principal::find($request->id_fecha_principal);

            if($feriado_nuevo->id){
                $data = array(
                    'tipo'              => 'success',
                    'mensaje'           => 'Se guardo el feriado con éxito',
                    'fecha_principal'   => $fecha_principal
                );
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error en el insertado de los datos');
            }
        }
        return response()->json($data);
    }

    //para editar el feriado
    public function feriado_editar(Request $request){
        $fecha_principal = Fecha_principal::with(['feriado'])->find($request->id);
        if($fecha_principal){
            $data = mensaje_mostrar('success', $fecha_principal);
        }else{
            $data = mensaje_mostrar('error', 'Ocurrio un error al editar el feriado');
        }
        return response()->json($data);
    }

    //para guardar el feriado editado
    public function  feriado_editar_guardar(Request $request){
        $validar = Validator::make($request->all(), [
            'descripcion_'    => 'required',
        ]);

        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            $feriado_editar                      = Feriado::find($request->id_feriado);
            $feriado_editar->descripcion         = $request->descripcion_;
            $feriado_editar->id_usuario          = Auth::user()->id;
            $feriado_editar->save();

            //para optener los datos para actualizar la tabla
            $fecha_principal = Fecha_principal::find($request->id_fecha_princ_edit);

            if($feriado_editar->id){
                $data = array(
                    'tipo'              => 'success',
                    'mensaje'           => 'Se edito el feriado con éxito',
                    'fecha_principal'   => $fecha_principal
                );
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error en editar los datos');
            }

        }
        return response()->json($data);
    }

    //para eliminar el registro de feriado si se equivoco
    public function  feriado_eliminar(Request $request){
        try {
            $fecha_principal = Fecha_principal::with(['feriado'])->find($request->id);
            $feriado = Feriado::find($fecha_principal->feriado->id);
            if($feriado->delete()){
                $data = array(
                    'tipo'              => 'success',
                    'mensaje'           => 'Se elimino el registro con éxito',
                    'fecha_principal'   => $fecha_principal
                );
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar los datos');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar los datos');
        }
        return response()->json($data);
    }
}
