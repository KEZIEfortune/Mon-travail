<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Auth;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        // Vérifier que l'utilisateur est connecté
        if (Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour réserver');
        }

        // Vérifier que l'utilisateur est un membre
        if (Auth::user()->role === 'Member'()) {
            return redirect()->back()->with('error', 'Seuls les membres peuvent faire des réservations');
        }

        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'number_of_tickets' => 'required|integer|min:1|max:10',
        ]);

        $events = Event::findOrFail($validated['event_id']);

        // Vérifier la disponibilité
        if ($events->available_tickets && $events->available_tickets < $validated['number_of_tickets']) {
            return redirect()->back()->with('error', 'Pas assez de places disponibles');
        }

        // Calculer le prix total
        $total_price = $event->price * $validated['number_of_tickets'];

        // Créer la réservation
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'event_id' => $validated['event_id'],
            'number_of_tickets' => $validated['number_of_tickets'],
            'total_price' => $total_price,
            'status' => 'pending',
            'payment_status' => $event->price > 0 ? 'pending' : 'paid',
        ]);

        // Mettre à jour les places disponibles
        if ($events->available_tickets) {
            $events->decrement('available_tickets', $validated['number_of_tickets']);
        }

        // Si gratuit, confirmer automatiquement
        if ($events->price == 0) {
            $reservation->update(['status' => 'confirmed']);
            return redirect()->route('member.reservations')->with('success', 'Réservation confirmée avec succès !');
        }

        // Sinon rediriger vers paiement
        return redirect()->route('member.reservations')->with('success', 'Réservation créée ! Veuillez procéder au paiement.');
    }

    public function destroy(Reservation $reservation)
    {
        // Vérifier que c'est bien l'utilisateur propriétaire
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Non autorisé');
        }

        // Vérifier que la réservation peut être annulée
        if ($reservation->status === 'cancelled') {
            return redirect()->back()->with('error', 'Cette réservation est déjà annulée');
        }

        // Rembourser les places
        if ($reservation->events->available_tickets !== null) {
            $reservation->events->increment('available_tickets', $reservation->number_of_tickets);
        }

        // Annuler la réservation
        $reservation->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Réservation annulée avec succès');
    }
}

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class Reservation extends Controller
{
    public function processPayment(Request $request)
    {
        // 1. Récupérer l'événement
        $events = Event::findOrFail($request->event_id);
        $user = Auth::user();

        // 2. (Optionnel) Sauvegarder la réservation en base de données comme "En attente"
        // Reservation::create([...]);

        // 3. Préparer le lien PayPal
        // Ceci est un lien standard PayPal "Payer maintenant". 
        // Remplace 'ton-email-paypal@business.com' par ton vrai email PayPal Business.
        $paypalUrl = "https://www.paypal.com/cgi-bin/webscr";
        $params = [
            'cmd' => '_xclick',
            'business' => 'ton-email-paypal@gmail.com', // <--- METS TON EMAIL PAYPAL ICI
            'item_name' => 'Réservation : ' . $events->title,
            'amount' => $events->price,
            'currency_code' => 'EUR',
            'return' => route('dashboard'), // Où revenir après paiement
            'cancel_return' => route('dashboard'),
        ];

        // Construire l'URL de redirection
        $redirectUrl = $paypalUrl . '?' . http_build_query($params);

        // 4. Rediriger l'utilisateur vers PayPal
        return redirect()->away($redirectUrl);
    }
}