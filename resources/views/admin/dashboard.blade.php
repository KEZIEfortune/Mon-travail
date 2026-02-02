@extends('layouts.app')

@section('styles')
<style>
/* ═══ VOS STYLES EXISTANTS (GARDÉS À 100%) ═══ */
:root {
    --dark:#1a1a2e; --dark-mid:#16213e; --dark-card:#1e2a4a;
    --gold:#d4a017; --gold-light:#f0d060; --gold-pale:#fff8dc;
    --text:#c8cdd8; --text-dim:#6e7590; --white:#ffffff; --radius:14px;
    --accent-admin:#dc3545;
}
/* ... (Le reste de votre CSS reste inchangé) ... */
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'Jost','Segoe UI',sans-serif;background:var(--dark);color:var(--text);min-height:100vh;line-height:1.6;}
.ev-nav{position:fixed;top:0;left:0;width:100%;z-index:100;display:flex;align-items:center;justify-content:space-between;padding:16px 40px;background:rgba(26,26,46,0.95);backdrop-filter:blur(18px);border-bottom:1px solid rgba(220,53,69,0.15);}
.ev-nav-logo{display:flex;align-items:center;gap:10px;text-decoration:none;}
.ev-nav-logo .logo-wrap{width:34px;height:34px;border-radius:50%;background:var(--dark-mid);border:1.5px solid rgba(220,53,69,0.4);display:flex;align-items:center;justify-content:center;}
.ev-nav-logo .logo-wrap span{font-family:'Cormorant Garamond',serif;font-size:18px;font-weight:600;background:linear-gradient(135deg,#dc3545,#ff6b6b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.ev-nav-logo .logo-name{font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:600;letter-spacing:4px;color:var(--white);}
.ev-nav-links{display:flex;align-items:center;gap:28px;list-style:none;}
.ev-nav-links a{color:var(--text-dim);text-decoration:none;font-size:12px;font-weight:400;letter-spacing:1.8px;text-transform:uppercase;transition:color .3s;}
.ev-nav-links a:hover{color:var(--accent-admin);}
.nav-user{display:flex;align-items:center;gap:12px;}
.nav-user-name{font-size:12px;color:var(--accent-admin);letter-spacing:1px;}
.btn-logout{color:var(--text-dim);font-size:11px;letter-spacing:1px;text-transform:uppercase;text-decoration:none;padding:6px 16px;border:1px solid rgba(220,53,69,0.2);border-radius:50px;background:transparent;transition:all .3s;}
.btn-logout:hover{background:rgba(220,53,69,0.08);color:var(--accent-admin);}
.dash-hero{padding:100px 40px 40px;background:linear-gradient(135deg,rgba(220,53,69,0.08) 0%,transparent 50%);border-bottom:1px solid rgba(220,53,69,0.08);}
.dash-hero h1{font-family:'Cormorant Garamond',serif;font-size:38px;font-weight:300;color:var(--white);letter-spacing:2px;margin-bottom:8px;}
.dash-hero h1 .icon{color:var(--accent-admin);}
.dash-hero p{color:var(--text-dim);font-size:13px;letter-spacing:1px;}
.stats-section{padding:40px 40px 20px;}
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;}
.stat-card{background:var(--dark-card);border:1px solid rgba(220,53,69,0.12);border-top:3px solid var(--accent-admin);border-radius:var(--radius);padding:24px;transition:transform .3s,box-shadow .3s;}
.stat-card:hover{transform:translateY(-3px);box-shadow:0 8px 24px rgba(220,53,69,0.2);}
.stat-card-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;}
.stat-card-icon{font-size:28px;}
.stat-card h3{font-family:'Cormorant Garamond',serif;font-size:32px;color:var(--white);font-weight:600;margin-bottom:4px;}
.stat-card p{font-size:12px;color:var(--text-dim);letter-spacing:0.8px;text-transform:uppercase;}
.actions-section{padding:20px 40px;}
.actions-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;}
.action-card{background:linear-gradient(135deg,var(--dark-card),var(--dark-mid));border:1px solid rgba(220,53,69,0.15);border-radius:var(--radius);padding:20px;text-align:center;text-decoration:none;transition:all .3s;display:flex;flex-direction:column;align-items:center;gap:10px;}
.action-card:hover{border-color:var(--accent-admin);background:linear-gradient(135deg,var(--dark-card),rgba(220,53,69,0.05));transform:translateY(-2px);box-shadow:0 6px 20px rgba(220,53,69,0.15);}
.action-card-icon{font-size:32px;}
.action-card h4{font-size:13px;color:var(--white);letter-spacing:1px;text-transform:uppercase;margin:0;}
.table-section{padding:20px 40px;}
.table-card{background:var(--dark-card);border:1px solid rgba(220,53,69,0.12);border-radius:var(--radius);padding:24px;margin-bottom:24px;}
.table-card h3{font-family:'Cormorant Garamond',serif;font-size:24px;color:var(--white);margin-bottom:16px;}
.table-responsive{overflow-x:auto;}
table{width:100%;border-collapse:collapse;}
thead th{text-align:left;padding:12px;font-size:11px;color:var(--text-dim);letter-spacing:1px;text-transform:uppercase;border-bottom:1px solid rgba(220,53,69,0.1);}
tbody td{padding:14px 12px;font-size:13px;color:var(--text);border-bottom:1px solid rgba(255,255,255,0.03);}
tbody tr:hover{background:rgba(220,53,69,0.02);}
tbody tr:last-child td{border-bottom:none;}
.badge{padding:4px 10px;border-radius:50px;font-size:10px;letter-spacing:0.5px;text-transform:uppercase;font-weight:600;}
.badge-success{background:rgba(94,205,130,0.15);color:#5ecd82;}
.badge-warning{background:rgba(255,193,7,0.15);color:#ffc107;}
.badge-danger{background:rgba(220,53,69,0.15);color:#dc3545;}
.badge-info{background:rgba(74,144,226,0.15);color:#4a90e2;}
.btn-group{display:flex;gap:6px;}
.btn-sm{padding:5px 12px;font-size:10px;border-radius:5px;border:1px solid;background:transparent;text-decoration:none;cursor:pointer;transition:all .2s;}
.btn-validate{color:#5ecd82;border-color:rgba(94,205,130,0.3);}
.btn-validate:hover{background:rgba(94,205,130,0.08);border-color:#5ecd82;}
.btn-reject{color:#dc3545;border-color:rgba(220,53,69,0.3);}
.btn-reject:hover{background:rgba(220,53,69,0.08);border-color:#dc3545;}
.btn-ban{color:#ffc107;border-color:rgba(255,193,7,0.3);}
.btn-ban:hover{background:rgba(255,193,7,0.08);border-color:#ffc107;}
.cards-section{padding:20px 40px 60px;}
.cards-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:20px;}
.info-card{background:var(--dark-card);border:1px solid rgba(220,53,69,0.12);border-radius:var(--radius);padding:20px;}
.info-card h4{font-family:'Cormorant Garamond',serif;font-size:18px;color:var(--white);margin-bottom:12px;display:flex;align-items:center;gap:8px;}
.user-list{display:flex;flex-direction:column;gap:10px;}
.user-item{display:flex;justify-content:space-between;align-items:center;padding:10px;background:rgba(26,26,46,0.5);border-radius:8px;}
.user-info{flex:1;}
.user-name{font-size:13px;color:var(--white);font-weight:500;}
.user-email{font-size:11px;color:var(--text-dim);}
.user-actions{display:flex;gap:6px;}
@media(max-width:768px){
    .ev-nav{padding:12px 18px;}
    .dash-hero,.stats-section,.actions-section,.table-section,.cards-section{padding-left:18px;padding-right:18px;}
    .stats-grid{grid-template-columns:1fr;}
}
</style>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet"/>
@endSection

@section('content')

<nav class="ev-nav">
    <a href="{{ route('admin.dashboard') }}" class="ev-nav-logo">
        <div class="logo-wrap"><span>E</span></div>
        <span class="logo-name">EVENTUS</span>
    </a>
    <ul class="ev-nav-links">
        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('admin.members.index') }}">Membres</a></li>
        <li><a href="{{ route('admin.organizers.index') }}">Organisateurs</a></li>
    </ul>
    <div class="nav-user">
        <span class="nav-user-name">{{ Auth::user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn-logout">Déconnexion</button>
        </form>
    </div>
</nav>

<section class="dash-hero">
    <h1><span class="icon">👑</span> Administration EVENTUS</h1>
    <p>Gestion complète de la plateforme</p>
</section>

<section class="stats-section">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-header"><div class="stat-card-icon">👥</div></div>
            <h3>{{ $totalUsers }}</h3>
            <p>Utilisateurs totaux</p>
        </div>
        <div class="stat-card">
            <div class="stat-card-header"><div class="stat-card-icon">🎪</div></div>
            <h3>{{ $totalEvents }}</h3>
            <p>Événements créés</p>
        </div>
        <div class="stat-card">
            <div class="stat-card-header"><div class="stat-card-icon">🎫</div></div>
            <h3>{{ $totalReservations }}</h3>
            <p>Les Réservations totales</p>
        </div>
        <div class="stat-card">
            <div class="stat-card-header"><div class="stat-card-icon">⏳</div></div>
            <h3>{{ $pendingEvents }}</h3>
            <p>événement en attente de validation</p>
        </div>
    </div>
</section>

<section class="table-section">
    <div class="table-card">
        <h3>⏳ Événements en attente de validation</h3>
        @if($pendingEventsList->count() > 0)
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Événement</th>
                        <th>Organisateur</th>
                        <th>Date</th>
                        <th>Ville</th>
                        <th>Prix</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingEventsList as $event)
                    <tr>
                        <td><strong>{{ $event->title }}</strong></td>
                        <td>{{ $event->organizer->name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }}</td>
                        <td>{{ $event->city }}</td>
                        <td>{{ number_format($event->price, 0) }} DH</td>
                        <td>
                            <div class="btn-group">
                                <form action="{{ route('admin.events.approve', $event->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-sm btn-validate">✓ Valider</button>
                                </form>
                                <form action="{{ route('admin.events.reject', $event->id) }}" method="POST" onsubmit="return confirm('Rejeter ?');">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-sm btn-reject">✗ Refuser</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p style="text-align:center;color:var(--text-dim);padding:20px;">Aucun événement en attente</p>
        @endif
    </div>
</section>

<section class="cards-section">
    <div class="cards-grid">
        <div class="info-card">
            <h4>👥 Nouveaux membres</h4>
            <div class="user-list">
                @foreach($recentMembers as $member)
                <div class="user-item">
                    <div class="user-info">
                        <div class="user-name">{{ $member->name }}</div>
                        <div class="user-email">{{ $member->email }}</div>
                    </div>
                    <form action="{{ route('admin.members.store', $member->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-sm {{ $member->is_active ? 'btn-ban' : 'btn-validate' }}">
                            {{ $member->is_active ? '🚫' : '🔓' }}
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>

        <div class="info-card">
            <h4>🏢 Nouveaux organisateurs</h4>
            <div class="user-list">
                @foreach($recentOrganizers as $organizer)
                <div class="user-item">
                    <div class="user-info">
                        <div class="user-name">{{ $organizer->name }}</div>
                        <div class="user-email">{{ $organizer->email }}</div>
                    </div>
                    <form action="{{ route('admin.organizers.store', $organizer->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-sm {{ $organizer->is_active ? 'btn-ban' : 'btn-validate' }}">
                            {{ $organizer->is_active ? '🚫' : '🔓' }}
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>

                <div class="info-card">
            <h4>📊 Ce mois</h4>
            <div style="display:flex;flex-direction:column;gap:12px;padding-top:8px;">
                <div style="display:flex;justify-content:space-between;padding:10px;background:rgba(94,205,130,0.05);border-radius:6px;">
                    <span style="font-size:12px;color:var(--text-dim);">Actifs</span>
                    <span style="color:#5ecd82;font-weight:600;">{{ $activeMembers }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:10px;background:rgba(74,144,226,0.05);border-radius:6px;">
                    <span style="font-size:12px;color:var(--text-dim);">Validés</span>
                    <span style="color:#4a90;font-weight:600;">{{ $validatedEvents }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:10px;background:rgba(255,193,7,0.05);border-radius:6px;">
                    <span style="font-size:12px;color:var(--text-dim);">Suspendus</span>
                    <span style="color:#ffc107;font-weight:600;">{{ $bannedUsers }}</span>
                </div>
            </div>