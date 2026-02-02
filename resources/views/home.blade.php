@extends('layouts.app')

@section('content')
<style>
    /* Section Hero avec l'image fond-fete.png */
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.65)), 
                    url("{{ asset('images/fond-fete.png') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 65vh;
        display: flex;
        align-items: center;
        margin-top: -24px; /* Ajuste si tu as un espace blanc sous la navbar */
        color: white;
    }

    /* Style de la barre de recherche */
    .search-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        border: none;
        padding: 25px;
    }

    .btn-search {
        background-color: #6366f1;
        border: none;
        font-weight: bold;
        color: white;
    }

    .btn-search:hover {
        background-color: #4f46e5;
        color: white;
    }

    /* Icônes et cartes de profil */
    .profile-card {
        transition: transform 0.3s ease;
        border-radius: 15px;
    }

    .profile-card:hover {
        transform: translateY(-10px);
    }
</style>

<div class="hero-section">
    <div class="container text-center">
        <img src="{{ asset('images/logo-eventus.png') }}" 
             alt="Logo Eventus" 
             style="max-height: 140px; width: auto; margin-bottom: 25px;"
             class="img-fluid">

        <h1 class="fw-bold display-4 mb-4">Événements à la une</h1>
        
        <div class="card search-card shadow-lg mx-auto" style="max-width: 950px;">
            <form action="{{ route('events.index') }}" method="GET" class="row g-2 align-items-center text-dark">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Nom de l'événement...">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">Catégorie</option>
                        </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="date" class="form-control">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-search w-100 py-2">
                        Rechercher
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container my-5 py-5">
    <h2 class="text-center mb-5 fw-bold">Créez votre compte et commencez à profiter</h2>
    <div class="row g-4">
        
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm p-4 text-center profile-card">
                <div class="mb-3 text-primary">
                    <i class="fas fa-user-circle fa-4x"></i>
                </div>
                <h3 class="fw-bold">Découvrez et réservez</h3>
                <ul class="list-unstyled text-start mx-auto mt-3" style="max-width: 280px;">
                    <li>✅ Réservez vos places facilement</li>
                    <li>✅ Recommandations personnalisées</li>
                    <li>✅ Partagez vos avis et expériences</li>
                </ul>
                <a href="{{ route('register', ['role' => 'Member']) }}" class="btn btn-outline-primary mt-4 px-4 py-2 fw-bold">
                    S'inscrire comme Membre
                </a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm p-4 text-center profile-card">
                <div class="mb-3 text-success">
                    <i class="fas fa-bullhorn fa-4x"></i>
                </div>
                <h3 class="fw-bold">Publiez et gérez</h3>
                <ul class="list-unstyled text-start mx-auto mt-3" style="max-width: 280px;">
                    <li>✅ Créez et publiez vos événements</li>
                    <li>✅ Gérez les réservations en temps réel</li>
                    <li>✅ Touchez une large audience</li>
                </ul>
                <a href="{{ route('register', ['role' => 'Organizer']) }}" class="btn btn-primary mt-4 px-4 py-2 fw-bold btn-search">
                    Devenir Organisateur
                </a>
            </div>
        </div>

    </div>
</div>
@endsection