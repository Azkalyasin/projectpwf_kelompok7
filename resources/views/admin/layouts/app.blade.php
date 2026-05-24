<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — FilmKu Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-w: 250px;
            --bg:        #0f0f13;
            --surface:   #18181f;
            --surface2:  #1f1f28;
            --border:    rgba(255,255,255,0.07);
            --text:      #e5e7eb;
            --muted:     #6b7280;
            --accent:    #7c3aed;
            --accent2:   #ec4899;
            --success:   #10b981;
            --danger:    #ef4444;
            --warning:   #f59e0b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
        }

        .sidebar-logo {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-logo .icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .sidebar-logo span {
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
        }

        .sidebar-logo small {
            display: block;
            font-size: 0.7rem;
            color: var(--muted);
            font-weight: 400;
        }

        .sidebar-nav {
            padding: 1rem 0.75rem;
            flex: 1;
        }

        .nav-section {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            color: var(--muted);
            text-transform: uppercase;
            padding: 0.5rem 0.5rem 0.25rem;
            margin-top: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 0.75rem;
            border-radius: 10px;
            color: var(--muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 2px;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.05);
            color: var(--text);
        }

        .nav-link.active {
            background: rgba(124,58,237,0.15);
            color: #a78bfa;
        }

        .nav-link .nav-icon { font-size: 1.1rem; width: 20px; text-align: center; }

        .sidebar-footer {
            padding: 1rem 0.75rem;
            border-top: 1px solid var(--border);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem;
            border-radius: 10px;
        }

        .avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .user-info .name { font-size: 0.875rem; font-weight: 600; color: var(--text); }
        .user-info .role { font-size: 0.75rem; color: var(--muted); }

        .logout-form { margin-top: 0.5rem; }

        .btn-logout {
            width: 100%;
            padding: 0.6rem;
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.2);
            border-radius: 8px;
            color: #f87171;
            font-size: 0.85rem;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-logout:hover { background: rgba(239,68,68,0.2); }

        /* ── Main ── */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            padding: 1rem 1.75rem;
            border-bottom: 1px solid var(--border);
            background: var(--surface);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar h2 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff;
        }

        .topbar .breadcrumb {
            font-size: 0.8rem;
            color: var(--muted);
            margin-top: 2px;
        }

        .content { padding: 1.75rem; }

        /* ── Alerts ── */
        .alert {
            padding: 0.85rem 1.1rem;
            border-radius: 10px;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert-success {
            background: rgba(16,185,129,0.1);
            border: 1px solid rgba(16,185,129,0.25);
            color: #6ee7b7;
        }

        .alert-danger {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.25);
            color: #fca5a5;
        }

        /* ── Cards ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }

        .card-header {
            padding: 1.1rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header h3 { font-size: 1rem; font-weight: 600; color: #fff; }
        .card-body { padding: 1.5rem; }

        /* ── Stat Cards ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.4rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: transform 0.2s, border-color 0.2s;
        }

        .stat-card:hover { transform: translateY(-2px); border-color: rgba(124,58,237,0.3); }

        .stat-icon {
            width: 50px; height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .stat-info .value { font-size: 1.75rem; font-weight: 700; color: #fff; line-height: 1; }
        .stat-info .label { font-size: 0.8rem; color: var(--muted); margin-top: 0.3rem; }

        /* ── Tables ── */
        .table-wrapper { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        thead th {
            padding: 0.75rem 1rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--muted);
            border-bottom: 1px solid var(--border);
        }

        tbody td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--border);
            color: var(--text);
            vertical-align: middle;
        }

        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: rgba(255,255,255,0.02); }

        /* ── Badges ── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.65rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-admin   { background: rgba(124,58,237,0.15); color: #a78bfa; }
        .badge-user    { background: rgba(107,114,128,0.15); color: #9ca3af; }
        .badge-success { background: rgba(16,185,129,0.15); color: #6ee7b7; }
        .badge-warning { background: rgba(245,158,11,0.15); color: #fcd34d; }
        .badge-danger  { background: rgba(239,68,68,0.15); color: #fca5a5; }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.55rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary { background: var(--accent); color: white; }
        .btn-primary:hover { background: #6d28d9; }

        .btn-secondary {
            background: rgba(255,255,255,0.06);
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover { background: rgba(255,255,255,0.1); }

        .btn-danger { background: rgba(239,68,68,0.15); color: #f87171; border: 1px solid rgba(239,68,68,0.2); }
        .btn-danger:hover { background: rgba(239,68,68,0.25); }

        .btn-sm { padding: 0.35rem 0.7rem; font-size: 0.8rem; }
        .btn-warning { background: rgba(245,158,11,0.15); color: #fcd34d; border: 1px solid rgba(245,158,11,0.2); }
        .btn-warning:hover { background: rgba(245,158,11,0.25); }

        /* ── Forms ── */
        .form-group { margin-bottom: 1.25rem; }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #9ca3af;
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.7rem 1rem;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-control:focus { border-color: var(--accent); }

        select.form-control option { background: #1f1f28; }

        .form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.3rem; }

        /* ── Pagination ── */
        .pagination { display: flex; gap: 0.35rem; justify-content: center; margin-top: 1.25rem; }

        .pagination a, .pagination span {
            padding: 0.45rem 0.85rem;
            border-radius: 8px;
            font-size: 0.875rem;
            text-decoration: none;
            color: var(--muted);
            border: 1px solid var(--border);
            transition: all 0.2s;
        }

        .pagination a:hover { background: rgba(124,58,237,0.1); color: #a78bfa; }
        .pagination .active span { background: var(--accent); color: white; border-color: var(--accent); }

        /* ── Poster thumbnail ── */
        .poster-thumb {
            width: 42px; height: 60px;
            object-fit: cover;
            border-radius: 6px;
            background: var(--surface2);
        }

        .no-poster {
            width: 42px; height: 60px;
            background: var(--surface2);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            font-size: 1.2rem;
        }

        /* ── Stars ── */
        .stars { color: #fbbf24; }

        /* ── Grid 2 col ── */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        @media (max-width: 640px) { .grid-2 { grid-template-columns: 1fr; } }

        /* ── Search bar ── */
        .search-bar {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .search-bar .form-control { max-width: 300px; }
    </style>
    @stack('styles')
</head>
<body>

{{-- ──────────── SIDEBAR ──────────── --}}
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="icon">🎬</div>
        <div>
            <span>FilmKu</span>
            <small>Admin Panel</small>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">Menu</div>

        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">📊</span> Dashboard
        </a>

        <div class="nav-section">Konten</div>

        <a href="{{ route('admin.films.index') }}"
           class="nav-link {{ request()->routeIs('admin.films.*') ? 'active' : '' }}">
            <span class="nav-icon">🎞️</span> Film
        </a>

        <a href="{{ route('admin.genres.index') }}"
           class="nav-link {{ request()->routeIs('admin.genres.*') ? 'active' : '' }}">
            <span class="nav-icon">🏷️</span> Genre
        </a>

        <div class="nav-section">Manajemen</div>

        <a href="{{ route('admin.users.index') }}"
           class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <span class="nav-icon">👥</span> Users
        </a>

        <a href="{{ route('admin.reviews.index') }}"
           class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <span class="nav-icon">💬</span> Reviews
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div class="name">{{ auth()->user()->name }}</div>
                <div class="role">Administrator</div>
            </div>
        </div>
        <form class="logout-form" method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">🚪 Keluar</button>
        </form>
    </div>
</aside>

{{-- ──────────── MAIN ──────────── --}}
<div class="main">
    <div class="topbar">
        <div>
            <h2>@yield('title', 'Dashboard')</h2>
            <div class="breadcrumb">@yield('breadcrumb', 'Admin / Dashboard')</div>
        </div>
        @yield('topbar-actions')
    </div>

    <div class="content">
        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">❌ {{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>

@stack('scripts')
</body>
</html>
