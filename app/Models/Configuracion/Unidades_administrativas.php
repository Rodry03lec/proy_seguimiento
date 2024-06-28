<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Unidades_administrativas extends Model
{
    use HasFactory;
    protected $table = 'rl_unidades_admin';
    protected $fillable=[
        'nombre',
        'sigla',
        'estado',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //para que este en mayuscula
    protected function nombre():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => mb_strtoupper($value),
        );
    }
}
