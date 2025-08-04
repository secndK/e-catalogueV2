<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('pages.Auth.login');
});


// Routes accessibles aux invités seulement
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('connexion');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/guest-access', [AuthController::class, 'guestAccess'])->name('guest.access');
});

// Routes accessibles aux utilisateurs connectés
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':admin'])->group(function () {

    Route::get('catalogue/all', [CatalogueController::class, 'getAllCatalogue'])->name('catalogue.all');

    Route::post('createCatalogue', [CatalogueController::class, 'createCatalogue'])->name('catalogue.create');
    Route::get('/catalogue/{id}/edit', [CatalogueController::class, 'editCatalogue'])->name('catalogue.edit');
    Route::post('/catalogue/{id}', [CatalogueController::class, 'updateCatalogue'])->name('catalogue.update.post');
    Route::put('/catalogue/{id}', [CatalogueController::class, 'updateCatalogue'])->name('catalogue.update');
    Route::delete('/catalogue/{id}/delete', [CatalogueController::class, 'deleteCatalogue'])->name('catalogue.delete');
    Route::get('/recent-searches', [CatalogueController::class, 'getRecentSearches'])->name('get.recent.searches');

    Route::get('/catalogue/export/all', [CatalogueController::class, 'exportAll'])->name('catalogue.export.all');
    Route::get('/catalogue/export/filtered', [CatalogueController::class, 'exportFiltered'])->name('catalogue.export.filtered');
});

Route::get('/catalogue', [CatalogueController::class, 'getCatalogue'])->name('catalogue')->middleware(['auth', \App\Http\Middleware\CheckRole::class . ':admin,user']);
Route::post('catalogue', [CatalogueController::class, 'postCatalogue'])->name('catalogue')->middleware(['auth', \App\Http\Middleware\CheckRole::class . ':admin,user']);
Route::post('/clear-search-history', [CatalogueController::class, 'clearSearchHistory'])->name('clear.search.history')->middleware(['auth', \App\Http\Middleware\CheckRole::class . ':admin,user']);

// Routes accessibles uniquement à l'admin
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'getStats'])->name('dashboard');
});

// Route de déconnexion (protégée par auth simple)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');