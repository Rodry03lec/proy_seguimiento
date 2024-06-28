<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Configuracion\Horario;
use App\Models\Configuracion\Excepcion;

class Rango_hora extends Model
{
    use HasFactory;
    protected $table = 'rl_rangos_hora';
    protected $fillable=[
        'nombre',
        'numero',
        'hora_inicio',
        'hora_final',
        'tolerancia',
        'id_horario',
        'id_usuario',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //relacion reversa de horarios
    public function horarios(){
        return $this->belongsTo(Horario::class, 'id_horario', 'id');
    }
    //relacion de uno a muchos con la tabla rl_excepcion_horario
    public function excepcion_horario(){
        return $this->hasMany(Excepcion::class, 'id_rango_hora', 'id')->OrderBy('id', 'asc');
    }

    //relacion de muchos a muchos con excepcion_dia_sem
    public function excepcion_dia_semana(){
        return $this->belongsToMany(Excepcion::class, 'excepcion_dia_sem', 'id_excepcion', 'id_dia_sem');
    }
}
