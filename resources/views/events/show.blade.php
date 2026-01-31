@extends('layouts.app')

@section('title', $event->title)

@section('content')
    <div style="background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <a href="{{ route('home') }}" style="color: #667eea; text-decoration: none; margin-bottom: 1rem; display: inline-block;">
            ← Retour aux événements
        </a>
        
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.5rem 1rem; border-radius: 8px; display: inline-block; margin-bottom: 1rem;">
            {{ $events->type }}
        </div>
        
        <h1 style="color: #333; margin-bottom: 1.5rem;">{{ $event->title }}</h1>
        
        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem;">
            <p style="margin-bottom: 1rem;"><strong>📍 Lieu:</strong> {{ $event->location }}, {{ $event->city }} ({{ $event->region }})</p>
            <p style="margin-bottom: 1rem;"><strong>📅 Début:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y à H:i') }}</p>
            @if($events->end_date)
                <p style="margin-bottom: 1rem;"><strong>🏁 Fin:</strong> {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y à H:i') }}</p>
            @endif
            <p style="margin-bottom: 1rem;"><strong>🎭 Catégorie:</strong> {{ $event->category->name }}</p>
            <p style="margin-bottom: 1rem;">
                @if($events->price > 0)
                    <strong>💰 Prix:</strong> {{ $events->price }} DH
                @else
                    <strong>💰 Entrée gratuite</strong>
                @endif
            </p>
            <p><strong>👥 Organisateur:</strong> {{ $events->organizer->name }}</p>
        </div>
        
        <h3 style="color: #333; margin-bottom: 1rem;">Description</h3>
        <p style="color: #666; line-height: 1.8; text-align: justify;">{{ $events->description }}</p>
    </div>
@endsection