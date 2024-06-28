<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Registro\Persona;

class Genero extends Model
{
    use HasFactory;
    protected $table = 'rl_genero';
    protected $fillable=[
        'sigla',
        'nombre',
        'estado',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //relacion de uno a muchos con rl_persona
    /* public function persona(){
        return $this->hasMany(Persona::class, 'id_genero', 'id');
    } */
}
