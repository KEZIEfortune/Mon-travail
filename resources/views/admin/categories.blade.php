@extends('layouts.app')

@section('title', 'Gestion des catégories')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900">🏷️ Gestion des catégories</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn-secondary">← Retour</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-6">{{ session('success') }}</div>
    @endif

    <!-- Formulaire ajout catégorie -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <h2 class="text-2xl font-bold mb-4">➕ Ajouter une catégorie</h2>
        
        <form action="{{ route('admin.categories.store') }}" method="POST" class="flex gap-4">
            @csrf
            <input type="text" name="name" placeholder="Nom de la catégorie" class="form-input flex-1" required>
            <button type="submit" class="btn-primary">Ajouter</button>
        </form>
    </div>

    <!-- Liste des catégories -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($categories as $category)
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold">{{ $category->name }}</h3>
                        <p class="text-gray-500 text-sm">{{ $category->events->count() }} événements</p>
                    </div>
                    
                    <form action="{{ route('admin.categories.delete', $category) }}" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">🗑️</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection