@extends('layouts.app')

@section('styles')
<style>
/* ═══ EVENTUS — DASHBOARD MEMBRE ═══ */
:root {
    --dark:#1a1a2e; --dark-mid:#16213e; --dark-card:#1e2a4a;
    --gold:#d4a017; --gold-light:#f0d060; --gold-pale:#fff8dc;
    --text:#c8cdd8; --text-dim:#6e7590; --white:#ffffff; --radius:14px;
    --accent-membre:#4a90e2;
}
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'Jost','Segoe UI',sans-serif;background:var(--dark);color:var(--text);min-height:100vh;line-height:1.6;}

/* ── NAVBAR ── */
.ev-nav{position:fixed;top:0;left:0;width:100%;z-index:100;display:flex;align-items:center;justify-content:space-between;padding:16px 40px;background:rgba(26,26,46,0.95);backdrop-filter:blur(18px);border-bottom:1px solid rgba(212,160,23,0.1);}
.ev-nav-logo{display:flex;align-items:center;gap:10px;text-decoration:none;}
.ev-nav-logo .logo-wrap{width:34px;height:34px;border-radius:50%;background:var(--dark-mid);border:1.5px solid rgba(212,160,23,0.4);display:flex;align-items:center;justify-content:center;}
.ev-nav-logo .logo-wrap span{font-family:'Cormorant Garamond',serif;font-size:18px;font-weight:600;background:linear-gradient(135deg,#b8860b,#f0d060,#fff8dc,#f0d060,#b8860b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.ev-nav-logo .logo-name{font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:600;letter-spacing:4px;color:var(--white);}
.ev-nav-links{display:flex;align-items:center;gap:28px;list-style:none;}
.ev-nav-links a{color:var(--text-dim);text-decoration:none;font-size:12px;font-weight:400;letter-spacing:1.8px;text-transform:uppercase;transition:color .3s;position:relative;}
.ev-nav-links a:hover{color:var(--gold);}
.nav-user{display:flex;align-items:center;gap:12px;}
.nav-user-name{font-size:12px;color:var(--gold);letter-spacing:1px;}
.btn-logout{color:var(--text-dim);font-size:11px;letter-spacing:1px;text-transform:uppercase;text-decoration:none;padding:6px 16px;border:1px solid rgba(212,160,23,0.2);border-radius:50px;transition:all .3s;}
.btn-logout:hover{background:rgba(212,160,23,0.08);color:var(--gold);}

/* ── HERO DASHBOARD ── */
.dash-hero{padding:100px 40px 40px;background:linear-gradient(135deg,rgba(74,144,226,0.08) 0%,transparent 50%);border-bottom:1px solid rgba(212,160,23,0.08);}
.dash-hero h1{font-family:'Cormorant Garamond',serif;font-size:38px;font-weight:300;color:var(--white);letter-spacing:2px;margin-bottom:8px;}
.dash-hero h1 .icon{color:var(--accent-membre);}
.dash-hero p{color:var(--text-dim);font-size:13px;letter-spacing:1px;}

/* ── STATS CARDS ── */
.stats-section{padding:40px 40px 20px;}
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:20px;}
.stat-card{background:var(--dark-card);border:1px solid rgba(212,160,23,0.12);border-radius:var(--radius);padding:24px;transition:transform .3s,border-color .3s,box-shadow .3s;}
.stat-card:hover{transform:translateY(-3px);border-color:rgba(212,160,23,0.3);box-shadow:0 8px 24px rgba(0,0,0,0.2);}
.stat-card-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;}
.stat-card-icon{font-size:28px;}
.stat-card h3{font-family:'Cormorant Garamond',serif;font-size:32px;color:var(--white);font-weight:600;margin-bottom:4px;}
.stat-card p{font-size:12px;color:var(--text-dim);letter-spacing:0.8px;text-transform:uppercase;}

/* ── QUICK ACTIONS ── */
.actions-section{padding:20px 40px;}
.actions-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;}
.action-card{background:linear-gradient(135deg,var(--dark-card),var(--dark-mid));border:1px solid rgba(212,160,23,0.15);border-radius:var(--radius);padding:20px;text-align:center;text-decoration:none;transition:all .3s;display:flex;flex-direction:column;align-items:center;gap:10px;}
.action-card:hover{border-color:var(--gold);background:linear-gradient(135deg,var(--dark-card),rgba(212,160,23,0.05));transform:translateY(-2px);box-shadow:0 6px 20px rgba(212,160,23,0.15);}
.action-card-icon{font-size:32px;}
.action-card h4{font-size:13px;color:var(--white);letter-spacing:1px;text-transform:uppercase;margin:0;}

