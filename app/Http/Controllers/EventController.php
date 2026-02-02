<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Liste des événements publics (Approuvés et Validés)
     */
    public function index(Request $request)
    {
        $query = Event::with('organizer')
            ->where('status', 'approved') // 'approved' est dans ton ENUM
            ->where('is_validated', 1)
            ->where('start_date', '>=', now());

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('region', 'like', "%{$search}%");  // Ajoute la recherche par région
            });
        }

        $query->orderBy('start_date', 'asc');

        $events = $query->paginate(12);
        $categories = Category::all();

        return view('events.index', compact('events', 'categories'));
    }

    /**
     * Enregistrer un nouvel événement (Colonnes BDD respectées)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $data = $request->all();
            $data['organizer_id'] = Auth::id();
            $data['status'] = 'pending';   // Par défaut en attente
            $data['is_validated'] = 0;     // Non validé par défaut
            $data['slug'] = Str::slug($request->title) . '-' . time();

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('events', 'public');
            }

            Event::create($data);

            return redirect()->route('organisateur.events.index')
                ->with('success', 'Événement créé ! En attente de validation admin.');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Action pour l'Admin : Valider un événement
     */
    public function validateEvent($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $event = Event::findOrFail($id);
        $event->update([
            'status' => 'approved',
            'is_validated' => 1
        ]);

        return redirect()->back()->with('success', 'Événement approuvé et publié !');
    }

    // ... Gardez vos méthodes show, edit, update, destroy en remplaçant 'titre' par 'title'
}