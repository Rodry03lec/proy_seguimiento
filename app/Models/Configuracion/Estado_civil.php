<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado_civil extends Model
{
    use HasFactory;
    protected $table = 'rl_estado_civil';
    protected $fillable=[
        'nombre',
        'estado',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';
}
