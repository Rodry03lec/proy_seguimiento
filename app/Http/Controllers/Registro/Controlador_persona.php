<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuracion\Estado_civil;
use App\Models\Configuracion\Genero;
use App\Models\Registro\Contrato;
use App\Models\Registro\Persona;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Controlador_persona extends Controller
{
    /**
     * @version 1.0
     * @author  Graice Callizaya Chambi <graicecallizaya1234@gmail.com>
     * @param Controlador Administrar la parte de LA ADMINISTRACION DE LAS PERSONAS QUE ESTEN REGISTRADAS
     * ¡Muchas gracias por preferirnos! Esperamos poder servirte nuevamente
     */

    /**
     * ADMINISTRACION DEL LAS PERSONAS
    */
    public function persona(){
        $data['menu']           = '13';
        $data['lis_genero']         = Genero::where('estado','activo')->Orderby('id', 'asc')->get();
        $data['lis_estado_civil']   = Estado_civil::OrderBy('id','asc')->get();
        return view('administrador.persona.persona', $data);
    }
    //para la busqueda de la persona con por ci
    public function persona_buscar(Request $request){
        $persona = Persona::with(['genero','estado_civil'])->where('ci', $request->ci)->get();
        if(!$persona->isEmpty()){
            $data['listar_persona'] = $persona;
        }else{
            $data['listar_persona'] = null;
        }
        return view('administrador.persona.listado_persona', $data);
    }
    //para realizar el registro de la nueva persona
    public function persona_nuevo(Request $request){
        $validar = Validator::make($request->all(),[
            'ci'                => 'required|unique:rl_persona,ci',
            'fecha_nacimiento'  => 'required|date|before_or_equal:' . now()->format('Y-m-d'),
            'genero'            => 'required',
            'estado_civil'      => 'required',
            'nombres'           => 'required',
            'apellido_paterno'  => 'required',
            'gmail'             => 'required',
            'numero_celular'    => 'required',
            'direccion'         => 'required'
        ],
        [
            'fecha_nacimiento.before_or_equal' => 'La fecha de nacimiento no puede ser en el futuro.',
        ]
        );
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $persona                    = new Persona();
            $persona->ci                = $request->ci;
            $persona->complemento       = $request->complemento;
            $persona->nit               = $request->nit;
            $persona->nombres           = $request->nombres;
            $persona->ap_paterno        = $request->apellido_paterno;
            $persona->ap_materno        = $request->apellido_materno;
            $persona->fecha_nacimiento  = $request->fecha_nacimiento;
            $persona->gmail             = $request->gmail;
            $persona->celular           = $request->numero_celular;
            $persona->direccion         = $request->direccion;
            $persona->estado            = 'activo';
            $persona->id_genero         = $request->genero;
            $persona->id_estado_civil   = $request->estado_civil;
            $persona->id_usuario        = Auth::user()->id;
            $persona->save();
            if($persona->id){
                /* $data = mensaje_mostrar('success', 'Se realizo el registro con éxito ! '); */
                $data = array(
                    'tipo'      => 'success',
                    'mensaje'   => 'Se realizo el registro con éxito ! ',
                    'ci_rec'    => $persona->ci
                );
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al registrar ! ');
            }
        }
        return response()->json($data);
    }

    //para validar el ci de la persona
    public function persona_validar(Request $request){
        $persona = Persona::where('ci', $request->ci)->first();
        if(!$persona){
            $data = mensaje_mostrar('success', 'Puede seguir con el registro !');
        }else{
            $numeroContratos = Contrato::where('id_persona', $persona->id)
                ->where('estado', 'activo')
                ->count();
            $data = array(
                'tipo'              =>  'error',
                'mensaje'           =>  'Ya existe el CI registrado !',
                'persona'           =>  $persona,
                'contar_contratos'  =>  $numeroContratos,
                'id_encript_per'    =>  encriptar($persona->id),
                'mensaje_persona'   =>  "YA HAY UN CONTRATO NO DADO DE BAJA, PORFAVOR VERIFIQUE Y DE DE BAJA Y VUELVA A REGISTRAR EL NUEVO CONTRATO !",
            );
        }
        return response()->json($data);
    }
    //para editar el registro
    public function persona_editar(Request $request){
        try {
            $persona = Persona::find($request->id);
            if($persona){
                $data = mensaje_mostrar('success', $persona);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al editar');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al editar');
        }
        return response()->json($data);
    }
    //para guardar el registro
    public function persona_editar_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'fecha_nacimiento_'  => 'required|date|before_or_equal:' . now()->format('Y-m-d'),
            'genero_'            => 'required',
            'estado_civil_'      => 'required',
            'nombres_'           => 'required',
            'apellido_paterno_'  => 'required',
            'gmail_'             => 'required',
            'numero_celular_'    => 'required',
            'direccion_'         => 'required'
        ],
        [
            'fecha_nacimiento_.before_or_equal' => 'La fecha de nacimiento no puede ser en el futuro.',
        ]
        );
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $persona                    = Persona::find($request->id_persona);
            $persona->nit               = $request->nit_;
            $persona->nombres           = $request->nombres_;
            $persona->ap_paterno        = $request->apellido_paterno_;
            $persona->ap_materno        = $request->apellido_materno_;
            $persona->fecha_nacimiento  = $request->fecha_nacimiento_;
            $persona->gmail             = $request->gmail_;
            $persona->celular           = $request->numero_celular_;
            $persona->direccion         = $request->direccion_;
            $persona->id_genero         = $request->genero_;
            $persona->id_estado_civil   = $request->estado_civil_;
            $persona->save();
            if($persona->id){
                $data = array(
                    'tipo'      => 'success',
                    'mensaje'   => 'Se editó con éxito ! ',
                    'ci_rec1'   => $persona->ci
                );
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al registrar ! ');
            }
        }
        return response()->json($data);
    }

    //para eliminar la persona registrada
    public function persona_eliminar(Request $request){
        try {
            $persona = Persona::find($request->id);
            if($persona->delete()){
                $data = mensaje_mostrar('success', 'Se elimino con exito el registro');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar el registro');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al eliminar el registro');
        }
        return response()->json($data);
    }
    /**
     * FIN DE LA ADMINISTRACION DE LAS PERSONAS
    */
}
