<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // Correction de l'import ici

class OrganizerController extends Controller
{
    public function dashboard()
    {
        // On récupère les stats pour les afficher sur la page
        $stats = [
            'total_events' => Event::where('organizer_id', Auth::id())->count(),
            'approved_events' => Event::where('organizer_id', Auth::id())->where('status', 'approved')->count(),
            'pending_events' => Event::where('organizer_id', Auth::id())->where('status', 'pending')->count(),
            'total_reservations' => Reservation::whereHas('event', function($q) {
                $q->where('organizer_id', Auth::id());
            })->count(),
        ];
        
        // Assurez-vous que le dossier s'appelle bien 'organisateur' dans resources/views
        return view('organizer.dashboard', compact('stats'));
    }

    public function events()
    {
        $events = Event::where('user_id', Auth::id())
            ->with(['category', 'reservations'])
            ->latest()
            ->paginate(10);
        
        return view('organisateur.events', compact('events'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('organisateur.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'location' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'type' => 'required|in:festival,concert,exposition,theatre',
            'category_id' => 'required|exists:categories,id',
            'available_tickets' => 'nullable|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending'; 
        $validated['is_active'] = true;

        Event::create($validated);

        return redirect()->route('organisateur.events')->with('success', 'Événement créé ! En attente de validation.');
    }

    // Gardez le reste de vos fonctions (edit, update, destroy, etc.) 
    // en veillant à utiliser view('organisateur.xxx')
}