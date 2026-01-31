<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
   public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_events' => Event::count(),
            'pending_events' => Event::where('status', 'pending')->count(),
            'total_organizers' => User::where('role', 'organizer')->count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::where('role', 'member')->latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function createUser(Request $request)
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
        $events = Event::with(['user', 'category'])->latest()->paginate(20);
        return view('admin.events', compact('events'));
    }

    public function approveEvent(Event $event)
    {
        $event->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Événement approuvé');
    }

    public function rejectEvent(Event $event)
    {
        $event->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Événement rejeté');
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
    return view('admin.dashboard'); 
}
}
