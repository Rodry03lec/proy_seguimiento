<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Configuracion\Estado_civil;
use App\Models\Configuracion\Genero;

class Seeder_persona extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //primero agregaremos los generos
        $generos = array(
            [
                'sigla'=>'M',
                'nombre'=>'MASCULINO',
            ],
            [
                'sigla'=>'F',
                'nombre'=>'FEMENINO',
            ],
            [
                'sigla'=>'NS',
                'nombre'=>'NO SABE',
            ],
            [
                'sigla'=>'PND',
                'nombre'=>'PREFIERE NO DECIR',
            ],
        );

        foreach ($generos as $lis) {
            $genero             = new Genero();
            $genero->sigla      = $lis['sigla'];
            $genero->nombre     = $lis['nombre'];
            $genero->estado     = 'activo';   
            $genero->save();
        }

        //para la creacion de estados civiles
        $estado_civiles = [
            'SOLTERO/A',
            'CASADO/A',
            'VIUDO/A',
            'DIVORCIADO/A',
            'CONCUVINO/A',
        ];
        foreach ($estado_civiles as $lis) {
            $es_civil = new Estado_civil();
            $es_civil->nombre = $lis;
            $es_civil->estado = 'activo';
            $es_civil->save();
        }
    }
}
