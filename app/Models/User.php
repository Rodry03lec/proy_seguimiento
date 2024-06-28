<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Configuracion_tramite\User_cargo_tramite;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class User extends Authenticatable
{
    use HasRoles,HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usuario',
        'password',
        'ci',
        'nombres',
        'apellidos',
        'estado',
        'id_persona',
    ];



    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    protected function nombres():Attribute{
        return new Attribute(
            set: fn ($value) => ucfirst($value),
            get: fn ($value) => $value,
        );
    }

    protected function apellidos():Attribute{
        return new Attribute(
            set: fn ($value) => ucfirst($value),
            get: fn ($value) => $value,
        );
    }

    //relacion revesa
    public function roles(){
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
    }

    //relacion de uno a muchos con
    public function user_cargo_tramite(){
        return $this->hasMany(User_cargo_tramite::class, 'id_usuario', 'id');
    }
}
