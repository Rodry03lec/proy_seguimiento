<?php

namespace App\Models\Tramite;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Ruta_archivado extends Model
{
    use HasFactory;
    protected $table = 'rl_ruta_archivado';
    protected $fillable=[
        'descripcion',
        'id_hoja_ruta',
    ];

    //relacion reversa con Hoja_ruta
    public function hoja_ruta(){
        return $this->belongsTo(Hojas_ruta::class, 'id_hoja_ruta', 'id');
    }

    protected function descripcion(): Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value, 'UTF-8'),
            get: fn ($value) => mb_strtoupper($value, 'UTF-8'),
        );
    }
}
