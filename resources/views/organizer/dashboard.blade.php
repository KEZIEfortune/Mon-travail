@extends('layouts.app')

@section('styles')
<style>
/* ═══ EVENTUS — DASHBOARD ORGANISATEUR ═══ */
:root {
    --dark:#1a1a2e; --dark-mid:#16213e; --dark-card:#1e2a4a;
    --gold:#d4a017; --gold-light:#f0d060; --gold-pale:#fff8dc;
    --text:#c8cdd8; --text-dim:#6e7590; --white:#ffffff; --radius:14px;
    --accent-org:#8b5cf6;
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
.ev-nav-links a{color:var(--text-dim);text-decoration:none;font-size:12px;font-weight:400;letter-spacing:1.8px;text-transform:uppercase;transition:color .3s;}
.ev-nav-links a:hover{color:var(--gold);}
.nav-user{display:flex;align-items:center;gap:12px;}
.nav-user-name{font-size:12px;color:var(--gold);letter-spacing:1px;}
.btn-logout{color:var(--text-dim);font-size:11px;letter-spacing:1px;text-transform:uppercase;text-decoration:none;padding:6px 16px;border:1px solid rgba(212,160,23,0.2);border-radius:50px;background:transparent;transition:all .3s;}
.btn-logout:hover{background:rgba(212,160,23,0.08);color:var(--gold);}

/* ── HERO DASHBOARD ── */
.dash-hero{padding:100px 40px 40px;background:linear-gradient(135deg,rgba(139,92,246,0.08) 0%,transparent 50%);border-bottom:1px solid rgba(212,160,23,0.08);}
.dash-hero h1{font-family:'Cormorant Garamond',serif;font-size:38px;font-weight:300;color:var(--white);letter-spacing:2px;margin-bottom:8px;}
.dash-hero h1 .icon{color:var(--accent-org);}
.dash-hero p{color:var(--text-dim);font-size:13px;letter-spacing:1px;}

/* ── STATS CARDS ── */
.stats-section{padding:40px 40px 20px;}
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;}
.stat-card{background:var(--dark-card);border:1px solid rgba(212,160,23,0.12);border-radius:var(--radius);padding:24px;transition:transform .3s,border-color .3s,box-shadow .3s;position:relative;overflow:hidden;}
.stat-card::before{content:'';position:absolute;top:0;right:0;width:80px;height:80px;background:radial-gradient(circle,rgba(139,92,246,0.1),transparent);pointer-events:none;}
.stat-card:hover{transform:translateY(-3px);border-color:rgba(212,160,23,0.3);box-shadow:0 8px 24px rgba(0,0,0,0.2);}
.stat-card-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;}
.stat-card-icon{font-size:28px;}
.stat-card h3{font-family:'Cormorant Garamond',serif;font-size:32px;color:var(--white);font-weight:600;margin-bottom:4px;}
.stat-card p{font-size:12px;color:var(--text-dim);letter-spacing:0.8px;text-transform:uppercase;}

/* ── QUICK ACTIONS ── */
.actions-section{padding:20px 40px;}
.btn-create{display:inline-flex;align-items:center;gap:10px;padding:14px 32px;background:linear-gradient(135deg,#8b5cf6,#a78bfa);border:none;border-radius:10px;color:white;font-size:13px;font-weight:600;letter-spacing:1.2px;text-transform:uppercase;text-decoration:none;cursor:pointer;transition:transform .2s,box-shadow .3s;margin-bottom:20px;}
.btn-create:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(139,92,246,0.4);}
.actions-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;}
.action-card{background:linear-gradient(135deg,var(--dark-card),var(--dark-mid));border:1px solid rgba(212,160,23,0.15);border-radius:var(--radius);padding:20px;text-align:center;text-decoration:none;transition:all .3s;display:flex;flex-direction:column;align-items:center;gap:10px;}
.action-card:hover{border-color:var(--gold);background:linear-gradient(135deg,var(--dark-card),rgba(212,160,23,0.05));transform:translateY(-2px);box-shadow:0 6px 20px rgba(212,160,23,0.15);}
.action-card-icon{font-size:32px;}
.action-card h4{font-size:13px;color:var(--white);letter-spacing:1px;text-transform:uppercase;margin:0;}

