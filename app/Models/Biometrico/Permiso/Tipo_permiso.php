<?php

namespace App\Models\Biometrico\Permiso;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_permiso extends Model
{
    use HasFactory;
    protected $table = 'rl_tipo_permiso';
    protected $fillable=[
        'nombre',
        'estado',
        'id_usuario',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';
}
