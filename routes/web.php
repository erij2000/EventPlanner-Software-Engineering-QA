<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminRegistrationController;

/*
|--------------------------------------------------------------------------
| Pages publiques
|--------------------------------------------------------------------------
*/

// Accueil
Route::get('/', fn () => view('home'))->name('home');

// Liste publique des événements
Route::get('/events', [EventController::class, 'publicIndex'])->name('events.public');

// Détail d’un événement
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

/*
|--------------------------------------------------------------------------
| Espace utilisateur
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/events/{event}/cancel', [RegistrationController::class, 'destroy'])->name('events.cancel');
    // S’inscrire à un événement
    Route::post('/events/{event}/register', [RegistrationController::class, 'store'])
        ->name('events.register');

    // Mes inscriptions (dashboard utilisateur)
    Route::get('/my-registrations', [RegistrationController::class, 'myRegistrations'])
        ->name('my.registrations');

    // Dashboard → redirige selon rôle
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('my.registrations');
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Espace administrateur
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard admin
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');

    // CRUD catégories
    Route::resource('categories', CategoryController::class);

    // CRUD événements
    Route::resource('events', EventController::class);

    // Toutes les inscriptions (admin)
    Route::get('/registrations', [AdminRegistrationController::class, 'allRegistrations'])
        ->name('registrations');
});

/*
|--------------------------------------------------------------------------
| Routes d’authentification (Breeze / Jetstream)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
