@extends('layouts.app')

@section('title', $event->title)

@section('content')
    <div style="background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 900px; margin: 2rem auto;">
        <a href="{{ route('home') }}" style="color: #667eea; text-decoration: none; margin-bottom: 1rem; display: inline-block; font-weight: bold;">
            ← Retour aux événements
        </a>
        
        {{-- Correction ici : $event au lieu de $events --}}
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.5rem 1rem; border-radius: 8px; display: inline-block; margin-bottom: 1rem;">
            {{ $event->type }}
        </div>
        
        <h1 style="color: #333; margin-bottom: 1.5rem;">{{ $event->title }}</h1>
        
        <div class="row">
            <div class="col-md-7">
                <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem;">
                    <p style="margin-bottom: 1rem;"><strong>📍 Lieu:</strong> {{ $event->location }}, {{ $event->city }} ({{ $event->region }})</p>
                    <p style="margin-bottom: 1rem;"><strong>📅 Début:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y à H:i') }}</p>
                    
                    @if($event->end_date)
                        <p style="margin-bottom: 1rem;"><strong>🏁 Fin:</strong> {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y à H:i') }}</p>
                    @endif
                    
                    <p style="margin-bottom: 1rem;"><strong>🎭 Catégorie:</strong> {{ $event->category->name }}</p>
                    <p style="margin-bottom: 1rem;">
                        @if($event->price > 0)
                            <strong>💰 Prix:</strong> <span style="color: #2dce89; font-size: 1.2rem; font-weight: bold;">{{ $event->price }} DH</span>
                        @else
                            <strong style="color: #2dce89;">💰 Entrée gratuite</strong>
                        @endif
                    </p>
                    <p><strong>👥 Organisateur:</strong> {{ $event->user->name ?? 'Non spécifié' }}</p>
                </div>
            </div>

            {{-- SECTION RÉSERVATION --}}
            <div class="col-md-5">
                <div style="border: 2px solid #667eea; padding: 1.5rem; border-radius: 10px; background: #fff;">
                    <h4 style="color: #333; margin-bottom: 1rem;">Réserver vos places</h4>
                    <p style="color: #666;">Places disponibles : <strong>{{ $event->available_tickets }}</strong></p>

                    @auth
                        @if(Auth::user()->role === 'member')
                            @if($event->available_tickets > 0)
                                <form action="{{ route('events.reserve', $event->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="number_of_tickets" style="display: block; margin-bottom: 0.5rem;">Nombre de tickets :</label>
                                        <input type="number" name="number_of_tickets" id="number_of_tickets" 
                                               class="form-control" value="1" min="1" max="{{ $event->available_tickets }}" 
                                               style="width: 100%; padding: 0.5rem; border-radius: 5px; border: 1px solid #ddd;">
                                    </div>
                                    <button type="submit" style="background: #667eea; color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 8px; width: 100%; cursor: pointer; font-weight: bold;">
                                        Confirmer la réservation
                                    </button>
                                </form>
                            @else
                                <div style="color: #f5365c; font-weight: bold; text-align: center; padding: 1rem;">
                                    🚫 Événement Complet
                                </div>
                            @endif
                        @else
                            <div style="background: #e9ecef; padding: 1rem; border-radius: 8px; font-size: 0.9rem; color: #495057;">
                                Seuls les membres peuvent effectuer des réservations.
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" style="display: block; text-align: center; background: #764ba2; color: white; padding: 0.8rem; border-radius: 8px; text-decoration: none; font-weight: bold;">
                            Connectez-vous pour réserver
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        
        <h3 style="color: #333; margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #f8f9fa; padding-bottom: 0.5rem;">Description</h3>
        <p style="color: #666; line-height: 1.8; text-align: justify;">{{ $event->description }}</p>
    </div>
@endsection