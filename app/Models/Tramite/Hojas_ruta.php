<?php

namespace App\Models\Tramite;

use App\Models\Configuracion_tramite\Tipo_estado;
use App\Models\Configuracion_tramite\Tipo_tramite;
use App\Models\Configuracion_tramite\User_cargo_tramite;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tramite\Tramite;
use App\Models\Tramite\Ruta_archivado;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Hojas_ruta extends Model
{
    use HasFactory;
    protected $table = 'rl_hojas_ruta';
    protected $fillable=[
        'paso',
        'paso_txt',
        'instructivo',
        'nro_hojas_ingreso',
        'nro_anexos_ingreso',
        'nro_hojas_salida',
        'nro_anexos_salida',
        'fecha_ingreso',
        'fecha_salida',
        'fecha_envio',
        'actual',
        'remitente_id',
        'destinatario_id',
        'estado_id',
        'tramite_id',
    ];

    protected function instructivo(): Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value, 'UTF-8'),
            get: fn ($value) => mb_strtoupper($value, 'UTF-8' ),
        );
    }

    //relacion reversa con User_cargo_tramite
    public function remitente_user(){
        return $this->belongsTo(User_cargo_tramite::class, 'remitente_id', 'id');
    }

    //relacion reversa con User_cargo_tramite
    public function destinatario_user(){
        return $this->belongsTo(User_cargo_tramite::class, 'destinatario_id', 'id');
    }

    //relacion reversa con estado
    public function estado_tipo(){
        return $this->belongsTo(Tipo_estado::class, 'estado_id', 'id');
    }

    //relacion reversa con tramite
    public function tramite(){
        return $this->belongsTo(Tramite::class, 'tramite_id', 'id');
    }

    //relacion de uno a uno
    public function ruta_archivado(){
        return $this->hasOne(Ruta_archivado::class, 'id_hoja_ruta', 'id');
    }
}
