<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Secretaria_municipal extends Model
{
    use HasFactory;
    protected $table = 'rl_secretaria_municipal';
    protected $fillable=[
        'sigla',
        'nombre',
        'estado',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //para que este en mayuscula
    protected function sigla():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => mb_strtoupper($value),
        );
    }
    protected function nombre():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => mb_strtoupper($value),
        );
    }
    //para listar las direcciones
    public function direcciones(){
        return $this->hasMany(Direccion_municipal::class, 'id_secretaria', 'id');
    }
}
