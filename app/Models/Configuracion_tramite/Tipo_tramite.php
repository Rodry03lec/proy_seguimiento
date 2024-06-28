<?php

namespace App\Models\Configuracion_tramite;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Tipo_tramite extends Model
{
    use HasFactory;
    protected $table = 'rl_tipo_tramite';
    protected $fillable=[
        'nombre',
        'sigla',
        'estado',
    ];

    //para que este en mayuscula
    protected function nombre():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => mb_strtoupper($value),
        );
    }
}
