<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DemandeServController;

Route::get('/', function () {
    return view('pages.Auth.login');
});

Route::get('/test', function () {
    return view('test');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('connexion');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Routes accessibles aux utilisateurs connectés (admin et user)
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':admin,user'])->group(function () {

    // Routes catalogue accessibles à tous les utilisateurs authentifiés
    Route::prefix('catalogue')->group(function () {
        Route::get('/', [CatalogueController::class, 'getCatalogue'])->name('catalogue');
        Route::post('/', [CatalogueController::class, 'postCatalogue'])->name('catalogue.search');
    });
});

// Routes réservées à l'admin uniquement
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':admin'])->group(function () {

    // Dashboard admin
    Route::get('/dashboard', [DashboardController::class, 'getStats'])->name('dashboard');

    // Gestion complète du catalogue
    Route::prefix('catalogue')->group(function () {
        Route::get('all', [CatalogueController::class, 'getAllCatalogue'])->name('catalogue.all');
        Route::get('export/all', [CatalogueController::class, 'exportAll'])->name('catalogue.export.all');

        Route::post('create', [CatalogueController::class, 'createCatalogue'])->name('catalogue.create');
        Route::get('{id}/edit', [CatalogueController::class, 'editCatalogue'])->name('catalogue.edit');
        Route::put('{id}', [CatalogueController::class, 'updateCatalogue'])->name('catalogue.update');
        Route::delete('{id}/delete', [CatalogueController::class, 'deleteCatalogue'])->name('catalogue.delete');
    });

    Route::post('demande', [CatalogueController::class, 'faireDemande'])->name('faire.demande');
});

// Route de déconnexion (accessible à tous les utilisateurs connectés)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
