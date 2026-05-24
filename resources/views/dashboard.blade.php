@extends('layouts.user-app')

@section('title', 'Dashboard')
@section('breadcrumb', 'User / Beranda')

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <h3 class="text-lg font-semibold" style="font-size: 1.2rem; margin-bottom: 0.5rem; color: #fff;">
                Selamat datang kembali, {{ auth()->user()->name }}! 🎬
            </h3>
            <p style="color: var(--muted); font-size: 0.9rem;">
                Di sini Anda dapat melihat aktivitas Anda, mengatur profil, serta mengelola film-film yang ingin Anda tonton atau review.
            </p>
        </div>
    </div>

    <!-- Stat Cards Placeholder -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(124,58,237,0.1); color: #a78bfa;">
                📑
            </div>
            <div class="stat-info">
                <div class="value">0</div>
                <div class="label">Film di Watchlist</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(16,185,129,0.1); color: #6ee7b7;">
                ⭐
            </div>
            <div class="stat-info">
                <div class="value">0</div>
                <div class="label">Total Review Saya</div>
            </div>
        </div>
    </div>
@endsection
