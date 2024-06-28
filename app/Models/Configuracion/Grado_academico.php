<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Grado_academico extends Model
{
    use HasFactory;
    protected $table = 'rl_grado_academico';
    protected $fillable=[
        'abreviatura',
        'nombre',
        'estado',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //para que este en mayuscula EL NOMBRE
    protected function abreviatura():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => mb_strtoupper($value),
        );
    }
     //para que este en mayuscula la SIGLA
    protected function nombre():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => mb_strtoupper($value),
        );
    }
}
