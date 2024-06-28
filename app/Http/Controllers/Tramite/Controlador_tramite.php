<?php

namespace App\Http\Controllers\Tramite;

use App\Http\Controllers\Controller;
use App\Models\Configuracion_tramite\Tipo_prioridad;
use App\Models\Configuracion_tramite\Tipo_tramite;
use App\Models\Configuracion_tramite\User_cargo_tramite;
use App\Models\Tramite\Hojas_ruta;
use App\Models\Tramite\Ruta_archivado;
use App\Models\Tramite\Tramite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Cache;

class Controlador_tramite extends Controller{

    /**
     * @version 1.0
     * @author  Graice Callizaya Chambi <graicecallizaya1234@gmail.com>
     * @param Controlador Administrar la parte de LA ADMINISTRACION DE LOS TRAMITES QUE SE REALIZARAN
     * ¡Muchas gracias por preferirnos! Esperamos poder servirte nuevamente
     */

    //Para la administracion de los tramites
    public function  vizualizar_cargos_tramite() {
        $data['menu'] = 60;

        $listar_cargos = User_cargo_tramite::with([
            'tramite' => function ($us_tramite) {
                $us_tramite->with([
                    'hojas_ruta',
                    'tipo_tramite'
                ])->withCount([
                    'hojas_ruta as bandeja_entrada_count' => function ($query) {
                        $query->where('estado_id', 2);
                    },
                    'hojas_ruta as recibidos_count' => function ($query) {
                        $query->where('estado_id', 3);
                    }
                ]);
            },
            'cargo_sm',
            'cargo_mae'
        ])
        ->where('estado', true)
        ->where('id_usuario', Auth::user()->id)
        ->get();



        $data['listar_cargos'] = $listar_cargos;
        return view('administrador.tramite.vista_tramite', $data);
    }
    //para la administracion del tramite cargo
    /**
     * PARA LA PARTE DE LA CORRESPONDENCIA
     */
    public function tramite_cargo($id){
        $id_descript                = desencriptar($id);
        $cargo                      = User_cargo_tramite::with(['cargo_sm', 'cargo_mae'])->find($id_descript);
        $data['cargo_enum']         = $cargo;
        $data['id_user_cargo_tram'] = $id_descript;
        $data['titulo_menu']        = 'CORRESPONDENCIA';
        $data['menu']               = 60;


        $data['contar_num_tramite']     = Tramite::where('user_cargo_id', $id_descript)
                                        ->count();

        $data['contar_bandeja_entrada'] = Hojas_ruta::where('destinatario_id', $id_descript)
                                        ->where('estado_id', 2)
                                        ->count();

        $data['contar_bandeja_recibido'] = Hojas_ruta::where('destinatario_id', $id_descript)
                                        ->where('estado_id', 3)
                                        ->count();

        $data['contar_bandeja_observado'] = Hojas_ruta::where('destinatario_id', $id_descript)
                                        ->where('estado_id', 6)
                                        ->count();

        $data['tipo_tramite']       = Tipo_tramite::where('estado', 1)->get();
        $data['tipo_prioridad']     = Tipo_prioridad::get();
        $data['destinatario_ti']    = User_cargo_tramite::with(['cargo_sm', 'cargo_mae', 'usuario', 'persona'])->where('estado', 1)->get();

        return view('administrador.tramite.correspondencia.correspondencia', $data);

    }

    //Para la parte de tipo de correspondencia
    public function correspondencia_tipo_sigla(Request $request){
        try {
            $tipo_tramite       = Tipo_tramite::find($request->id);
            $user_cargo_tram    = User_cargo_tramite::with(['cargo_sm', 'cargo_mae'])->find($request->id_user_cargo);
            if($tipo_tramite){

                $cargo_normal = "";
                if($user_cargo_tram->cargo_sm != null ){
                    $cargo_normal = abreviarCargo($user_cargo_tram->cargo_sm->nombre);
                }else{
                    $cargo_normal = abreviarCargo($user_cargo_tram->cargo_mae->nombre);
                }

                $data = [
                    'tipo'              => 'success',
                    'tipo_tramite'      => $tipo_tramite,
                    'user_cargo_tram'   => $user_cargo_tram,
                    'cargo_normal'      => $cargo_normal
                ];
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error');
            }
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error');
        }
        return response()->json($data);
    }



    //para listar los tramites del cargo de la persona
    public function correspondencia_listar(Request $request){
        $listar_correspondencia = Tramite::withCount(['hojas_ruta'])->with([
            'hojas_ruta',
            'tipo_prioridad',
            'tipo_tramite',
            'estado_tipo',
            'remitente_user'=>function ($ruse) {
            $ruse->with([
                'persona',
                'contrato'=>function($cotn){
                $cotn->with([
                    'grado_academico'
                ]);
            }]);
        }, 'destinatario_user'=>function($des_user){
            $des_user->with([
                'cargo_sm',
                'cargo_mae',
                'persona',
                'contrato'=>function ($cdes) {
                $cdes->with([
                    'grado_academico'
                ]);
            }]);
        }, 'user_cargo_tramite'=>function ($uct) {
            $uct->with([
                'cargo_sm',
                'cargo_mae',
                'persona',
                'contrato'=>function($cto){
                $cto->with([
                    'grado_academico'
                ]);
            }]);
        }])->where('user_cargo_id', $request->id)->OrderBy('id', 'desc')->get();
        return response()->json($listar_correspondencia);
    }

