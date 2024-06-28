<?php

namespace App\Models\Biometrico\Licencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Biometrico\Licencia\Tipo_licencia;
use App\Models\Registro\Contrato;
use App\Models\Registro\Persona;
use App\Models\User;

class Licencia extends Model
{
    use HasFactory;
    protected $table = 'rl_licencia';
    protected $fillable=[
        'fecha',
        'descripcion',
        'hora_inicio',
        'hora_final',
        'fecha_inicio',
        'fecha_final',
        'aprobado',
        'constancia',
        'id_us_create',
        'id_us_update',
        'id_tipo_licencia',
        'id_persona',
        'id_contrato',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //relacion reversa con usuario create
    public function usuario_creado(){
        return $this->belongsTo(User::class, 'id_us_create', 'id');
    }

    //relacion reversa con usuario update
    public function usuario_editado(){
        return $this->belongsTo(User::class, 'id_us_update', 'id');
    }

    //relacion reversa con rl_tipo_licencia
    public function tipo_licencia(){
        return $this->belongsTo(Tipo_licencia::class,  'id_tipo_licencia', 'id');
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
