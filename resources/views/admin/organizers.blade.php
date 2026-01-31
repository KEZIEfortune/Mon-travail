@extends('layouts.app')

@section('title', 'Gestion des organisateurs')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900">🎭 Gestion des organisateurs</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn-secondary">← Retour</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-6">{{ session('success') }}</div>
    @endif

    <!-- Liste des organisateurs -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Événements</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($organizers as $organizer)
                    <tr>
                        <td>{{ $organizer->id }}</td>
                        <td>{{ $organizer->name }}</td>
                        <td>{{ $organizer->email }}</td>
                        <td>{{ $organizer->phone ?? 'N/A' }}</td>
                        <td>{{ $organizer->events->count() }}</td>
                        <td>
                            @if($organizer->is_active)
                                <span class="text-green-600">✅ Actif</span>
                            @else
                                <span class="text-red-600">❌ Inactif</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.users.toggle', $organizer) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="text-blue-600 hover:text-blue-800">
                                    {{ $organizer->is_active ? '🔒 Désactiver' : '🔓 Activer' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-8">Aucun organisateur</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $organizers->links() }}
    </div>
</div>
@endsection