<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Organizer\OrganizerController;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Models\Event; 

Route::get('/dashboard', function () {
    // 1. On récupère tous les événements
    $events = Event::all(); 
    
    // 2. On envoie la variable $events à la vue
    return view('member.dashboard', compact('events')); 
})->middleware(['auth', 'verified'])->name('dashboard');
// 1. ROUTES PUBLIQUES (Visiteurs)
Route::get('/', [EventController::class, 'index'])->name('home');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/calendar', [EventController::class, 'calendar'])->name('events.calendar');

// 2. REDIRECTION DASHBOARD (L'aiguillage central)
Route::get('/dashboard', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role === 'Admin') return redirect()->route('admin.dashboard');
        if ($role === 'Organizer') return redirect()->route('organizer.dashboard');
        if ($role === 'Member') return redirect()->route('member.dashboard');
    }
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

// 3. ROUTES AUTHENTIFIÉES (Profil)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// 4. ROUTES MEMBRES (Member)
Route::middleware(['auth'])->group(function () {
    Route::get('/member/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard'); // Utilise index comme dans ton code
    Route::get('/member/reservations', [MemberController::class, 'reservations'])->name('member.reservations');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');    
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
});

// 5. ROUTES ORGANISATEURS (Organizer)
Route::middleware(['auth'])->group(function () {
    Route::get('/organizer/dashboard', [OrganizerController::class, 'dashboard'])->name('organizer.dashboard');
    Route::get('/organizer/events', [OrganizerController::class, 'events'])->name('organizer.events');
    Route::get('/organizer/events/create', [OrganizerController::class, 'create'])->name('organizer.events.create');
    Route::post('/organizer/events', [OrganizerController::class, 'store'])->name('organizer.events.store');
    Route::get('/organizer/events/{event}/edit', [OrganizerController::class, 'edit'])->name('organizer.events.edit');
    Route::put('/organizer/events/{event}', [OrganizerController::class, 'update'])->name('organizer.events.update');
    Route::delete('/organizer/events/{event}', [OrganizerController::class, 'destroy'])->name('organizer.events.destroy');
    Route::get('/organizer/reservations', [OrganizerController::class, 'reservations'])->name('organizer.reservations');
    Route::put('/organizer/reservations/{reservation}/confirm', [OrganizerController::class, 'confirmReservation'])->name('organizer.reservations.confirm');
    Route::put('/organizer/reservations/{reservation}/cancel', [OrganizerController::class, 'cancelReservation'])->name('organizer.reservations.cancel');
});

// 6. ROUTES ADMIN (Admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/organizers', [AdminController::class, 'organizers'])->name('admin.organizers');
    Route::get('/admin/events', [AdminController::class, 'events'])->name('admin.events');
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
});

// 7. COMMENTAIRES
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth');


Route::post('/reservation/payment', [ReservationController::class, 'processPayment'])->name('reservation.payment');
