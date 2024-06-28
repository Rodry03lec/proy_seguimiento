<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Configuracion\Secretaria_municipal;

class Direccion_municipal extends Model
{
    use HasFactory;
    protected $table = 'rl_direccion';
    protected $fillable=[
        'sigla',
        'nombre',
        'estado',
        'id_secretaria',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //para que este en mayuscula EL NOMBRE
    protected function nombre():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => mb_strtoupper($value),
        );
    }
     //para que este en mayuscula la SIGLA
    protected function sigla():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => mb_strtoupper($value),
        );
    }

    //relacion reversa con secretaria municipal
    public function secretaria_municipal(){
        return $this->belongsTo(Secretaria_municipal::class, 'id_secretaria', 'id');
    }

    //de uno a muchos los cargos
    public function cargos(){
        return $this->hasMany(Cargo_sm::class, 'id_direccion', 'id');
    }
}
