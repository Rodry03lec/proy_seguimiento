<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Ambito extends Model
{
    use HasFactory;
    protected $table = 'rl_ambito';
    protected $fillable=[
        'nombre',
        'descripcion',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //para que este en mayuscula
    protected function nombre():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => mb_strtoupper($value),
        );
    }
    public function profesion(){
        return $this->hasMany(Profesion::class, 'id_ambito', 'id');
    }
}
