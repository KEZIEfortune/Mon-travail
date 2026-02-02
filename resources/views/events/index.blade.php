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
.hero-cta{position:relative;z-index:1;display:inline-flex;align-items:center;gap:8px;padding:12px 32px;border-radius:50px;border:1px solid rgba(212,160,23,0.32);color:var(--gold);text-decoration:none;font-size:12px;letter-spacing:2.5px;text-transform:uppercase;transition:background .3s,box-shadow .3s,transform .2s;animation:fadeUp .8s .55s ease both;}
.hero-cta:hover{background:rgba(212,160,23,0.07);box-shadow:0 0 28px rgba(212,160,23,0.13);transform:translateY(-2px);}
.hero-cta svg{width:14px;height:14px;transition:transform .3s;}
.hero-cta:hover svg{transform:translateY(2px);}

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
}
</style>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet"/>
@endSection

@section('content')

<!-- NAVBAR -->
<nav class="ev-nav" id="evNav">
    <a href="{{ route('home') }}" class="ev-nav-logo">
        <div class="logo-wrap"><span>E</span></div>
        <span class="logo-name">EVENTUS</span>
    </a>
    <ul class="ev-nav-links">
        <li><a href="{{ route('home') }}">Accueil</a></li>
        
    </ul>
    <div class="nav-auth">
        @guest
            <a href="{{ route('login') }}" class="btn-login">Connexion</a>
            
        @else
            <span style="font-size:13px;color:var(--text-dim);margin-right:4px;">{{ Auth::user()->name }}</span>
            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn-login">Déconnexion</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">{{ csrf_field() }}</form>
        @endguest
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-badge">Plateforme culturelle — Tanger</div>
    <h1>Découvrez les<br/><span class="gold-text">Événements</span></h1>
    <p class="hero-sub">Festivals · Concerts · Théâtre · Expositions</p>
    <div class="hero-rule"></div>
    <a href="#events" class="hero-cta">
        Explorer les événements
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><path d="M8 2v12M2 8l6 6 6-6"/></svg>
    </a>
</section>

<!-- SEARCH & FILTERS -->
<section class="search-section" id="events">
    <div class="search-inner">
        <form method="GET" action="{{ route('home') }}">
            <div class="search-bar">
                <input type="text" name="search" placeholder="🔍  Rechercher un événement..." value="{{ request('search') }}"/>
                <div class="sep"></div>
                <select name="category">
                    <option value="">📂  Catégorie</option>
                    <option value="concert">🎵  Concert</option>
                    <option value="festival">🎪  Festival</option>
                    <option value="theatre">🎭  Théâtre</option>
                    <option value="expo">🖼️  Exposition</option>
                    <option value="gastro">🍽️  Gastronomie</option>
                </select>
                <div class="sep"></div>
                <select name="date">
                    <option value="">📅  Date</option>
                    <option value="today">Aujourd'hui</option>
                    <option value="week">Cette semaine</option>
                    <option value="month">Ce mois</option>
                </select>
                <div class="sep"></div>
                <select name="price">
                    <option value="">💰  Prix</option>
                    <option value="free">Gratuit</option>
                    <option value="low">Moins de 20€</option>
                    <option value="mid">20€ – 50€</option>
                    <option value="high">Plus de 50€</option>
                </select>
                <button type="submit" class="btn-search">Rechercher</button>
            </div>
        </form>
        <div class="filter-pills">
            <button class="pill active" onclick="this.classList.toggle('active')">✦ Tous</button>
            <button class="pill" onclick="this.classList.toggle('active')">🎵 Concerts</button>
            <button class="pill" onclick="this.classList.toggle('active')">🎪 Festivals</button>
            <button class="pill" onclick="this.classList.toggle('active')">🎭 Théâtre</button>
            <button class="pill" onclick="this.classList.toggle('active')">🖼️ Expositions</button>
            <button class="pill" onclick="this.classList.toggle('active')">🍽️ Gastronomie</button>
            <button class="pill" onclick="this.classList.toggle('active')">💰 Gratuit</button>
        </div>
    </div>
</section>

<!-- EVENTS -->
<section class="events-section">
    <div class="events-inner">
        <div class="events-header">
            <div>
                <h2>Événements à venir</h2>
                <span class="count">8 événements trouvés</span>
            </div>
            <select class="sort-select">
                <option>Trier par : Date</option>
                <option>Trier par : Popularité</option>
                <option>Trier par : Prix ↑</option>
                <option>Trier par : Prix ↓</option>
            </select>
        </div>
      <div class="events-grid">
    @forelse($events as $event)
        <div class="event-card">
            <div class="event-card-img">
                @if($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" class="img-bg" style="width:100%; height:100%; object-fit: cover;">
                @else
                    {{-- On garde vos classes CSS pour les couleurs si pas d'image --}}
                    <div class="img-bg img-{{ Str::slug($event->category->name ?? 'concert') }}"></div>
                @endif
                
                <div class="cat-icon">
                    @php
                        $icons = ['Concert' => '🎵', 'Festival' => '🎪', 'Théâtre' => '🎭', 'Exposition' => '🖼️', 'Gastronomie' => '🍽️'];
                        echo $icons[$event->category->name] ?? '✨';
                    @endphp
                </div>
                
                <span class="card-badge">{{ $event->category->name }}</span>
                <span class="card-price {{ $event->price == 0 ? 'free' : '' }}">
                    {{ $event->price == 0 ? 'Gratuit' : $event->price . ' DH' }}
                </span>
            </div>
            
            <div class="event-card-body">
                <h3>{{ $event->title }}</h3>
                <div class="event-card-meta">
                    <div class="meta-item"><span class="mi-icon">📅</span> {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d M Y') }}</div>
                    <div class="meta-item"><span class="mi-icon">📍</span> {{ $event->city }}</div>
                    <div class="meta-item"><span class="mi-icon">🕐</span> {{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }}</div>
                </div>
                <div class="event-card-footer">
                    <div class="rating"><span class="stars">★★★★☆</span> 4.2</div>
                    <a href="{{ route('events.show', $event->id) }}" class="btn-voir">Voir →</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <p style="color: var(--text-dim);">Aucun événement trouvé pour le moment.</p>
        </div>
    @endforelse
</div>  
</section>

<!-- FOOTER -->
<footer class="ev-footer">
    <div class="footer-logo">EVENTUS</div>
    <div class="footer-rule"></div>
    <p>© 2025 Eventus — Découvrez, Réservez, Célébrez</p>
</footer>

<script>
window.addEventListener('scroll',()=>{document.getElementById('evNav').classList.toggle('scrolled',window.scrollY>50);});
</script>

@endSection