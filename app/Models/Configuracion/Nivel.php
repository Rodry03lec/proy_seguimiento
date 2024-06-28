<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Nivel extends Model
{
    use HasFactory;
    protected $table = 'rl_nivel';
    protected $fillable=[
        'nivel',
        'descripcion',
        'haber_basico',
        'id_categoria'
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //para que este en mayuscula
    protected function descripcion():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => mb_strtoupper($value),
        );
    }



    //relacion inversa con tipo de categoria
    public function categoria(){
        return $this->belongsTo(Tipo_categoria::class, 'id_categoria', 'id');
    }
}
