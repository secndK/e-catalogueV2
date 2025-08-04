<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. Vérifie si l'utilisateur est connecté (authentifié)
        if (!Auth::check()) {
            // S'il n'est pas connecté, on le redirige vers la page de login
            return redirect()->route('connexion');
        }

        // 2. Récupère l'utilisateur connecté
        $user = Auth::user(); // équivalent de auth()->user()

        // 3. Vérifie si le rôle de l'utilisateur est dans la liste des rôles autorisés
        if (!in_array($user->role, $roles)) {
            // Si non autorisé => erreur 403 (Accès interdit)
            abort(403, 'Accès refusé');
        }

        // 4. Si tout est ok, on laisse passer la requête
        return $next($request);
    }
}