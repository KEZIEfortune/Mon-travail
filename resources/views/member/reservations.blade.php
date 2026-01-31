@extends('layouts.app')

@section('title', 'Mes réservations')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900">🎫 Mes réservations</h1>
        <a href="{{ route('member.dashboard') }}" class="btn-secondary">← Retour</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-6">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mb-6">{{ session('error') }}</div>
    @endif

    <!-- Liste des réservations -->
    <div class="space-y-4">
        @forelse($reservations as $reservation)
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $reservation->event->title }}</h3>
                            <span class="badge badge-{{ $reservation->status }}">{{ ucfirst($reservation->status) }}</span>
                            <span class="badge badge-{{ $reservation->payment_status }}">
                                {{ $reservation->payment_status === 'paid' ? '💳 Payé' : '⏳ Paiement en attente' }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-4">
                            <div>
                                <span class="text-gray-500">📅 Date événement:</span>
                                <div class="font-semibold">{{ \Carbon\Carbon::parse($reservation->event->start_date)->format('d/m/Y à H:i') }}</div>
                            </div>
                            <div>
                                <span class="text-gray-500">📍 Lieu:</span>
                                <div class="font-semibold">{{ $reservation->event->location }}, {{ $reservation->event->city }}</div>
                            </div>
                            <div>
                                <span class="text-gray-500">🎫 Billets:</span>
                                <div class="font-semibold">{{ $reservation->number_of_tickets }} place(s)</div>
                            </div>
                            <div>
                                <span class="text-gray-500">💰 Total:</span>
                                <div class="font-semibold text-indigo-600">{{ $reservation->total_price }} DH</div>
                            </div>
                        </div>

                        <div class="text-sm text-gray-600">
                            <span>📌 Réservé le {{ $reservation->created_at->format('d/m/Y à H:i') }}</span>
                        </div>

                        @if($reservation->cancelled_at)
                            <div class="mt-2 text-sm text-red-600">
                                ❌ Annulée le {{ $reservation->cancelled_at->format('d/m/Y à H:i') }}
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-col gap-2 ml-4">
                        <a href="{{ route('events.show', $reservation->event->id) }}" class="btn-secondary text-sm">
                            👁️ Voir l'événement
                        </a>

                        @if($reservation->status !== 'cancelled' && $reservation->event->start_date > now())
                            @if($reservation->payment_status === 'pending')
                                <button class="btn-primary text-sm" onclick="alert('Fonctionnalité de paiement à venir')">
                                    💳 Payer
                                </button>
                            @endif

                            <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger text-sm w-full">
                                    ❌ Annuler
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-state-icon">🎫</div>
                <p class="empty-state-text">Vous n'avez pas encore de réservation</p>
                <a href="{{ route('home') }}" class="btn-primary mt-4">🎪 Découvrir les événements</a>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $reservations->links() }}
    </div>
</div>
@endsection