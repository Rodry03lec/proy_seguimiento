<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Mae extends Model
{
    use HasFactory;

    protected $table = 'rl_mae';
    protected $fillable=[
        'nombre',
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

    //para listar las unidades que tiene
    public function unidades_mae(){
        return $this->hasMany(Unidad_mae::class, 'id_mae', 'id');
    }
}
