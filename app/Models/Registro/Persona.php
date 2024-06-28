<?php

namespace App\Models\Registro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Configuracion\Estado_civil;
use App\Models\Configuracion\Genero;
use App\Models\Registro\Contrato;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class Persona extends Model
{
    use HasFactory; //LogsActivity;

    protected $table = 'rl_persona';

    protected $fillable = [
        'ci',
        'complemento',
        'nit',
        'nombres',
        'ap_paterno',
        'ap_materno',
        'fecha_nacimiento',
        'gmail',
        'celular',
        'direccion',
        'estado',
        'id_genero',
        'id_estado_civil',
        'id_usuario',
    ];

    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    // Relación reversa con rl_genero
    public function genero(){
        return $this->belongsTo(Genero::class, 'id_genero', 'id');
    }

    // Relación reversa con rl_estado_civil
    public function estado_civil(){
        return $this->belongsTo(Estado_civil::class, 'id_estado_civil', 'id');
    }

    // Relación de uno a muchos con el contrato
    public function contrato(){
        return $this->hasMany(Contrato::class, 'id_persona', 'id');
    }

    public function getActivitylogOptions(): LogOptions{
        return LogOptions::defaults()
            ->logOnly([
                'ci',
                'complemento',
                'nit',
                'nombres',
                'ap_paterno',
                'ap_materno',
                'fecha_nacimiento',
                'gmail',
                'celular',
                'direccion',
                'estado',
                'id_genero',
                'id_estado_civil',
                'id_usuario',
            ])
            ->useLogName('persona') // El nombre del log
            ->setDescriptionForEvent(fn(string $eventName) => $this->getDescriptionForEvent($eventName))
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    // Descripción personalizada para eventos
    public function getDescriptionForEvent(string $eventName): string {
        $user = Auth::user();
        return "Este modelo ha sido {$eventName} por el usuario {$user->nombres} {$user->apellidos} (ID: {$user->id})  (CI: {$user->ci})";
    }
}
