<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Configuracion\Unidad_mae;


class Cargo_mae extends Model
{
    use HasFactory;

    protected $table = 'rl_cargo_mae';
    protected $fillable=[
        'nombre',
        'id_unidad',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //para que este en mayuscula
    protected function nombre():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => mb_strtoupper($value)
        );
    }

    //relacion reversa de unidad
    public function unidad_mae(){
        return $this->belongsTo(Unidad_mae::class, 'id_unidad', 'id');
    }
}
