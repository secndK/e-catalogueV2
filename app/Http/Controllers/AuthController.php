<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.Auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'mat_ag' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        $user = DB::connection('mysql')
            ->selectOne('SELECT * FROM users WHERE mat_ag = ? LIMIT 1', [$request->mat_ag]);

        if (!$user) {
            // Le message 'Matricule incorrect.' sera capturé par le SweetAlert2 en front-end
            return back()->withInput()->with('error', 'Matricule incorrect.');
        }

        if (!Hash::check($request->password, $user->password)) {
            // Le message 'Mot de passe incorrect.' sera capturé par le SweetAlert2 en front-end
            return back()->withInput()->with('error', 'Mot de passe incorrect.');
        }

        // Connexion de l'utilisateur
        Auth::loginUsingId($user->id);
        $request->session()->regenerate();

        // Redirection selon le rôle
        if ($user->role === 'admin') {

            return redirect()->route('dashboard');
        }

        return redirect()->route('catalogue');
    }





    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
