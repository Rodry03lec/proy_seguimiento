<?php

namespace App\Models\Fechas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    use HasFactory;
    protected $table = 'rl_gestion';
    protected $fillable=[
        'gestion',
    ];

    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';
}