/* ── EVENTS TABLE ── */
.table-section{padding:20px 40px 60px;}
.section-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;}
.section-header h2{font-family:'Cormorant Garamond',serif;font-size:28px;color:var(--white);font-weight:300;letter-spacing:1.5px;}
.table-card{background:var(--dark-card);border:1px solid rgba(212,160,23,0.12);border-radius:var(--radius);padding:24px;}
.table-responsive{overflow-x:auto;}
table{width:100%;border-collapse:collapse;}
thead th{text-align:left;padding:12px;font-size:11px;color:var(--text-dim);letter-spacing:1px;text-transform:uppercase;border-bottom:1px solid rgba(212,160,23,0.1);}
tbody td{padding:14px 12px;font-size:13px;color:var(--text);border-bottom:1px solid rgba(255,255,255,0.03);}
tbody tr:hover{background:rgba(212,160,23,0.02);}
tbody tr:last-child td{border-bottom:none;}
.badge{padding:4px 10px;border-radius:50px;font-size:10px;letter-spacing:0.5px;text-transform:uppercase;font-weight:600;}
.badge-success{background:rgba(94,205,130,0.15);color:#5ecd82;}
.badge-warning{background:rgba(255,193,7,0.15);color:#ffc107;}
.badge-info{background:rgba(74,144,226,0.15);color:#4a90e2;}
.btn-group{display:flex;gap:6px;}
.btn-sm{padding:5px 12px;font-size:10px;border-radius:5px;border:1px solid rgba(212,160,23,0.2);background:transparent;color:var(--gold);text-decoration:none;cursor:pointer;transition:all .2s;}
.btn-sm:hover{background:rgba(212,160,23,0.08);border-color:var(--gold);}
.btn-edit{color:#ffc107;border-color:rgba(255,193,7,0.2);}
.btn-edit:hover{background:rgba(255,193,7,0.08);border-color:#ffc107;}
.btn-delete{color:#dc3545;border-color:rgba(220,53,69,0.2);}
.btn-delete:hover{background:rgba(220,53,69,0.08);border-color:#dc3545;}

/* ── CHARTS SECTION ── */
.charts-section{padding:20px 40px;}
.charts-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:20px;}
.chart-card{background:var(--dark-card);border:1px solid rgba(212,160,23,0.12);border-radius:var(--radius);padding:24px;}
.chart-card h3{font-family:'Cormorant Garamond',serif;font-size:20px;color:var(--white);margin-bottom:16px;}
.info-item{display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid rgba(255,255,255,0.03);}
.info-item:last-child{border-bottom:none;}
.info-label{font-size:13px;color:var(--text-dim);}
.info-value{font-size:14px;color:var(--white);font-weight:600;}

@media(max-width:768px){
    .ev-nav{padding:12px 18px;}
    .dash-hero,.stats-section,.actions-section,.table-section,.charts-section{padding-left:18px;padding-right:18px;}
    .stats-grid{grid-template-columns:1fr;}
    .section-header{flex-direction:column;align-items:flex-start;}
}
</style>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet"/>
@endSection

@section('content')

<!-- NAVBAR -->
<nav class="ev-nav">
    <a href="{{ route('organizer.dashboard') }}" class="ev-nav-logo">
        <div class="logo-wrap"><span>E</span></div>
        <span class="logo-name">EVENTUS</span>
    </a>
    <ul class="ev-nav-links">
        <li><a href="{{ route('organizer.dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('organizer.events.index') }}">Mes Événements</a></li>
        <li><a href="{{ route('organizer.reservations.index') }}">Réservations</a></li>
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
    <h1><span class="icon">🎪</span> Espace Organisateur</h1>
    <p>Bienvenue {{ Auth::user()->name }}, gérez vos événements et réservations</p>
</section>

<!-- STATISTIQUES -->
<section class="stats-section">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon">🎪</div>
            </div>
            <h3>{{ $totalEvents ?? 0 }}</h3>
            <p>Événements créés</p>
        </div>
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon">📅</div>
            </div>
            <h3>{{ $upcomingEvents ?? 0 }}</h3>
            <p>Événements à venir</p>
        </div>
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon">👥</div>
            </div>
            <h3>{{ $totalReservations ?? 0 }}</h3>
            <p>Réservations totales</p>
        </div>
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon">💰</div>
            </div>
            <h3>{{ number_format($totalRevenue ?? 0, 0) }} DH</h3>
            <p>Revenus générés</p>
        </div>
    </div>
</section>

<!-- ACTIONS RAPIDES -->
<section class="actions-section">
    <a href="{{ route('organizer.events.create') }}" class="btn-create">
        <span>➕</span> Créer un nouvel événement
    </a>
    <div class="actions-grid">
        <a href="{{ route('organizer.events.index') }}" class="action-card">
            <div class="action-card-icon">📋</div>
            <h4>Mes Événements</h4>
        </a>
        <a href="{{ route('organizer.reservations.index') }}" class="action-card">
            <div class="action-card-icon">🎫</div>
            <h4>Réservations</h4>
        </a>
        
    </div>
</section>

<!-- PERFORMANCE -->
<section class="charts-section">
    <div class="charts-grid">
        <div class="chart-card">
            <h3>📊 Performance</h3>
            <div class="info-item">
                <span class="info-label">Taux de remplissage moyen</span>
                <span class="info-value">{{ $fillRate ?? 0 }}%</span>
            </div>
            <div class="info-item">
                <span class="info-label">Événements populaires</span>
                <span class="info-value">{{ $popularEvents ?? 0 }}</span>
            </div>
        </div>
        <div class="chart-card">
            <h3>🔔 Notifications</h3>
            <div class="info-item">
                <span class="info-label">Réservations en attente</span>
                <span class="info-value badge badge-warning">{{ $pendingReservations ?? 0 }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Événements dans 7 jours</span>
                <span class="info-value badge badge-info">{{ $upcomingEvents ?? 0 }}</span>
            </div>
        </div>
    </div>
</section>

<!-- MES ÉVÉNEMENTS RÉCENTS -->
<section class="table-section">
    <div class="section-header">
        <h2>📋 Mes événements récents</h2>
        <a href="{{ route('organizer.events.create') }}" class="btn-create">+ Créer</a>
    </div>
    <div class="table-card">
        @if(isset($recentEvents) && $recentEvents->count() > 0)
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Événement</th>
                        <th>Date</th>
                        <th>Lieu</th>
                        <th>Places</th>
                        <th>Prix</th>
                        <th>Réservations</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentEvents as $event)
                    <tr>
                        <td><strong>{{ $event->title }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }}</td>
                        <td>{{ Str::limit($event->city, 20) }}</td>
                        <td><span class="badge badge-info">{{ $event->available_tickets }}</span></td>
                        <td>{{ number_format($event->price, 0) }} DH</td>
                        <td><span class="badge badge-success">{{ $event->reservations->where('status', 'confirmed')->count() }}</span></td>
                        <td>
                            @if($event->is_validated)
                                <span class="badge badge-success">Validé</span>
                            @else
                                <span class="badge badge-warning">En attente</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('organizer.events.edit', $event->id) }}" class="btn-sm btn-edit">✏️</a>
                                <form action="{{ route('organizer.events.destroy', $event->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cet événement ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm btn-delete">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p style="text-align:center;color:var(--text-dim);padding:40px;">
            Aucun événement créé. <a href="{{ route('organizer.events.create') }}" style="color:var(--gold);">Créez votre premier événement →</a>
        </p>
        @endif
    </div>
</section>

@endSection