<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Configuracion\Rango_hora;
use App\Models\Fechas\Dias_semana;

class Excepcion extends Model
{
    use HasFactory;

    protected $table = 'rl_excepcion_horario';
    protected $fillable=[
        'descripcion',
        'fecha_inicio',
        'fecha_final',
        'estado',
        'hora',
        'id_rango_hora',
        'id_usuario',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //relacion revesa con rangos hora
    public function rango_hora(){
        return $this->belongsTo(Rango_hora::class, 'id_rango_hora', 'id');
    }

    //relacion de uno a muchos con dias semana
    public function dias_semana_excepcion(){
        return $this->belongsToMany(Dias_semana::class, 'excepcion_dia_sem', 'id_excepcion', 'id_dias_sem');
    }

}
