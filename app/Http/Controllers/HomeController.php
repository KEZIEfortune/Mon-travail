<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Afficher la page d'accueil avec les événements
     */
    public function index(Request $request)
    {
        // Requête de base pour les événements publics
        $query = Event::where('status', 'published')
            ->where('is_validated', true)
            ->where('date', '>=', now());

        // Filtrer par recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('lieu', 'like', "%{$search}%");
            });
        }

        // Filtrer par type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filtrer par date
        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('date', today());
                    break;
                case 'week':
                    $query->whereBetween('date', [now(), now()->addWeek()]);
                    break;
                case 'month':
                    $query->whereBetween('date', [now(), now()->addMonth()]);
                    break;
            }
        }

        // Filtrer par prix
        if ($request->filled('prix_filter')) {
            switch ($request->prix_filter) {
                case 'free':
                    $query->where('prix', 0);
                    break;
                case 'low':
                    $query->where('prix', '>', 0)->where('prix', '<=', 100);
                    break;
                case 'mid':
                    $query->where('prix', '>', 100)->where('prix', '<=', 300);
                    break;
                case 'high':
                    $query->where('prix', '>', 300);
                    break;
            }
        }

        // Récupérer les événements
        $events = Event::where('is_validated', true)
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')  // ✅ CORRECTION ICI
            ->limit(12)
            ->get();

        return view('welcome', compact('events'));
    }
}