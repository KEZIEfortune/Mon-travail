@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-900 font-poppins">Espace Organisateur</h1>
                <p class="text-slate-500 italic">Boostez vos événements à Tanger.</p>
            </div>
            
            <a href="#" class="btn-eventus flex items-center gap-2 px-8 py-4 shadow-xl hover:scale-105 transition transform">
                <span>➕</span>
                <span class="font-bold">PUBLIER UN ÉVÉNEMENT</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="event-card p-6 border-l-4 border-indigo-600">
                <h3 class="text-slate-400 text-xs font-bold uppercase">Réservations totales</h3>
                <p class="text-3xl font-black text-slate-900">412</p>
            </div>
            <div class="event-card p-6 border-l-4 border-pink-500">
                <h3 class="text-slate-400 text-xs font-bold uppercase">Vues ce mois</h3>
                <p class="text-3xl font-black text-slate-900">2,840</p>
            </div>
            <div class="event-card p-6 border-l-4 border-emerald-500">
                <h3 class="text-slate-400 text-xs font-bold uppercase">Note moyenne</h3>
                <p class="text-3xl font-black text-slate-900">4.8/5</p>
            </div>
        </div>

        <div class="event-card overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-white">
                <h2 class="font-bold text-slate-800">Mes Événements en ligne</h2>
            </div>
            <div class="p-6 bg-white">
                <p class="text-slate-400 italic text-sm">Vous n'avez pas encore d'événements validés.</p>
            </div>
        </div>
    </div>
</div>
@endsection