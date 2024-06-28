<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Configuracion\Nivel;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Tipo_categoria extends Model
{
    use HasFactory;
    protected $table = 'rl_categoria';
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

    //para la relacion con niveles
    public function nivel(){
        return $this->hasMany(Nivel::class, 'id_categoria', 'id');
    }
}
