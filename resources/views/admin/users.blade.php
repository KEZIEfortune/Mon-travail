@extends('layouts.app')

@section('title', 'Gestion des membres')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900">👥 Gestion des membres</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn-secondary">← Retour</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-6">{{ session('success') }}</div>
    @endif

    <!-- Formulaire création membre -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <h2 class="text-2xl font-bold mb-4">➕ Créer un nouveau membre</h2>
        
        <form action="{{ route('admin.members.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Nom</label>
                    <input type="text" name="name" class="form-input" required>
                </div>
                
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" required>
                </div>
                
                <div>
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-input" required>
                </div>
                
                <div>
                    <label class="form-label">Rôle</label>
                    <select name="role" class="form-input" required>
                        <option value="member">Membre</option>
                        <option value="organizer">Organisateur</option>
                    </select>
                </div>
            </div>
            
            <button type="submit" class="btn-primary mt-4">Créer le compte</button>
        </form>
    </div>

    <!-- Liste des membres -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th>Inscrit le</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge badge-approved">{{ ucfirst($user->role) }}</span></td>
                        <td>
                            @if($user->is_active)
                                <span class="text-green-600">✅ Actif</span>
                            @else
                                <span class="text-red-600">❌ Inactif</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <form action="{{ route('admin.members.update', $user) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="text-blue-600 hover:text-blue-800">
                                    {{ $user->is_active ? '🔒 Désactiver' : '🔓 Activer' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-8">Aucun membre</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection
