@extends('layouts.app')
@section('styles')
<style>
    
    </style>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet"/>
@endSection
@section('title', 'Mes événements')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900">📋 Mes événements</h1>
        <div class="flex gap-4">
            <a href="{{ route('organizer.events.create') }}" class="btn-primary">➕ Créer un événement</a>
            <a href="{{ route('organizer.dashboard') }}" class="btn-secondary">← Retour</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-6">{{ session('success') }}</div>
    @endif

    <!-- Liste des événements -->
    <div class="space-y-4">
        @forelse($recentEvents as $event)
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $event->title }}</h3>
                            <span class="badge badge-{{ $event->type }}">{{ ucfirst($event->type) }}</span>
                            <span class="badge badge-{{ $event->status }}">{{ ucfirst($event->status) }}</span>
                        </div>
                        
                        <p class="text-gray-600 mb-4">{{ Str::limit($event->description, 150) }}</p>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">📅 Date:</span>
                                <div class="font-semibold">{{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }}</div>
                            </div>
                            <div>
                                <span class="text-gray-500">📍 Lieu:</span>
                                <div class="font-semibold">{{ $event->city }}</div>
                            </div>
                            <div>
                                <span class="text-gray-500">💰 Prix:</span>
                                <div class="font-semibold">{{ $event->price > 0 ? $event->price . ' DH' : 'Gratuit' }}</div>
                            </div>
                            <div>
                                <span class="text-gray-500">🎫 Réservations:</span>
                                <div class="font-semibold">{{ $event->reservations->count() }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col gap-2 ml-4">
                        <a href="{{ route('events.show', $event->id) }}" class="btn-secondary text-sm">👁️ Voir</a>
                        <a href="{{ route('organizer.events.edit', $event) }}" class="btn-primary text-sm">✏️ Modifier</a>
                        <form action="{{ route('organizer.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Supprimer cet événement ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger text-sm w-full">🗑️ Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-state-icon">🎪</div>
                <p class="empty-state-text">Vous n'avez pas encore créé d'événement</p>
                <a href="{{ route('organizer.events.create') }}" class="btn-primary mt-4">➕ Créer votre premier événement</a>
            </div>
        @endforelse
    </div>

</div>
@endsection