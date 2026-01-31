@extends('layouts.app')

@section('title', 'Réservations')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900">🎫 Réservations de mes événements</h1>
        <a href="{{ route('organizer.dashboard') }}" class="btn-secondary">← Retour</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-6">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="table">
            <thead>
                <tr>
                    <th>Événement</th>
                    <th>Client</th>
                    <th>Places</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->event->title }}</td>
                        <td>{{ $reservation->user->name }}</td>
                        <td>{{ $reservation->number_of_tickets }}</td>
                        <td>{{ $reservation->total_price }} DH</td>
                        <td><span class="badge badge-{{ $reservation->status }}">{{ ucfirst($reservation->status) }}</span></td>
                        <td>{{ $reservation->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if($reservation->status === 'pending')
                                <form action="{{ route('organizer.reservations.confirm', $reservation) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-green-600 hover:text-green-800 text-sm">✅ Confirmer</button>
                                </form>
                                
                                <form action="{{ route('organizer.reservations.cancel', $reservation) }}" method="POST" class="inline ml-2">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">❌ Annuler</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-8">Aucune réservation</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $reservations->links() }}
    </div>
</div>
@endsection