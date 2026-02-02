<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Reservation;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrganizerController extends Controller
{
    
    public function dashboard()
    {
        $user = Auth::user();

        // Statistiques
        $totalEvents = Event::where('organizer_id', $user->id)->count();
        
        $upcomingEvents = Event::where('organizer_id', $user->id)
            ->where('start_date', '>=', now())
            ->count();
        
        $totalReservations = Reservation::whereHas('event', function($query) use ($user) {
            $query->where('organizer_id', $user->id);
        })->where('status', 'confirmed')->count();
        
        $totalRevenue = Reservation::whereHas('event', function($query) use ($user) {
            $query->where('organizer_id', $user->id);
        })
        ->where('status', 'confirmed')
        ->sum('total_price');

        // Événements récents
        $recentEvents = Event::where('organizer_id', $user->id)
            ->withCount(['reservations as confirmed_count' => function($query) {
                $query->where('status', 'confirmed');
            }])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Réservations récentes
        $recentReservations = Reservation::with(['event', 'user'])
            ->whereHas('event', function($query) use ($user) {
                $query->where('organizer_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Taux de remplissage
        $totalTickets = $recentEvents->sum('available_tickets');
        $confirmedTickets = $recentEvents->sum('confirmed_count');
        $fillRate = $totalTickets > 0 ? round(($confirmedTickets / $totalTickets) * 100) : 0;

        return view('organizer.dashboard', compact(
            'totalEvents',
            'upcomingEvents',
            'totalReservations',
            'totalRevenue',
            'recentEvents',
            'recentReservations',
            'fillRate'
        ));
    }

    /**
     * Afficher la liste des événements de l'organisateur
     */
    public function index()
    {
        $user = Auth::user();

        $recentEvents = Event::where('organizer_id', $user->id)
            ->withCount(['reservations as confirmed_count' => function($query) {
                $query->where('status', 'confirmed');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalEvents = $recentEvents->count();
        $upcomingEvents = Event::where('organizer_id', $user->id)
            ->where('start_date', '>', now())
            ->count();
        $totalReservations = Reservation::whereHas('event', function($q) use ($user) {
                $q->where('organizer_id', $user->id);
            })->count();
        
        $totalRevenue = $recentEvents->sum(function($event) {
            return $event->price * $event->confirmed_count;
        });

        $totalTickets = $recentEvents->sum('available_tickets');
        $confirmedTickets = $recentEvents->sum('confirmed_count');
        $fillRate = $totalTickets > 0 ? round(($confirmedTickets / $totalTickets) * 100) : 0;

        return view('organizer.events', compact(
            'recentEvents', 'totalEvents', 'upcomingEvents', 
            'totalReservations', 'totalRevenue', 'fillRate'
        ));
    }

    /**
     * Afficher le formulaire de création d'événement
     */
    public function create()
    {
        $categories = Category::all();
        return view('organizer.create', compact('categories'));
    }

    /**
     * Enregistrer un nouvel événement
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after:now',
            'city' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'available_tickets' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('events', 'public');
            }

            Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'city' => $request->city,
                'region' => $request->region,
                'price' => $request->price,
                'available_tickets' => $request->available_tickets,
                'category_id' => $request->category_id,
                'organizer_id' => Auth::id(),
                'image' => $imagePath,
                'is_validated' => false,
                'status' => 'published',
            ]);

             return redirect()->route('organizer.dashboard')
                 ->with('success', 'Événement créé !');
                 

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Afficher le formulaire d'édition d'événement
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);

        if ($event->organizer_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez pas modifier cet événement.');
        }

        $categories = Category::all();
        return view('organizer.events.edit', compact('event', 'categories'));
    }

    /**
     * Mettre à jour un événement
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        if ($event->organizer_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez pas modifier cet événement.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'city' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'available_tickets' => 'required|integer|min:1',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $data = $request->except('image');

            if ($request->hasFile('image')) {
                if ($event->image && Storage::disk('public')->exists($event->image)) {
                    Storage::disk('public')->delete($event->image);
                }
                
                $imagePath = $request->file('image')->store('events', 'public');
                $data['image'] = $imagePath;
            }

            $event->update($data);

            return redirect()->route('organizer.events.index')
                ->with('success', 'Événement mis à jour avec succès !');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    /**
     * Supprimer un événement
     */
    public function destroy($id)
    {
        try {
            $event = Event::findOrFail($id);

            if ($event->organizer_id !== Auth::id()) {
                abort(403, 'Vous ne pouvez pas supprimer cet événement.');
            }

            $confirmedReservations = $event->reservations()
                ->where('status', 'confirmed')
                ->count();

            if ($confirmedReservations > 0) {
                return redirect()->back()
                    ->with('error', 'Impossible de supprimer cet événement car il y a ' . $confirmedReservations . ' réservation(s) confirmée(s).');
            }

            if ($event->image && Storage::disk('public')->exists($event->image)) {
                Storage::disk('public')->delete($event->image);
            }

            $event->delete();

            return redirect()->route('organizer.events.index')
                ->with('success', 'Événement supprimé avec succès !');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    /**
     * Afficher les réservations de l'organisateur
     */
    public function reservations()
    {
        $reservations = Reservation::with(['event', 'user'])
            ->whereHas('event', function($query) {
                $query->where('organizer_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('organizer.reservations.index', compact('reservations'));
    }

    /**
     * Valider une réservation
     */
    public function confirmReservation($id)
    {
        try {
            $reservation = Reservation::with('event')->findOrFail($id);

            if ($reservation->event->organizer_id !== Auth::id()) {
                abort(403, 'Vous ne pouvez pas valider cette réservation.');
            }

            DB::beginTransaction();

            $reservation->update([
                'status' => 'confirmed',
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Réservation validée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la validation : ' . $e->getMessage());
        }
    }

    /**
     * Annuler une réservation
     */
    public function cancelReservation($id)
    {
        try {
            $reservation = Reservation::with('event')->findOrFail($id);

            if ($reservation->event->organizer_id !== Auth::id()) {
                abort(403, 'Vous ne pouvez pas annuler cette réservation.');
            }

            DB::beginTransaction();

            $reservation->update([
                'status' => 'cancelled',
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Réservation annulée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de l\'annulation : ' . $e->getMessage());
        }
    }
}