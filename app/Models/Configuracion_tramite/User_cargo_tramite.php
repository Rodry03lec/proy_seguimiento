<?php

namespace App\Models\Configuracion_tramite;

use App\Models\Configuracion\Cargo_mae;
use App\Models\Configuracion\Cargo_sm;
use App\Models\Registro\Contrato;
use App\Models\Registro\Persona;
use App\Models\Tramite\Tramite;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_cargo_tramite extends Model
{
    use HasFactory;
    protected $table = 'rl_user_cargo_tram';
    protected $fillable=[
        'id_cargo_sm',
        'id_cargo_mae',
        'id_contrato',
        'id_usuario',
        'id_persona',
        'estado'
    ];

    //relacion reversa de cargo_sm
    public function cargo_sm(){
        return $this->belongsTo(Cargo_sm::class, 'id_cargo_sm', 'id');
    }

    //relacion reversa con cargo_mae
    public function cargo_mae(){
        return $this->belongsTo(Cargo_mae::class, 'id_cargo_mae', 'id');
    }

    //relacion reversa con contrato
    public function contrato(){
        return $this->belongsTo(Contrato::class, 'id_contrato', 'id');
    }

    //relacion reversa con usuario
    public function usuario(){
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }

    //relacion reversa con persona
    public function persona(){
        return $this->belongsTo(Persona::class, 'id_persona', 'id');
    }

    //para la relacion de uno a muchos con tramite
    public function tramite(){
        return $this->hasMany(Tramite::class, 'user_cargo_id', 'id');
    }
}
