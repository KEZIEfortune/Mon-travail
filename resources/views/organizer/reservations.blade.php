@extends('layouts.app')

@section('styles')
<style>
/* Réutilisation de la charte graphique EVENTUS */
:root {
    --dark:#1a1a2e; --dark-mid:#16213e; --dark-card:#1e2a4a;
    --gold:#d4a017; --white:#ffffff; --text-dim:#6e7590; --radius:14px;
}
body { background: var(--dark); color: var(--white); font-family: 'Jost', sans-serif; }

.res-section { padding: 110px 40px 60px; }
.header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
.header-flex h1 { font-family: 'Cormorant Garamond', serif; font-size: 34px; letter-spacing: 2px; }

.table-card { background: var(--dark-card); border: 1px solid rgba(212,160,23,0.15); border-radius: var(--radius); padding: 24px; }
table { width: 100%; border-collapse: collapse; }
thead th { text-align: left; padding: 15px; font-size: 11px; color: var(--gold); text-transform: uppercase; letter-spacing: 1.5px; border-bottom: 1px solid rgba(212,160,23,0.1); }
tbody td { padding: 18px 15px; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.03); }

/* Status Badges */
.badge { padding: 5px 12px; border-radius: 50px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
.badge-pending { background: rgba(255, 193, 7, 0.15); color: #ffc107; }
.badge-confirmed { background: rgba(94, 205, 130, 0.15); color: #5ecd82; }
.badge-cancelled { background: rgba(220, 53, 69, 0.15); color: #dc3545; }

/* Action Buttons */
.btn-action { padding: 7px 14px; border-radius: 6px; font-size: 11px; font-weight: 600; text-decoration: none; transition: 0.3s; cursor: pointer; border: none; }
.btn-confirm { background: #5ecd82; color: #1a1a2e; }
.btn-confirm:hover { background: #4bb56e; transform: translateY(-2px); }
.btn-cancel { background: transparent; border: 1px solid #dc3545; color: #dc3545; }
.btn-cancel:hover { background: #dc3545; color: #white; }
</style>
@endsection

@section('content')
<div class="res-section">
    <div class="header-flex">
        <h1>🎫 Réservations de mes événements</h1>
        <a href="{{ route('organizer.dashboard') }}" class="btn-action" style="border: 1px solid var(--gold); color: var(--gold);">← Dashboard</a>
    </div>

    @if(session('success'))
        <div style="background: rgba(94, 205, 130, 0.2); color: #5ecd82; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-card">
        <div style="overflow-x: auto;">
            <table>
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
                            <td><strong style="color: var(--white)">{{ $reservation->event->title }}</strong></td>
                            <td>{{ $reservation->user->name }}</td>
                            <td>{{ $reservation->number_of_tickets }}</td>
                            <td style="color: var(--gold)">{{ number_format($reservation->total_price, 0) }} DH</td>
                            <td>
                                <span class="badge badge-{{ $reservation->status }}">
                                    {{ $reservation->status == 'pending' ? 'En attente' : ($reservation->status == 'confirmed' ? 'Confirmé' : 'Annulé') }}
                                </span>
                            </td>
                            <td>{{ $reservation->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($reservation->status === 'pending')
                                    <div style="display: flex; gap: 10px;">
                                        <form action="{{ route('organizer.reservations.confirm', $reservation) }}" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit" class="btn-action btn-confirm">Valider</button>
                                        </form>
                                        
                                        <form action="{{ route('organizer.reservations.cancel', $reservation) }}" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit" class="btn-action btn-cancel">Refuser</button>
                                        </form>
                                    </div>
                                @else
                                    <span style="color: var(--text-dim); font-size: 11px;">Traitée</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: var(--text-dim); padding: 50px;">Aucune réservation reçue.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $reservations->links() }}
    </div>
</div>
@endsection