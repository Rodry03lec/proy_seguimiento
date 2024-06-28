<?php

use App\Http\Controllers\Biometrico\Controlador_asistencias;
use App\Http\Controllers\Biometrico\Controlador_biometrico;
use App\Http\Controllers\Biometrico\Controlador_boleta;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usuario\Controlador_login;
use App\Http\Controllers\Usuario\Controlador_usuario;
use App\Http\Controllers\Configuracion\Controlador_tipocontrato;
use App\Http\Controllers\Configuracion\Controlador_ambito_profesional;
use App\Http\Controllers\Configuracion\Controlador_mae;
use App\Http\Controllers\Configuracion\Controlador_unidades_administrativas;
use App\Http\Controllers\Configuracion\Controlador_secretaria;
use App\Http\Controllers\Configuracion\Controlador_horario;
use App\Http\Controllers\Configuracion\Controlador_genero_estado;
use App\Http\Controllers\Biometrico\Controlador_feriado;
use App\Http\Controllers\Biometrico\Controlador_horario_continuo;
use App\Http\Controllers\Biometrico\Controlador_licencia;
use App\Http\Controllers\Biometrico\Controlador_permiso;
use App\Http\Controllers\Registro\Controlador_persona;
use App\Http\Controllers\Registro\Controlador_contrato;
use App\Http\Controllers\Reportes\Controlador_reporte_ausencia;
use App\Http\Controllers\Reportes\Controlador_reporte_tramite;
use App\Http\Controllers\Tramite\Controlador_configuracion;
use App\Http\Controllers\Tramite\Controlador_tramite;
use App\Http\Controllers\Reportes\Controlador_reporte;
use App\Http\Controllers\Tramite\Controlador_busqueda;

//PARA LA PARTE DE LAS ASISTENCIAS
Route::get('/gamhasistencia', function () {
    return view('asistencia.vista_asistencia');
})->name('asistencia');

Route::get('gamhasistencia', [Controlador_reporte::class, 'vista_asistencia'])->name('crep_asistencia');
Route::get('AsistenciaReporte', [Controlador_reporte::class, 'asitencia_reporte'])->name('crep_asistencia_reporte');


//PARA LA PARTE DE LA CORRESPONDENCIA
Route::get('/gamhcorrespondenica', function () {
    return view('correspondencia.vista_correspondencia');
})->name('correspondencia_vista');

Route::post('seguimiento_correspondencia', [Controlador_tramite::class, 'seguimiento_correspondencia'])->name('crep_seguimiento_correspondencia');


//AQUI PARA LOS NO AUTENTICADOS DE LOS USUSARIOS
Route::prefix('/')->middleware(['no_autenticados'])->group(function () {
    Route::get('/', function () {
        return view('login');
    })->name('login');
    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::controller(Controlador_login::class)->group(function () {
        Route::post('ingresar', 'ingresar')->name('cl_ingresar');
    });

    Route::get('captcha', [Controlador_login::class, 'generateCaptchaImage'])->name('captcha');
});

