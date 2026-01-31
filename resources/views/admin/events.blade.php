@extends('layouts.app')

@section('title', 'Gestion des événements')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900">📋 Gestion des événements</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn-secondary">← Retour</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-6">{{ session('success') }}</div>
    @endif

    <!-- Filtres -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <form method="GET" class="flex gap-4">
            <select name="status" class="form-input flex-1" onchange="this.form.submit()">
                <option value="">Tous les statuts</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approuvé</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejeté</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulé</option>
            </select>
        </form>
    </div>

    <!-- Table des événements -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Organisateur</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr>
                        <td>{{ $event->id }}</td>
                        <td>
                            <div class="font-semibold">{{ $event->title }}</div>
                            <div class="text-sm text-gray-500">{{ $event->type }} - {{ $event->city }}</div>
                        </td>
                        <td>{{ $event->user->name ?? $event->organizer->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge badge-{{ $event->status }}">{{ ucfirst($event->status) }}</span>
                        </td>
                        <td>
                            <div class="flex gap-2">
                                <a href="{{ route('events.show', $event->id) }}" class="text-blue-600 hover:text-blue-800" title="Voir">👁️</a>
                                
                                @if($event->status == 'pending')
                                    <form action="{{ route('admin.events.approve', $event) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-800" title="Approuver">✅</button>
                                    </form>
                                    
                                    <form action="{{ route('admin.events.reject', $event) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Rejeter">❌</button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('admin.events.delete', $event) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet événement ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Supprimer">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-8">Aucun événement</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $events->links() }}
    </div>
</div>
@endsection
