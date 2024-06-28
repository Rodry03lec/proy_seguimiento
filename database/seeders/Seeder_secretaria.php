<?php

namespace Database\Seeders;

use App\Models\Configuracion\Direccion_municipal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Configuracion\Secretaria_municipal;
use App\Models\Configuracion\Unidades_administrativas;

class Seeder_secretaria extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //primero creamos las secretarias municipales
        $secretarias = array(
            [
                'sigla'=>'SMAF',
                'nombre'=>'SECRETARÍA MUNICIPAL ADMINISTRATIVA FINANCIERA'
            ],
            [
                'sigla'=>'SMDPMA',
                'nombre'=>'SECRETARÍA MUNICIPAL DE DESARROLLO PRODUCTIVO Y MEDIO AMBIENTE'
            ],
            [
                'sigla'=>'SMTOP',
                'nombre'=>'SECRETARÍA MUNICIPAL TÉCNICA Y DE OBRAS PÚBLICAS'
            ],
            [
                'sigla'=>'SMDH',
                'nombre'=>'SECRETARÍA MUNICIPAL DE DESARROLLO HUMANO'
            ],
        );
        foreach ($secretarias as $lis) {
            $secretaria_new             = new Secretaria_municipal();
            $secretaria_new->sigla      = $lis['sigla'];
            $secretaria_new->nombre     = $lis['nombre'];
            $secretaria_new->estado     = 'activo';
            $secretaria_new->save();
        }


        //AHORA VAMOS A REALIZAR EL LLENADO DE LAS DIRECCIONES
        $direcciones = array(
            [
                'sigla'         => 'DDR',
                'nombre'        => 'DIRECCIÓN DE RECAUDACIONES',
                'id_secretaria' => 1
            ],
            [
                'sigla'         => 'DAF',
                'nombre'        => 'DIRECCIÓN ADMINISTRATIVA FINANCIERA',
                'id_secretaria' => 1
            ],
            [
                'sigla'         => 'DDC',
                'nombre'        => 'DIRECCIÓN DE CAFÉ',
                'id_secretaria' => 2
            ],
            [
                'sigla'         => 'DMA',
                'nombre'        => 'DIRECCIÓN DE MEDIO AMBIENTE',
                'id_secretaria' => 2
            ],
            [
                'sigla'         => 'DDA',
                'nombre'        => 'DIRECCIÓN DE DESARROLLO AGROPECUARIO',
                'id_secretaria' => 2
            ],
            [
                'sigla'         => 'DMGR',
                'nombre'        => 'DIRECCIÓN DE MAQUINARIA Y GESTIÓN DE RIESGOS',
                'id_secretaria' => 3
            ],
            [
                'sigla'         => 'DOP',
                'nombre'        => 'DIRECCIÓN DE OBRAS PÚBLICAS',
                'id_secretaria' => 3
            ],
            [
                'sigla'         => 'DATC',
                'nombre'        => 'DIRECCIÓN ADMINISTRACIÓN TERRITORIAL Y CATASTRO',
                'id_secretaria' => 3
            ],
            [
                'sigla'         => 'DECD',
                'nombre'        => 'DIRECCIÓN DE EDUCACIÓN, CULTURA Y DEPORTE',
                'id_secretaria' => 4
            ],
            [
                'sigla'         => 'DDS',
                'nombre'        => 'DIRECCIÓN DE SALUD',
                'id_secretaria' => 4
            ],
        );

        foreach ($direcciones as $lis) {
            $save_direcciones                   = new Direccion_municipal();
            $save_direcciones->sigla            = $lis['sigla'];
            $save_direcciones->nombre           = $lis['nombre'];
            $save_direcciones->estado           = 'activo';
            $save_direcciones->id_secretaria    = $lis['id_secretaria']; 
            $save_direcciones->save();
        }



        //ahora vamos a llenar las unidades administrativas
        $unidades_adm = array(
            [
                'sigla' => 'UFCC',
                'nombre' => 'UNIDAD DE FISCALIZACIÓN Y COBRANZA COACTIVA',
            ],
            [
                'sigla' => 'UDP',
                'nombre' => 'UNIDAD DE PRESUPUESTOS',
            ],
            [
                'sigla' => 'UDC',
                'nombre' => 'UNIDAD DE CONTABILIDAD',
            ],
            [
                'sigla' => 'UDTCP',
                'nombre' => 'UNIDAD DE TESORERÍA Y CRÉDITO PÚBLICO',
            ],
            [
                'sigla' => 'RRHH',
                'nombre' => 'UNIDAD DE RECURSOS HUMANOS',
            ],
            [
                'sigla' => 'UDC',
                'nombre' => 'UNIDAD DE CONTRATACIONES',
            ],
            [
                'sigla' => 'UDGR',
                'nombre' => 'UNIDAD DE GESTIÓN DE RIESGOS',
            ],
            [
                'sigla' => 'UFDO',
                'nombre' => 'UNIDAD DE FISCALIZACION DE OBRAS',
            ],
            [
                'sigla' => 'UDPS',
                'nombre' => 'UNIDAD DE PROYECTOS ESPECIALES',
            ],
            [
                'sigla' => 'UDU',
                'nombre' => 'UNIDAD DE DESARROLLO URBANO',
            ],
            [
                'sigla' => 'UOTC',
                'nombre' => 'UNIDAD DE ORDENAMIENTO TERRITORIAL Y CATASTRO',
            ],
            [
                'sigla' => 'UADHM',
                'nombre' => 'UNIDAD DE ADMINISTRACIÓN DEL HOSPITAL MUNICIPAL',
            ],
            [
                'sigla' => 'URSSM',
                'nombre' => 'UNIDAD DE REDES Y SERVICIOS DE SALUD MUNICIPAL',
            ],
            [
                'sigla' => 'JSI',
                'nombre' => 'JEFATURA DE SERVICIOS INTEGRALES',
            ],
        );

        foreach ($unidades_adm as $lis) {
            $unidades_save          = new Unidades_administrativas();
            $unidades_save->sigla   = $lis['sigla'];
            $unidades_save->nombre  = $lis['nombre'];
            $unidades_save->estado  = 'activo';
            $unidades_save->save();
        }
    }
}
