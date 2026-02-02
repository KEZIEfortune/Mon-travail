@extends('layouts.app')

@section('styles')
<style>
    :root { --dark:#1a1a2e; --dark-mid:#16213e; --gold:#d4a017; --white:#ffffff; --text-dim:#6e7590; }
    body { background: var(--dark); color: var(--white); font-family: 'Jost', sans-serif; }
    .form-section { padding: 120px 40px; max-width: 900px; margin: 0 auto; }
    .form-card { background: var(--dark-mid); border: 1px solid rgba(212,160,23,0.2); padding: 40px; border-radius: 15px; }
    h1 { font-family: 'Cormorant Garamond', serif; color: var(--gold); margin-bottom: 30px; }
    .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-group { margin-bottom: 20px; }
    label { display: block; font-size: 12px; text-transform: uppercase; color: var(--gold); margin-bottom: 8px; }
    input, textarea, select { width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(212,160,23,0.1); padding: 12px; color: white; border-radius: 8px; }
    .btn-submit { background: linear-gradient(135deg, #8b5cf6, #a78bfa); color: white; border: none; padding: 15px 30px; border-radius: 8px; cursor: pointer; font-weight: 600; margin-top: 20px; width: 100%; }
</style>
@endsection

@section('content')
<section class="form-section">
    <div class="form-card">
        <h1>✨ Créer un Événement</h1>
        <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Titre de l'événement</label>
                <input type="text" name="title" required placeholder="Ex: Gala de Charité">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="4" required></textarea>
            </div>

            <div class="grid">
                <div class="form-group">
                    <label>Catégorie</label>
                    <select name="category_id">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Date de l'événement</label>
                    <input type="datetime-local" name="start_date" required>
                </div>
            </div>

            <div class="grid">
                <div class="form-group">
                    <label>Ville</label>
                    <input type="text" name="city" required placeholder="Ex: Casablanca">
                </div>
                <div class="form-group">
                    <label>Région</label>
                    <input type="text" name="region" required placeholder="Ex: Casablanca-Settat">
                </div>
            </div>

            <div class="grid">
                <div class="form-group">
                    <label>Nombre de places (Tickets)</label>
                    <input type="number" name="available_tickets" required min="1">
                </div>
                <div class="form-group">
                    <label>Prix (DH)</label>
                    <input type="number" name="price" required min="0">
                </div>
            </div>

            <div class="form-group">
                <label>Image de couverture</label>
                <input type="file" name="image" accept="image/*" required>
            </div>

            <button type="submit" class="btn-submit">Soumettre votre événement </button>
        </form>
    </div>
</section>
@endsection