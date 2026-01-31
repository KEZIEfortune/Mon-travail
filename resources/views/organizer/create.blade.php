@extends('layouts.app')

@section('title', 'Créer un événement')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900">➕ Créer un événement</h1>
        <a href="{{ route('organizer.events') }}" class="btn-secondary">← Retour</a>
    </div>

    <div class="bg-white rounded-xl shadow-md p-8">
        <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <!-- Titre -->
                <div>
                    <label class="form-label">Titre de l'événement *</label>
                    <input type="text" name="title" class="form-input" required value="{{ old('title') }}">
                    @error('title')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="form-label">Description *</label>
                    <textarea name="description" rows="5" class="form-input" required>{{ old('description') }}</textarea>
                    @error('description')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Type et Catégorie -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Type *</label>
                        <select name="type" class="form-input" required>
                            <option value="">Sélectionnez un type</option>
                            <option value="festival">Festival</option>
                            <option value="concert">Concert</option>
                            <option value="exposition">Exposition</option>
                            <option value="theatre">Théâtre</option>
                        </select>
                        @error('type')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">Catégorie *</label>
                        <select name="category_id" class="form-input" required>
                            <option value="">Sélectionnez une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Date de début *</label>
                        <input type="datetime-local" name="start_date" class="form-input" required value="{{ old('start_date') }}">
                        @error('start_date')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">Date de fin</label>
                        <input type="datetime-local" name="end_date" class="form-input" value="{{ old('end_date') }}">
                        @error('end_date')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Localisation -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="form-label">Lieu *</label>
                        <input type="text" name="location" class="form-input" required value="{{ old('location') }}">
                        @error('location')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">Ville *</label>
                        <input type="text" name="city" class="form-input" required value="{{ old('city') }}">
                        @error('city')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">Région *</label>
                        <input type="text" name="region" class="form-input" required value="{{ old('region') }}">
                        @error('region')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Prix et Places -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Prix (DH)</label>
                        <input type="number" name="price" class="form-input" min="0" step="0.01" value="{{ old('price', 0) }}">
                        <p class="text-sm text-gray-500 mt-1">Laissez 0 pour un événement gratuit</p>
                        @error('price')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">Places disponibles</label>
                        <input type="number" name="available_tickets" class="form-input" min="0" value="{{ old('available_tickets') }}">
                        @error('available_tickets')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Image -->
                <div>
                    <label class="form-label">Image de l'événement</label>
                    <input type="file" name="image" class="form-input" accept="image/*">
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (max 2MB)</p>
                    @error('image')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <!-- Boutons -->
                <div class="flex gap-4 pt-4">
                    <button type="submit" class="btn-primary flex-1">✅ Créer l'événement</button>
                    <a href="{{ route('organizer.events') }}" class="btn-secondary flex-1 text-center">❌ Annuler</a>
                </div>

                <p class="text-sm text-gray-500 text-center">
                    ℹ️ Votre événement sera soumis à validation avant publication
                </p>
            </div>
        </form>
    </div>
</div>
@endsection