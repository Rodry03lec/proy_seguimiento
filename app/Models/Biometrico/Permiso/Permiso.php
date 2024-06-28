<?php

namespace App\Models\Biometrico\Permiso;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Biometrico\Permiso\Desglose_permiso;
use App\Models\Registro\Contrato;
use App\Models\Registro\Persona;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permiso extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'rl_permiso';
    protected $fillable=[
        'fecha',
        'descripcion',
        'fecha_inicio',
        'fecha_final',
        'hora_inicio',
        'hora_final',
        'aprobado',
        'constancia',
        'id_permiso_desglose',
        'id_us_create',
        'id_us_update',
        'id_persona',
        'id_contrato',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    protected $dates = ['deleted_at'];

    //relacion reversa con rl_persona_desglose
    public function permiso_desglose(){
        return $this->belongsTo(Desglose_permiso::class, 'id_permiso_desglose', 'id');
    }

    //relacion reversa con usuario
    public function usuario_creado(){
        return $this->belongsTo(User::class,  'id_us_create', 'id');
    }

    //relacion reversa con usuario
    public function usuario_editado(){
        return $this->belongsTo(User::class,  'id_us_update', 'id');
    }

    //relacion reversa con persona
    public function persona(){
        return $this->belongsTo(Persona::class, 'id_persona', 'id');
    }

    //relacion reversa con contrato
    public function contrato(){
        return $this->belongsTo(Contrato::class, 'id_contrato', 'id');
    }
}
