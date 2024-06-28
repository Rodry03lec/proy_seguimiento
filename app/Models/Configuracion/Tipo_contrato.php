<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipo_contrato extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'rl_tipo_contrato';
    protected $fillable=[
        'sigla',
        'nombre',
        'estado'
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    protected $dates = ['deleted_at'];

    //para que este en mayusculas
    protected function nombre():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => mb_strtoupper($value),
        );
    }
}
