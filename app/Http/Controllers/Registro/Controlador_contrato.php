<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use App\Models\Configuracion\Ambito;
use App\Models\Configuracion\Baja;
use App\Models\Configuracion\Cargo_mae;
use App\Models\Configuracion\Cargo_sm;
use App\Models\Configuracion\Direccion_municipal;
use Illuminate\Http\Request;
use App\Models\Configuracion\Genero;
use App\Models\Registro\Persona;
use App\Models\Configuracion\Estado_civil;
use App\Models\Configuracion\Grado_academico;
use App\Models\Configuracion\Horario;
use App\Models\Configuracion\Mae;
use App\Models\Configuracion\Nivel;
use App\Models\Configuracion\Profesion;
use App\Models\Configuracion\Secretaria_municipal;
use App\Models\Configuracion\Tipo_baja;
use App\Models\Configuracion\Tipo_categoria;
use App\Models\Configuracion\Tipo_contrato;
use App\Models\Configuracion\Unidad_mae;
use App\Models\Configuracion\Unidades_administrativas;
use App\Models\Registro\Contrato;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Controlador_contrato extends Controller
{
    /**
     * @version 1.0
     * @author  Graice Callizaya Chambi <graicecallizaya1234@gmail.com>
     * @param Controlador Administrar la parte de la administracion de los contratos
     * ¡Muchas gracias por preferirnos! Esperamos poder servirte nuevamente
     */
    private $menu_registro = 'registro';
    /**
     * PARA LA ADMINISTRACION DEL CONTRATO
     */

    //para ver la vista de los contrato
    public function contrato(){
        $data['menu']                   = '14';
        $data['lis_genero']             = Genero::where('estado','activo')->Orderby('id', 'asc')->get();
        $data['lis_estado_civil']       = Estado_civil::OrderBy('id','asc')->get();
        $data['lis_tipo_contrato']      = Tipo_contrato::OrderBy('id','asc')->get();
        $data['lis_categoria']          = Tipo_categoria::OrderBy('id', 'asc')->get();
        $data['lis_ambito']             = Ambito::OrderBy('id', 'asc')->get();
        $data['lis_horario']            = Horario::Orderby('id', 'asc')->get();
        $data['grado_academico']        = Grado_academico::OrderBy('id', 'asc')->get();
        $data['listar_mae']             = Mae::OrderBy('id','asc')->get();
        $data['secretaria_municipal']   = Secretaria_municipal::where('estado', 'activo')->OrderBy('id', 'asc')->get();
        $data['unidad_administrativa']  = Unidades_administrativas::where('estado', 'activo')->OrderBy('id','asc')->get();
        return view('administrador.contrato.contrato', $data);
    }

    //para listar el las profesiones
    public function listar_profesiones(Request $request){
        try {
            $profesion = Profesion::where('id_ambito', $request->id)->OrderBy('id', 'asc')->get();
            if($profesion){
                $data = mensaje_mostrar('success', $profesion);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al listar las profesiones');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al listar las profesiones');
        }
        return response()->json($data);
    }
    //para el tipo de contrato
    public function tipo_contrato_selec(Request $request){
        try {
            $tipo_contrato = Tipo_contrato::find($request->id);
            if($tipo_contrato){
                $data = mensaje_mostrar('success', $tipo_contrato);
            }else{
                $data = mensaje_mostrar('error', 'Ocurio un problema en el seleccionado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurio un problema en el seleccionado');
        }
        return response()->json($data);
    }
    //para el seleccionado del nivel
    public function nivel_select(Request $request){
        try {
            $nivel = Nivel::where('id_categoria', $request->id)->OrderBy('id', 'asc')->get();
            if($nivel){
                $data = mensaje_mostrar('success', $nivel);
            }else{
                $data = mensaje_mostrar('error', 'Ocurio un problema en el seleccionado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurio un problema en el seleccionado');
        }
        return response()->json($data);
    }
    //para los horarios select
    public function horarios_select(Request $request){
        try {
            $horario = Horario::find($request->id);
            if($horario){
                $data = mensaje_mostrar('success', $horario);
            }else{
                $data = mensaje_mostrar('error', 'Ocurio un problema en el seleccionado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurio un problema en el seleccionado');
        }
        return response()->json($data);
    }
    //para las uniades select
    public function unidad_select(Request $request){
        try {
            $unidad_mae = Unidad_mae::where('id_mae', $request->id)->OrderBy('id', 'asc')->get();
            if($unidad_mae){
                $data = mensaje_mostrar('success', $unidad_mae);
            }else{
                $data = mensaje_mostrar('error', 'Ocurio un problema en el seleccionado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurio un problema en el seleccionado');
        }
        return response()->json($data);
    }
    //para los cargos select
    public function cargo_select(Request $request){
        try {
            $cargo_mae = Cargo_mae::where('id_unidad', $request->id)->OrderBy('id', 'asc')->get();
            if($cargo_mae){
                $data = mensaje_mostrar('success', $cargo_mae);
            }else{
                $data = mensaje_mostrar('error', 'Ocurio un problema en el seleccionado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurio un problema en el seleccionado');
        }
        return response()->json($data);
    }
    //para listar las direcciones
    public function direccion_select(Request $request){
        try {
            $direccion_mae = Direccion_municipal::where('id_secretaria', $request->id)->OrderBy('id','asc')->get();
            if($direccion_mae){
                $data = mensaje_mostrar('success', $direccion_mae);
            }else{
                $data = mensaje_mostrar('error', 'Ocurio un problema en el seleccionado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurio un problema en el seleccionado');
        }
        return response()->json($data);
    }
    //para seleccionar el cargo
    public function cargo_select_sm(Request $request){
        try {
            $direccion_sm = Cargo_sm::where('id_direccion', $request->id)->OrderBy('id', 'desc')->get();
            if($direccion_sm){
                $data = mensaje_mostrar('success', $direccion_sm);
            }else{
                $data = mensaje_mostrar('error', 'Ocurio un problema en el seleccionado');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurio un problema en el seleccionado');
        }
        return response()->json($data);
    }

    //PARA GUARDAR EL CONTRATO
    public function guardar_contrato(Request $request){
        $validar = Validator::make($request->all(),[
            'fecha_nacimiento'  => 'required',
            'genero'            => 'required',
            'estado_civil'      => 'required',
            'nombres'           => 'required',
            'apellido_paterno'  => 'required',
            'apellido_materno'  => 'required',
            'gmail'             => 'required',
            'numero_celular'    => 'required',
            'direccion'         => 'required',
            //desde aqio informacion para el contrato
            'fecha_inicio'      => 'required',
            //'fecha_conclusion'  => 'required',
            'tipo_contrato'     => 'required',
            'numero_contrato'   => 'required',
            'haber_basico'      => 'required',
            'categoria'         => 'required',
            'nivel'             => 'required',
            'horario'           => 'required',
            //INFORMACIÓN ACADEMICA
            'ambito_profesional'=> 'required',
            'profesion'         => 'required',
            'grado_academico'   => 'required',
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            //primero verificamos si la creamos persona o no
            if($request->id_persona != '' || $request->id_persona != null){
                $persona = Persona::find($request->id_persona);
            }else{
                $persona                    = new Persona();
                $persona->ci                = $request->ci;
                $persona->nombres           = $request->nombres;
                $persona->ap_paterno        = $request->apellido_paterno;
                $persona->ap_materno        = $request->apellido_materno;
                $persona->fecha_nacimiento  = $request->fecha_nacimiento;
                $persona->estado            = 'activo';
                $persona->id_usuario        = Auth::user()->id;
            }
            $persona->complemento       = $request->complemento;
            $persona->nit               = $request->nit;
            $persona->gmail             = $request->gmail;
            $persona->celular           = $request->numero_celular;
            $persona->direccion         = $request->direccion;
            $persona->id_genero         = $request->genero;
            $persona->id_estado_civil   = $request->estado_civil;
            $persona->save();
            //fin del registro o edicion de la pérsona




            //ahora iniciamos el registro de rl_contrato
            $contrato                       = new Contrato();
            $contrato->fecha_inicio         = $request->fecha_inicio;
            if($request->fecha_conclusion != '' || $request->fecha_conclusion != null){
                $contrato->fecha_conclusion     = $request->fecha_conclusion;
            }
            $contrato->numero_contrato      = $request->numero_contrato;
            $contrato->haber_basico         = sin_separador_comas($request->haber_basico);
            $contrato->estado               = 'activo';
            $contrato->id_nivel             = $request->nivel;
            $contrato->id_tipo_contrato     = $request->tipo_contrato;
            $contrato->id_persona           = $persona->id;

            //ahora creamos o seleccionamos el cargo mae
            if($request->mae_sm=='1'){
                if($request->cargo_mae != 'selected' || $request->cargo_mae != ''){
                    $valor1 = $request->cargo_mae;
                }
                if($request->cargo_mae_descripcion != ''){
                    $cargo_mae_guardar              = new Cargo_mae();
                    $cargo_mae_guardar->nombre      = $request->cargo_mae_descripcion;
                    $cargo_mae_guardar->id_unidad   = $request->unidad_mae;
                    $cargo_mae_guardar->save();
                    $valor1 = $cargo_mae_guardar->id;
                }
                $contrato->id_cargo_mae         = $valor1;
            }

            if($request->mae_sm=='2'){
                //ahora creamos o seleccionamos el cargo sm
                if($request->cargo_sm != 'selected' || $request->cargo_sm != ''){
                    $valor2 = $request->cargo_sm;
                }
                if($request->cargo_sm_descripcion != ''){
                    $cargo_sm_guardar               = new Cargo_sm();
                    $cargo_sm_guardar->nombre       = $request->cargo_sm_descripcion;
                    $cargo_sm_guardar->id_direccion = $request->direccion_sm;
                    $cargo_sm_guardar->id_unidad    = $request->unidad_administrativa_sm;
                    $cargo_sm_guardar->save();
                    $valor2 = $cargo_sm_guardar->id;
                }
                $contrato->id_cargo_sm          = $valor2;
            }
            $contrato->id_profesion         = $request->profesion;
            $contrato->id_grado_academico   = $request->grado_academico;
            $contrato->id_horario           = $request->horario;
            $contrato->id_usuario           = Auth::user()->id;
            $contrato->save();

            if($contrato->id){
                $data = mensaje_mostrar('success', 'Se inserto con éxito ');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un problema al insertar el registro!');
            }
        }
        return response()->json($data);
    }
    /**
     * FIN DE LA ADMINISTRACION DEL CONTRATO
     */



    /**
      * PARA MOSTRAR LOS CONTRATOS QUE TIENE IUNA PERSONA
    */
    public function listar_contratos($id){
        $id_persona             = desencriptar($id);
        $data['menu']           = '14';
        $data['id_persona']     = $id_persona;
        $data['tipo_baja']      = Tipo_baja::where('estado','activo')->OrderBy('id','asc')->get();
        $data['persona']        = Persona::find($id_persona);

        //para la parte de los contratos
        $data['lis_genero']             = Genero::where('estado','activo')->Orderby('id', 'asc')->get();
        $data['lis_estado_civil']       = Estado_civil::OrderBy('id','asc')->get();
        $data['lis_tipo_contrato']      = Tipo_contrato::OrderBy('id','asc')->get();
        $data['lis_categoria']          = Tipo_categoria::OrderBy('id', 'asc')->get();
        $data['lis_ambito']             = Ambito::OrderBy('id', 'asc')->get();
        $data['lis_horario']            = Horario::Orderby('id', 'asc')->get();
        $data['grado_academico']        = Grado_academico::OrderBy('id', 'asc')->get();
        $data['listar_mae']             = Mae::OrderBy('id','asc')->get();
        $data['secretaria_municipal']   = Secretaria_municipal::where('estado', 'activo')->OrderBy('id', 'asc')->get();
        $data['unidad_administrativa']  = Unidades_administrativas::where('estado', 'activo')->OrderBy('id','asc')->get();
        //fin de la parte de los contratos

        return view('administrador.contrato.listar_contratos', $data);
    }

    //para listar el contrato especifico
    public function listar_contratos_especifico(Request $request){
        $contato = Contrato::with(['nivel','tipo_contrato','persona','cargo_mae','cargo_sm','profesion','grado_academico','horario','usuario'])->where('id_persona', $request->id )->get();
        return response()->json($contato);
    }
    //para vizalizar los datos del contrato
    public function vizualizar_contrato(Request $request){
        $contrato = Contrato::with(['nivel'=>function($n1){
            $n1->with(['categoria']);
        },'tipo_contrato','persona','cargo_mae'=>function($cm1){
            $cm1->with(['unidad_mae'=>function($um1){
                $um1->with('mae');
            }]);
        },'cargo_sm'=>function($cs1){
            $cs1->with(['unidades_admnistrativas','direccion'=>function($dir1){
                $dir1->with('secretaria_municipal');
            }]);
        },'profesion'=>function($pro1){
            $pro1->with(['ambito']);
        },'grado_academico','horario'=>function($h1){
            $h1->with(['rango_hora']);
        },'usuario'])->find($request->id);

        //print_r($contrato);
        $data['contrato'] = $contrato;
        return view('administrador.contrato.vizualizar_contrato', $data);

    }

    //para vizuazlizar el contrato especifico
    public function contrato_datos(Request $request){
        $contrato = contrato::with(['tipo_contrato'])->find($request->id);
        if($contrato){
            $data = mensaje_mostrar('success', $contrato);
        }else{
            $data = mensaje_mostrar('error', 'Ocurrio un error al obtener los datos');
        }
        return response()->json($data);
    }

    //para la parte de guardar realizar la baja de un contrato
    public function baja_contrato(Request $request){
        $validar = Validator::make($request->all(),[
            'fecha'             => 'required|date|before_or_equal:' . now()->format('Y-m-d'),
            'tipo_baja'         => 'required',
            'descripcion'       => 'required',
        ],
        [
            'fecha_nacimiento_.before_or_equal' => 'La fecha no puede ser del futuro.',
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            //primero creamos la baja
            $baja               = new Baja();
            $baja->fecha        = $request->fecha;
            $baja->descripcion  = $request->descripcion;
            $baja->id_tipo_baja = $request->tipo_baja;
            $baja->id_usuario   = Auth::user()->id;
            $baja->save();
            //ahora para registrar el contrato
            $contrato               = Contrato::find($request->id_contrato);
            $contrato->id_baja      = $baja->id;
            $contrato->estado       = "inactivo";
            $contrato->save();

            if($contrato->id){
                $data = mensaje_mostrar('success', 'Se realizo la baja con éxito!');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al querer registrar la baja!');
            }
        }
        return response()->json($data);
    }


    //PARA VIZUALIZAR LA BAJA RAZONES
    public function vizualizar_baja(Request $request){
        try {
            $contrato = Contrato::with(['baja'])->find($request->id);
            if($contrato){
                $data = mensaje_mostrar('success', $contrato);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error al mostrar los datos');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error al mostrar los datos');
        }
        return response()->json($data);
    }

    //para guardar lo editado
    public function vizualizar_baja_editar(Request $request){
        $validar = Validator::make($request->all(),[
            'fecha_'             => 'required|date|before_or_equal:' . now()->format('Y-m-d'),
            'tipo_baja_'         => 'required',
            'descripcion_'       => 'required',
        ],
        [
            'fecha_nacimiento_.before_or_equal' => 'La fecha no puede ser del futuro.',
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            //primero creamos la baja
            $baja               = Baja::find($request->id_baja);
            $baja->fecha        = $request->fecha_;
            $baja->descripcion  = $request->descripcion_;
            $baja->id_tipo_baja = $request->tipo_baja_;
            $baja->id_usuario   = Auth::user()->id;
            $baja->save();

            if($baja->id){
                $data = mensaje_mostrar('success','Se edito la baja con éxito!');
            }else{
                $data = mensaje_mostrar('error','Ocurrio un error al querer editar la baja!');
            }
        }
        return response()->json($data);
    }

    /**
     * PARA EDITAR CONTRATO
     */
    public function editar_contrato(Request $request){
        //try {
            $contrato = Contrato::with([
                'nivel'=>function($niv){
                    $niv->with(['categoria'=>function($cat){
                        $cat->with(['nivel']);
                    }]);
                },
                'tipo_contrato',
                'persona'=>function($per){
                    $per->with([
                        'genero',
                        'estado_civil',
                        'contrato'
                    ]);
                },
                'cargo_mae'=>function($car_mae){
                    $car_mae->with([
                        'unidad_mae'=>function($uni_mae){
                            $uni_mae->with([
                                'cargos',
                                'mae'=>function($mae){
                                    $mae->with(['unidades_mae']);
                                }
                            ]);
                        }
                    ]);
                },
                'cargo_sm'=>function($car_sm){
                    $car_sm->with([
                        'unidades_admnistrativas',
                        'direccion'=>function($direc){
                            $direc->with(['cargos','secretaria_municipal'=>function($sec_mun){
                                $sec_mun->with([
                                    'direcciones'
                                ]);
                            }]);
                        }
                    ]);
                },
                'profesion'=>function($profe){
                    $profe->with(['ambito'=>function($amb){
                        $amb->with(['profesion']);
                    }]);
                },
                'grado_academico',
                'horario'=>function($hor){
                    $hor->with([
                        'rango_hora'=>function($rang_hora){
                            $rang_hora->with([
                                'horarios'
                            ]);
                        }
                    ]);
                },
                'usuario',
                'baja'=>function ($baja) {
                    $baja->with([
                        'contrato'
                    ]);
                }
                ])
            ->find($request->id);

            if($contrato){
                $data = mensaje_mostrar('success', $contrato);
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error');
            }
        /* } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error');
        } */
        return response()->json($data);
    }

    //para guardar el registro del contrato editado
    public function editar_contrato_save(Request $request){
        $validar = Validator::make($request->all(),[
            //desde aqio informacion para el contrato
            'fecha_inicio'      => 'required',
            //'fecha_conclusion'  => 'required',
            'tipo_contrato'     => 'required',
            'numero_contrato'   => 'required',
            'haber_basico'      => 'required',
            'categoria'         => 'required',
            'nivel'             => 'required',
            'horario'           => 'required',
            //INFORMACIÓN ACADEMICA
            'ambito_profesional'=> 'required',
            'profesion'         => 'required',
            'grado_academico'   => 'required',
        ]);
        if($validar->fails()){
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            //ahora iniciamos el registro de rl_contrato
            $contrato                       = Contrato::find($request->id_contrato_);
            $contrato->fecha_inicio         = $request->fecha_inicio;
            if($request->fecha_conclusion != '' || $request->fecha_conclusion != null){
                $contrato->fecha_conclusion     = $request->fecha_conclusion;
            }
            $contrato->numero_contrato      = $request->numero_contrato;
            $contrato->haber_basico         = sin_separador_comas($request->haber_basico);
            $contrato->id_nivel             = $request->nivel;
            $contrato->id_tipo_contrato     = $request->tipo_contrato;

            //ahora creamos o seleccionamos el cargo mae
            if($request->mae_sm=='1'){
                $contrato->id_cargo_sm = null;
                if($request->cargo_mae != 'selected' || $request->cargo_mae != ''){
                    $valor1 = $request->cargo_mae;
                }
                if($request->cargo_mae_descripcion != ''){
                    $cargo_mae_guardar              = new Cargo_mae();
                    $cargo_mae_guardar->nombre      = $request->cargo_mae_descripcion;
                    $cargo_mae_guardar->id_unidad   = $request->unidad_mae;
                    $cargo_mae_guardar->save();
                    $valor1 = $cargo_mae_guardar->id;
                }
                $contrato->id_cargo_mae         = $valor1;
            }

            if($request->mae_sm=='2'){
                $contrato->id_cargo_mae = null;
                //ahora creamos o seleccionamos el cargo sm
                if($request->cargo_sm != 'selected' || $request->cargo_sm != ''){
                    $valor2 = $request->cargo_sm;
                }
                if($request->cargo_sm_descripcion != ''){
                    $cargo_sm_guardar               = new Cargo_sm();
                    $cargo_sm_guardar->nombre       = $request->cargo_sm_descripcion;
                    $cargo_sm_guardar->id_direccion = $request->direccion_sm;
                    $cargo_sm_guardar->id_unidad    = $request->unidad_administrativa_sm;
                    $cargo_sm_guardar->save();
                    $valor2 = $cargo_sm_guardar->id;
                }
                $contrato->id_cargo_sm          = $valor2;
            }
            $contrato->id_profesion         = $request->profesion;
            $contrato->id_grado_academico   = $request->grado_academico;
            $contrato->id_horario           = $request->horario;
            $contrato->id_usuario           = Auth::user()->id;
            $contrato->save();

            if($contrato->id){
                $data = mensaje_mostrar('success', 'Se Editó con éxito ');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un problema al insertar el registro!');
            }
        }
        return response()->json($data);
    }
    /**
     * FIN DE LA PARTE DE EDITAR CONTRATO
     */

}
