<?php

namespace App\Models\Biometrico;

use App\Models\Fechas\Fecha_principal;
use App\Models\Registro\Contrato;
use App\Models\Registro\Persona;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biometrico extends Model
{
    use HasFactory;
    protected $table = 'rl_biometrico';
    protected $fillable=[
        'hora_ingreso_ma',
        'hora_salida_ma',
        'hora_entrada_ta',
        'hora_salida_ta',
        'id_fecha',
        'id_persona',
        'id_contrato',
        'id_usuario',
        'id_user_up',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //relacion reversa con fecha principal
    public function fecha_principal(){
        return $this->belongsTo(Fecha_principal::class, 'id_fecha', 'id');
    }
    //relacion reversa con persona
    public function persona(){
        return $this->belongsTo(Persona::class, 'id_persona', 'id');
    }
    //relacion reversa con contrato
    public function contrato(){
        return $this->belongsTo(Contrato::class, 'id_contrato', 'id');
    }

    //relacion con usuario quien inserto
    public function usuario(){
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }

    //relacion con el uusario quien edito
    public function usuario_edit(){
        return $this->belongsTo(User::class, 'id_user_up', 'id');
    }
}
