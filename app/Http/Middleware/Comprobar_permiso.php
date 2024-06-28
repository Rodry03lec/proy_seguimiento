<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Comprobar_permiso
{
    public function handle($request, Closure $next, ...$permissions)
{
    foreach ($permissions as $permission) {
        if ($request->user()->can($permission)) {
            return $next($request);
        }
    }

    abort(403, "No tienes permiso para acceder a esta página :(");
}
}
