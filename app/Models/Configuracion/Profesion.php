<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Configuracion\Ambito;

class Profesion extends Model
{
    use HasFactory;
    protected $table = 'rl_profesion';
    protected $fillable=[
        'nombre',
        'estado',
        'id_ambito',
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
    //relacion reversa con ambito profesional
    public function ambito(){
        return $this->belongsTo(Ambito::class, 'id_ambito', 'id');
    }
}
