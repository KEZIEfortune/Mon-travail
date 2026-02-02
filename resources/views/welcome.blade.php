@extends('layouts.app')

@section('styles')
<style>
/* ═══ EVENTUS — PAGE D'ACCUEIL ═══ */
:root {
    --dark:#1a1a2e; --dark-mid:#16213e; --dark-card:#1e2a4a;
    --gold:#d4a017; --gold-light:#f0d060; --gold-pale:#fff8dc;
    --text:#c8cdd8; --text-dim:#6e7590; --white:#ffffff; --radius:14px;
}
*{margin:0;padding:0;box-sizing:border-box;}
html{scroll-behavior:smooth;}
body{font-family:'Jost','Segoe UI',sans-serif;background:var(--dark);color:var(--text);min-height:100vh;line-height:1.6;}

/* ── NAVBAR ── */
.ev-nav{position:fixed;top:0;left:0;width:100%;z-index:100;display:flex;align-items:center;justify-content:space-between;padding:16px 40px;background:rgba(26,26,46,0.82);backdrop-filter:blur(18px);border-bottom:1px solid rgba(212,160,23,0.1);transition:padding .3s;}
.ev-nav.scrolled{padding:10px 40px;}
.ev-nav-logo{display:flex;align-items:center;gap:10px;text-decoration:none;}
.ev-nav-logo .logo-wrap{width:34px;height:34px;border-radius:50%;background:var(--dark-mid);border:1.5px solid rgba(212,160,23,0.4);display:flex;align-items:center;justify-content:center;}
.ev-nav-logo .logo-wrap span{font-family:'Cormorant Garamond',serif;font-size:18px;font-weight:600;background:linear-gradient(135deg,#b8860b,#f0d060,#fff8dc,#f0d060,#b8860b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.ev-nav-logo .logo-name{font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:600;letter-spacing:4px;color:var(--white);}
.ev-nav-links{display:flex;align-items:center;gap:28px;list-style:none;}
.ev-nav-links a{color:var(--text-dim);text-decoration:none;font-size:12px;font-weight:400;letter-spacing:1.8px;text-transform:uppercase;transition:color .3s;position:relative;}
.ev-nav-links a::after{content:'';position:absolute;bottom:-3px;left:0;width:0;height:1px;background:var(--gold);transition:width .3s;}
.ev-nav-links a:hover{color:var(--gold);}
.ev-nav-links a:hover::after{width:100%;}
.btn-propos{padding:8px 22px;border-radius:50px;border:1px solid rgba(212,160,23,0.3);color:var(--gold) !important;font-size:12px;letter-spacing:1.8px;text-transform:uppercase;text-decoration:none;transition:background .3s,box-shadow .3s;background:transparent;}
.btn-propos::after{display:none !important;}
.btn-propos:hover{background:rgba(212,160,23,0.08);box-shadow:0 0 20px rgba(212,160,23,0.12);}
.nav-auth{display:flex;gap:12px;align-items:center;}
.btn-login{color:var(--text-dim);font-size:12px;letter-spacing:1.5px;text-transform:uppercase;text-decoration:none;transition:color .3s;}
.btn-login:hover{color:var(--gold);}
.btn-register{padding:7px 20px;border-radius:50px;background:linear-gradient(135deg,#d4a017,#f0d060);color:var(--dark);font-size:11px;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;text-decoration:none;transition:transform .2s,box-shadow .3s;}
.btn-register:hover{transform:translateY(-1px);box-shadow:0 4px 18px rgba(212,160,23,0.3);}

/* ── HERO ── */
.hero{min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:140px 24px 80px;position:relative;overflow:hidden;}
.hero::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 65% 45% at 50% 42%,rgba(212,160,23,0.07) 0%,transparent 70%),radial-gradient(ellipse 35% 25% at 15% 75%,rgba(201,114,122,0.04) 0%,transparent 60%),radial-gradient(ellipse 35% 25% at 85% 70%,rgba(46,92,154,0.05) 0%,transparent 60%);pointer-events:none;}
.hero::after{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(212,160,23,0.025) 1px,transparent 1px),linear-gradient(90deg,rgba(212,160,23,0.025) 1px,transparent 1px);background-size:72px 72px;pointer-events:none;}
.hero-badge{position:relative;z-index:1;display:inline-block;padding:5px 18px;border-radius:50px;border:1px solid rgba(212,160,23,0.22);font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--gold);margin-bottom:28px;animation:fadeDown .7s ease both;}
.hero h1{position:relative;z-index:1;font-family:'Cormorant Garamond',serif;font-size:clamp(44px,7vw,82px);font-weight:300;color:var(--white);letter-spacing:5px;line-height:1.15;animation:fadeUp .8s .12s ease both;}
.hero h1 .gold-text{background:linear-gradient(135deg,#b8860b,#f0d060,#fff8dc,#f0d060,#b8860b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.hero-sub{position:relative;z-index:1;margin-top:22px;font-size:14px;color:var(--text-dim);letter-spacing:3px;font-style:italic;animation:fadeUp .8s .3s ease both;}
.hero-rule{position:relative;z-index:1;width:100px;height:1px;background:linear-gradient(90deg,transparent,var(--gold),transparent);margin:30px auto;animation:fadeUp .8s .42s ease both;}

/* Section Inscription */
.inscription-section{position:relative;z-index:1;padding:40px 24px;animation:fadeUp .8s .55s ease both;}
.inscription-cta-title{font-family:'Cormorant Garamond',serif;font-size:28px;color:var(--white);text-align:center;margin-bottom:12px;}
.inscription-cta-sub{text-align:center;color:var(--text-dim);font-size:13px;letter-spacing:1.2px;margin-bottom:32px;}
.inscription-cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:24px;max-width:900px;margin:0 auto;}
.inscription-card{background:var(--dark-card);border:1px solid rgba(212,160,23,0.15);border-radius:var(--radius);padding:32px;text-align:center;transition:transform .3s,border-color .3s,box-shadow .3s;}
.inscription-card:hover{transform:translateY(-5px);border-color:rgba(212,160,23,0.35);box-shadow:0 16px 40px rgba(0,0,0,0.3);}
.inscription-card .card-icon{font-size:48px;margin-bottom:16px;}
.inscription-card h3{font-family:'Cormorant Garamond',serif;font-size:24px;color:var(--white);margin-bottom:12px;}
.inscription-card p{color:var(--text-dim);font-size:13px;line-height:1.6;margin-bottom:20px;}
.inscription-card ul{list-style:none;text-align:left;margin-bottom:24px;}
.inscription-card ul li{padding:8px 0;padding-left:24px;position:relative;font-size:13px;color:var(--text);}
.inscription-card ul li:before{content:"✓";position:absolute;left:0;color:var(--gold);font-weight:bold;}
.btn-inscription-card{display:inline-block;padding:10px 28px;border-radius:50px;background:linear-gradient(135deg,#d4a017,#e8c840);color:var(--dark);font-size:12px;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;text-decoration:none;transition:transform .2s,box-shadow .3s;}
.btn-inscription-card:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(212,160,23,0.4);}

/* ── SEARCH ── */
.search-section{position:relative;z-index:2;background:var(--dark-mid);padding:36px 24px;border-top:1px solid rgba(212,160,23,0.08);border-bottom:1px solid rgba(212,160,23,0.08);}
.search-inner{max-width:1100px;margin:0 auto;}
.search-bar{display:flex;gap:12px;flex-wrap:wrap;background:var(--dark-card);border:1px solid rgba(212,160,23,0.15);border-radius:var(--radius);padding:14px 18px;}
.search-bar input,.search-bar select{flex:1;min-width:150px;background:transparent;border:none;outline:none;color:var(--white);font-family:inherit;font-size:14px;padding:10px 0;}
.search-bar input::placeholder{color:var(--text-dim);}
.search-bar select{color:var(--text-dim);cursor:pointer;}
.search-bar select option{background:var(--dark-card);color:var(--white);}
.search-bar .sep{width:1px;background:rgba(212,160,23,0.12);align-self:stretch;margin:4px 0;}
.btn-search{padding:10px 28px;border-radius:10px;background:linear-gradient(135deg,#d4a017,#e8c840);border:none;color:var(--dark);font-family:inherit;font-size:13px;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;cursor:pointer;transition:transform .2s,box-shadow .3s;white-space:nowrap;}
.btn-search:hover{transform:translateY(-1px);box-shadow:0 4px 16px rgba(212,160,23,0.3);}
.filter-pills{display:flex;gap:8px;flex-wrap:wrap;margin-top:18px;}
.pill{padding:6px 16px;border-radius:50px;border:1px solid rgba(212,160,23,0.18);background:transparent;color:var(--text-dim);font-size:12px;letter-spacing:0.8px;cursor:pointer;transition:all .25s;font-family:inherit;}
.pill:hover,.pill.active{border-color:var(--gold);background:rgba(212,160,23,0.08);color:var(--gold);}

/* ── EVENTS GRID ── */
.events-section{padding:60px 24px 100px;}
.events-inner{max-width:1200px;margin:0 auto;}
.events-header{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:36px;flex-wrap:wrap;gap:12px;}
.events-header h2{font-family:'Cormorant Garamond',serif;font-size:32px;font-weight:300;color:var(--white);letter-spacing:2px;}
.events-header .count{font-size:12px;color:var(--text-dim);letter-spacing:1px;}
.sort-select{background:var(--dark-card);border:1px solid rgba(212,160,23,0.15);border-radius:8px;padding:8px 14px;color:var(--text-dim);font-size:12px;font-family:inherit;cursor:pointer;outline:none;}
.sort-select option{background:var(--dark-card);color:var(--white);}
.events-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:24px;}

/* ── EVENT CARD ── */
.event-card{background:var(--dark-card);border:1px solid rgba(212,160,23,0.1);border-radius:var(--radius);overflow:hidden;transition:transform .3s,border-color .3s,box-shadow .3s;display:flex;flex-direction:column;}
.event-card:hover{transform:translateY(-5px);border-color:rgba(212,160,23,0.28);box-shadow:0 16px 48px rgba(0,0,0,0.25);}
.event-card-img{width:100%;height:190px;position:relative;overflow:hidden;}
.event-card-img .img-bg{width:100%;height:100%;transition:transform .4s;}
.event-card:hover .img-bg{transform:scale(1.06);}
.img-concert{background:linear-gradient(135deg,#1a1035 0%,#2d1b5e 60%,#1a1035 100%);}
.img-festival{background:linear-gradient(135deg,#0d2b1e 0%,#1a4d35 60%,#0d2b1e 100%);}
.img-theatre{background:linear-gradient(135deg,#2a1520 0%,#4d2235 60%,#2a1520 100%);}
.img-expo{background:linear-gradient(135deg,#1a2535 0%,#2d4a6e 60%,#1a2535 100%);}
.img-gastro{background:linear-gradient(135deg,#2a1d0d 0%,#4d3520 60%,#2a1d0d 100%);}
.event-card-img .cat-icon{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-size:52px;opacity:0.18;}
.event-card-img .card-badge{position:absolute;top:14px;left:14px;padding:4px 12px;border-radius:50px;background:rgba(26,26,46,0.72);backdrop-filter:blur(6px);font-size:11px;letter-spacing:1.2px;text-transform:uppercase;color:var(--gold);border:1px solid rgba(212,160,23,0.2);}
.event-card-img .card-price{position:absolute;top:14px;right:14px;padding:4px 12px;border-radius:50px;background:rgba(26,26,46,0.72);backdrop-filter:blur(6px);font-size:13px;font-weight:600;color:var(--white);border:1px solid rgba(255,255,255,0.1);}
.card-price.free{color:#5ecd82;}
.event-card-body{padding:22px;flex:1;display:flex;flex-direction:column;}
.event-card-body h3{font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:600;color:var(--white);margin-bottom:10px;line-height:1.3;}
.event-card-meta{display:flex;flex-direction:column;gap:6px;margin-bottom:16px;}
.meta-item{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--text-dim);}
.mi-icon{font-size:14px;opacity:.7;}
.event-card-footer{margin-top:auto;display:flex;align-items:center;justify-content:space-between;padding-top:16px;border-top:1px solid rgba(255,255,255,0.05);}
.rating{display:flex;align-items:center;gap:5px;font-size:13px;color:var(--text-dim);}
.stars{color:var(--gold);font-size:12px;}
.btn-voir{padding:7px 18px;border-radius:8px;border:1px solid rgba(212,160,23,0.3);background:transparent;color:var(--gold);font-size:12px;font-weight:500;letter-spacing:1px;text-transform:uppercase;text-decoration:none;font-family:inherit;cursor:pointer;transition:background .25s,box-shadow .25s;}
.btn-voir:hover{background:rgba(212,160,23,0.08);box-shadow:0 2px 12px rgba(212,160,23,0.15);}

/* ── FOOTER ── */
.ev-footer{background:var(--dark-mid);border-top:1px solid rgba(212,160,23,0.08);padding:50px 24px 28px;text-align:center;}
.ev-footer .footer-logo{font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:300;letter-spacing:6px;color:var(--white);margin-bottom:10px;}
.ev-footer .footer-rule{width:50px;height:1px;background:linear-gradient(90deg,transparent,var(--gold),transparent);margin:0 auto 12px;}
.ev-footer p{font-size:11px;color:var(--text-dim);letter-spacing:1px;}

@keyframes fadeUp{from{opacity:0;transform:translateY(22px);}to{opacity:1;transform:translateY(0);}}
@keyframes fadeDown{from{opacity:0;transform:translateY(-14px);}to{opacity:1;transform:translateY(0);}}

@media(max-width:768px){
    .ev-nav{padding:12px 18px;}
    .ev-nav-links li:not(:last-child){display:none;}
    .search-bar{flex-direction:column;}
    .search-bar .sep{width:100%;height:1px;margin:0;}
    .events-grid{grid-template-columns:1fr;}
    .inscription-cards{grid-template-columns:1fr;}
}
</style>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet"/>
@endSection

@section('content')
@auth
    {{-- Si l'utilisateur est connecté --}}
    @if(Auth::user()->role === 'member')
        <a href="{{ route('member.dashboard') }}" class="btn-inscription">
            ACCÉDER À MON ESPACE
        </a>
    @elseif(Auth::user()->role === 'organizer')
        <a href="{{ route('organizer.dashboard') }}" class="btn-inscription">
            ACCÉDER À MON ESPACE ORGANISATEUR
        </a>
    @elseif(Auth::user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="btn-inscription">
            ACCÉDER À L'ADMINISTRATION
        </a>
    @endif
@else
    {{-- Si l'utilisateur n'est PAS connecté --}}
    <a href="{{ route('register') }}?role=member" class="btn-inscription">
        S'INSCRIRE MEMBRE
    </a>
@endauth
<!-- NAVBAR -->
<nav class="ev-nav" id="evNav">
    <a href="{{ route('home') }}" class="ev-nav-logo">
        <div class="logo-wrap"><span>E</span></div>
        <span class="logo-name">EVENTUS</span>
    </a>
    <ul class="ev-nav-links">
        <li><a href="#accueil">Accueil</a></li>
        <li><a href="#events">Événements</a></li>
        <li><a href="#inscription">Inscription</a></li>
    </ul>
    <div class="nav-auth">
        <a href="{{ route('login') }}" class="btn-login">Connexion</a>
        <a href="{{ route('register') }}" class="btn-register">incription</a>
    </div>
</nav>

<!-- HERO -->
<section class="hero" id="accueil">
    <div class="hero-badge">Plateforme culturelle — Tanger</div>
    <h1>Découvrez les<br/><span class="gold-text">Événements</span></h1>
    <p class="hero-sub">Festivals · Concerts · Théâtre · Expositions</p>
    <div class="hero-rule"></div>
    
    <!-- Section Inscription -->
    <div class="inscription-section" id="inscription">
        <h2 class="inscription-cta-title">Rejoignez EVENTUS</h2>
        <p class="inscription-cta-sub">Choisissez le profil qui vous correspond</p>
        
        <div class="inscription-cards">
            <!-- Carte Membre -->
            <div class="inscription-card">
                <div class="card-icon">👥</div>
                <h3>Je veux étre Membre</h3>
                <p>Découvrez et réservez les meilleurs événements</p>
                <ul>
                    <li>Rechercher des événements</li>
                    <li>Réserver en ligne</li>
                    <li>Gérer vos réservations</li>
                    <li>Laisser des avis</li>
                </ul>
                <a href="{{ route('register') }}" class="btn-inscription-card">S'inscrire Membre</a>
            </div>

            <!-- Carte Organisateur -->
            <div class="inscription-card">
                <div class="card-icon">🎪</div>
                <h3>Je suis Organisateur</h3>
                <p>Créez et gérez vos événements facilement</p>
                <ul>
                    <li>Créer vos événements</li>
                    <li>Gérer les réservations</li>
                    <li>Suivre vos statistiques</li>
                    <li>Modifier vos événements</li>
                </ul>
                <a href="{{ route('register') }}" class="btn-inscription-card">S'inscrire Organisateur</a>
            </div>
        </div>
    </div>
</section>

<!-- SEARCH & FILTERS -->
<section class="search-section" id="events">
    <div class="search-inner">
        <form method="GET" action="{{ route('events.index') }}">
            <div class="search-bar">
                <input type="text" name="search" placeholder="🔍  Rechercher un événement..." value="{{ request('search') }}"/>
                <div class="sep"></div>
                <select name="type">
                    <option value="">📂  Type</option>
                    <option value="Concert">🎵  Concert</option>
                    <option value="Festival">🎪  Festival</option>
                    <option value="Théâtre">🎭  Théâtre</option>
                    <option value="Exposition">🖼️  Exposition</option>
                    <option value="Gastronomie">🍽️  Gastronomie</option>
                </select>
                <div class="sep"></div>
                <select name="date_filter">
                    <option value="">📅  Date</option>
                    <option value="today">Aujourd'hui</option>
                    <option value="week">Cette semaine</option>
                    <option value="month">Ce mois</option>
                </select>
                <div class="sep"></div>
                <select name="prix_filter">
                    <option value="">💰  Prix</option>
                    <option value="free">Gratuit</option>
                    <option value="low">Moins de 100 DH</option>
                    <option value="mid">100 – 300 DH</option>
                    <option value="high">Plus de 300 DH</option>
                </select>
                <button type="submit" class="btn-search">Rechercher</button>
            </div>
        </form>
    </div>
</section>

<!-- EVENTS -->
<section class="events-section">
    <div class="events-inner">
        <div class="events-header">
            <div>
                <h2>Événements à venir</h2>
                <span class="count">{{ $events->count() ?? 0 }} événements trouvés</span>
            </div>
        </div>
        <div class="events-grid">
            @forelse($events ?? [] as $event)
            <div class="event-card">
                <div class="event-card-img">
                    <div class="img-bg 
                        @if(str_contains(strtolower($event->type ?? ''), 'concert')) img-concert
                        @elseif(str_contains(strtolower($event->type ?? ''), 'festival')) img-festival
                        @elseif(str_contains(strtolower($event->type ?? ''), 'théâtre')) img-theatre
                        @elseif(str_contains(strtolower($event->type ?? ''), 'expo')) img-expo
                        @else img-gastro
                        @endif
                    "></div>
                    <div class="cat-icon">
                        @if(str_contains(strtolower($event->type ?? ''), 'concert')) 🎵
                        @elseif(str_contains(strtolower($event->type ?? ''), 'festival')) 🎪
                        @elseif(str_contains(strtolower($event->type ?? ''), 'théâtre')) 🎭
                        @elseif(str_contains(strtolower($event->type ?? ''), 'expo')) 🖼️
                        @else 🍽️
                        @endif
                    </div>
                    <span class="card-badge">{{ $event->type ?? 'Événement' }}</span>
                    <span class="card-price {{ $event->prix == 0 ? 'free' : '' }}">
                        {{ $event->prix == 0 ? 'Gratuit' : number_format($event->prix, 0) . ' DH' }}
                    </span>
                </div>
                <div class="event-card-body">
                    <h3>{{ $event->titre ?? 'Sans titre' }}</h3>
                    <div class="event-card-meta">
                        <div class="meta-item">
                            <span class="mi-icon">📅</span> 
                            {{ \Carbon\Carbon::parse($event->date ?? now())->format('d M Y') }}
                        </div>
                        <div class="meta-item">
                            <span class="mi-icon">📍</span> 
                            {{ $event->lieu ?? 'Tanger' }}
                        </div>
                        <div class="meta-item">
                            <span class="mi-icon">👥</span> 
                            {{ $event->places_disponibles ?? 0 }} places
                        </div>
                    </div>
                    <div class="event-card-footer">
                        <div class="rating">
                            <span class="stars">★★★★☆</span> 4.5
                        </div>
                        <a href="{{ route('events.show', $event->id ?? 1) }}" class="btn-voir">Voir →</a>
                    </div>
                </div>
            </div>
            @empty
            <!-- Événements par défaut si aucun événement -->
            <div class="event-card">
                <div class="event-card-img"><div class="img-bg img-concert"></div><div class="cat-icon">🎵</div><span class="card-badge">Concert</span><span class="card-price">45 DH</span></div>
                <div class="event-card-body">
                    <h3>Nuit Jazz au Médina</h3>
                    <div class="event-card-meta">
                        <div class="meta-item"><span class="mi-icon">📅</span> 14 février 2026</div>
                        <div class="meta-item"><span class="mi-icon">📍</span> Place Utta, Tanger</div>
                        <div class="meta-item"><span class="mi-icon">👥</span> 150 places</div>
                    </div>
                    <div class="event-card-footer"><div class="rating"><span class="stars">★★★★☆</span> 4.2</div><a href="#" class="btn-voir">Voir →</a></div>
                </div>
            </div>
            <div class="event-card">
                <div class="event-card-img"><div class="img-bg img-festival"></div><div class="cat-icon">🎪</div><span class="card-badge">Festival</span><span class="card-price free">Gratuit</span></div>
                <div class="event-card-body">
                    <h3>Festival Culturel de Tanger</h3>
                    <div class="event-card-meta">
                        <div class="meta-item"><span class="mi-icon">📅</span> 20 février 2026</div>
                        <div class="meta-item"><span class="mi-icon">📍</span> Kasbah, Tanger</div>
                        <div class="meta-item"><span class="mi-icon">👥</span> 500 places</div>
                    </div>
                    <div class="event-card-footer"><div class="rating"><span class="stars">★★★★★</span> 4.8</div><a href="#" class="btn-voir">Voir →</a></div>
                </div>
            </div>
            <div class="event-card">
                <div class="event-card-img"><div class="img-bg img-theatre"></div><div class="cat-icon">🎭</div><span class="card-badge">Théâtre</span><span class="card-price">30 DH</span></div>
                <div class="event-card-body">
                    <h3>Le Songe d'une Nuit d'Été</h3>
                    <div class="event-card-meta">
                        <div class="meta-item"><span class="mi-icon">📅</span> 1er mars 2026</div>
                        <div class="meta-item"><span class="mi-icon">📍</span> Théâtre Ibn Batouta</div>
                        <div class="meta-item"><span class="mi-icon">👥</span> 200 places</div>
                    </div>
                    <div class="event-card-footer"><div class="rating"><span class="stars">★★★★☆</span> 4.5</div><a href="#" class="btn-voir">Voir →</a></div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="ev-footer">
    <div class="footer-logo">EVENTUS</div>
    <div class="footer-rule"></div>
    <p>© 2026 Eventus — Découvrez, Réservez, Célébrez</p>
</footer>

<script>
window.addEventListener('scroll',()=>{document.getElementById('evNav').classList.toggle('scrolled',window.scrollY>50);});
</script>

@endSection