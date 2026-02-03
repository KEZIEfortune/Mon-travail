<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    /**
     * Dashboard pour le MEMBRE (Celle-ci contient toutes tes stats Eventus)
     */
    public function Dashboard()
    {
        $user = Auth::user();

        // Récupération des données pour ton design Eventus
        $allReservations = Reservation::where('user_id', $user->id)->get();

        return view('member.dashboard', [
            'totalReservations'  => $allReservations->count(),
            'activeReservations' => $allReservations->where('status', 'confirmed')->count(),
            'totalSpent'         => $allReservations->where('status', 'confirmed')->sum('total_price'),
            
            'recentReservations' => Reservation::where('user_id', $user->id)
                                    ->with('event')
                                    ->latest()
                                    ->take(5)
                                    ->get(),

            'upcomingEvents'     => Event::where('start_date', '>=', now())
                                    ->latest()
                                    ->take(6)
                                    ->get(),
        ]);
    }

    /**
     * Effectuer une réservation
     */
    public function reserve(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        $request->validate([
            'number_of_tickets' => 'required|integer|min:1|max:' . $event->available_tickets,
        ], [
            'number_of_tickets.max' => 'Désolé, il ne reste que ' . $event->available_tickets . ' places.',
        ]);

        $exists = Reservation::where('user_id', Auth::id())
            ->where('event_id', $eventId)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($exists) {
            return back()->with('error', 'Vous avez déjà une réservation active pour cet événement.');
        }

        try {
            DB::beginTransaction();

            Reservation::create([
                'user_id'           => Auth::id(),
                'event_id'          => $event->id,
                'number_of_tickets' => $request->number_of_tickets,
                'total_price'       => $event->price * $request->number_of_tickets,
                'status'            => 'confirmed',
                'payment_status'    => 'paid',
                'payment_method'    => 'card',
                'reserved_at'       => now(),
            ]);

            $event->decrement('available_tickets', $request->number_of_tickets);

            DB::commit();
            return redirect()->route('member.dashboard')->with('success', 'Votre réservation a été confirmée !');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la réservation : ' . $e->getMessage());
        }
    }

    /**
     * Liste des réservations pour Admin / Organizer
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            $reservations = Reservation::with(['event', 'user'])->latest()->paginate(20);
        } elseif ($user->role === 'organizer') {
            $reservations = Reservation::whereHas('event', function($query) use ($user) {
                $query->where('user_id', $user->id); 
            })->with(['event', 'user'])->latest()->paginate(20);
        } else {
            // Sécurité : un membre ne doit jamais voir l'index global
            return redirect()->route('member.dashboard');
        }

        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Valider une réservation (Organizer)
     */
    public function validateReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        if ($reservation->event->user_id !== Auth::id()) { abort(403); }
        $reservation->update(['status' => 'confirmed']);
        return back()->with('success', 'Réservation validée avec succès.');
    }

    /**
     * Annuler une réservation (Organizer)
     */
    public function cancelByOrganizer($id)
    {
        $reservation = Reservation::findOrFail($id);
        if ($reservation->event->user_id !== Auth::id()) { abort(403); }

        DB::transaction(function () use ($reservation) {
            $reservation->event->increment('available_tickets', $reservation->number_of_tickets);
            $reservation->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => 'Annulée par l\'organisateur'
            ]);
        });

        return back()->with('success', 'La réservation a été annulée.');
    }
    
}