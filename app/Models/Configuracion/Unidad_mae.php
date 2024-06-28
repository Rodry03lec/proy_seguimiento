<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Configuracion\Mae;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Unidad_mae extends Model
{
    use HasFactory;
    protected $table = 'rl_unidad_mae';
    protected $fillable=[
        'descripcion',
        'id_mae',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //relacion reversa de rl_mae
    public function mae(){
        return $this->belongsTo(Mae::class, 'id_mae', 'id');
    }

    //para que este en mayuscula
    protected function descripcion():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => mb_strtoupper($value),
        );
    }
    //para relacion de uno a muchos a cargos
    public function cargos(){
        return $this->hasMany(Cargo_mae::class, 'id_unidad', 'id');
    }
}
