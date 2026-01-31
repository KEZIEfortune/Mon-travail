@extends('layouts.app')

@section('title', 'Eventus - Découvrez les événements culturels')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50">
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 opacity-90"></div>
        <div class="absolute inset-0" style="background-image: url('https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=1920'); background-size: cover; opacity: 0.2;"></div>
        
        <div class="relative z-10 container mx-auto px-4 py-20 text-center text-black">
            <h1 class="text-6xl md:text-7xl font-black mb-6 animate-fade-in drop-shadow-lg">
                🎉 Eventus
            </h1>
            <p class="text-2xl md:text-3xl mb-8 font-light">
                Découvrez les Événements Culturels près de chez vous
            </p>
            <p class="text-xl opacity-90 max-w-2xl mx-auto">
                Festivals, concerts, expositions, théâtre et bien plus encore !
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <div class="bg-white rounded-3xl shadow-2xl p-8 mb-12 border-t-4 border-purple-500">
            <h2 class="text-2xl font-bold text-black-800 mb-6 flex items-center">
                <span class="text-3xl mr-3">🔍</span> Rechercher un événement
            </h2>
            
            <form method="GET" action="{{ route('home') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <input type="text" name="search" placeholder="Nom de l'événement..." class="col-span-1 md:col-span-2 px-6 py-4 rounded-xl border-2 border-purple-200 focus:border-purple-500 transition outline-none" value="{{ request('search') }}">
                
                <select name="category" class="px-6 py-4 rounded-xl border-2 border-purple-200 focus:border-purple-500 transition outline-none">
                    <option value="">📂 Catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>

                <select name="type" class="px-6 py-4 rounded-xl border-2 border-purple-200 focus:border-purple-500 transition outline-none">
                    <option value="">🎭 Type</option>
                    <option value="festival" {{ request('type') == 'festival' ? 'selected' : '' }}>🎪 Festival</option>
                    <option value="concert" {{ request('type') == 'concert' ? 'selected' : '' }}>🎵 Concert</option>
                    <option value="exposition" {{ request('type') == 'exposition' ? 'selected' : '' }}>🎨 Exposition</option>
                </select>

                <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold py-4 px-8 rounded-xl hover:scale-105 transition shadow-lg">
                    Rechercher
                </button>
            </form>
        </div>

        <h2 class="text-4xl font-bold text-gray-800 mb-8 text-center">✨ Événements à la une</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
            @forelse($events as $events)
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 flex flex-col">
                    <div class="relative h-56">
                        <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=800' }}" class="w-full h-full object-cover">
                        <div class="absolute top-4 right-4 bg-white/90 px-3 py-1 rounded-full text-xs font-bold uppercase">{{ $event->type }}</div>
                        <div class="absolute bottom-4 left-4 bg-green-500 text-white px-4 py-1 rounded-full font-bold">
                            {{ $events->price > 0 ? $events->price . ' DH' : 'GRATUIT' }}
                        </div>
                    </div>
                    <div class="p-6 flex-grow">
                        <h3 class="text-xl font-bold mb-2">{{ $event->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $event->description }}</p>
                        <div class="text-sm text-gray-500 space-y-1 mb-6">
                            <p>📍 {{ $events->city }}, {{ $events->address }}</p>
                            <p>📅 {{ \Carbon\Carbon::parse($events->start_date)->format('d M Y • H:i') }}</p>
                        </div>
                        <button class="w-full py-3 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-bold hover:opacity-90 transition">
                            RÉSERVER MA PLACE
                        </button>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500">Aucun événement trouvé.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white py-20 border-t border-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-2">Créez votre compte et commencez à profiter</h2>
            <p class="text-center text-gray-600 mb-12">Choisissez le profil qui vous correspond le mieux</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-5xl mx-auto">
                <div class="flex flex-col items-center p-8 bg-gray-50 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="text-5xl mb-6">👤</div>
                    <h3 class="text-xl font-bold mb-4">Découvrez et réservez vos événements préférés</h3>
                    <ul class="space-y-3 mb-8 text-gray-700 w-full">
                        <li class="flex items-center">✅ <span class="ml-3">Réservez vos places facilement</span></li>
                        <li class="flex items-center">✅ <span class="ml-3">Recevez des recommandations personnalisées</span></li>
                        <li class="flex items-center">✅ <span class="ml-3">Partagez vos avis et expériences</span></li>
                    </ul>
                    <a href="{{ route('register', ['role' => 'member']) }}" class="w-full py-4 text-center bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg">
                        S'inscrire comme Membre
                    </a>
                </div>

                <div class="flex flex-col items-center p-8 bg-gray-50 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="text-5xl mb-6">🎭</div>
                    <h3 class="text-xl font-bold mb-4">Publiez et gérez vos événements culturels</h3>
                    <ul class="space-y-3 mb-8 text-gray-700 w-full">
                        <li class="flex items-center">✅ <span class="ml-3">Créez et publiez vos événements</span></li>
                        <li class="flex items-center">✅ <span class="ml-3">Gérez les réservations en temps réel</span></li>
                        <li class="flex items-center">✅ <span class="ml-3">Touchez une large audience</span></li>
                    </ul>
                    <a href="{{ route('register', ['role' => 'organizer']) }}" class="w-full py-4 text-center bg-blue-600  text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg">
                        S'inscrire comme Organisateur
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection