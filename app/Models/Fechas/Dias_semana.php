<?php

namespace App\Models\Fechas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dias_semana extends Model
{
    use HasFactory;
    protected $table = 'rl_dias_semana';
    protected $fillable=[
        'sigla',
        'nombre',
    ];

    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';
}
