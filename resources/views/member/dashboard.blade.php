{{-- On appelle le layout principal pour avoir le menu et le design global --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-[#0f0f0e]">
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <h2 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">
            Événements à la une
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Ta boucle corrigée --}}
            @forelse($events as $event)
                <div class="bg-white dark:bg-[#161615] overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-[#3E3E3A] p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $event->title }}</h3> 
                        <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">{{ $event->description }}</p>
                        
                        <div class="text-sm text-gray-500 mb-6 space-y-1">
                            <p>📍 {{ $event->location }}</p>
                            <p>📅 {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} • {{ $event->time }}</p>
                            <p>💰 Prix : <span class="font-bold text-green-600">{{ $event->price == 0 ? 'GRATUIT' : $event->price . ' €' }}</span></p>
                        </div>
                    </div>

                    <button onclick="openModal('{{ $event->id }}', '{{ addslashes($event->title) }}', '{{ $event->price }}')" 
                       class="w-full py-3 bg-gradient-to-r from-purple-600 to-pink-500 text-white font-bold rounded-lg hover:opacity-90 transition shadow-md mt-4">
                        S'inscrire à l'événement
                    </button>
                </div>
            @empty
                {{-- Ce qui s'affiche si la base de données est vide --}}
                <div class="col-span-full text-center py-20 bg-white dark:bg-[#161615] rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-700">
                    <p class="text-gray-500 text-lg">Aucun événement disponible pour le moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Petite fonction de test pour vérifier que tes boutons fonctionnent --}}
<script>
function openModal(id, title, price) {
    alert("Réservation pour : " + title + "\nID : " + id);
}
</script>
@endsection