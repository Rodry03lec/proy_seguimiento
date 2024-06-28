<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_baja extends Model
{
    use HasFactory;
    protected $table = 'rl_tipo_baja';
    protected $fillable=[
        'nombre',
        'estado',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';
}
