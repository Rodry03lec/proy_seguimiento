<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Configuracion\Rango_hora;

class Horario extends Model
{
    use HasFactory;
    protected $table = 'rl_horarios';
    protected $fillable=[
        'nombre',
        'descripcion',
        'id_usuario',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //relacion con los rangos de hora
    public function rango_hora(){
        return $this->hasMany(Rango_hora::class, 'id_horario', 'id')->OrderBy('numero','asc');
    }
}
