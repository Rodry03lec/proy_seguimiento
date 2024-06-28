<?php

namespace App\Http\Controllers\Biometrico;

use App\Http\Controllers\Controller;
use App\Models\Biometrico\Licencia\Licencia;
use App\Models\Biometrico\Licencia\Tipo_licencia;
use App\Models\Biometrico\Permiso\Desglose_permiso;
use App\Models\Biometrico\Permiso\Permiso;
use App\Models\Biometrico\Permiso\Tipo_permiso;
use Illuminate\Support\Facades\Validator;
use App\Models\Registro\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Controlador_boleta extends Controller
{
    /**
     * @version 1.0
     * @author  Graice Callizaya Chambi <graicecallizaya1234@gmail.com>
     * @param Controlador ADMINISTRACION DE GENERAR BOLETAS
     * ¡Muchas gracias por preferirnos! Esperamos poder servirte nuevamente
     */

    /**
     * PARA LA ADMINISTRACION DE GENERAR BOLETA
     */
    public function boleta(){
        $data['menu'] = '18';
        return view('administrador.biometrico.boletas.boletas', $data);
    }
    /**
     * FIN DE LA ADMINISTRACION DE GENERAR BOLETA
     */


    /**
     * PARA LA ADMINISTRACION DE GENERAR PERMISOS
    */

    public function  buscarPersona(Request $request){
        $query = $request->input('q');
        $personas = Persona::where('nombres', 'LIKE', "%$query%")
                            ->orWhere('ci', 'LIKE', "%$query%")
                            ->orWhere('ap_paterno', 'LIKE', "%$query%")
                            ->orWhere('ap_materno', 'LIKE', "%$query%")
                            ->get();

        return response()->json($personas);
    }


    public function boleta_permiso(){
        $data['menu'] = '18';
        $data['tipo_permiso'] = Tipo_permiso::where('estado', 'activo')->OrderBy('id', 'asc')->get();
        $data['personas'] = Persona::where('estado', 'activo')->OrderBy('id', 'asc')->get();
        return view('administrador.biometrico.boletas.boleta_permiso', $data);
    }


     //para la busqueda de la persona con por ci
    public function persona_ci(Request $request){
        // Consulta la persona con contratos activos
        $persona = Persona::with(['contrato' => function ($query) {
            $query->where('estado', 'activo');
        }])->where('ci', $request->ci)->first();

        // Inicializa un arreglo para almacenar los resultados
        $resultados = [];

        // Verifica si se encontró la persona
        if ($persona) {
            // Verifica si la persona tiene contratos activos
            if (!$persona->contrato->isEmpty()) {
                // Si tiene contratos activos, agrega la información al arreglo de resultados
                foreach ($persona->contrato as $contrato) {
                    $resultados[] = [
                        'persona'       => $persona,
                        'id_persona'    => $persona->id,
                        'id_contrato'   => $contrato->id
                    ];
                }
                // Devuelve un mensaje de éxito con los datos
                $data = mensaje_mostrar('success', $resultados);
            } else {
                // Si el arreglo de resultados está vacío, devuelve un mensaje indicando que no se encontraron contratos activos
                $data = [
                    'tipo'      => 'error',
                    'mensaje'   => 'No se encontraron contratos activos para la persona',
                    'persona_per'   => $persona
                ];
            }
        } else {
            // Si no se encontró la persona, devuelve un mensaje de error
            $data = mensaje_mostrar('error', 'No existe la persona registrada');
        }

        // Devuelve la respuesta en formato JSON
        return response()->json($data, 200);

    }

    public function boleta_per_desglose(Request $request){
        $desglose_permiso = Desglose_permiso::where('id_tipo_permiso', $request->id)->get();
        return response()->json($desglose_permiso);
    }

    //para guardar el permiso generado
    public function permiso_boleta_guardar(Request $request){
        $validar = Validator::make($request->all(), [
            'tipo_permiso'          => 'required',
            'desglose_permiso'      => 'required',
            'fecha_inicio'          => 'required|date',
            'hora_inicio'           => 'required',
            'fecha_final'           => 'required|date',
            'hora_final'            => 'required',
            'descripcion'           => 'required',
        ]);

        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            //antes de realziar el guardado preguntamos si la fecha inicial es distinto a todo lo que existe registrado
            $listar_permisos = Permiso::where('id_persona', $request->id_persona)
                ->where(function($query) use ($request) {
                    $query->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_final])
                        ->orWhereBetween('fecha_final', [$request->fecha_inicio, $request->fecha_final])
                        ->orWhere(function($q) use ($request) {
                            $q->where('fecha_inicio', '<', $request->fecha_inicio)
                                ->where('fecha_final', '>', $request->fecha_final);
                        });
                })
                ->get();
            $cont = $listar_permisos->isEmpty() ? 0 : 1;
            if($cont==0){
                $permiso                = new Permiso();
                $permiso->fecha         = date('Y-m-d');
                $permiso->descripcion   = $request->descripcion;
                $permiso->fecha_inicio  = $request->fecha_inicio;
                $permiso->fecha_final   = $request->fecha_final;
                $permiso->hora_inicio   = $request->hora_inicio;
                $permiso->hora_final    = $request->hora_final;
                $permiso->aprobado      = 1;
                $permiso->constancia    = 0;
                $permiso->id_permiso_desglose = $request->desglose_permiso;
                $permiso->id_us_create  = Auth::user()->id;
                $permiso->id_persona    = $request->id_persona;
                $permiso->id_contrato   = $request->id_contrato;
                $permiso->save();
                if($permiso->id){
                    $data = array(
                        'tipo'              => 'success',
                        'mensaje'           => 'Se guardo con exito el registro!',
                        'id_persona'        => $request->id_persona,
                        'id_permiso_new'    => $permiso->id
                    );
                }else{
                    $data = array(
                        'tipo'              => 'error',
                        'mensaje'           => 'Ocurrio un error imprevisto en el guardado!',
                        'id_persona_edi'    => $request->id_persona,
                    );
                }
            }else{
                $data = array(
                    'tipo'              => 'error',
                    'mensaje'           => 'Ya se existe un registro con esa fecha',
                    'id_persona_edi'    => $request->id_persona,
                );
            }
        }
        return response()->json($data);
    }

    //para aprobar el permiso
    public function permiso_boleta_aprobar(Request $request){
        try {
            $permiso                = Permiso::find($request->id);
            $permiso->aprobado      = ($permiso->aprobado == 1) ? 0 : 1;
            $permiso->id_us_update  = Auth::user()->id;
            $permiso->save();
            if($permiso->id){
                $data = array(
                    'tipo'          => 'success',
                    'mensaje'       => 'Se cambio el estado de aprobado con éxito',
                    'id_persona'    => $permiso->id_persona
                );
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado de aprobado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema al cambiar');
        }
        return response()->json($data);
    }

    //para aprobar la constancia
    public function permiso_boleta_constancia(Request $request) {
        try {
            $permiso                = Permiso::find($request->id);
            $permiso->constancia    = ($permiso->constancia == 1) ? 0 : 1;
            $permiso->id_us_update  = Auth::user()->id;
            $permiso->save();
            if($permiso->id){
                $data = array(
                    'tipo'          => 'success',
                    'mensaje'       => 'Se cambio el estado de aprobado con éxito',
                    'id_persona'    => $permiso->id_persona
                );
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado de aprobado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema al cambiar');
        }
        return response()->json($data);
    }

    //para listar todas las boletas-permisos generadas
    public function permiso_boleta_listar(Request $request){
        $permiso_boleta_listar = Permiso::where('id_persona', $request->id)->OrderBy('fecha_inicio', 'desc')->get();
        if(!$permiso_boleta_listar->isEmpty()){
            $data  = mensaje_mostrar('success', $permiso_boleta_listar);
        }else{
            $data = mensaje_mostrar('error', 'La lista esta vacia');
        }
        return response()->json($data);
    }

    //para editar el registro del permiso
    public function permiso_boleta_editar(Request $request){
        try {
            $permiso = Permiso::with(['permiso_desglose'])->find($request->id);
            if($permiso){
                $desglose_permiso = Desglose_permiso::where('id_tipo_permiso', $permiso->permiso_desglose->id_tipo_permiso)->get();
                $data = mensaje_mostrar('success', $permiso);
                $data = array(
                    'tipo'              => 'success',
                    'mensaje'           => $permiso,
                    'desglose_permiso'  => $desglose_permiso
                );
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un problema al editar');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema al editar');
        }
        return response()->json($data);
    }

    //para guardar lo editado
    public function permiso_boleta_editar_save(Request $request){
        $validar = Validator::make($request->all(), [
            'tipo_permiso_'          => 'required',
            'desglose_permiso_'      => 'required',
            'fecha_inicio_'          => 'required|date',
            'hora_inicio_'           => 'required',
            'fecha_final_'           => 'required|date',
            'hora_final_'            => 'required',
            'descripcion_'           => 'required',
            'fecha_creada'           => 'required',
        ]);

        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            $listar_permisos = Permiso::where('id_persona', $request->id_persona_edi)
            ->where('id', '!=', $request->id_permiso)
            ->where(function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->whereBetween('fecha_inicio', [$request->fecha_inicio_, $request->fecha_final_])
                        ->orWhereBetween('fecha_final', [$request->fecha_inicio_, $request->fecha_final_]);
                })
                ->orWhere(function($q) use ($request) {
                    $q->where('fecha_inicio', '<', $request->fecha_inicio_)
                        ->where('fecha_final', '>', $request->fecha_final_);
                });
            })
            ->get();

            $cont = $listar_permisos->isEmpty() ? 0 : 1;

            if ($cont == 0) {
                $permiso = Permiso::find($request->id_permiso);
                $permiso->fecha                 = $request->fecha_creada;
                $permiso->descripcion           = $request->descripcion_;
                $permiso->fecha_inicio          = $request->fecha_inicio_;
                $permiso->fecha_final           = $request->fecha_final_;
                $permiso->hora_inicio           = $request->hora_inicio_;
                $permiso->hora_final            = $request->hora_final_;
                $permiso->id_permiso_desglose   = $request->desglose_permiso_;
                $permiso->id_us_update          = Auth::user()->id;
                $permiso->save();

                if ($permiso->id) {
                    $data = [
                        'tipo'          => 'success',
                        'mensaje'       => 'Se editó con éxito el registro!',
                        'id_persona'    => $permiso->id_persona,
                    ];
                } else {
                    $data = [
                        'tipo'              => 'error',
                        'mensaje'           => 'Ocurrió un error imprevisto al editar!',
                        'id_persona_edi'    => $permiso->id_persona,
                    ];
                }
            } else {
                $data = [
                    'tipo'              => 'error',
                    'mensaje'           => 'Ya existe un registro con esa fecha',
                    'id_persona_edi'    => $request->id_persona_edi,
                ];
            }
        }
        return response()->json($data);
    }


    //para vizualizar los detalles de las boletas de los permisos
    public function  permiso_boleta_vizualizar(Request $request){
        $data['permiso'] = Permiso::with(['permiso_desglose'=>function($pd){
            $pd->with(['tipo_permiso']);
        },'usuario_creado','usuario_editado','persona', 'contrato'=>function($co){
            $co->with(['tipo_contrato']);
        }])
        ->find($request->id);
        return view('administrador.biometrico.boletas.vizualizar_permiso', $data);
    }

    //para eliminar el registro del permiso
    public function permiso_boleta_eliminar(Request $request){
        try {
            $permiso = Permiso::find($request->id);
            $id_persona = $permiso->id_persona;
            if($permiso->delete()){
                $data = array(
                    'tipo'      => 'success',
                    'mensaje'   => 'Se elimino con exito el registro',
                    'id_persona'=>$id_persona
                );
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar el registro');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar el registro');
        }
        return response()->json($data);
    }
    /**
     * FIN DE LA ADMINISTRACIO DE GENERAR LOS PERMISOS
     */


    /**
     * PARA LA ADMINISTRACION DE GENERAR LAS LICENCIASS
     */
    public function boleta_licencia(){
        $data['menu'] = '18';
        $data['licencias'] = Tipo_licencia::where('estado', 'activo')
                                        ->OrderBy('id', 'desc')
                                        ->get();
        $data['personas'] = Persona::where('estado', 'activo')->OrderBy('id', 'asc')->get();
        return view('administrador.biometrico.boletas.boleta_licencia', $data);
    }

    //para listar la licencia
    public function boleta_licencia_listar(Request $request){
        $licencias_listar = Licencia::with(['tipo_licencia'])->where('id_persona', $request->id )->OrderBy('id', 'desc')->get();
        if(!$licencias_listar->isEmpty()){
            $data  = mensaje_mostrar('success', $licencias_listar);
        }else{
            $data = mensaje_mostrar('error', 'La lista esta vacia');
        }
        return response()->json($data);
    }

    //para guardar la licencia generar nuevo
    public function boleta_licencia_guardar(Request $request){
        $validar = Validator::make($request->all(), [
            'licencia'          => 'required',
            'fecha_inicio'      => 'required|date',
            'hora_inicio'          => 'required',
            'fecha_final'           => 'required|date',
            'hora_final'           => 'required',
        ]);
        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            //antes de realziar el guardado preguntamos si la fecha inicial es distinto a todo lo que existe registrado
            $listar_licencia = Licencia::where('id_persona', $request->id_persona)
                ->where(function($query) use ($request) {
                    $query->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_final])
                        ->orWhereBetween('fecha_final', [$request->fecha_inicio, $request->fecha_final])
                        ->orWhere(function($q) use ($request) {
                            $q->where('fecha_inicio', '<', $request->fecha_inicio)
                                ->where('fecha_final', '>', $request->fecha_final);
                        });
                })
                ->get();
            $cont = $listar_licencia->isEmpty() ? 0 : 1;
            if($cont==0){
                $licencia                   = new Licencia();
                $licencia->fecha            = date('Y-m-d');
                $licencia->descripcion      = $request->descripcion;
                $licencia->fecha_inicio     = $request->fecha_inicio;
                $licencia->fecha_final      = $request->fecha_final;
                $licencia->hora_inicio      = $request->hora_inicio;
                $licencia->hora_final       = $request->hora_final;
                $licencia->aprobado         = 1;
                $licencia->constancia       = 0;
                $licencia->id_tipo_licencia = $request->licencia;
                $licencia->id_us_create     = Auth::user()->id;
                $licencia->id_persona       = $request->id_persona;
                $licencia->id_contrato      = $request->id_contrato;
                $licencia->save();
                if($licencia->id){
                    $data = array(
                        'tipo'          => 'success',
                        'mensaje'       => 'Se guardo con exito el registro!',
                        'id_persona'    => $request->id_persona,
                        'id_licencia_id'=> $licencia->id
                    );
                }else{
                    $data = array(
                        'tipo'              => 'error',
                        'mensaje'           => 'Ocurrio un error imprevisto en el guardado!',
                        'id_persona_edi'    => $request->id_persona,
                    );
                }
            }else{
                $data = array(
                    'tipo'              => 'error',
                    'mensaje'           => 'Ya se existe un registro con esa fecha',
                    'id_persona_edi'    => $request->id_persona,
                );
            }
        }
        return response()->json($data);
    }

    //para cambiar el estado de aprobado o no
    public function boleta_licencia_aprobado(Request $request) {
        try {
            $licencia                = Licencia::find($request->id);
            $licencia->aprobado      = ($licencia->aprobado == 1) ? 0 : 1;
            $licencia->id_us_update  = Auth::user()->id;
            $licencia->save();
            if($licencia->id){
                $data = array(
                    'tipo'          => 'success',
                    'mensaje'       => 'Se cambio el estado de aprobado con éxito',
                    'id_persona'    => $licencia->id_persona
                );
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado de aprobado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema al cambiar');
        }
        return response()->json($data);
    }

    //para aprobar la constancia
    public function boleta_licencia_constancia(Request $request){
        try {
            $licencia                = Licencia::find($request->id);
            $licencia->constancia    = ($licencia->constancia == 1) ? 0 : 1;
            $licencia->id_us_update  = Auth::user()->id;
            $licencia->save();
            if($licencia->id){
                $data = array(
                    'tipo'          => 'success',
                    'mensaje'       => 'Se cambio el estado de aprobado con éxito',
                    'id_persona'    => $licencia->id_persona
                );
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al cambiar el estado de licencia');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema al cambiar');
        }
        return response()->json($data);
    }

    //para vizualizar todo
    public function  boleta_licencia_vizualizar(Request $request){
        $data['licencia'] = Licencia::with(['tipo_licencia','usuario_creado','usuario_editado','persona', 'contrato'=>function($co){
            $co->with(['tipo_contrato']);
        }])
        ->find($request->id);
        return view('administrador.biometrico.boletas.vizualizar_licencia', $data);
    }

    //para la eliminacion de registro de la boleta-licencia
    public function boleta_licencia_eliminar(Request $request){
        try {
            $licencia = Licencia::find($request->id);
            $id_persona = $licencia->id_persona;
            if($licencia->delete()){
                $data = array(
                    'tipo'          => 'success',
                    'mensaje'       => 'Se elimino con exito el registro',
                    'id_persona'    => $id_persona
                );
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar el registro');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema al eliminar!');
        }
        return response()->json($data);
    }

    //para editar el registro
    public function  boleta_licencia_edit(Request $request){
        try {
            $licencia = Licencia::with(['tipo_licencia','usuario_creado','usuario_editado','persona', 'contrato'=>function($co){
                $co->with(['tipo_contrato']);
            }])
            ->find($request->id);
            if($licencia){
                $data = mensaje_mostrar('success', $licencia);
            }else{
                $data = mensaje_mostrar('error', 'Se elimino el registro con éxito');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Se elimino el registro con éxito');
        }
        return response()->json($data);
    }

    //para guardar lo editado
    public function boleta_licencia_editar(Request $request){
        $validar = Validator::make($request->all(), [
            'licencia_'             => 'required',
            'fecha_inicio_'         => 'required|date',
            'hora_inicio_'          => 'required',
            'fecha_final_'          => 'required|date',
            'hora_final_'           => 'required',
        ]);
        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        } else {
            //antes de realziar el guardado preguntamos si la fecha inicial es distinto a todo lo que existe registrado
            $listar_licencia = Licencia::where('id_persona', $request->id_persona_)
                ->where('id', '!=', $request->id_licencia)
                ->where(function($query) use ($request) {
                    $query->whereBetween('fecha_inicio', [$request->fecha_inicio_, $request->fecha_final_])
                        ->orWhereBetween('fecha_final', [$request->fecha_inicio_, $request->fecha_final_])
                        ->orWhere(function($q) use ($request) {
                            $q->where('fecha_inicio', '<', $request->fecha_inicio_)
                                ->where('fecha_final', '>', $request->fecha_final_);
                        });
                })
                ->get();
            $cont = $listar_licencia->isEmpty() ? 0 : 1;
            if($cont==0){
                $licencia                       = Licencia::find($request->id_licencia);
                $licencia->id_tipo_licencia     = $request->licencia_;
                $licencia->descripcion          = $request->descripcion_;
                $licencia->fecha_inicio         = $request->fecha_inicio_;
                $licencia->fecha_final          = $request->fecha_final_;
                $licencia->hora_inicio          = $request->hora_inicio_;
                $licencia->hora_final           = $request->hora_final_;
                $licencia->id_us_update         = Auth::user()->id;
                $licencia->save();
                if($licencia->id){
                    $data = array(
                        'tipo'          => 'success',
                        'mensaje'       => 'Se guardo con exito el registro!',
                        'id_persona'    => $request->id_persona_,
                    );
                }else{
                    $data = array(
                        'tipo'              => 'error',
                        'mensaje'           => 'Ocurrio un error imprevisto en el guardado!',
                        'id_persona_edi'    => $request->id_persona_,
                    );
                }
            }else{
                $data = array(
                    'tipo'              => 'error',
                    'mensaje'           => 'Ya se existe un registro con esa fecha',
                    'id_persona_edi'    => $request->id_persona_,
                );
            }
        }
        return response()->json($data);
    }
    /**
     * FIN PARA LA ADMINISTRACION DE GENERAR LAS LICENCIAS
     */
}
