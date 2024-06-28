<?php

namespace App\Models\Registro;

use App\Models\Configuracion\Baja;
use App\Models\Configuracion\Cargo_mae;
use App\Models\Configuracion\Cargo_sm;
use App\Models\Configuracion\Grado_academico;
use App\Models\Configuracion\Horario;
use App\Models\Configuracion\Nivel;
use App\Models\Configuracion\Profesion;
use App\Models\Configuracion\Tipo_contrato;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class Contrato extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'rl_contrato';
    protected $fillable=[
        'fecha_inicio',
        'fecha_conclusion',
        'numero_contrato',
        'haber_basico',
        'estado',
        'id_nivel',
        'id_tipo_contrato',
        'id_persona',
        'id_cargo_mae',
        'id_cargo_sm',
        'id_profesion',
        'id_grado_academico',
        'id_horario',
        'id_usuario',
        'id_baja',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';


    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
            ->logOnly([
                'fecha_inicio',
                'fecha_conclusion',
                'numero_contrato',
                'haber_basico',
                'estado',
                'id_nivel',
                'id_tipo_contrato',
                'id_persona',
                'id_cargo_mae',
                'id_cargo_sm',
                'id_profesion',
                'id_grado_academico',
                'id_horario',
                'id_usuario',
                'id_baja',
            ])
            ->useLogName('rl_contrato')
            ->setDescriptionForEvent(fn(string $eventName) => $this->getDescriptionForEvent($eventName))
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getDescriptionForEvent(string $eventName): string {
        $user = Auth::user();
        return "Este modelo ha sido {$eventName} por el usuario {$user->nombres} {$user->apellidos} (ID: {$user->id}) (CI: {$user->ci})";
    }


    //relacion reversa con nivel
    public function nivel(){
        return $this->belongsTo(Nivel::class, 'id_nivel', 'id');
    }
    //relacion reversa con tipo de contrato
    public function tipo_contrato(){
        return $this->belongsTo(Tipo_contrato::class, 'id_tipo_contrato', 'id');
    }
    //relacion con persona
    public function persona() {
        return $this->belongsTo(Persona::class, 'id_persona', 'id');
    }
    //relacion reversa con cargo mae
    public function cargo_mae(){
        return $this->belongsTo(Cargo_mae::class, 'id_cargo_mae', 'id');
    }
    //relacion reversa con  cargo_sm
    public function cargo_sm(){
        return $this->belongsTo(Cargo_sm::class, 'id_cargo_sm', 'id');
    }
    //relacion reversa con id_profesion
    public function profesion(){
        return $this->belongsTo(Profesion::class, 'id_profesion', 'id');
    }
    //relacion reversa con grado academico
    public function grado_academico(){
        return $this->belongsTo(Grado_academico::class, 'id_grado_academico', 'id');
    }
    //relacion con el horario
    public function horario(){
        return $this->belongsTo(Horario::class, 'id_horario', 'id');
    }
    //relacion con el usuario
    public function usuario(){
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }
    //relacion reversa con baja
    public function baja(){
        return $this->belongsTo(Baja::class, 'id_baja', 'id');
    }
}
