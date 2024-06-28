<?php

namespace App\Models\Biometrico;

use App\Models\Fechas\Fecha_principal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feriado extends Model
{
    use HasFactory;
    protected $table = 'rl_feriado';
    protected $fillable=[
        'descripcion',
        'id_fecha_principal',
        'id_usuario'
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //relacion reversa con fecha principal
    public function fecha_principal(){
        return $this->belongsTo(Fecha_principal::class, 'id_fecha_principal', 'id');
    }
}
