<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Configuracion\Nivel;
use App\Models\Configuracion\Tipo_baja;
use App\Models\Configuracion\Tipo_categoria;
use App\Models\Configuracion\Tipo_contrato;

class Seeder_configuracion extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //para llenar todos los contratos
        $tipo_contrato = array(
            array(
                'sigla'=>'ITEM-',
                'nombre'=>'PERSONAL CON ITEM',
                'estado'=>'activo'
            ),
            array(
                'sigla'=>'EVEN-',
                'nombre'=>'PERSONAL EVENTUAL',
                'estado'=>'activo'
            ),
            array(
                'sigla'=>'CONS-LIN-',
                'nombre'=>'PERSONAL CONSULTOR EN LINEA',
                'estado'=>'activo'
            )
        );
        foreach($tipo_contrato as $lis){
            $guardar_tipoc = new Tipo_contrato();
            $guardar_tipoc->sigla = $lis['sigla'];
            $guardar_tipoc->nombre = $lis['nombre'];
            $guardar_tipoc->estado = $lis['estado'];
            $guardar_tipoc->save(); 
        }
        //para llenar todos los datos de categoria

        //PARA GUARDAR EL TIPÓ DE CATEGORIA
        $tipo_categoria = array(
            'SUPERIOR',
            'EJECUTIVO',
            'OPERATIVO'
        );
        foreach ($tipo_categoria as $lis) {
            $tipo_categoria_guardar = new Tipo_categoria();
            $tipo_categoria_guardar->nombre = $lis;
            $tipo_categoria_guardar->save();
        }
        //FIN PARA GUARDAR EL TIPO DE CATEGORIA

        //PARA GUARDAR LOS NIVELES
        $niveles = array(
            array(
                'nivel'         => '1',
                'descripcion'   => 'ALCALDE MUNICIPAL',
                'haber_basico'  => sin_separador_comas('11000'),
                'id_categoria'  => 1
            ),
            array(
                'nivel'         => '2',
                'descripcion'   => 'CONCEJALES',
                'haber_basico'  => sin_separador_comas('10500'),
                'id_categoria'  => 1
            ),
            array(
                'nivel'         => '3',
                'descripcion'   => 'SECRETARIO GENERAL',
                'haber_basico'  => sin_separador_comas('7800'),
                'id_categoria'  => 1
            ),
            array(
                'nivel'         => '4',
                'descripcion'   => 'SECRETARIOS MUNICIPALES',
                'haber_basico'  => sin_separador_comas('7600'),
                'id_categoria'  => 1
            ),
            array(
                'nivel'         => '5',
                'descripcion'   => 'DIRECTOR DE AUDITORÍA INTERNA',
                'haber_basico'  => sin_separador_comas('7300'),
                'id_categoria'  => 2
            ),
            array(
                'nivel'         => '5',
                'descripcion'   => 'DIRECTOR JURÍDICO',
                'haber_basico'  => sin_separador_comas('7300'),
                'id_categoria'  => 2
            ),
            array(
                'nivel'         => '5',
                'descripcion'   => 'DIRECTORES ASESORES',
                'haber_basico'  => sin_separador_comas('7300'),
                'id_categoria'  => 2
            ),
            array(
                'nivel'         => '5',
                'descripcion'   => 'CONCEJO',
                'haber_basico'  => sin_separador_comas('7300'),
                'id_categoria'  => 2
            ),
            array(
                'nivel'         => '6',
                'descripcion'   => 'PROFESIONAL I',
                'haber_basico'  => sin_separador_comas('6450'),
                'id_categoria'  => 2
            ),
            array(
                'nivel'         => '6',
                'descripcion'   => 'ASESORES',
                'haber_basico'  => sin_separador_comas('6450'),
                'id_categoria'  => 2
            ),
            array(
                'nivel'         => '7',
                'descripcion'   => 'DIRECTOR',
                'haber_basico'  => sin_separador_comas('6000'),
                'id_categoria'  => 2
            ),
            array(
                'nivel'         => '8',
                'descripcion'   => 'PROFESIONAL II',
                'haber_basico'  => sin_separador_comas('5600'),
                'id_categoria'  => 3
            ),
            array(
                'nivel'         => '9',
                'descripcion'   => 'PROFESIONAL III',
                'haber_basico'  => sin_separador_comas('5300'),
                'id_categoria'  => 3
            ),
            array(
                'nivel'         => '10',
                'descripcion'   => 'PROFESIONAL IV',
                'haber_basico'  => sin_separador_comas('5000'),
                'id_categoria'  => 3
            ),
            array(
                'nivel'         => '10',
                'descripcion'   => 'RESPONSABLE I',
                'haber_basico'  => sin_separador_comas('5000'),
                'id_categoria'  => 3
            ),
            array(
                'nivel'         => '11',
                'descripcion'   => 'RESPONSABLE II',
                'haber_basico'  => sin_separador_comas('4200'),
                'id_categoria'  => 3
            ),
            array(
                'nivel'         => '12',
                'descripcion'   => 'RESPONSABLE III',
                'haber_basico'  => sin_separador_comas('3600'),
                'id_categoria'  => 3
            ),
            array(
                'nivel'         => '12',
                'descripcion'   => 'TECNICO I',
                'haber_basico'  => sin_separador_comas('3600'),
                'id_categoria'  => 3
            ),
            array(
                'nivel'         => '13',
                'descripcion'   => 'TÉCNICO II',
                'haber_basico'  => sin_separador_comas('3450'),
                'id_categoria'  => 3
            ),
            array(
                'nivel'         => '14',
                'descripcion'   => 'TÉCNICO III',
                'haber_basico'  => sin_separador_comas('3200'),
                'id_categoria'  => 3
            ),
            array(
                'nivel'         => '15',
                'descripcion'   => 'TECNICO IV',
                'haber_basico'  => sin_separador_comas('2900'),
                'id_categoria'  => 3
            ),
            array(
                'nivel'         => '15',
                'descripcion'   => 'SECRETARIAS',
                'haber_basico'  => sin_separador_comas('2900'),
                'id_categoria'  => 3
            ),
            array(
                'nivel'         => '16',
                'descripcion'   => 'OPERATIVO I',
                'haber_basico'  => sin_separador_comas('2700'),
                'id_categoria'  => 3
            ),
            array(
                'nivel'         => '17',
                'descripcion'   => 'OPERATIVO II',
                'haber_basico'  => sin_separador_comas('2600'),
                'id_categoria'  => 3
            ),
            array(
                'nivel'         => '17',
                'descripcion'   => 'AUXILIAR I',
                'haber_basico'  => sin_separador_comas('2600'),
                'id_categoria'  => 3
            ),
            array(
                'nivel'         => '17',
                'descripcion'   => 'ADMINISTRATIVO I',
                'haber_basico'  => sin_separador_comas('2600'),
                'id_categoria'  => 3
            ),
        );

        foreach($niveles as $lis){
            $guardar_nivel                  = new Nivel();
            $guardar_nivel->nivel           = $lis['nivel'];
            $guardar_nivel->descripcion     = $lis['descripcion'];
            $guardar_nivel->haber_basico    = $lis['haber_basico'];
            $guardar_nivel->id_categoria    = $lis['id_categoria'];
            $guardar_nivel->save();
        }
        //FIN PARA GUARDAR LOS NIVELES

        //PARA GUARDAR LOS TIPOS DE BAJA QUE EXISTE
        $tipos_baja = [
            'ABANDONO',
            'AGRADECIMIENTO',
            'DESTITUCIÓN',
            'FIN DEL CONTRATO',
            'RENUNCIA'
        ];
        /* foreach ($tipos_baja as $lis) {
            $nuevo_tipo_baja            = new Tipo_baja();
            $nuevo_tipo_baja->nombre    = $lis;
            $nuevo_tipo_baja->estado    = 'activo';
            $nuevo_tipo_baja->save();
        } */
        //FIN DE LA PARTE DE LOS TIPOS DE BAJA
    }
}
