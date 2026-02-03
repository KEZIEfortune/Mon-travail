<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Organizer\OrganizerController;
use App\Http\Controllers\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| Routes Publiques (Visiteurs)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

/*
|--------------------------------------------------------------------------
| Routes d'Authentification
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

/*
|--------------------------------------------------------------------------
| Routes Membres (authentifiés)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'member'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [ReservationController::class, 'Dashboard'])->name('dashboard');

    // ✅ Routes à ajouter
    Route::get('/events/search', [EventController::class, 'search'])->name('events.search');
    Route::get('/reservations', [ReservationController::class, 'myReservations'])->name('reservations.index');
    Route::get('/reservations/{id}', [ReservationController::class, 'showReservation'])->name('reservations.show');
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile');

    // Déjà existantes
    Route::post('/events/{id}/reserve', [ReservationController::class, 'store'])->name('reserve');
    Route::post('/reservations/{id}/validate-payment', [ReservationController::class, 'validatePayment'])->name('reservations.validate');
    Route::delete('/reservations/{id}', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::post('/events/{id}/comment', [EventController::class, 'addComment'])->name('events.comment');
});

/*
|--------------------------------------------------------------------------
| Routes Organisateurs
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'organizer'])->prefix('organizer')->name('organizer.')->group(function () {
    Route::get('/dashboard', [OrganizerController::class, 'dashboard'])->name('dashboard');
    Route::get('/events', [OrganizerController::class, 'index'])->name('events.index');
    Route::get('/events/create', [OrganizerController::class, 'create'])->name('events.create');
    Route::post('/events', [OrganizerController::class, 'store'])->name('events.store');
    Route::get('/events/{id}/edit', [OrganizerController::class, 'edit'])->name('events.edit');
    Route::put('/events/{id}', [OrganizerController::class, 'update'])->name('events.update');
    Route::delete('/events/{id}', [OrganizerController::class, 'destroy'])->name('events.destroy');
    Route::get('/reservations', [OrganizerController::class, 'reservations'])->name('reservations.index');
    Route::post('/reservations/{id}/confirm', [OrganizerController::class, 'confirmReservation'])->name('reservations.confirm');
    Route::post('/reservations/{id}/cancel', [OrganizerController::class, 'cancelReservation'])->name('reservations.cancel');
});

/*
|--------------------------------------------------------------------------
| Routes Administrateur
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    /*
    | Gestion des Membres
    */
    Route::get('/members', [AdminController::class, 'members'])->name('members.index');
    Route::get('/members/create', [AdminController::class, 'createMemberForm'])->name('members.create');
    Route::post('/members', [AdminController::class, 'storeMember'])->name('members.store');
    Route::get('/members/{id}/edit', [AdminController::class, 'editMember'])->name('members.edit');
    Route::put('/members/{id}', [AdminController::class, 'updateMember'])->name('members.update');
    Route::delete('/members/{id}', [AdminController::class, 'deleteMember'])->name('members.delete');
    Route::post('/members/{id}/ban', [AdminController::class, 'banMember'])->name('members.ban');
    Route::post('/members/{id}/unban', [AdminController::class, 'unbanMember'])->name('members.unban');
    
    /*
    | Gestion des Organisateurs
    */
    Route::get('/organizers', [AdminController::class, 'organizers'])->name('organizers.index');
    Route::get('/organizers/create', [AdminController::class, 'createOrganizerForm'])->name('organizers.create');
    Route::post('/organizers', [AdminController::class, 'storeOrganizer'])->name('organizers.store');
    Route::get('/organizers/{id}/edit', [AdminController::class, 'editOrganizer'])->name('organizers.edit');
    Route::put('/organizers/{id}', [AdminController::class, 'updateOrganizer'])->name('organizers.update');
    Route::delete('/organizers/{id}', [AdminController::class, 'deleteOrganizer'])->name('organizers.delete');
    Route::post('/organizers/{id}/suspend', [AdminController::class, 'suspendOrganizer'])->name('organizers.suspend');
    Route::post('/organizers/{id}/unsuspend', [AdminController::class, 'unsuspendOrganizer'])->name('organizers.unsuspend');
    
    /*
    | Validation des Événements
    */
    Route::get('/events/pending', [AdminController::class, 'pendingEvents'])->name('events.pending');
    Route::get('/events', [AdminController::class, 'allEvents'])->name('events.index');
    Route::post('/events/{id}/validate', [AdminController::class, 'validateEvent'])->name('events.validate');
    Route::post('/events/{id}/reject', [AdminController::class, 'rejectEvent'])->name('events.reject');
    Route::delete('/events/{id}', [AdminController::class, 'deleteEvent'])->name('events.delete');
    
    /*
    | Gestion des Catégories
    */
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');
    Route::get('/categories/create', [AdminController::class, 'createCategoryForm'])->name('categories.create');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])->name('categories.delete');
    
    /*
    | Modération des Commentaires
    */
    Route::get('/comments', [AdminController::class, 'comments'])->name('comments.index');
    Route::delete('/comments/{id}', [AdminController::class, 'deleteComment'])->name('comments.delete');
    
    /*
    | Statistiques et Rapports
    */
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
});