Route::prefix('/admin')->middleware(['autenticados', 'rectroceder'])->group(function () {
    Route::controller(Controlador_login::class)->group(function () {
        Route::get('inicio', 'inicio')->name('inicio');
        Route::post('mensaje', 'mensaje')->name('in_mensaje');
        Route::post('salir', 'cerrar_session')->name('salir');
    });

    Route::controller(Controlador_usuario::class)->group(function () {
        /**
         * ADMINISTRACION DEL PERFIL
         */
        Route::get('perfil', 'perfil')->name('perfil');
        Route::post('guardar_password', 'guardar_password')->name('pe_guardar');
        /**
         * FIN DE ADMINISTRACION DE PERFIL
         */

        /**
         * PARA ADMINISTRAR LOS USUARIOS
         */
        Route::get('usuarios', 'usuarios')->name('usuarios')->middleware('comprobar_permiso:usuario_submenu');
        Route::post('listar_usuario', 'listar_usuario')->name('user_listar');
        Route::post('validar_usuario', 'validar_usuario')->name('user_validar');
        Route::post('nuevo_usuario', 'nuevo_usuario')->name('user_crear')->middleware('comprobar_permiso:usuario_nuevo');;
        Route::delete('eliminar_usuario', 'eliminar_usuario')->name('user_eliminar')->middleware('comprobar_permiso:usuario_eliminar');;
        Route::post('estado_usuario', 'estado_usuario')->name('user_estado');
        Route::post('edit_usuario', 'edit_usuario')->name('user_edit')->middleware('comprobar_permiso:usuario_editar');;
        Route::post('update_usuario', 'update_usuario')->name('user_update');
        /**
         * FIN PARA ADMINISTRAR LOS USUARIOS
         */

        /**
         * ADMINISTRAR ROLES
         */
        Route::get('roles', 'roles')->name('roles')->middleware('comprobar_permiso:roles_submenu');
        Route::post('roles_guardar', 'roles_guardar')->name('rol_guardar')->middleware('comprobar_permiso:roles_nuevo');
        Route::post('roles_editar', 'roles_editar')->name('rol_editar')->middleware('comprobar_permiso:roles_editar');
        Route::post('roles_editar_guardar', 'roles_editar_guardar')->name('rol_editar_guardar');
        Route::delete('roles_eliminar', 'roles_eliminar')->name('rol_eliminar')->middleware('comprobar_permiso:roles_eliminar');
        Route::delete('roles_vizualizar', 'roles_vizualizar')->name('rol_vizualizar')->middleware('comprobar_permiso:roles_vizualizar');
        /**
         * FIN DE ADMINISTRAR LOS ROLES
         */

        /**
         * ADMINISTRAR PERMISOS
         */
        Route::get('permisos', 'permisos')->name('permisos')->middleware('comprobar_permiso:permisos_submenu');
        Route::post('guardar_permiso', 'guardar_permiso')->name('per_guardar')->middleware('comprobar_permiso:permisos_nuevo');
        Route::get('permiso_listar', 'permiso_listar')->name('per_listar');
        Route::post('permiso_editar', 'permiso_editar')->name('permis_editar')->middleware('comprobar_permiso:permisos_editar');
        Route::post('permiso_editar_guardar', 'permiso_editar_guardar')->name('pergu_editar');
        Route::delete('permiso_eliminar', 'permiso_eliminar')->name('per_eliminar')->middleware('comprobar_permiso:permisos_eliminar');
        /**
         * FIN DE ADMINISTRAR LOS PERMISOS
         */

        //ESTO VA SER LA PART DE QUE
        Route::post('encriptar', 'encriptar')->name('enc_crypt');
    });

    Route::controller(Controlador_tipocontrato::class)->group(function () {
        //PARA ADMINISTRAR TODOS LOS TIPOS DE CONTRATO QUE EXISTE
        Route::get('tipoContrato', 'tipocontrato')->name('ctc_tipoContato')->middleware('comprobar_permiso:tipo_contrato_submenu');
        Route::post('tipoContrato_guardar', 'tipocontrato_guardar')->name('tcg_guardar')->middleware('comprobar_permiso:tipo_contrato_nuevo');
        Route::post('tipoContrato_listar', 'tipocontrato_listar')->name('tcg_listar');
        Route::delete('tipoContrato_eliminar', 'tipocontrato_eliminar')->name('tcg_eliminar')->middleware('comprobar_permiso:tipo_contrato_eliminar');
        Route::post('tipoContrato_editar', 'tipocontrato_editar')->name('tcg_editar')->middleware('comprobar_permiso:tipo_contrato_editar');
        Route::post('tipoContrato_editar_guardar', 'tipocontrato_editar_guardar')->name('tcg_edit_guardar');
        //PARA ADMINISTRAR TODOS LAS CATEGORIAS QUE EXISTE
        Route::get('tipoCategoria', 'tipocategoria')->name('xtc_tipocategoria')->middleware('comprobar_permiso:tipo_categoria_submenu');
        Route::post('tipoCategoria_guardar', 'tipocategoria_guardar')->name('xtc_guardar')->middleware('comprobar_permiso:tipo_categoria_nuevo');
        Route::post('tipoCategoria_listar', 'tipocategoria_listar')->name('xtc_listar');
        Route::delete('tipoCategoria_eliminar', 'tipocategoria_eliminar')->name('xtc_eliminar')->middleware('comprobar_permiso:tipo_categoria_eliminar');
        Route::post('tipoCategoria_editar', 'tipocategoria_editar')->name('xtc_editar')->middleware('comprobar_permiso:tipo_categoria_editar');
        Route::post('tipoCategoria_editar_guardar', 'tipocategoria_editar_guardar')->name('xtc_edit_guardar');
        //PARA ADMINISTRAR TODOS LOS NIVELES SEGUN LA CATEGORIA QUE EXISTE
        Route::post('tipoNivel', 'tiponivel_abrir')->name('xtn_tiponivel_abrir')->middleware('comprobar_permiso:tipo_categoria_vizualizar');
        Route::post('nivelLista', 'nivel_lista')->name('xtn_nivellista');
        Route::post('nivelNuevo', 'nivel_nuevo')->name('xtn_nivelnuevo')->middleware('comprobar_permiso:tipo_categoria_vizualizar_nivel_nuevo');
        Route::post('nivelEditar', 'nivel_editar')->name('xtn_niveleditar')->middleware('comprobar_permiso:tipo_categoria_vizualizar_nivel_editar');
        Route::delete('nivelEliminar', 'nivel_eliminar')->name('xtn_niveleliminar')->middleware('comprobar_permiso:tipo_categoria_vizualizar_nivel_eliminar');
    });


    //PARA LA ADMINISTRACION DE AMBITO PROFESIONAL Y LAS PROFESIONES
    Route::controller(Controlador_ambito_profesional::class)->group(function () {
        //para la administracion de ambitos profesionales
        Route::get('ambitoProfesional', 'ambito_profesional')->name('cap_index')->middleware('comprobar_permiso:ambito_profesional_submenu');
        Route::post('ambitoProfesionalGuardar', 'ambito_profesional_guardar')->name('apg_guardar')->middleware('comprobar_permiso:ambito_profesional_nuevo');
        Route::delete('ambitoProfesionalEliminar', 'ambito_profesional_eliminar')->name('apg_eliminar')->middleware('comprobar_permiso:ambito_profesional_eliminar');
        Route::post('ambitoProfesionalEditar', 'ambito_profesional_editar')->name('apg_editar')->middleware('comprobar_permiso:ambito_profesional_editar');
        Route::post('ambitoProfesionalEditguardar', 'ambito_profesional_editar_guardar')->name('apg_editar_guardar');
        //para la administracion de ambitos profesionales
        Route::get('profesiones/{id}', 'profesiones')->name('pfs_index')->middleware('comprobar_permiso:ambito_profesional_vizualizar');
        Route::post('profesionesGuardar', 'profesiones_guardar')->name('pfs_guardar')->middleware('comprobar_permiso:ambito_profesional_vizualizar_profesion_nuevo');
        Route::post('profesionesListar', 'profesiones_listar')->name('pfs_listar');
        Route::delete('profesionesEliminar', 'profesiones_eliminar')->name('pfs_eliminar')->middleware('comprobar_permiso:ambito_profesional_vizualizar_profesion_eliminar');
        Route::post('profesionesEditar', 'profesiones_editar')->name('pfs_editar')->middleware('comprobar_permiso:ambito_profesional_vizualizar_profesion_editar');
        Route::post('profesionesEditarGuardar', 'profesiones_editar_guardar')->name('pfs_editar_guardar');
        //para la administracion de los grados academicos
        Route::get('gradoAcademico', 'grado_academico')->name('gac_index')->middleware('comprobar_permiso:grados_academicos_submenu');
        Route::post('gradoAcademicoGuardar', 'grado_academico_guardar')->name('gac_guardar')->middleware('comprobar_permiso:grados_academicos_nuevo');
        Route::post('gradoAcademicoListar', 'grado_academico_listar')->name('gac_listar');
        Route::post('gradoAcademicoEstado', 'grado_academico_estado')->name('gac_estado')->middleware('comprobar_permiso:grados_academicos_estado');
        Route::delete('gradoAcademicoEliminar', 'grado_academico_eliminar')->name('gac_eliminar')->middleware('comprobar_permiso:grados_academicos_eliminar');
        Route::post('gradoAcademicoEditar', 'grado_academico_editar')->name('gac_editar')->middleware('comprobar_permiso:grados_academicos_editar');
        Route::post('gradoAcademicoEditGuardar', 'grado_academico_edit_guardar')->name('gac_editar_guardar');
    });


    //PARA LA ADMINISTRACION DE MAE - CARGOS DE MAE
    Route::controller(Controlador_mae::class)->group(function () {
        //para la administracion del mae
        Route::get('Mae', 'mae')->name('mae_index')->middleware('comprobar_permiso:mae_unidad_submenu');
        Route::post('MaeGuardar', 'mae_guardar')->name('mae_guardar')->middleware('comprobar_permiso:mae_unidad_nuevo');
        Route::post('MaeListar', 'mae_listar')->name('mae_listar');
        Route::post('MaeEditar', 'mae_editar')->name('mae_editar')->middleware('comprobar_permiso:mae_unidad_editar');
        Route::post('MaeEditarGuardar', 'mae_editar_guardar')->name('mae_editar_guardar');
        Route::delete('MaeEliminar', 'mae_eliminar')->name('mae_eliminar')->middleware('comprobar_permiso:mae_unidad_eliminar');

        //para la administracion de los cargos
        Route::post('maeUnidad', 'mae_unidad')->name('mae_unidad')->middleware('comprobar_permiso:mae_unidad_vizualizar');
        Route::post('maeUnidadListar', 'mae_unidad_listar')->name('mae_unidad_listar');
        Route::post('maeUnidadNuevo', 'mae_unidad_nuevo')->name('mae_unidad_nuevo')->middleware('comprobar_permiso:mae_unidad_vizualizar_unidades_nuevo');
        Route::post('maeUnidadEditar', 'mae_unidad_editar')->name('mag_unidad_editar')->middleware('comprobar_permiso:mae_unidad_vizualizar_unidades_editar');
        Route::delete('maeUnidadEliminar', 'mae_unidad_eliminar')->name('mag_unidad_eliminar')->middleware('comprobar_permiso:mae_unidad_vizualizar_unidades_eliminar');
    });

    //ADMINISTRAR LA PARTE DE LAS UNIDADES ADMINISTRATIVAS
    Route::controller(Controlador_unidades_administrativas::class)->group(function () {
        //administracion de las unidades administrativas
        Route::get('UnidadesAdministrativas', 'unidades_administrativas')->name('uadm_index')->middleware('comprobar_permiso:unidades_administrativas_submenu');
        Route::post('UnidadesAdministrativasNuevo', 'unidades_admin_nuevo')->name('uadm_nuevo')->middleware('comprobar_permiso:unidades_administrativas_nuevo');
        Route::post('UnidadesAdministrativasListar', 'unidades_admin_listar')->name('uadm_listar');
        Route::post('UnidadesAdministrativasEditar', 'unidades_admin_editar')->name('uadm_editar')->middleware('comprobar_permiso:unidades_administrativas_editar');
        Route::post('UnidadesAdminGuardar', 'unidades_admin_edit_guardar')->name('uadm_editar_guardar');
        Route::delete('UnidadesAdminEliminar', 'unidades_admin_eliminar')->name('uadm_eliminar')->middleware('comprobar_permiso:unidades_administrativas_eliminar');
        Route::post('UnidadesAdminEstado', 'unidades_admin_estado')->name('uadm_estado')->middleware('comprobar_permiso:unidades_administrativas_estado');
    });


    //PARA LA ADMINISTRACION DE LAS SECRETARIAS MUNICIPALES Y DIRECCIÓN
    Route::controller(Controlador_secretaria::class)->group(function () {
        //para la administracion de las secretarias municipales
        Route::get('SecretariaMunicipal', 'secretaria_municipal')->name('smun_index')->middleware('comprobar_permiso:secretaria_municipales_direccion_submenu');
        Route::post('SecretariaMunicipalGuardar', 'secretaria_municipal_guardar')->name('smun_guardar')->middleware('comprobar_permiso:secretaria_municipales_direccion_nuevo');
        Route::post('SecretariaMunicipalListar', 'secretaria_municipal_listar')->name('smun_listar');
        Route::post('SecretariaMunicipalEstado', 'secretaria_municipal_estado')->name('smun_estado')->middleware('comprobar_permiso:secretaria_municipales_direccion_estado');
        Route::delete('SecretariaMunicipalEliminar', 'secretaria_municipal_eliminar')->name('smun_eliminar')->middleware('comprobar_permiso:secretaria_municipales_direccion_eliminar');
        Route::post('SecretariaMunicipalEditar', 'secretaria_municipal_editar')->name('smun_editar')->middleware('comprobar_permiso:secretaria_municipales_direccion_editar');
        Route::post('SecretariaMunicipalEditGuardar', 'secretaria_municipal_edit_guardar')->name('smun_edit_guardar');
        //para la administracion de las direcciones de las secretarias municipales
        Route::get('Direccion', 'direccion')->name('dir_index');
        Route::post('DireccionVista', 'direccion_vista')->name('dir_vista')->middleware('comprobar_permiso:secretaria_municipales_direccion_vizualizar');
        Route::post('DireccionGuardar', 'direccion_guardar')->name('dir_guardar')->middleware('comprobar_permiso:secretaria_municipales_direccion_vizualizar_nuevo');
        Route::post('DireccionListar', 'direccion_listar')->name('dir_listar');
        Route::post('DireccionEditar', 'direccion_editar')->name('dir_editar')->middleware('comprobar_permiso:secretaria_municipales_direccion_vizualizar_editar');
        Route::delete('DireccionEliminar', 'direccion_eliminar')->name('dir_eliminar')->middleware('comprobar_permiso:secretaria_municipales_direccion_vizualizar_eliminar');
        Route::post('DireccionEstado', 'direccion_estado')->name('dir_estado')->middleware('comprobar_permiso:secretaria_municipales_direccion_vizualizar_estado');
    });

    //para la parte de la administracion de los horarios
    Route::controller(Controlador_horario::class)->group(function () {
        //esto es para la administracion de los tipos de horario
        Route::get('horarios', 'horarios')->name('hor_index')->middleware('comprobar_permiso:horarios_submenu');
        Route::post('horariosNuevo', 'horarios_nuevo')->name('hor_nuevo_save')->middleware('comprobar_permiso:horarios_nuevo');
        Route::post('horariosListar', 'horarios_listar')->name('hor_listar');
        Route::delete('horariosEliminar', 'horarios_eliminar')->name('hor_eliminar')->middleware('comprobar_permiso:horarios_eliminar');
        Route::post('horariosEditar', 'horarios_editar')->name('hor_editar')->middleware('comprobar_permiso:horarios_editar');
        Route::post('horariosEditarGuardar', 'horarios_editar_guardar')->name('hor_editar_guardar');
        //para la parte de la administración de los horarios especificos
        Route::post('horariosEspecificos', 'horarios_especificos')->name('hes_nuevo')->middleware('comprobar_permiso:horarios_editar');
        Route::post('horariosEspecificosListar', 'horarios_especificos_listar')->name('hes_listar');
        Route::post('horariosEspecificosEditar', 'horarios_especificos_editar')->name('hes_editar')->middleware('comprobar_permiso:horarios_vizualizar_especificacion_horas_editar');
        Route::delete('horariosEspecificosEliminar', 'horarios_especificos_eliminar')->name('hes_eliminar')->middleware('comprobar_permiso:horarios_vizualizar_especificacion_horas_eliminar');

        //PARA LA PARTE DE ASIGNACION DE HORARIOS
        Route::get('excepcionHorario/{id}', 'excepcion_horario')->name('exhor_index')->middleware('comprobar_permiso:horarios_vizualizar_especificacion_horas_excepciones');
        Route::post('excepcion_guardar', 'excepcion_guardar')->name('exept_guardar')->middleware('comprobar_permiso:horarios_vizualizar_especificacion_horas_excepciones_nuevo');
        Route::post('excepcion_listar', 'excepcion_listar')->name('exept_listar');
        Route::post('excepcion_estado', 'excepcion_estado')->name('exept_estado')->middleware('comprobar_permiso:horarios_vizualizar_especificacion_horas_excepciones_estado');
        Route::post('excepcion_edit', 'excepcion_edit')->name('exept_edit')->middleware('comprobar_permiso:horarios_vizualizar_especificacion_horas_excepciones_editar');
        Route::post('excepcion_edit_guardar', 'excepcion_edit_guardar')->name('exept_edit_save');
    });

    //para la parte de la administracion de los generos y estado civil
    Route::controller(Controlador_genero_estado::class)->group(function () {
        //para la la vista de los generos y estados civiles
        Route::get('GeneroEstado', 'genero_estado')->name('ges_index')->middleware('comprobar_permiso:genero_estado_civil_submenu');
        //para listar los generos
        Route::post('GeneroListar', 'genero_listar')->name('gen_listar');
        Route::post('GeneroNuevo', 'genero_nuevo')->name('gen_nuevo')->middleware('comprobar_permiso:genero_nuevo');
        Route::delete('GeneroEliminar', 'genero_eliminar')->name('gen_eliminar')->middleware('comprobar_permiso:genero_eliminar');
        Route::post('GeneroEstado', 'genero_estados')->name('gen_estado')->middleware('comprobar_permiso:genero_estado');
        Route::post('GeneroEditar', 'genero_editar')->name('gen_editar')->middleware('comprobar_permiso:genero_editar');
        Route::post('GeneroEditarGuardar', 'genero_editar_guardar')->name('gen_editar_guardar');
        //para listar los estados civiles
        Route::post('EstadoCivilListar', 'estado_civil_listar')->name('eci_listar');
        Route::post('EstadoCivilNuevo', 'estado_civil_nuevo')->name('eci_nuevo')->middleware('comprobar_permiso:estado_civil_nuevo');
        Route::delete('EstadoCivilEliminar', 'estado_civil_eliminar')->name('eci_eliminar')->middleware('comprobar_permiso:estado_civil_eliminar');
        Route::post('EstadoCivilEstado', 'estado_civil_estado')->name('eci_estado')->middleware('comprobar_permiso:estado_civil_estado');
        Route::post('EstadoCivilEditar', 'estado_civil_editar')->name('eci_editar')->middleware('comprobar_permiso:estado_civil_editar');
        Route::post('EstadoCivilEditarGuardar', 'estado_civil_editar_guardar')->name('eci_editar_guardar');
    });


    //PARA LA PARTE DEL REGISTRO DE PERSONAS
    Route::controller(Controlador_persona::class)->group(function () {
        Route::get('persona', 'persona')->name('per_index')->middleware('comprobar_permiso:persona_submenu');
        Route::post('persona_buscar', 'persona_buscar')->name('per_buscar');
        Route::post('persona_nuevo', 'persona_nuevo')->name('per_nuevo')->middleware('comprobar_permiso:persona_nuevo');
        Route::post('persona_validar', 'persona_validar')->name('per_validar');
        Route::post('persona_editar', 'persona_editar')->name('per_editar')->middleware('comprobar_permiso:persona_editar');
        Route::post('persona_editar_guardar', 'persona_editar_guardar')->name('per_editar_guardar');
        Route::delete('persona_eliminar', 'persona_eliminar')->name('per_eliminar')->middleware('comprobar_permiso:persona_eliminar');
    });

    //PARA LA ADMINISTRACION DE REGISTRO DE CONTRATOS
    Route::controller(Controlador_contrato::class)->group(function () {
        Route::get('contrato', 'contrato')->name('cco_index')->middleware('comprobar_permiso:contrato_submenu');
        Route::post('listar_profesiones', 'listar_profesiones')->name('cco_listar_profesion');
        Route::post('tipo_contrato_selec', 'tipo_contrato_selec')->name('cco_tipo_contrato_select');
        Route::post('nivel_select', 'nivel_select')->name('cco_nivel_select');
        Route::post('horarios_select', 'horarios_select')->name('cco_horarios_select');
        Route::post('unidad_select', 'unidad_select')->name('cco_unidad_select');
        Route::post('cargo_select', 'cargo_select')->name('cco_cargo_select');
        Route::post('direccion_select', 'direccion_select')->name('cco_direccion_select');
        Route::post('cargo_select_sm', 'cargo_select_sm')->name('cco_cargo_select_sm');
        //para el guardao del
        Route::post('guardar_contrato', 'guardar_contrato')->name('gco_guardar_contrato')->middleware('comprobar_permiso:contrato_nuevo');
        //para listar contratos espécificos
        Route::get('listarContrato/{id}', 'listar_contratos')->name('lc_listar_contratos');
        Route::post('listarContrato', 'listar_contratos_especifico')->name('lis_lista_contrato_especifico');
        Route::post('vizualizarContrato', 'vizualizar_contrato')->name('viz_contrato')->middleware('comprobar_permiso:persona_listar_contratos_vizualizar');
        Route::post('Contrato_datos', 'contrato_datos')->name('cont_datos');
        //guardar una baja
        Route::post('bajaContrato', 'baja_contrato')->name('bc_baja_contrato');
        Route::post('vizualizarBaja', 'vizualizar_baja')->name('viz_baja');
        Route::post('vizualizarBajaeditado', 'vizualizar_baja_editar')->name('viz_baja_edit');


        //PARA LA EDICION DEL CONTRATO
        Route::post('editarcontrato', 'editar_contrato')->name('cct_editar_contrato');
        Route::post('editarcontrato_save', 'editar_contrato_save')->name('cct_editar_contrato_save');
    });

    //PARA LA ADMINISTRACION DE BIOMETRICO
    Route::controller(Controlador_biometrico::class)->group(function () {
        Route::get('biometrico', 'biometrico')->name('bio_index')->middleware('comprobar_permiso:subir_biometrico_submenu');
        Route::post('biometrico_subir', 'biometrico_subir')->name('bio_subir')->middleware('comprobar_permiso:subir_biometrico_validar_archivo');
        Route::get('especial', 'especial')->name('bio_especial')->middleware('comprobar_permiso:especial_submenu');
    });



    //PARA LA ADMINISTRACION DE LAS ASSITENCIAS
    Route::controller(Controlador_asistencias::class)->group(function () {
        Route::get('asistencia', 'asistencia')->name('asist_index')->middleware('comprobar_permiso:asistencia_submenu');
        Route::get('generarAsistencia', 'generar_asistencia')->name('asist_generar')->middleware('comprobar_permiso:asistencia_generar');
        Route::post('editar_asistencia', 'editar_asistencia')->name('asit_editar')->middleware('comprobar_permiso:asistencia_editar');
        Route::post('guardar_asist_edi', 'guardar_asist_editado')->name('asit_editar_save');
    });

    //PARA LA ADMINISTRACION DE PERMISOS FERIADOS
    Route::controller(Controlador_feriado::class)->group(function () {
        Route::get('feriado', 'feriado')->name('cfer_index')->middleware('comprobar_permiso:especial_feriado');
        Route::post('lista_fechas', 'lista_fechas')->name('cfer_lisfechas');
        Route::post('mostrar_fecha_principal', 'mostrar_fecha_principal')->name('cfer_mostrar_fecha');
        Route::post('feriado_guardar', 'feriado_guardar')->name('cfer_feriado_guardar');
        Route::post('feriado_editar', 'feriado_editar')->name('cfer_feriado_edit');
        Route::post('feriado_editar_guardar', 'feriado_editar_guardar')->name('cfer_feriado_edit_guardar');
        Route::delete('feriado_eliminar', 'feriado_eliminar')->name('cfer_eliminar');
    });

    //PARA LA ADMINISTRACION DEL HORARIO CONTINUO
    Route::controller(Controlador_horario_continuo::class)->group(function () {
        Route::get('horario_continuo', 'horario_continuo')->name('chcon_index')->middleware('comprobar_permiso:especial_horario_continuo');
        Route::post('hor_continuo_guardar', 'hor_continuo_guardar')->name('chcon_nuevo')->middleware('comprobar_permiso:especial_horario_continuo_nuevo');
        Route::post('hor_continuo_listar', 'hor_continuo_listar')->name('chcon_listar');
        Route::post('hor_continuo_editar', 'hor_continuo_editar')->name('chcon_editar')->middleware('comprobar_permiso:especial_horario_continuo_editar');
        Route::post('hor_continuo_edit_guardar', 'hor_continuo_edit_guardar')->name('chcon_editar_guardar');
        Route::delete('hor_continuo_eliminar', 'hor_continuo_eliminar')->name('chcon_eliminar')->middleware('comprobar_permiso:especial_horario_continuo_eliminar');
        Route::post('hor_continuo_estado', 'hor_continuo_estado')->name('chcon_estado')->middleware('comprobar_permiso:especial_horario_continuo_estado');
    });


    //PARA EL LA ADMINISTRACION DE LAS LICENCIAS
    Route::controller(Controlador_licencia::class)->group(function () {
        Route::get('configuracion_licencia', 'configuracion_licencia')->name('clic_configuracion')->middleware('comprobar_permiso:especial_licencias');
        Route::post('tipo_licencia_listar', 'tipo_licencia_listar')->name('clic_listar_tiplicencia');
        Route::post('tipo_licencia_estado', 'tipo_licencia_estado')->name('clic_tipolicecnia_estado')->middleware('comprobar_permiso:especial_licencias_estado');
        Route::post('tipo_licencia_nuevo', 'tipo_licencia_nuevo')->name('clic_tipolicecnia_nuevo')->middleware('comprobar_permiso:especial_licencias_nuevo');
        Route::post('tipo_licencia_editar', 'tipo_licencia_editar')->name('clic_tipolicecnia_editar')->middleware('comprobar_permiso:especial_licencias_editar');
        Route::post('tipo_licencia_edi_save', 'tipo_licencia_editar_save')->name('clic_tipolicecnia_edi_save');
        Route::delete('tipo_licencia_eliminar', 'tipo_licencia_eliminar')->name('clic_tipolicecnia_eliminar')->middleware('comprobar_permiso:especial_licencias_eliminar');
    });

    //PARA LA ADMINISTRACION DE LOS TIPOS DE PERMISOS
    Route::controller(Controlador_permiso::class)->group(function () {
        //para la administracion de los tipos de permiso
        Route::get('tipo_permiso', 'tipo_permiso')->name('cper_index')->middleware('comprobar_permiso:especial_permisos');
        Route::post('tipo_permiso_listar', 'tipo_permiso_listar')->name('cper_per_listar');
        Route::post('tipo_permiso_estado', 'tipo_permiso_estado')->name('cper_per_estado')->middleware('comprobar_permiso:especial_permisos_estado');
        Route::post('tipo_permiso_nuevo', 'tipo_permiso_nuevo')->name('cper_per_nuevo')->middleware('comprobar_permiso:especial_permisos_nuevo');
        Route::delete('tipo_permiso_eliminar', 'tipo_permiso_eliminar')->name('cper_per_eliminar')->middleware('comprobar_permiso:especial_permisos_eliminar');
        Route::post('tipo_permiso_editar', 'tipo_permiso_editar')->name('cper_per_editar')->middleware('comprobar_permiso:especial_permisos_editar');
        Route::post('tipo_permiso_editar_save', 'tipo_permiso_editar_save')->name('cper_per_edit_save');

        //para la administracion del desglose de los permisos
        Route::post('desglose_permiso_listar', 'desglose_permiso_listar')->name('dplis_listar')->middleware('comprobar_permiso:especial_permisos_desglose');
        Route::post('desglose_permiso_guardar', 'desglose_permiso_guardar')->name('dplis_guardar')->middleware('comprobar_permiso:especial_permisos_desglose_nuevo');
        Route::delete('desglose_permiso_eliminar', 'desglose_permiso_eliminar')->name('dplis_eliminar')->middleware('comprobar_permiso:especial_permisos_desglose_eliminar');
        Route::post('desglose_permiso_editar', 'desglose_permiso_editar')->name('dplis_editar')->middleware('comprobar_permiso:especial_permisos_desglose_editar');
        Route::post('desglose_permiso_estado', 'desglose_permiso_estado')->name('dplis_estado')->middleware('comprobar_permiso:especial_permisos_desglose_estado');


        //para la administracion de
    });


    //PARA LA ADMINISTRACION DE GENERAR BOLETAS
    Route::controller(Controlador_boleta::class)->group(function () {
        Route::get('boleta', 'boleta')->name('cbol_index')->middleware('comprobar_permiso:boletas_submenu');

        Route::get('/buscar-persona', 'buscarPersona')->name('buscar_persona_bol');
        //para la generacion de permisos
        Route::get('boleta_permiso', 'boleta_permiso')->name('cbol_boleta_permiso');
        Route::post('persona_ci', 'persona_ci')->name('cbol_persona_ci');
        Route::post('boleta_per_desglose', 'boleta_per_desglose')->name('cbol_permiso_desglose');
        Route::post('permiso_boleta_guardar', 'permiso_boleta_guardar')->name('cbol_boleta_guardar');
        Route::post('permiso_boleta_listar', 'permiso_boleta_listar')->name('cbol_boleta_listar');
        Route::post('permiso_boleta_aprobar', 'permiso_boleta_aprobar')->name('cbol_boleta_aprobar');
        Route::post('permiso_boleta_constancia', 'permiso_boleta_constancia')->name('cbol_boleta_constancia');
        Route::post('permiso_boleta_editar', 'permiso_boleta_editar')->name('cbol_boleta_editar');


        //PARA LAS EDICIONES DE LA BOLETA PARA GUARDAR
        Route::post('permiso_boleta_editar_save', 'permiso_boleta_editar_save')->name('cbol_boleta_permiso_edit_save');
        Route::post('permiso_boleta_vizualizar', 'permiso_boleta_vizualizar')->name('cbol_boleta_permiso_vizualizar');

        Route::delete('permiso_boleta_eliminar', 'permiso_boleta_eliminar')->name('cbol_boleta_permiso_eliminar');


        //para la generarcion de las licencias
        Route::get('boleta_licencia', 'boleta_licencia')->name('cbol_boleta_licencia');
        Route::post('boleta_licencia_guardar', 'boleta_licencia_guardar')->name('licen_boleta_guardar');
        Route::post('boleta_licencia_listar', 'boleta_licencia_listar')->name('licen_boleta_listar');
        Route::post('boleta_licencia_aprobado', 'boleta_licencia_aprobado')->name('licen_boleta_aprobado');
        Route::post('boleta_licencia_constancia', 'boleta_licencia_constancia')->name('licen_boleta_constancia');
        Route::post('boleta_licencia_vizualizar', 'boleta_licencia_vizualizar')->name('licen_boleta_vizualizar');
        Route::delete('boleta_licencia_eliminar', 'boleta_licencia_eliminar')->name('licen_boleta_eliminar');
        Route::post('boleta_licencia_edit', 'boleta_licencia_edit')->name('licen_boleta_edit');
        Route::post('boleta_licencia_editar', 'boleta_licencia_editar')->name('licen_boleta_editar');
    });



    //PARA LA PARTE DE LOS REPORTES
    Route::controller(Controlador_reporte_ausencia::class)->group(function () {
        Route::get('permisoboletapdf/{id}', 'permiso_boleta_pdf')->name('cra_permiso_boleta_pdf');
        Route::get('licenciaboletapdf/{id}', 'licencia_boleta_pdf')->name('cra_licencia_boleta_pdf');
    });



    //PARA LA PARTE DE SEGUIMIENTO *************************************************************************************

    //para la parte de la configuracion
    Route::controller(Controlador_configuracion::class)->group(function () {
        //para la administracion del tipo de tramite
        Route::get('tipotramite', 'tipo_tramite')->name('ttram_index');
        Route::post('tipotramite_listar', 'tipo_tramite_listar')->name('ttram_listar');
        Route::post('tipotramite_nuevo', 'tipo_tramite_nuevo')->name('ttram_nuevo');
        Route::post('tipotramite_estado', 'tipotramite_estado')->name('ttram_estado');
        Route::delete('tipotramite_eliminar', 'tipotramite_eliminar')->name('ttram_eliminar');
        Route::post('tipotramite_editar', 'tipotramite_editar')->name('ttram_editar');
        Route::post('tipotramite_update', 'tipotramite_update')->name('ttram_update');

        //para la administracion de tipo de estado
        Route::get('tipoestado', 'tipo_estado_tramite')->name('test_index');
        Route::post('tipoestado_listar', 'tipo_estado_listar')->name('test_listar');
        Route::post('tipoestado_nuevo', 'tipo_estado_nuevo')->name('test_nuevo');
        Route::delete('tipoestado_eliminar', 'tipo_estado_eliminar')->name('test_eliminar');
        Route::post('tipoestado_editar', 'tipo_estado_editar')->name('test_editar');
        Route::post('tipoestado_update', 'tipo_estado_update')->name('test_update');

        //para la administracion para habilitar los tramites
        Route::get('habilitaraTramite', 'habilitar_a_tramite')->name('htram_index');
        Route::post('habilitaraTramite_listar', 'habilitar_a_tramite_listar')->name('htram_listar');
        Route::post('habilitaraTramite_validar', 'habilitar_a_tramite_validar')->name('htram_validar');
        Route::post('habilitaraTramite_habilita', 'habilitar_a_tramite_habilita')->name('htram_habilita');
        Route::post('habilitaraTramite_vizualiza', 'habilitar_a_tramite_vizualiza')->name('htram_vizualizar');
        Route::post('habilitaraTramite_vizualiza_listar', 'habilitar_a_tramite_vizualiza_listar')->name('htram_vizualizar_lis');
        Route::post('habilitaraTramite_vizualiza_nuevo', 'habilitar_a_tramite_vizualiza_nuevo')->name('htram_vizualizar_nuevo');
        Route::post('habilitaraTramite_vizualiza_estado', 'habilitar_a_tramite_vizualiza_estado')->name('htram_vizualizar_estado');
        Route::delete('habilitaraTramite_vizualiza_eliminar', 'habilitar_a_tramite_vizualiza_eliminar')->name('htram_vizualizar_eliminar');
    });


    //PARA LA PARTE DE LA BUSQUEDA DEL TRAMITE
    Route::controller(Controlador_busqueda::class)->group(function(){
        Route::get('vistaBusqueda', 'vista_busqueda')->name('cobus_index');
        Route::post('vizualizar_busqueda_tramites', 'vizualizar_busqueda_tramites')->name('cobus_vizualizar_tramite');
    });



    //para la vizualizacion de los cargos que tiene cada uno
    Route::controller(Controlador_tramite::class)->group(function () {
        //para la vizualizacion de todos los permisos
        Route::get('vizualizarCargosTramite', 'vizualizar_cargos_tramite')->name('ctram_index');

        //PARA LA PARTE DE LA CORESPONDECIA
        Route::get('TramiteCargo/{id}', 'tramite_cargo')->name('tcar_cargos');
        Route::post('correspondencia_tipo_sigla', 'correspondencia_tipo_sigla')->name('corres_tipo_sigla');
        Route::post('correspondencia_nuevo', 'correspondencia_nuevo')->name('corres_nuevo');
        Route::post('correspondencia_listar', 'correspondencia_listar')->name('corres_listar');
        Route::post('correspondencia_vizualizar', 'correspondencia_vizualizar')->name('corres_vizualizar');
        Route::post('correspondencia_listar_hoja_ruta', 'correspondencia_listar_hoja_ruta')->name('corres_lis_ruta');
        Route::post('correspondencia_anular', 'correspondencia_anular')->name('corres_lis_anular');


        //PARA LA PARTE DE BANDEJA DE ENTRADA
        Route::get('BandejaEntrada/{id}', 'bandeja_entrada')->name('tcar_bandeja_entrada');
        Route::post('BandejaEntrada_listar', 'bandeja_entrada_listar')->name('tcar_bandeja_entrada_listar');
        Route::post('BandejaEntrada_recibir', 'bandeja_entrada_recibir')->name('tcar_bandeja_entrada_recibir');


        //PARA LA PARTE DE LOS RECIBIDOS
        Route::get('Recibidos/{id}', 'recibidos')->name('tcar_recibidos');
        Route::post('Recibidos_listar', 'listar_tramite_recibido')->name('tcar_recibidos_listar');
        Route::post('Recibidos_reenviar', 'recibidos_tramite_reenviar')->name('tcar_recibidos_reenviar');


        //PARA LA PARTE DE LOS OBSERVADOS
        Route::get('Observados/{id}', 'observados')->name('tcar_observados');


        //PARA LA PARTE DE LOS ARCHIVADOS
        Route::get('Archivados/{id}', 'archivados')->name('tcar_archivados');
        Route::post('Archivados_guardar', 'archivados_guardar')->name('tcar_archivados_save');
        Route::post('Archivados_listar', 'archivados_listar')->name('tcar_archivados_listar');
    });



    //PARA LA PARTE DE LOS REPORTES
    Route::controller(Controlador_reporte_tramite::class)->group(function () {
        Route::get('ReporteTramite/{id}', 'reporte_tramite_pdf')->name('crt_reporte_tramite');

        //PARA LOS REPORTES DE LOS TRAMITES - REPORTES PDF
        Route::get('Reportes','reportes_tramite_index')->name('crt_reportes_index');
        Route::get('ReportesVizualizar','reportes_vizualizar')->name('crt_vizualizar_index');


    });

    //FIN DE LA PARTE DEL SEGUIMIENTO





});
