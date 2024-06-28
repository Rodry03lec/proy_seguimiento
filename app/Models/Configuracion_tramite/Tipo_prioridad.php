<?php

namespace App\Models\Configuracion_tramite;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_prioridad extends Model
{
    use HasFactory;
    protected $table = 'rl_tipo_prioridad';
    protected $fillable=[
        'nombre',
    ];
}
