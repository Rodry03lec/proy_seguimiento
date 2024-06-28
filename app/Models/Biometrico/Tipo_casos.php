<?php

namespace App\Models\Biometrico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Biometrico\Tipo_permiso;

class Tipo_casos extends Model
{
    use HasFactory;
    protected $table = 'rl_tipo_casos';
    protected $fillable=[
        'nombre',
        'descripcion',
        'estado',
        'id_tipo_permiso',
        'id_usuario',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';
    //relacion reversa de Tipo permiso
    public function tipo_permiso(){
        return $this->belongsTo(Tipo_permiso::class, 'id_tipo_permiso', 'id');
    }
}
