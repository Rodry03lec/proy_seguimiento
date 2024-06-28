<?php

namespace App\Models\Tramite;

use App\Models\Configuracion_tramite\Tipo_estado;
use App\Models\Configuracion_tramite\Tipo_prioridad;
use App\Models\Configuracion_tramite\Tipo_tramite;
use App\Models\Configuracion_tramite\User_cargo_tramite;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class Tramite extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'rl_tramite';

    protected $fillable = [
        'fecha_creada',
        'hora_creada',
        'fecha_hora_creada',
        'cite',
        'cite_texto',
        'numero_hojas',
        'numero_anexos',
        'referencia',
        'remitente_nombre',
        'remitente_cargo',
        'remitente_sigla',
        'remitente_txt',
        'destinatario_nombre',
        'destinatario_cargo',
        'destinatario_sigla',
        'destinatario_txt',
        'gestion',
        'numero_unico',
        'codigo',
        'observacion',
        'id_tipo_prioridad',
        'id_tipo_tramite',
        'id_estado',
        'remitente_id',
        'destinatario_id',
        'user_cargo_id',
    ];

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
            ->logOnly([
                'fecha_creada',
                'hora_creada',
                'fecha_hora_creada',
                'cite',
                'cite_texto',
                'numero_hojas',
                'numero_anexos',
                'referencia',
                'remitente_nombre',
                'remitente_cargo',
                'remitente_sigla',
                'remitente_txt',
                'destinatario_nombre',
                'destinatario_cargo',
                'destinatario_sigla',
                'destinatario_txt',
                'gestion',
                'numero_unico',
                'codigo',
                'observacion',
                'id_tipo_prioridad',
                'id_tipo_tramite',
                'id_estado',
                'remitente_id',
                'destinatario_id',
                'user_cargo_id',
            ])
            ->useLogName('rl_tramite')
            ->setDescriptionForEvent(fn(string $eventName) => $this->getDescriptionForEvent($eventName))
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getDescriptionForEvent(string $eventName): string {
        $user = Auth::user();
        return "Este modelo ha sido {$eventName} por el usuario {$user->nombres} {$user->apellidos} (ID: {$user->id}) (CI: {$user->ci})";
    }

    protected function referencia(): Attribute {
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value, 'UTF-8'),
            get: fn ($value) => mb_strtoupper($value, 'UTF-8'),
        );
    }

    protected function remitenteNombre(): Attribute {
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value, 'UTF-8'),
            get: fn ($value) => mb_strtoupper($value, 'UTF-8'),
        );
    }

    public function hojas_ruta() {
        return $this->hasMany(Hojas_ruta::class, 'tramite_id', 'id');
    }

    public function tipo_prioridad() {
        return $this->belongsTo(Tipo_prioridad::class, 'id_tipo_prioridad', 'id');
    }

    public function tipo_tramite() {
        return $this->belongsTo(Tipo_tramite::class, 'id_tipo_tramite', 'id');
    }

    public function estado_tipo() {
        return $this->belongsTo(Tipo_estado::class, 'id_estado', 'id');
    }

    public function remitente_user() {
        return $this->belongsTo(User_cargo_tramite::class, 'remitente_id', 'id');
    }

    public function destinatario_user() {
        return $this->belongsTo(User_cargo_tramite::class, 'destinatario_id', 'id');
    }

    public function user_cargo_tramite() {
        return $this->belongsTo(User_cargo_tramite::class, 'user_cargo_id', 'id');
    }
}
