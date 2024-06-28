<?php

namespace Database\Seeders;

use App\Models\Biometrico\Permiso\Permiso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class Seeder_permision extends Seeder
{
    public function run(): void
    {
        //AQUI VAMOS A CREAR LOS PERMISOS
        $permisos = [
            'admin_usuario_menu',
            //para el menu usuario
            'usuario_submenu',
            'usuario_nuevo',
            'usuario_estado',
            'usuario_editar',
            'usuario_eliminar',
            //para la parte de los roles
            'roles_submenu',
            'roles_nuevo',
            'roles_editar',
            'roles_eliminar',
            'roles_vizualizar',
            //para la parte de los permisos
            'permisos_submenu',
            'permisos_nuevo',
            'permisos_editar',
            'permisos_eliminar',

            //para el menu de CONFIGURACION
            'configuracion_menu',
            //para el submenu de tipo de contrato
            'tipo_contrato_submenu',
            'tipo_contrato_nuevo',
            'tipo_contrato_editar',
            'tipo_contrato_eliminar',

            //para el submenu de TIPO DE CATEGORIA
            'tipo_categoria_submenu',
            'tipo_categoria_nuevo',
            'tipo_categoria_editar',
            'tipo_categoria_eliminar',
            //sub_sub menu de TIPO DE CATEGORIA VIZUALIZAR
            'tipo_categoria_vizualizar',
            'tipo_categoria_vizualizar_nivel_nuevo',
            'tipo_categoria_vizualizar_nivel_editar',
            'tipo_categoria_vizualizar_nivel_eliminar',

            //para el submenu de GRADOS ACADEMICOS
            'grados_academicos_submenu',
            'grados_academicos_nuevo',
            'grados_academicos_estado',
            'grados_academicos_editar',
            'grados_academicos_eliminar',

            //para el submenu de AMBITO PROFESIONAL
            'ambito_profesional_submenu',
            'ambito_profesional_nuevo',
            'ambito_profesional_editar',
            'ambito_profesional_eliminar',
            //para vizualizar de acuerdo al AMBITO PROFESIONAL
            'ambito_profesional_vizualizar',
            'ambito_profesional_vizualizar_profesion_nuevo',
            'ambito_profesional_vizualizar_profesion_editar',
            'ambito_profesional_vizualizar_profesion_eliminar',

            //para el submenu MAE-UNIDAD
            'mae_unidad_submenu',
            'mae_unidad_nuevo',
            'mae_unidad_editar',
            'mae_unidad_eliminar',
            'mae_unidad_vizualizar',
            'mae_unidad_vizualizar_unidades_nuevo',
            'mae_unidad_vizualizar_unidades_editar',
            'mae_unidad_vizualizar_unidades_eliminar',

            //para el submenu UNIDADES ADMINISTRATIVAS
            'unidades_administrativas_submenu',
            'unidades_administrativas_nuevo',
            'unidades_administrativas_estado',
            'unidades_administrativas_editar',
            'unidades_administrativas_eliminar',

            //para el submenu SECRETARIAS MUNICIPALES
            'secretaria_municipales_direccion_submenu',
            'secretaria_municipales_direccion_nuevo',
            'secretaria_municipales_direccion_estado',
            'secretaria_municipales_direccion_editar',
            'secretaria_municipales_direccion_eliminar',
            //para la vizualizar las direcciones
            'secretaria_municipales_direccion_vizualizar',
            'secretaria_municipales_direccion_vizualizar_nuevo',
            'secretaria_municipales_direccion_vizualizar_estado',
            'secretaria_municipales_direccion_vizualizar_eliminar',
            'secretaria_municipales_direccion_vizualizar_editar',

            //para el submenu HORARIOS
            'horarios_submenu',
            'horarios_nuevo',
            'horarios_editar',
            'horarios_eliminar',
            //para la vizualizacion DE ESPECIFICACION DE HORAS
            'horarios_vizualizar',
            'horarios_vizualizar_especificacion_horas_nuevo',
            'horarios_vizualizar_especificacion_horas_editar',
            'horarios_vizualizar_especificacion_horas_eliminar',
            //para la parte de las excepciones de horario
            'horarios_vizualizar_especificacion_horas_excepciones',
            'horarios_vizualizar_especificacion_horas_excepciones_nuevo',
            'horarios_vizualizar_especificacion_horas_excepciones_editar',
            'horarios_vizualizar_especificacion_horas_excepciones_estado',

            //para el submenu GENERO - ESTADO CIVIL
            'genero_estado_civil_submenu',
            //para el genero
            'genero_nuevo',
            'genero_estado',
            'genero_editar',
            'genero_eliminar',
            //para el estado civil
            'estado_civil_nuevo',
            'estado_civil_estado',
            'estado_civil_editar',
            'estado_civil_eliminar',

            //PARA EL MENU DE REGISTROS
            'registros_menu',
            //submenu personas
            'persona_submenu',
            'persona_nuevo',
            'persona_editar',
            'persona_eliminar',
            'persona_listar_contratos',
            'persona_listar_contratos_vizualizar',
            'persona_listar_contratos_vizualizar_retiro',
            'persona_listar_contratos_generar_retiro',
            'persona_listar_contratos_modificatorio',
            'persona_listar_contratos_editar',
            'persona_listar_contratos_eliminar',

            //submenu contrato
            'contrato_submenu',
            'contrato_nuevo',

            //PARA LA ADMINITRACION DEL BIOMETRICO
            'adm_biometrico_menu',
            //para subir el biometrico
            'subir_biometrico_submenu',
            'subir_biometrico_validar_archivo',
            //para el sub menu especial
            'especial_submenu',
            //para la administracion de los permisos que existe
            'especial_permisos',
            'especial_permisos_nuevo',
            'especial_permisos_estado',
            'especial_permisos_editar',
            'especial_permisos_eliminar',
            //desglose permiso de la administracion
            'especial_permisos_desglose',
            'especial_permisos_desglose_nuevo',
            'especial_permisos_desglose_estado',
            'especial_permisos_desglose_editar',
            'especial_permisos_desglose_eliminar',
            'especial_permisos_desglose_vizualizar',

            //para la administración de las licencias
            'especial_licencias',
            'especial_licencias_nuevo',
            'especial_licencias_estado',
            'especial_licencias_editar',
            'especial_licencias_eliminar',

            //para la administracion del feriado
            'especial_feriado',
            'especial_feriado_editar',
            'especial_feriado_eliminar',
            'especial_feriado_nuevo',

            //para la administracion del horario continuo
            'especial_horario_continuo',
            'especial_horario_continuo_nuevo',
            'especial_horario_continuo_estado',
            'especial_horario_continuo_editar',
            'especial_horario_continuo_eliminar',

            //para el submenu de asistencias
            'asistencia_submenu',
            'asistencia_generar',
            'asistencia_editar',

            //para el submenu de boletas
            'boletas_submenu',
            'boletas_generar_permiso',
            'boletas_generar_permiso_nuevo',
            'boletas_generar_permiso_editar',
            'boletas_generar_permiso_vizualizar',
            'boletas_generar_permiso_eliminar',
            'boletas_generar_permiso_pdf',
            'boletas_generar_permiso_aprobado',
            'boletas_generar_permiso_constancia',



            'boletas_generar_licencia',
            'boletas_generar_licencia_nuevo',
            'boletas_generar_licencia_editar',
            'boletas_generar_licencia_vizualizar',
            'boletas_generar_licencia_eliminar',
            'boletas_generar_licencia_pdf',
            'boletas_generar_licencia_aprobado',
            'boletas_generar_licencia_constancia',


            //TRAMITE
            'menu_configuracion_tramite',

            'tipos_tramite_submenu',
            'tipos_tramite_submenu_nuevo',
            'tipos_tramite_submenu_estado',
            'tipos_tramite_submenu_editar',
            'tipos_tramite_submenu_eliminar',

            'tipos_esado_submenu',
            'tipos_esado_submenu_nuevo',
            'tipos_esado_submenu_editar',
            'tipos_esado_submenu_eliminar',


            'habilitar_tramite_submenu',
            'habilitar_tramite_submenu_habilitar',
            'habilitar_tramite_submenu_vizualizar',

            'habilitar_tramite_submenu_vizualizar_nuevo',
            'habilitar_tramite_submenu_vizualizar_estado',
            'habilitar_tramite_submenu_vizualizar_eliminar',

        ];

        foreach ($permisos as $lis) {
            $permiso        = new Permission();
            $permiso->name  = $lis;
            $permiso->save();
        }

    }
}
