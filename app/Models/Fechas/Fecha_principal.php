<?php

namespace App\Models\Fechas;

use App\Models\Biometrico\Feriado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fecha_principal extends Model
{
    use HasFactory;
    protected $table = 'rl_fecha_principal';
    protected $fillable=[
        'fecha',
        'id_gestion',
        'id_mes',
        'id_dia_sem',
    ];

    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //realacion reversa con la gestion
    public function gestion(){
        return $this->belongsTo(Gestion::class, 'id_gestion', 'id');
    }
    //relacion revers con gestion
    public function mes(){
        return $this->belongsTo(Mes::class, 'id_mes', 'id');
    }
    //relacion con dias de semana
    public function dias_semana(){
        return $this->belongsTo(Dias_semana::class, 'id_dia_sem', 'id');
    }
    //relacion de uno a muchos con feriado
    public function feriado(){
        return $this->hasOne(Feriado::class, 'id_fecha_principal', 'id');
    }

    //
}