/* ── SEARCH BOX ── */
.search-box{background:var(--dark-card);border:1px solid rgba(212,160,23,0.15);border-radius:var(--radius);padding:24px;margin:20px 40px;}
.search-box h3{font-family:'Cormorant Garamond',serif;font-size:22px;color:var(--white);margin-bottom:16px;}
.search-bar{display:flex;gap:12px;flex-wrap:wrap;}
.search-bar input,.search-bar select{flex:1;min-width:150px;background:rgba(26,26,46,0.5);border:1px solid rgba(212,160,23,0.1);border-radius:8px;color:var(--white);font-family:inherit;font-size:13px;padding:12px 16px;outline:none;}
.search-bar input::placeholder{color:var(--text-dim);}
.search-bar select{color:var(--text-dim);cursor:pointer;}
.search-bar select option{background:var(--dark-card);color:var(--white);}
.btn-search{padding:12px 28px;border-radius:8px;background:linear-gradient(135deg,#d4a017,#e8c840);border:none;color:var(--dark);font-family:inherit;font-size:12px;font-weight:600;letter-spacing:1.2px;text-transform:uppercase;cursor:pointer;transition:transform .2s,box-shadow .3s;}
.btn-search:hover{transform:translateY(-1px);box-shadow:0 4px 16px rgba(212,160,23,0.3);}

/* ── EVENTS GRID ── */
.events-section{padding:20px 40px 60px;}
.section-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;}
.section-header h2{font-family:'Cormorant Garamond',serif;font-size:28px;color:var(--white);font-weight:300;letter-spacing:1.5px;}
.events-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:20px;}
.event-card{background:var(--dark-card);border:1px solid rgba(212,160,23,0.1);border-radius:var(--radius);overflow:hidden;transition:transform .3s,border-color .3s,box-shadow .3s;}
.event-card:hover{transform:translateY(-4px);border-color:rgba(212,160,23,0.25);box-shadow:0 12px 36px rgba(0,0,0,0.2);}
.event-card-img{width:100%;height:160px;background:linear-gradient(135deg,#1a1035 0%,#2d1b5e 60%,#1a1035 100%);position:relative;display:flex;align-items:center;justify-content:center;font-size:42px;opacity:0.3;}
.event-card-body{padding:20px;}
.event-card-body h3{font-family:'Cormorant Garamond',serif;font-size:18px;color:var(--white);margin-bottom:10px;}
.event-meta{display:flex;flex-direction:column;gap:6px;font-size:12px;color:var(--text-dim);margin-bottom:16px;}
.meta-item{display:flex;align-items:center;gap:6px;}
.event-card-footer{display:flex;align-items:center;justify-content:space-between;padding-top:12px;border-top:1px solid rgba(255,255,255,0.05);}
.btn-voir{padding:6px 16px;border-radius:6px;border:1px solid rgba(212,160,23,0.3);background:transparent;color:var(--gold);font-size:11px;font-weight:500;letter-spacing:1px;text-transform:uppercase;text-decoration:none;transition:all .25s;}
.btn-voir:hover{background:rgba(212,160,23,0.08);box-shadow:0 2px 10px rgba(212,160,23,0.12);}

/* ── RESERVATIONS TABLE ── */
.table-card{background:var(--dark-card);border:1px solid rgba(212,160,23,0.12);border-radius:var(--radius);padding:24px;margin:20px 40px;}
.table-card h3{font-family:'Cormorant Garamond',serif;font-size:24px;color:var(--white);margin-bottom:16px;}
.table-responsive{overflow-x:auto;}
table{width:100%;border-collapse:collapse;}
thead th{text-align:left;padding:12px;font-size:11px;color:var(--text-dim);letter-spacing:1px;text-transform:uppercase;border-bottom:1px solid rgba(212,160,23,0.1);}
tbody td{padding:14px 12px;font-size:13px;color:var(--text);border-bottom:1px solid rgba(255,255,255,0.03);}
tbody tr:hover{background:rgba(212,160,23,0.02);}
.badge{padding:4px 10px;border-radius:50px;font-size:10px;letter-spacing:0.5px;text-transform:uppercase;font-weight:600;}
.badge-success{background:rgba(94,205,130,0.15);color:#5ecd82;}
.badge-warning{background:rgba(255,193,7,0.15);color:#ffc107;}
.badge-danger{background:rgba(220,53,69,0.15);color:#dc3545;}
.btn-sm{padding:5px 12px;font-size:10px;border-radius:5px;}

@media(max-width:768px){
    .ev-nav{padding:12px 18px;}
    .dash-hero,.stats-section,.actions-section,.search-box,.events-section,.table-card{padding-left:18px;padding-right:18px;}
    .stats-grid{grid-template-columns:1fr;}
    .events-grid{grid-template-columns:1fr;}
}
</style>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet"/>
@endSection

@section('content')

<!-- NAVBAR -->
<nav class="ev-nav">
    <a href="{{ route('member.dashboard') }}" class="ev-nav-logo">
        <div class="logo-wrap"><span>E</span></div>
        <span class="logo-name">EVENTUS</span>
    </a>
    <ul class="ev-nav-links">
        
        <li><a href="{{ route('member.dashboard') }}">Dashboard</a></li>

        <li><a href="{{ route('member.events.search') }}">Événements</a></li>

        <li><a href="{{ route('member.reservations.index') }}">Réservations</a></li>
    </ul>
    <div class="nav-user">
        <span class="nav-user-name">{{ Auth::user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn-logout">Déconnexion</button>
        </form>
    </div>
</nav>

<!-- HERO -->
<section class="dash-hero">
    <h1><span class="icon">👤</span> Espace Membre</h1>
    <p>Bienvenue {{ Auth::user()->name }}, découvrez et réservez vos événements</p>
</section>

<!-- STATISTIQUES -->
<section class="stats-section">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon">🎫</div>
            </div>
            <h3>{{ $totalReservations ?? 0 }}</h3>
            <p>Réservations totales</p>
        </div>
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon">✅</div>
            </div>
            <h3>{{ $activeReservations ?? 0 }}</h3>
            <p>Réservations actives</p>
        </div>
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon">💰</div>
            </div>
            <h3>{{ number_format($totalSpent ?? 0, 0) }} DH</h3>
            <p>Montant total dépensé</p>
        </div>
    </div>
</section>

<!-- ACTIONS RAPIDES -->
<section class="actions-section">
    <div class="actions-grid">
        <a href="{{ route('membereventsearch}" class="action-card">
            <div class="action-card-icon">🔍</div>
            <h4>Rechercher</h4>
        </a>
        <a href="{{ route('member.reservations.index') }}" class="action-card">
            <div class="action-card-icon">📋</div>
            <h4>Mes Réservations</h4>
        </a>
        <a href="{{ route('member.p }}" class="action-card">
            <div class="action-card-icon">⚙️</div>
            <h4>Mon Profil</h4>
        </a>
    </div>
</section>

<!-- RECHERCHE RAPIDE -->
<section class="search-box">
    <h3>🔍 Rechercher un événement</h3>
    <form action="{{ route('membre.events.search') }}" method="GET">
        <div class="search-bar">
            <input type="text" name="q" placeholder="Nom de l'événement...">
            <select name="type">
                <option value="">Type</option>
                <option value="Concert">Concert</option>
                <option value="Festival">Festival</option>
                <option value="Théâtre">Théâtre</option>
                <option value="Exposition">Exposition</option>
            </select>
            <button type="submit" class="btn-search">Rechercher</button>
        </div>
    </form>
</section>

<!-- ÉVÉNEMENTS POPULAIRES -->
<section class="events-section">
    <div class="section-header">
        <h2>🔥 Événements populaires</h2>
    </div>
    <div class="events-grid">
        @forelse($upcomingEvents ?? [] as $event)
        <div class="event-card">
            <div class="event-card-img">🎉</div>
            <div class="event-card-body">
                <h3>{{ $event->titre }}</h3>
                <div class="event-meta">
                    <div class="meta-item">📅 {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</div>
                    <div class="meta-item">📍 {{ $event->lieu }}</div>
                    <div class="meta-item">💰 {{ number_format($event->prix, 0) }} DH</div>
                </div>
                <div class="event-card-footer">
                    <span style="font-size:11px;color:var(--text-dim);">{{ $event->places_restantes ?? $event->places_disponibles }} places</span>
                    <a href="{{ route('events.show', $event->id) }}" class="btn-voir">Voir →</a>
                </div>
            </div>
        </div>
        @empty
        <p style="grid-column:1/-1;text-align:center;color:var(--text-dim);padding:40px;">Aucun événement disponible</p>
        @endforelse
    </div>
</section>

<!-- MES DERNIÈRES RÉSERVATIONS -->
@if(isset($recentReservations) && $recentReservations->count() > 0)
<section class="table-card">
    <h3>🎫 Mes dernières réservations</h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Événement</th>
                    <th>Date</th>
                    <th>Places</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentReservations as $reservation)
                <tr>
                    <td><strong>{{ $reservation->event->titre }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($reservation->event->date)->format('d/m/Y') }}</td>
                    <td>{{ $reservation->nombre_places }}</td>
                    <td>{{ number_format($reservation->montant_total, 0) }} DH</td>
                    <td>
                        @if($reservation->status === 'confirmed')
                            <span class="badge badge-success">Confirmée</span>
                        @elseif($reservation->status === 'pending')
                            <span class="badge badge-warning">En attente</span>
                        @else
                            <span class="badge badge-danger">Annulée</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('membre.reservations.show', $reservation->id) }}" class="btn-voir btn-sm">Voir</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endif

@endSection