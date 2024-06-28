<?php

namespace App\Models\Configuracion;

use App\Models\Registro\Contrato;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baja extends Model
{
    use HasFactory;

    protected $table = 'rl_baja';
    protected $fillable=[
        'fecha',
        'descripcion',
        'id_tipo_baja',
        'id_usuario'
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //recion con contrato
    public function contrato(){
        return $this->hasOne(Contrato::class, 'id_baja', 'id');
    }
}