    //funcion para contar los tramites del año
    function contarTramitesPorAno($year) {
        // Cachea el conteo de trámites creados en el año especificado durante 60 segundos
        return Cache::remember("tramites_count_$year", 60, function () use ($year) {
            return Tramite::whereYear('fecha_creada', $year)->count();
        });
    }

    //para guardar el registro de nuvo tramite
    public function correspondencia_nuevo(Request $request) {
        $validar = Validator::make($request->all(), [
            'tipo_tramite'  => ['required', 'not_in:0'],
            'cite'          => 'required',
            'prioridad'     => ['required', 'not_in:0'],
            'referencia'    => 'required',
            'instructivo'   => 'required',
        ]);

        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            try {
                // Inicia una transacción
                DB::beginTransaction();

                // Obtén la gestión actual
                $gestion = date('Y');

                // Obtener el último trámite del año en curso usando Eloquent sin usar `lockForUpdate`
                $ultimo_tramite = Tramite::whereYear('created_at', $gestion)
                    ->orderBy('id', 'desc')
                    ->first();

                $num_unico_tramite = $ultimo_tramite ? $ultimo_tramite->id + 1 : 1;
                $tramite_num = ($gestion % 100).$num_unico_tramite;

                $user_cargo_tram = User_cargo_tramite::with(['contrato' => function ($con) {
                    $con->with(['grado_academico']);
                }, 'usuario', 'persona', 'cargo_sm', 'cargo_mae'])->find($request->id_remitente);

                // Crear un nuevo trámite
                $tramite_nuevo                      = new Tramite();
                $tramite_nuevo->fecha_creada        = date('Y-m-d');
                $tramite_nuevo->hora_creada         = date('H:i:s');
                $tramite_nuevo->fecha_hora_creada   = date('Y-m-d H:i:s');
                $tramite_nuevo->cite                = $request->cite_numero;
                $tramite_nuevo->cite_texto          = $request->cite;
                $tramite_nuevo->numero_hojas        = $request->numero_hojas;
                $tramite_nuevo->numero_anexos       = $request->numero_anexos;
                $tramite_nuevo->referencia          = $request->referencia;

                if ($request->remitente_txt) {
                    $tramite_nuevo->remitente_nombre    = $request->remitente_txt;
                    $tramite_nuevo->remitente_cargo     = $request->cargo_txt;
                    $tramite_nuevo->remitente_txt       = $request->remitente_txt;
                }

                $tramite_nuevo->destinatario_nombre = $user_cargo_tram->contrato->grado_academico->abreviatura . ' ' . $user_cargo_tram->persona->nombres . ' ' . $user_cargo_tram->persona->ap_paterno . ' ' . $user_cargo_tram->persona->ap_paterno;

                if ($user_cargo_tram->cargo_sm != null) {
                    $tramite_nuevo->destinatario_cargo = $user_cargo_tram->cargo_sm->nombre;
                    $tramite_nuevo->destinatario_sigla = abreviarCargo_tres($user_cargo_tram->cargo_sm->nombre);
                } else {
                    $tramite_nuevo->destinatario_cargo = $user_cargo_tram->cargo_mae->nombre;
                    $tramite_nuevo->destinatario_sigla = abreviarCargo_tres($user_cargo_tram->cargo_mae->nombre);
                }

                $tramite_nuevo->gestion = $gestion;
                $tramite_nuevo->numero_unico = $tramite_num;
                $tramite_nuevo->codigo = Str::random(10);
                $tramite_nuevo->id_tipo_prioridad = $request->prioridad;
                $tramite_nuevo->id_tipo_tramite = $request->tipo_tramite;
                $tramite_nuevo->id_estado = 2;
                $tramite_nuevo->remitente_id = $request->id_remitente;
                $tramite_nuevo->destinatario_id = $request->destinatario;
                $tramite_nuevo->user_cargo_id = $request->id_remitente;
                $tramite_nuevo->save();

                // Guardar las hojas de ruta
                $hoja_ruta = new Hojas_ruta();
                $hoja_ruta->paso = 1;
                $hoja_ruta->paso_txt = numero_a_ordinal(1);
                $hoja_ruta->instructivo = $request->instructivo;
                $hoja_ruta->nro_hojas_ingreso = $request->numero_hojas;
                $hoja_ruta->nro_anexos_ingreso = $request->numero_anexos;
                //$hoja_ruta->fecha_ingreso = null;
                $hoja_ruta->fecha_salida = date('Y-m-d H:m:s');
                $hoja_ruta->fecha_envio = date('Y-m-d H:m:s');
                $hoja_ruta->actual = 1;
                $hoja_ruta->remitente_id = $request->id_remitente;
                $hoja_ruta->destinatario_id = $request->destinatario;
                $hoja_ruta->estado_id = 2;
                $hoja_ruta->tramite_id = $tramite_nuevo->id;
                $hoja_ruta->save();

                // Confirmar la transacción
                DB::commit();

                // Verifica si se guardó la hoja de ruta
                if ($hoja_ruta->id) {
                    $data = mensaje_mostrar('success', 'Se guardó con éxito!');
                } else {
                    $data = mensaje_mostrar('error', 'Error al crear el trámite');
                }

            } catch (\Exception $e) {
                // Revertir la transacción si algo falla
                DB::rollBack();
                $data = mensaje_mostrar('error', 'Error al crear el trámite: ' . $e->getMessage());
            }
        }
        return response()->json($data);
    }

    //para vizauliar la correspondencia
    public function correspondencia_vizualizar(Request $request){
        try {
            //esto es para el tramite
            $tramite = Tramite::with(['tipo_prioridad','tipo_tramite', 'estado_tipo', 'remitente_user'=>function ($ruse) {
            $ruse->with(['persona', 'contrato'=>function($cotn){
                $cotn->with(['grado_academico']);
            }]);
            }, 'destinatario_user'=>function($des_user){
                $des_user->with(['cargo_sm','cargo_mae','persona', 'contrato'=>function ($cdes) {
                    $cdes->with(['grado_academico']);
                }]);
            }, 'user_cargo_tramite'=>function ($uct) {
                $uct->with(['cargo_sm','cargo_mae','persona', 'contrato'=>function($cto){
                    $cto->with(['grado_academico']);
                }]);
            }])->find($request->id);
            //esto es para la hoja de ruta
            $listar_hojas_ruta = Hojas_ruta::with(['remitente_user'=>function($rem_user){
                $rem_user->with(['cargo_sm', 'cargo_mae', 'contrato'=>function($ru_con){
                    $ru_con->with(['grado_academico']);
                }, 'usuario', 'persona']);
            }, 'destinatario_user'=>function($des_user){
                $des_user->with(['cargo_sm'=>function($des_csm){
                    $des_csm->with(['unidades_admnistrativas', 'direccion']);
                }, 'cargo_mae'=>function($desca_m){
                    $desca_m->with(['unidad_mae']);
                },'contrato'=>function($de_con){
                    $de_con->with(['grado_academico']);
                }]);
            }, 'estado_tipo', 'tramite'])
                ->where('tramite_id', $request->id)->get();

            $data = [
                'tipo'      => 'success',
                'tramite'   => $tramite,
                'hoja_ruta' => $listar_hojas_ruta
            ];
        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un problema');
        }
            return response()->json($data);
    }

    //para listar las hojas de ruta
    public function correspondencia_listar_hoja_ruta(Request $request){
        $listar_hojas_ruta = Hojas_ruta::with(['ruta_archivado','remitente_user'=>function($rem_user){
            $rem_user->with(['cargo_sm', 'cargo_mae', 'contrato'=>function($ru_con){
                $ru_con->with(['grado_academico']);
            }, 'usuario', 'persona']);
        }, 'destinatario_user'=>function($des_user){
            $des_user->with(['cargo_sm'=>function($des_csm){
                $des_csm->with(['unidades_admnistrativas', 'direccion']);
            }, 'cargo_mae'=>function($desca_m){
                $desca_m->with(['unidad_mae']);
            },'contrato'=>function($de_con){
                $de_con->with(['grado_academico']);
            },'persona']);
        }, 'estado_tipo', 'tramite'])
            ->where('tramite_id', $request->id)
            ->OrderBy('id', 'asc')
            ->get();

        return response()->json($listar_hojas_ruta);
    }

    //para anular el tramite
    public function correspondencia_anular(Request $request){
        try {
            $tramite = Tramite::with(['hojas_ruta'])->find($request->id);

            if ($tramite && $tramite->hojas_ruta()->count() === 1) {
                // Si el tramite tiene exactamente una hoja_ruta, eliminarla
                $tramite->hojas_ruta()->delete();
                $tramite->id_estado = 5;
                $tramite->save();
                $data = mensaje_mostrar('success', 'El tramite se anulo con éxito' );
            } else {
                // Si no tiene exactamente una hoja_ruta, retornar un mensaje adecuado
                $data = mensaje_mostrar('error', 'No se pudo eliminar, por que ya tiene mas de 1 registro');
            }

        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error inesperado');
        }
        return response()->json($data);
    }

    /**
     * FIN DE LA PARTE DE CORRESPONDENCIA
     */

    /**
     * PARA LA PARTE DE BANDEJA DE ENTRADA
     */
    //para la parte de la bandeja de entrada
    public function  bandeja_entrada($id){
        $id_descript                = desencriptar($id);
        $cargo                      = User_cargo_tramite::with(['cargo_sm', 'cargo_mae'])->find($id_descript);
        $data['cargo_enum']         = $cargo;
        $data['id_user_cargo_tram'] = $id_descript;
        $data['titulo_menu']        = 'BANDEJA DE ENTRADA';
        $data['menu'] = 60;



        $data['contar_num_tramite'] = Tramite::where('user_cargo_id', $id_descript)
                                        ->count();

        $data['contar_bandeja_entrada'] = Hojas_ruta::where('destinatario_id', $id_descript)
                                        ->where('estado_id', 2)
                                        ->count();

        $data['contar_bandeja_recibido'] = Hojas_ruta::where('destinatario_id', $id_descript)
                                        ->where('estado_id', 3)
                                        ->count();

        $data['contar_bandeja_observado'] = Hojas_ruta::where('destinatario_id', $id_descript)
                                        ->where('estado_id', 6)
                                        ->count();




        return view('administrador.tramite.correspondencia.bandeja_entrada', $data);

    }

    //para listar la bandeja de entrada
    public function bandeja_entrada_listar(Request $request) {
        $hoja_ruta_listar = Hojas_ruta::with([
            'remitente_user' => function($rem_us) {
                $rem_us->with([
                    'cargo_sm' => function($re_car_sm) {
                        $re_car_sm->with([
                            'unidades_admnistrativas',
                            'direccion' => function($ca_direc) {
                                $ca_direc->with('secretaria_municipal');
                            }
                        ]);
                    },
                    'cargo_mae' => function($car_mae) {
                        $car_mae->with([
                            'unidad_mae' => function($un_mae) {
                                $un_mae->with('mae');
                            }
                        ]);
                    },
                    'contrato' => function($con) {
                        $con->with('grado_academico');
                    },
                    'persona'
                ]);
            },
            'destinatario_user' => function($des_user) {
                $des_user->with([
                    'cargo_sm' => function($des_car_sm) {
                        $des_car_sm->with([
                            'unidades_admnistrativas',
                            'direccion' => function($des_car_direc) {
                                $des_car_direc->with('secretaria_municipal');
                            }
                        ]);
                    },
                    'cargo_mae' => function($des_car_mae) {
                        $des_car_mae->with([
                            'unidad_mae' => function($des_car_unid) {
                                $des_car_unid->with('mae');
                            }
                        ]);
                    },
                    'contrato' => function($des_car_con) {
                        $des_car_con->with('grado_academico');
                    },
                    'persona'
                ]);
            },
            'estado_tipo',
            'tramite' => function($des_car_trami) {
                $des_car_trami->with([
                    'hojas_ruta' => function($tram_hoja) {
                        $tram_hoja->where('actual', 1)->with([
                            'remitente_user' => function($tram_hoja_rem) {
                                $tram_hoja_rem->with([
                                    'cargo_sm' => function($tram_carsm) {
                                        $tram_carsm->with([
                                            'unidades_admnistrativas',
                                            'direccion' => function($tram_direc) {
                                                $tram_direc->with('secretaria_municipal');
                                            }
                                        ]);
                                    },
                                    'cargo_mae' => function($tram_carmae) {
                                        $tram_carmae->with([
                                            'unidad_mae' => function($tra_car_unida_mae) {
                                                $tra_car_unida_mae->with('mae');
                                            }
                                        ]);
                                    },
                                    'contrato' => function($tra_con_con) {
                                        $tra_con_con->with('grado_academico');
                                    },
                                    'persona'
                                ]);
                            },
                            'destinatario_user' => function($des_us) {
                                $des_us->with([
                                    'cargo_sm' => function($des_car_sm) {
                                        $des_car_sm->with([
                                            'unidades_admnistrativas',
                                            'direccion' => function($des_dirrec) {
                                                $des_dirrec->with('secretaria_municipal');
                                            }
                                        ]);
                                    },
                                    'cargo_mae' => function($des_cargo_mae) {
                                        $des_cargo_mae->with([
                                            'unidad_mae' => function($des_uni_mae) {
                                                $des_uni_mae->with('mae');
                                            }
                                        ]);
                                    },
                                    'contrato' => function($des_contra) {
                                        $des_contra->with('grado_academico');
                                    }
                                ]);
                            },
                            'estado_tipo'
                        ]);
                    },
                    'tipo_prioridad',
                    'tipo_tramite',
                    'estado_tipo',
                    'remitente_user'=>function($rem_user){
                        $rem_user->with(['cargo_sm'=>function($car_sm){
                            $car_sm->with([
                                'unidades_admnistrativas',
                                'direccion' => function($ca_direc) {
                                    $ca_direc->with('secretaria_municipal');
                                }
                            ]);
                        },
                        'cargo_mae'=>function($car_mae){
                            $car_mae->with([
                                'unidad_mae' => function($un_mae) {
                                    $un_mae->with('mae');
                                }
                            ]);
                        },
                        'contrato'=>function($con){
                            $con->with('grado_academico');
                        },
                        'persona']);
                    },
                    'destinatario_user'=>function($des_user){
                        $des_user->with(['cargo_sm'=>function($car_sm){
                            $car_sm->with([
                                'unidades_admnistrativas',
                                'direccion' => function($ca_direc) {
                                    $ca_direc->with('secretaria_municipal');
                                }
                            ]);
                        },
                        'cargo_mae'=>function($car_mae){
                            $car_mae->with([
                                'unidad_mae' => function($un_mae) {
                                    $un_mae->with('mae');
                                }
                            ]);
                        },
                        'contrato'=>function($con){
                            $con->with('grado_academico');
                        },
                        'persona']);
                    },
                    'user_cargo_tramite'
                ]);
            }
        ])->where('destinatario_id', $request->id)
        ->where('actual', 1)
        ->where('estado_id', 2)
        ->get();

        return response()->json($hoja_ruta_listar);
    }


    //para recivir el tramite
    public function bandeja_entrada_recibir(Request $request){
        try {
            $hora_ruta                  = Hojas_ruta::find($request->id_ruta);
            $hora_ruta->fecha_ingreso   = date('Y-m-d H:m:s');
            $hora_ruta->estado_id       = 3;
            $hora_ruta->save();

            if($hora_ruta->id){
                $data = mensaje_mostrar('success', 'Se recibio con éxito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error');
            }

        } catch (\Throwable $th) {
            $data = mensaje_mostrar('error', 'Ocurrio un error');
        }
        return response()->json($data);
    }

    /**
     * FIN DE LA PARTE DE BANDEJA DE ENTRADA
     */

    /**
     * PARA LA PARTE DE LOS RECIVIDOS
     */
    public function recibidos($id){
        $id_descript                = desencriptar($id);
        $cargo                      = User_cargo_tramite::with(['cargo_sm', 'cargo_mae'])->find($id_descript);
        $data['cargo_enum']         = $cargo;
        $data['id_user_cargo_tram'] = $id_descript;
        $data['titulo_menu']        = 'RECIBIDOS';
        $data['menu'] = 60;

        $data['contar_num_tramite'] = Tramite::where('user_cargo_id', $id_descript)
                                        ->count();

        $data['contar_bandeja_entrada'] = Hojas_ruta::where('destinatario_id', $id_descript)
                                        ->where('estado_id', 2)
                                        ->count();

        $data['contar_bandeja_recibido'] = Hojas_ruta::where('destinatario_id', $id_descript)
                                        ->where('estado_id', 3)
                                        ->count();

        $data['contar_bandeja_observado'] = Hojas_ruta::where('destinatario_id', $id_descript)
                                        ->where('estado_id', 6)
                                        ->count();


        $data['destinatario']    = User_cargo_tramite::with(['cargo_sm', 'cargo_mae', 'usuario', 'persona','contrato'=>function($con){
            $con->with(['grado_academico']);
        }])->where('estado', 1)->get();

        return view('administrador.tramite.correspondencia.recibidos', $data);
    }

    //para listar los tramites recividos
    public function listar_tramite_recibido(Request $request){
        $hoja_ruta_listar = Hojas_ruta::with([
            'remitente_user' => function($rem_us) {
                $rem_us->with([
                    'cargo_sm' => function($re_car_sm) {
                        $re_car_sm->with([
                            'unidades_admnistrativas',
                            'direccion' => function($ca_direc) {
                                $ca_direc->with('secretaria_municipal');
                            }
                        ]);
                    },
                    'cargo_mae' => function($car_mae) {
                        $car_mae->with([
                            'unidad_mae' => function($un_mae) {
                                $un_mae->with('mae');
                            }
                        ]);
                    },
                    'contrato' => function($con) {
                        $con->with('grado_academico');
                    },
                    'persona'
                ]);
            },
            'destinatario_user' => function($des_user) {
                $des_user->with([
                    'cargo_sm' => function($des_car_sm) {
                        $des_car_sm->with([
                            'unidades_admnistrativas',
                            'direccion' => function($des_car_direc) {
                                $des_car_direc->with('secretaria_municipal');
                            }
                        ]);
                    },
                    'cargo_mae' => function($des_car_mae) {
                        $des_car_mae->with([
                            'unidad_mae' => function($des_car_unid) {
                                $des_car_unid->with('mae');
                            }
                        ]);
                    },
                    'contrato' => function($des_car_con) {
                        $des_car_con->with('grado_academico');
                    },
                    'persona'
                ]);
            },
            'estado_tipo',
            'tramite' => function($des_car_trami) {
                $des_car_trami->with([
                    'hojas_ruta' => function($tram_hoja) {
                        $tram_hoja->where('actual', 1)->with([
                            'remitente_user' => function($tram_hoja_rem) {
                                $tram_hoja_rem->with([
                                    'cargo_sm' => function($tram_carsm) {
                                        $tram_carsm->with([
                                            'unidades_admnistrativas',
                                            'direccion' => function($tram_direc) {
                                                $tram_direc->with('secretaria_municipal');
                                            }
                                        ]);
                                    },
                                    'cargo_mae' => function($tram_carmae) {
                                        $tram_carmae->with([
                                            'unidad_mae' => function($tra_car_unida_mae) {
                                                $tra_car_unida_mae->with('mae');
                                            }
                                        ]);
                                    },
                                    'contrato' => function($tra_con_con) {
                                        $tra_con_con->with('grado_academico');
                                    },
                                    'persona'
                                ]);
                            },
                            'destinatario_user' => function($des_us) {
                                $des_us->with([
                                    'cargo_sm' => function($des_car_sm) {
                                        $des_car_sm->with([
                                            'unidades_admnistrativas',
                                            'direccion' => function($des_dirrec) {
                                                $des_dirrec->with('secretaria_municipal');
                                            }
                                        ]);
                                    },
                                    'cargo_mae' => function($des_cargo_mae) {
                                        $des_cargo_mae->with([
                                            'unidad_mae' => function($des_uni_mae) {
                                                $des_uni_mae->with('mae');
                                            }
                                        ]);
                                    },
                                    'contrato' => function($des_contra) {
                                        $des_contra->with('grado_academico');
                                    }
                                ]);
                            },
                            'estado_tipo'
                        ]);
                    },
                    'tipo_prioridad',
                    'tipo_tramite',
                    'estado_tipo',
                    'remitente_user'=>function($rem_user){
                        $rem_user->with(['cargo_sm'=>function($car_sm){
                            $car_sm->with([
                                'unidades_admnistrativas',
                                'direccion' => function($ca_direc) {
                                    $ca_direc->with('secretaria_municipal');
                                }
                            ]);
                        },
                        'cargo_mae'=>function($car_mae){
                            $car_mae->with([
                                'unidad_mae' => function($un_mae) {
                                    $un_mae->with('mae');
                                }
                            ]);
                        },
                        'contrato'=>function($con){
                            $con->with('grado_academico');
                        },
                        'persona']);
                    },
                    'destinatario_user'=>function($des_user){
                        $des_user->with(['cargo_sm'=>function($car_sm){
                            $car_sm->with([
                                'unidades_admnistrativas',
                                'direccion' => function($ca_direc) {
                                    $ca_direc->with('secretaria_municipal');
                                }
                            ]);
                        },
                        'cargo_mae'=>function($car_mae){
                            $car_mae->with([
                                'unidad_mae' => function($un_mae) {
                                    $un_mae->with('mae');
                                }
                            ]);
                        },
                        'contrato'=>function($con){
                            $con->with('grado_academico');
                        },
                        'persona']);
                    },
                    'user_cargo_tramite'
                ]);
            }
        ])->where('destinatario_id', $request->id)
        ->where('actual', 1)
        ->where('estado_id', 3)
        ->get();
        return response()->json($hoja_ruta_listar);
    }

    //para reeviar y responder con correspondiente
    public function recibidos_tramite_reenviar(Request $request)  {
        $validar = Validator::make($request->all(), [
            'destinatario'  => ['required', 'not_in:0'],
            'instructivo'          => 'required',
        ]);

        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            try {
                // Inicia una transacción
               DB::beginTransaction();

                //la hoja de ruta actual
                $hoja_ruta_actual = Hojas_ruta::find($request->id_hoja_ruta);
                $hoja_ruta_actual->actual =  0;
                $hoja_ruta_actual->estado_id =  4;
                $hoja_ruta_actual->save();

                // Fetch the Tramite along with its hojas_ruta
                $tramite = Tramite::with('hojas_ruta')->find($request->id_tramite_resp);

                // Count the hojas_ruta
                $hojasRutaCount = $tramite->hojas_ruta->count() + 1;

                //para crear la nueva hoja de ruta
                $hoja_ruta_new = new Hojas_ruta();
                // Guardar las hojas de ruta
                $hoja_ruta_new                      = new Hojas_ruta();
                $hoja_ruta_new->paso                = $hojasRutaCount;
                $hoja_ruta_new->paso_txt            = numero_a_ordinal($hojasRutaCount);
                $hoja_ruta_new->instructivo         = $request->instructivo;
                $hoja_ruta_new->nro_hojas_ingreso   = $request->numero_hojas;
                $hoja_ruta_new->nro_anexos_ingreso  = $request->numero_anexos;
                $hoja_ruta_new->fecha_salida        = date('Y-m-d H:m:s');
                $hoja_ruta_new->fecha_envio         = date('Y-m-d H:m:s');
                $hoja_ruta_new->actual              = 1;
                $hoja_ruta_new->remitente_id        = $request->id_remitente;
                $hoja_ruta_new->destinatario_id     = $request->destinatario;
                $hoja_ruta_new->estado_id           = 2;
                $hoja_ruta_new->tramite_id          = $request->id_tramite_resp;
                $hoja_ruta_new->save();


                // Confirmar la transacción
                DB::commit();

                // Verifica si se guardó la hoja de ruta
                if ($hoja_ruta_new->id) {
                    $data = mensaje_mostrar('success', 'Se respondio con éxito!');
                } else {
                    $data = mensaje_mostrar('error', 'Error al crear el trámite');
                }

            } catch (\Exception $e) {
                // Revertir la transacción si algo falla
                DB::rollBack();
                $data = mensaje_mostrar('error', 'Error al crear el trámite: ' . $e->getMessage());
            }
        }
        return response()->json($data);
    }

    /**
     * FIN DE LA PARTE DE LOS RECIVIDOS
     */




    /**
     * PARA LA PARTE DE LOS OBSERVADOS
     */
    public function observados($id){
        $id_descript                = desencriptar($id);
        $cargo                      = User_cargo_tramite::with(['cargo_sm', 'cargo_mae'])->find($id_descript);
        $data['cargo_enum']         = $cargo;
        $data['id_user_cargo_tram'] = $id_descript;
        $data['titulo_menu']        = 'OBSERVADOS';
        $data['menu']               = 60;


        $data['contar_num_tramite'] = Tramite::where('user_cargo_id', $id_descript)
                                        ->count();

        $data['contar_bandeja_entrada'] = Hojas_ruta::where('destinatario_id', $id_descript)
                                        ->where('estado_id', 2)
                                        ->count();

        $data['contar_bandeja_recibido'] = Hojas_ruta::where('destinatario_id', $id_descript)
                                        ->where('estado_id', 3)
                                        ->count();

        $data['contar_bandeja_observado'] = Hojas_ruta::where('destinatario_id', $id_descript)
                                        ->where('estado_id', 6)
                                        ->count();

        //PARA LISTAR LOS TRAMITES CORRESPONDIENTES


        return view('administrador.tramite.correspondencia.observados', $data);
    }
    /**
     * FIN DE LA PARTE DE LOS OBSERVADOS
     */



    /**
      * PARA LA PARTE DE LOS ARCHIVADOS
    */
    public function archivados($id){
        $id_descript                = desencriptar($id);
        $cargo                      = User_cargo_tramite::with(['cargo_sm', 'cargo_mae'])->find($id_descript);
        $data['cargo_enum']         = $cargo;
        $data['id_user_cargo_tram'] = $id_descript;
        $data['titulo_menu']        = 'ARCHIVADOS';
        $data['menu']               = 60;


        $data['contar_num_tramite'] = Tramite::where('user_cargo_id', $id_descript)
                                        ->where('id_estado', 2)
                                        ->count();

        $data['contar_bandeja_entrada'] = Hojas_ruta::where('destinatario_id', $id_descript)
                                        ->where('estado_id', 2)
                                        ->count();

        $data['contar_bandeja_recibido'] = Hojas_ruta::where('destinatario_id', $id_descript)
                                        ->where('estado_id', 3)
                                        ->count();

        $data['contar_bandeja_observado'] = Hojas_ruta::where('destinatario_id', $id_descript)
                                        ->where('estado_id', 6)
                                        ->count();

        //PARA LISTAR LOS TRAMITES CORRESPONDIENTES

        return view('administrador.tramite.correspondencia.archivados', $data);
    }

    //para archivar los tramites hojas de ruta
    public function archivados_guardar(Request $request){
        $validar = Validator::make($request->all(), [
            'descripcion_archivar'  => 'required',
        ]);

        if ($validar->fails()) {
            $data = mensaje_mostrar('errores', $validar->errors());
        }else{
            $hoja_ruta              = Hojas_ruta::find($request->id_hoja_ruta_rec);
            $hoja_ruta->estado_id   = 4;

            $tramite = Tramite::find($hoja_ruta->tramite_id);
            $tramite->id_estado     = 4;
            $tramite->save();

            $hoja_ruta->save();
            //para crear el archivo de archivado
            $archivado = new Ruta_archivado();
            $archivado->descripcion = $request->descripcion_archivar;
            $archivado->id_hoja_ruta = $request->id_hoja_ruta_rec;
            $archivado->save();

            if($archivado->id){
                $data = mensaje_mostrar('success', 'Se archivo con exito');
            }else{
                $data = mensaje_mostrar('error', 'Ocurrio un error');
            }
        }
        return response()->json($data);
    }

    public function archivados_listar(Request $request){
        $hoja_ruta_listar = Hojas_ruta::with([
            'ruta_archivado',
            'remitente_user' => function($rem_us) {
                $rem_us->with([
                    'cargo_sm' => function($re_car_sm) {
                        $re_car_sm->with([
                            'unidades_admnistrativas',
                            'direccion' => function($ca_direc) {
                                $ca_direc->with('secretaria_municipal');
                            }
                        ]);
                    },
                    'cargo_mae' => function($car_mae) {
                        $car_mae->with([
                            'unidad_mae' => function($un_mae) {
                                $un_mae->with('mae');
                            }
                        ]);
                    },
                    'contrato' => function($con) {
                        $con->with('grado_academico');
                    },
                    'persona'
                ]);
            },
            'destinatario_user' => function($des_user) {
                $des_user->with([
                    'cargo_sm' => function($des_car_sm) {
                        $des_car_sm->with([
                            'unidades_admnistrativas',
                            'direccion' => function($des_car_direc) {
                                $des_car_direc->with('secretaria_municipal');
                            }
                        ]);
                    },
                    'cargo_mae' => function($des_car_mae) {
                        $des_car_mae->with([
                            'unidad_mae' => function($des_car_unid) {
                                $des_car_unid->with('mae');
                            }
                        ]);
                    },
                    'contrato' => function($des_car_con) {
                        $des_car_con->with('grado_academico');
                    },
                    'persona'
                ]);
            },
            'estado_tipo',
            'tramite' => function($des_car_trami) {
                $des_car_trami->with([
                    'hojas_ruta' => function($tram_hoja) {
                        $tram_hoja->where('actual', 1)->with([
                            'remitente_user' => function($tram_hoja_rem) {
                                $tram_hoja_rem->with([
                                    'cargo_sm' => function($tram_carsm) {
                                        $tram_carsm->with([
                                            'unidades_admnistrativas',
                                            'direccion' => function($tram_direc) {
                                                $tram_direc->with('secretaria_municipal');
                                            }
                                        ]);
                                    },
                                    'cargo_mae' => function($tram_carmae) {
                                        $tram_carmae->with([
                                            'unidad_mae' => function($tra_car_unida_mae) {
                                                $tra_car_unida_mae->with('mae');
                                            }
                                        ]);
                                    },
                                    'contrato' => function($tra_con_con) {
                                        $tra_con_con->with('grado_academico');
                                    },
                                    'persona'
                                ]);
                            },
                            'destinatario_user' => function($des_us) {
                                $des_us->with([
                                    'cargo_sm' => function($des_car_sm) {
                                        $des_car_sm->with([
                                            'unidades_admnistrativas',
                                            'direccion' => function($des_dirrec) {
                                                $des_dirrec->with('secretaria_municipal');
                                            }
                                        ]);
                                    },
                                    'cargo_mae' => function($des_cargo_mae) {
                                        $des_cargo_mae->with([
                                            'unidad_mae' => function($des_uni_mae) {
                                                $des_uni_mae->with('mae');
                                            }
                                        ]);
                                    },
                                    'contrato' => function($des_contra) {
                                        $des_contra->with('grado_academico');
                                    }
                                ]);
                            },
                            'estado_tipo'
                        ]);
                    },
                    'tipo_prioridad',
                    'tipo_tramite',
                    'estado_tipo',
                    'remitente_user'=>function($rem_user){
                        $rem_user->with(['cargo_sm'=>function($car_sm){
                            $car_sm->with([
                                'unidades_admnistrativas',
                                'direccion' => function($ca_direc) {
                                    $ca_direc->with('secretaria_municipal');
                                }
                            ]);
                        },
                        'cargo_mae'=>function($car_mae){
                            $car_mae->with([
                                'unidad_mae' => function($un_mae) {
                                    $un_mae->with('mae');
                                }
                            ]);
                        },
                        'contrato'=>function($con){
                            $con->with('grado_academico');
                        },
                        'persona']);
                    },
                    'destinatario_user'=>function($des_user){
                        $des_user->with(['cargo_sm'=>function($car_sm){
                            $car_sm->with([
                                'unidades_admnistrativas',
                                'direccion' => function($ca_direc) {
                                    $ca_direc->with('secretaria_municipal');
                                }
                            ]);
                        },
                        'cargo_mae'=>function($car_mae){
                            $car_mae->with([
                                'unidad_mae' => function($un_mae) {
                                    $un_mae->with('mae');
                                }
                            ]);
                        },
                        'contrato'=>function($con){
                            $con->with('grado_academico');
                        },
                        'persona']);
                    },
                    'user_cargo_tramite'
                ]);
            }
        ])->where('destinatario_id', $request->id)
        ->where('actual', 1)
        ->where('estado_id', 4)
        ->get();
        return response()->json($hoja_ruta_listar);
    }
    /**
     * FIN DE LA PARTE DE LOS ARCHIVADOS
     */



    /**
        * PARA LA PARTE DE CONSULTA DE DATOS
    */

    public function seguimiento_correspondencia(Request $request)
    {
        $tramite = Tramite::with([
            'hojas_ruta' => function($horu) {
                $horu->where('actual', 1);
                $horu->with([
                    'ruta_archivado',
                    'remitente_user' => function($rem_user) {
                        $rem_user->with([
                            'cargo_sm',
                            'cargo_mae',
                            'contrato' => function($con) {
                                $con->with([
                                    'grado_academico'
                                ]);
                            },
                            'persona',
                        ]);
                    },
                    'destinatario_user' => function($des_user) {
                        $des_user->with([
                            'cargo_sm',
                            'cargo_mae',
                            'contrato' => function($con) {
                                $con->with([
                                    'grado_academico'
                                ]);
                            },
                            'persona',
                        ]);
                    },
                ]);
            },
            'remitente_user' => function($rem_user) {
                $rem_user->with([
                    'cargo_sm',
                    'cargo_mae',
                    'contrato' => function($con) {
                        $con->with([
                            'grado_academico'
                        ]);
                    },
                    'persona',
                ]);
            },
            'tipo_tramite',
        ])->where('numero_unico', $request->numero)->first();

        if ($tramite) {
            $numero_unico = $tramite->numero_unico;
            $fecha_creada = $tramite->fecha_creada;
            $nombre_remitente = "";
            if ($tramite->remitente_nombre != null && $tramite->remitente_nombre != '') {
                $nombre_remitente = $tramite->remitente_nombre;
            } else {
                $nombre_remitente = $tramite->remitente_user->contrato->grado_academico->abreviatura . ' ' . $tramite->remitente_user->persona->nombres . ' ' . $tramite->remitente_user->persona->ap_paterno . ' ' . $tramite->remitente_user->persona->ap_materno;
            }
            $referencia = $tramite->referencia;

            $destinatario_actual = "";

            if ($tramite->hojas_ruta->isNotEmpty()) {
                if (!empty($tramite->hojas_ruta[0]->fecha_ingreso)) {
                    $destinatario_actual = $tramite->hojas_ruta[0]->destinatario_user->contrato->grado_academico->abreviatura . ' ' . $tramite->hojas_ruta[0]->destinatario_user->persona->nombres . ' ' . $tramite->hojas_ruta[0]->destinatario_user->persona->ap_paterno . ' ' . $tramite->hojas_ruta[0]->destinatario_user->persona->ap_materno;
                } else {
                    $destinatario_actual = $tramite->hojas_ruta[0]->remitente_user->contrato->grado_academico->abreviatura . ' ' . $tramite->hojas_ruta[0]->remitente_user->persona->nombres . ' ' . $tramite->hojas_ruta[0]->remitente_user->persona->ap_paterno . ' ' . $tramite->hojas_ruta[0]->remitente_user->persona->ap_materno;
                }

                $estado_archivado = " <span class='badge rounded-pill bg-success'>EN CURSO</span> ";
                if (isset($tramite->hojas_ruta[0]->ruta_archivado) && !is_null($tramite->hojas_ruta[0]->ruta_archivado)) {
                    $estado_archivado = " ARCHIVADO : " . $tramite->hojas_ruta[0]->ruta_archivado->descripcion;

                }

                $data = [
                    'tipo'                  => 'success',
                    'numero_unico'          => $numero_unico.'/'.$tramite->gestion,
                    'fecha_creada'          => $fecha_creada,
                    'nombre_remitente'      => $nombre_remitente,
                    'referencia'            => $referencia,
                    'destinatario_actual'   => $destinatario_actual,
                    'estado_actual'         => $estado_archivado,
                ];
            } else {
                $data = mensaje_mostrar('error', 'No Existe el tramite');
            }
        } else {
            $data = mensaje_mostrar('error', 'No se encontró el trámite');
        }

        return response()->json($data);
    }




    /**
     * FIN DE LA PARTE
     */

}
