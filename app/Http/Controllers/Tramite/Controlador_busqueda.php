<?php

namespace App\Http\Controllers\Tramite;

use App\Http\Controllers\Controller;
use App\Models\Configuracion_tramite\User_cargo_tramite;
use Illuminate\Http\Request;
use App\Models\Tramite\Tramite;

class Controlador_busqueda extends Controller
{
    //para la parte de la busqueda de tramite
    public function vista_busqueda(){
        $data['menu'] = 70;

        $user_cargo_tram    = User_cargo_tramite::with([
            'cargo_sm'=>function($csm){
                $csm->with([
                    'unidades_admnistrativas',
                    'direccion'=>function($dir){
                        $dir->with(['secretaria_municipal']);
                    }
                ]);
            },
            'cargo_mae'=>function($cmae){
                $cmae->with([
                    'unidad_mae'=>function($un_mae){
                        $un_mae->with([
                            'cargos'
                        ]);
                    },
                ]);
            },
            'persona',
            'contrato'=>function($con){
                $con->with([
                    'grado_academico'
                ]);
            },
            ])->get();
        $data['cargo_persona'] = $user_cargo_tram;
        return view('administrador.buscar_tramite.buscar_tramite', $data);
    }

    //para la vizualizacion
    public function vizualizar_busqueda_tramites(Request $request) {
        $query = Tramite::withCount('hojas_ruta')
        ->with([
            'hojas_ruta',
            'tipo_prioridad',
            'tipo_tramite',
            'estado_tipo',
            'remitente_user' => function ($ruse) {
                $ruse->with([
                    'persona',
                    'contrato' => function ($cotn) {
                        $cotn->with('grado_academico');
                    },
                ]);
            },
            'destinatario_user' => function ($des_user) {
                $des_user->with([
                    'cargo_sm',
                    'cargo_mae',
                    'persona',
                    'contrato' => function ($cdes) {
                        $cdes->with('grado_academico');
                    },
                ]);
            },
            'user_cargo_tramite' => function ($uct) {
                $uct->with([
                    'cargo_sm',
                    'cargo_mae',
                    'persona',
                    'contrato' => function ($cto) {
                        $cto->with('grado_academico');
                    },
                ]);
            },
        ]);

        if ($request->filled('numero_tramite')) {
            $query->orWhere('numero_unico', $request->numero_tramite);
        }

        if ($request->filled('referencia')) {
            $query->orWhere('referencia', 'LIKE', '%' . $request->referencia . '%');
        }

        if ($request->filled('remitente_interno')) {
            $query->orWhere('remitente_id', $request->remitente_interno);
        }

        if ($request->filled('remitente_externo')) {
            $query->orWhere('remitente_nombre', 'LIKE', '%' . $request->remitente_externo . '%');
        }

        $listar_correspondencia = $query->orderBy('id', 'desc')->get();

        $data['listar_correspondencia'] = $listar_correspondencia;

        return view('administrador.buscar_tramite.vizualizar_tramites_solicitados', $data);
    }
}
