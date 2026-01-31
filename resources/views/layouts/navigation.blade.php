<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20"> <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="Eventus" class="h-12 w-auto transition-transform group-hover:scale-110">
                        <div class="hidden md:flex flex-col">
                            <span class="text-xl font-black text-slate-800 tracking-tighter leading-none">EVENTUS</span>
                            <span class="text-[9px] font-bold text-indigo-600 uppercase tracking-[0.2em]">Tanger Hub</span>
                        </div>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        🏠 Accueil
                    </x-nav-link>

                    @auth
                        @if(auth()->user()->isAdmin())
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                                🔧 Administration
                            </x-nav-link>
                       @elseif(auth()->user()->role === 'organizer' || auth()->user()->isOrganizer())
                            <x-nav-link :href="route('organizer.dashboard')" :active="request()->routeIs('organizer.*')">
                                   🎭 Organisateur
                            </x-nav-link>
                    
                       @elseif(auth()->user()->isMember())
                            <x-nav-link :href="route('member.dashboard')" :active="request()->routeIs('member.*')">
                                👤 Mon Espace
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            @auth
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-slate-200 text-sm leading-4 font-medium rounded-xl text-slate-600 bg-white hover:bg-slate-50 hover:text-indigo-600 focus:outline-none transition ease-in-out duration-150">
                            <div class="flex items-center">
                                <span class="w-2 h-2 rounded-full bg-green-400 mr-2"></span>
                                {{ Auth::user()->name }}
                            </div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            ⚙️ Paramètres
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    class="text-red-600"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                🚪 Déconnexion
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @else
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-600 font-semibold transition">
                    Connexion
                </a>
                <a href="{{ route('register') }}" class="bg-indigo-600 text-black px-6 py-2.5 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                    Inscription
                </a>
            </div>
            @endauth

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-indigo-600 hover:bg-slate-50 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-slate-50">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                Accueil
            </x-responsive-nav-link>
        </div>

        @auth
        <div class="pt-4 pb-1 border-t border-slate-100">
            <div class="px-4 py-2 bg-slate-50 mx-4 rounded-xl mb-4">
                <div class="font-bold text-base text-slate-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-xs text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Paramètres
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            class="text-red-500"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        Déconnexion
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @else
        <div class="pt-4 pb-4 border-t border-slate-100 px-4 space-y-2">
            <a href="{{ route('login') }}" class="block w-full text-center py-3 text-slate-600 font-bold border border-slate-200 rounded-xl">Connexion</a>
            <a href="{{ route('register') }}" class="block w-full text-center py-3 bg-indigo-600 text-black font-bold rounded-xl shadow-md">Inscription</a>
        </div>
        @endauth
    </div>
</nav>