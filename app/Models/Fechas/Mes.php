<?php

namespace App\Models\Fechas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mes extends Model
{
    use HasFactory;
    protected $table = 'rl_mes';
    protected $fillable=[
        'numero',
        'nombre'
    ];

    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';
    
}
