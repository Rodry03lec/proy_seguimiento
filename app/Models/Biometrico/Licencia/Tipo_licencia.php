<?php

namespace App\Models\Biometrico\Licencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_licencia extends Model
{
    use HasFactory;
    protected $table = 'rl_tipo_licencia';
    protected $fillable=[
        'numero',
        'normativa',
        'motivo',
        'jornada_laboral',
        'requisitos',
        'plazos',
        'observaciones',
        'estado',
        'id_usuario',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';
}
