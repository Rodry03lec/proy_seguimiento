<?php

namespace App\Models\Biometrico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Biometrico\Tipo_casos;

class Tipo_permiso extends Model
{
    use HasFactory;
    protected $table = 'rl_tipo_permiso';
    protected $fillable=[
        'nombre',
        'descripcion',
        'estado',
        'id_usuario',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //relacion con tipos de casos
    public function tipos_casos(){
        return $this->hasMany(Tipo_casos::class, 'id_tipo_permiso', 'id');
    }
}
