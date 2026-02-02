<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Event; // Import important
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
   public function dashboard()
{
    // 1. Statistiques précises
    $stats = [
        'total_reservations' => Reservation::where('user_id', Auth::id())->count(),
        'confirmed_reservations' => Reservation::where('user_id', Auth::id())->where('status', 'confirmed')->count(),
        'total_spent' => Reservation::where('user_id', Auth::id())->where('payment_status', 'paid')->sum('total_price'),
    ];

    // 2. Récupération des RÉSERVATIONS du membre (et non tous les events)
    // C'est ce qui va alimenter ta table @foreach($reservations as $res)
    $reservations = Reservation::where('user_id', Auth::id())
        ->with('event')
        ->latest()
        ->take(5) // On prend les 5 dernières pour le dashboard
        ->get();
    
    return view('member.dashboard', compact('stats', 'reservations'));
}
// --- CETTE MÉTHODE EST CELLE QUI MANQUAIT ---
    public function cancelReservation($id)
    {
        // On récupère la réservation uniquement si elle appartient à l'utilisateur connecté
        $reservation = Reservation::where('user_id', Auth::id())->findOrFail($id);

        if ($reservation->status !== 'cancelled') {
            // 1. Remettre les tickets en stock dans la table events
            $reservation->event->increment('available_tickets', $reservation->number_of_tickets);

            // 2. Mettre à jour la réservation (colonnes de ton image 3)
            $reservation->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => 'Annulé par l\'utilisateur'
            ]);

            return back()->with('success', 'Réservation annulée. Les places ont été libérées.');
        }
        return back()->with('error', 'Cette réservation est déjà annulée.');
        }
    public function reservations()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->with(['event'])
            ->latest()
            ->paginate(10);
        
        return view('member.reservations', compact('reservations'));
    }
}