<?php

namespace App\Models\Biometrico\Permiso;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Biometrico\Permiso\Tipo_permiso;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Desglose_permiso extends Model
{
    use HasFactory;
    protected $table = 'rl_permiso_desglose';
    protected $fillable=[
        'nombre',
        'descripcion',
        'estado',
        'id_tipo_permiso',
        'id_usuario',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //reversa de tipo permiso
    public function tipo_permiso(){
        return $this->belongsTo(Tipo_permiso::class, 'id_tipo_permiso', 'id');
    }

    //para que convierta en mayusculas
    protected function nombre(): Attribute {
        return new Attribute(
            set: fn($value) => mb_convert_case($value, MB_CASE_UPPER, 'UTF-8'),
            get: fn($value) => mb_convert_case($value, MB_CASE_UPPER, 'UTF-8'),
        );
    }
}
