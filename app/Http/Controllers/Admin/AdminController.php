<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\Category;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminController extends Controller
{
   public function dashboard()
{
    // Statistiques globales basées sur votre schéma DB
    $totalUsers = User::count();
    $totalEvents = Event::count();
    $totalReservations = \App\Models\Reservation::count();
    
    // Un événement est en attente si is_validated est faux
    $pendingEvents = Event::where('is_validated', false)->count();

    // Liste des événements en attente avec leur organisateur
    $pendingEventsList = Event::with('organizer')
        ->where('is_validated', false)
        ->orderBy('created_at', 'desc')
        ->get();

    // Nouveaux inscrits selon les rôles de votre enum
    $recentMembers = User::where('role', 'member')
        ->latest()->limit(5)->get();

    $recentOrganizers = User::where('role', 'organizer')
        ->latest()->limit(5)->get();

    // Statistiques d'activité (is_active dans votre DB)
    $activeMembers = User::where('role', 'member')->where('is_active', true)->count();
    $validatedEvents = Event::where('is_validated', true)->count();
    $bannedUsers = User::where('is_active', false)->count();

    return view('admin.dashboard', compact(
        'totalUsers', 'totalEvents', 'totalReservations', 'pendingEvents',
        'pendingEventsList', 'recentMembers', 'recentOrganizers',
        'activeMembers', 'validatedEvents', 'bannedUsers'
    ));
}
    public function members()
    {
        $users = User::where('role', 'member')->latest()->paginate(20);
        return view('admin.users', compact('users'));
    }
    public function pendingEvents()
    {
        $events = Event::with('organizer')
            ->where('is_validated', false)
            ->latest()
            ->paginate(20);
        return view('admin.events', compact('events')); 
    }

    public function storeMember(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:member,organizer',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Utilisateur créé avec succès');
    }

    public function toggleUserStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        return redirect()->back()->with('success', 'Statut modifié');
    }

    public function organizers()
    {
        $organizers = User::where('role', 'organizer')->latest()->paginate(20);
        return view('admin.organizers', compact('organizers'));
    }

    public function events()
    {
        $events = Event::with(['organizer', 'category'])->latest()->paginate(20);
        return view('admin.events', compact('events'));
    }

    public function approveEvent(Event $event)
    {
    $event->update([
        'is_validated' => true,
        'status' => 'published' // On s'assure qu'il est aussi publié
    ]);
    return redirect()->back()->with('success', 'Événement approuvé et publié !');
    }
    public function rejectEvent(Event $event)
    {
    $event->update([
        'is_validated' => false,
        'status' => 'rejected'
    ]);
    return redirect()->back()->with('success', 'Événement rejeté.');
    }

    public function deleteEvent(Event $event)
    {
        $event->delete();
        return redirect()->back()->with('success', 'Événement supprimé');
    }

    public function categories()
    {
        $categories = Category::all();
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);

        return redirect()->back()->with('success', 'Catégorie créée');
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Catégorie supprimée');
    } 
    public function index() {
    return response()->view('admin.dashboard', compact('totalUsers'));

}
}
