<?php

namespace App\Models\Biometrico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario_continuo extends Model
{
    use HasFactory;
    protected $table = 'rl_horario_continuo';
    protected $fillable=[
        'descripcion',
        'fecha_inicio',
        'fecha_final',
        'hora_salida',
        'estado',
        'id_usuario',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';
}
