<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class EventController extends Controller
{ 
    public function index(Request $request)
    {
        $query = Event::with(['category', 'organizer', 'comments'])
            ->where('is_active', true)
            ->where('status', 'approved');

        // Filtre de recherche
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%');
            });
        }

        // Filtre par région
        if ($request->region) {
            $query->where('region', $request->region);
        }

        // Filtre par catégorie
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        // Filtre par type
        if ($request->type) {
            $query->where('type', $request->type);
        }

        $events = $query->get();

        // 5. IMPORTANT : On envoie la variable $events à la vue dashboard
        // Vérifie bien que le nom de ton fichier vue est correct ('member.dashboard' ou 'dashboard')
        return view('member.dashboard', compact('events'));

        $events = $query->orderBy('start_date', 'asc')->paginate(12);
        $categories = Category::all();
        
        return view('events.index', compact('events', 'categories'));
    }

    public function show($id)
    {
        $events = Event::with(['category', 'organizer', 'comments.user'])->findOrFail($id);
        return view('events.show', compact('event'));
    }

    public function calendar()
    {
        $events = Event::where('is_active', true)
            ->where('status', 'approved')
            ->orderBy('start_date', 'asc')
            ->get();
        
        return view('events.calendar', compact('events'));
    }
}