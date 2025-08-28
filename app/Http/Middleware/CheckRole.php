<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {


        // Vérifie si l'utilisateur est connecté
        if (!Auth::check()) {
            // S'il n'est pas connecté, on le redirige vers la page de login
            return redirect()->route('connexion');
        }

        // Vérifie si le rôle de l'utilisateur est dans la liste des rôles autorisés
        $user = Auth::user();
        if (!in_array($user->role, $roles)) {
            // on le bloque avec un 403
            abort(403, 'Accès refusé');
        }

        // Si tout est ok, il djor
        return $next($request);
    }
}