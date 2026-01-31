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
        // Récupération des statistiques pour l'utilisateur connecté
        $stats = [
            'total_reservations' => Reservation::where('user_id', Auth::id())->count(),
            'confirmed_reservations' => Reservation::where('user_id', Auth::id())->where('status', 'confirmed')->count(),
            'pending_reservations' => Reservation::where('user_id', Auth::id())->where('status', 'pending')->count(),
            'total_spent' => Reservation::where('user_id', Auth::id())->where('payment_status', 'paid')->sum('total_price'),
        ];

        // Récupération de tous les événements pour la boucle
        $events = Event::latest()->get(); 
        
        // On envoie TOUT à la vue
        return view('member.dashboard', compact('stats', 'events'));
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