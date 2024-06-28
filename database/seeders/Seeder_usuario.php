<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Seeder_usuario extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        $usuario = new User();
        $usuario->usuario = 'admin';
        $usuario->password = Hash::make('admin');
        $usuario->ci = '8422512';
        $usuario->nombres = 'Graice ';
        $usuario->apellidos = 'Callizaya Chambi';
        $usuario->estado =  'activo';
        $usuario->id_persona = '0';
        $usuario->save();


        $usuario->syncRoles(['Super Administrador']);


        $usuario1 = new User();
        $usuario1->usuario = 'prueva';
        $usuario1->password = Hash::make('rodry');
        $usuario1->ci = '12345678';
        $usuario1->nombres = 'Prueva';
        $usuario1->apellidos = 'Prueva Prueva';
        $usuario1->estado =  'activo';
        $usuario1->id_persona = '0';
        $usuario1->save();

    }


}
