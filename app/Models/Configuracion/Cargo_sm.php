<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Configuracion\Unidades_administrativas;
use App\Models\Configuracion\Direccion_municipal;

class Cargo_sm extends Model
{
    use HasFactory;
    protected $table = 'rl_cargo_sm';
    protected $fillable=[
        'nombre',
        'id_direccion',
        'id_unidad',
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

    //relacion reversad con unidades admin
    public function unidades_admnistrativas(){
        return $this->belongsTo(Unidades_administrativas::class, 'id_unidad', 'id');
    }
    //relacion reversa con direccion
    public function direccion(){
        return $this->belongsTo(Direccion_municipal::class, 'id_direccion', 'id');
    }
}
