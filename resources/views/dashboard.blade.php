@extends('layouts.user-app')

@section('title', 'Beranda')
@section('breadcrumb', 'User / Beranda')

@push('styles')
<style>
    /* ── Search & Filter ── */
    .filter-section {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 1.25rem;
        margin-bottom: 1.75rem;
    }

    .filter-form {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .search-input-group {
        flex: 1;
        min-width: 250px;
        position: relative;
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        font-size: 0.95rem;
    }

    .search-input-group .form-control {
        padding-left: 2.5rem;
    }

    .filter-select-group {
        width: 200px;
        min-width: 150px;
    }

    .filter-actions {
        display: flex;
        gap: 0.5rem;
    }

    /* ── Film Grid ── */
    .film-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .film-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s;
    }

    .film-card:hover {
        transform: translateY(-6px);
        border-color: rgba(124, 58, 237, 0.4);
        box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.5);
    }

    .film-poster-container {
        position: relative;
        aspect-ratio: 2 / 3;
        width: 100%;
        background: var(--surface2);
        overflow: hidden;
    }

    .film-poster {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .film-card:hover .film-poster {
        transform: scale(1.05);
    }

    .film-poster-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--surface2), #121216);
        color: var(--muted);
        text-align: center;
        padding: 1rem;
    }

    .film-poster-placeholder .icon {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        opacity: 0.6;
    }

    .film-rating-badge {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        background: rgba(15, 15, 19, 0.85);
        backdrop-filter: blur(8px);
        border: 1px solid var(--border);
        padding: 0.35rem 0.6rem;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.75rem;
        font-weight: 700;
        color: #fbbf24;
    }

    .film-info {
        padding: 1.1rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .film-genres {
        display: flex;
        gap: 0.3rem;
        flex-wrap: wrap;
        margin-bottom: 0.5rem;
    }

    .film-genre-tag {
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #a78bfa;
        background: rgba(124, 58, 237, 0.12);
        padding: 0.15rem 0.45rem;
        border-radius: 4px;
        letter-spacing: 0.02em;
    }

    .film-title {
        font-size: 1rem;
        font-weight: 600;
        color: #fff;
        line-height: 1.35;
        margin-bottom: 0.25rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 2.7rem;
    }

    .film-meta {
        font-size: 0.75rem;
        color: var(--muted);
        margin-bottom: 1rem;
        display: flex;
        justify-content: space-between;
    }

    .film-action-btn {
        margin-top: auto;
        text-align: center;
        width: 100%;
        justify-content: center;
        font-size: 0.8rem;
    }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
    }

    .empty-state .icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state h4 {
        color: #fff;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--muted);
        font-size: 0.9rem;
    }
</style>
@endpush

@section('content')
    <!-- Selamat Datang & Statistik -->
    <div class="card mb-4">
        <div class="card-body" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h3 class="text-lg font-semibold" style="font-size: 1.3rem; margin-bottom: 0.3rem; color: #fff;">
                    Selamat datang kembali, {{ auth()->user()->name }}! 🎬
                </h3>
                <p style="color: var(--muted); font-size: 0.9rem;">
                    Jelajahi dan temukan review film favorit Anda, kelola watchlist, serta bagikan opini Anda.
                </p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <div class="stat-card" style="margin-bottom: 0; padding: 0.8rem 1.2rem; background: var(--surface2);">
                    <div class="stat-icon" style="background: rgba(124,58,237,0.1); color: #a78bfa; width: 38px; height: 38px; font-size: 1.1rem; border-radius: 8px;">
                        📑
                    </div>
                    <div class="stat-info">
                        <div class="value" style="font-size: 1.2rem;">{{ $watchlistCount }}</div>
                        <div class="label" style="font-size: 0.7rem; margin-top: 0;">Watchlist</div>
                    </div>
                </div>
                <div class="stat-card" style="margin-bottom: 0; padding: 0.8rem 1.2rem; background: var(--surface2);">
                    <div class="stat-icon" style="background: rgba(16,185,129,0.1); color: #6ee7b7; width: 38px; height: 38px; font-size: 1.1rem; border-radius: 8px;">
                        ⭐
                    </div>
                    <div class="stat-info">
                        <div class="value" style="font-size: 1.2rem;">{{ $reviewCount }}</div>
                        <div class="label" style="font-size: 0.7rem; margin-top: 0;">Review</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pencarian & Filter -->
    <div class="filter-section">
        <form action="{{ route('dashboard') }}" method="GET" class="filter-form">
            <div class="search-input-group">
                <span class="search-icon">🔍</span>
                <input type="text" name="search" class="form-control" placeholder="Cari judul film atau sutradara..." value="{{ request('search') }}">
            </div>
            
            <div class="filter-select-group">
                <select name="genre" class="form-control">
                    <option value="">Semua Genre</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                            {{ $genre->nama_genre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">Filter</button>
                @if(request('search') || request('genre'))
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Grid Film -->
    @if(!$isFiltering)
        @if($trendingFilms->count() > 0)
            <div class="mb-5">
                <h4 style="color: #fff; font-size: 1.2rem; font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 1.3rem;">🔥</span> Trending Movies
                </h4>
                <div class="film-grid">
                    @foreach($trendingFilms as $film)
                        <div class="film-card">
                            <div class="film-poster-container">
                                @if($film->poster)
                                    <img src="{{ Storage::url($film->poster) }}" alt="{{ $film->judul }}" class="film-poster">
                                @else
                                    <div class="film-poster-placeholder">
                                        <span class="icon">🎬</span>
                                        <span style="font-size: 0.75rem; font-weight: 500; text-transform: uppercase;">{{ $film->judul }}</span>
                                    </div>
                                @endif
                                
                                <!-- Rating Rata-rata -->
                                @php
                                    $avgRating = $film->averageRating();
                                @endphp
                                <div class="film-rating-badge">
                                    <span>⭐</span>
                                    <span>{{ $avgRating > 0 ? number_format($avgRating, 1) : '-' }}</span>
                                </div>
                            </div>

                            <div class="film-info">
                                <div class="film-genres">
                                    @forelse($film->genres as $genre)
                                        <span class="film-genre-tag">{{ $genre->nama_genre }}</span>
                                    @empty
                                        <span class="film-genre-tag" style="color: var(--muted); background: rgba(255,255,255,0.05);">Uncategorized</span>
                                    @endforelse
                                </div>
                                
                                <h4 class="film-title" title="{{ $film->judul }}">{{ $film->judul }}</h4>
                                
                                <div class="film-meta">
                                    <span>📅 {{ $film->tahun_rilis ?? 'N/A' }}</span>
                                    <span>⏱️ {{ $film->durasi ? $film->durasi . 'm' : 'N/A' }}</span>
                                </div>

                                <a href="{{ route('films.show', $film->slug) }}" class="btn btn-secondary btn-sm film-action-btn">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($topRatingFilms->count() > 0)
            <div class="mb-5">
                <h4 style="color: #fff; font-size: 1.2rem; font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 1.3rem;">🏆</span> Top Rating Movies
                </h4>
                <div class="film-grid">
                    @foreach($topRatingFilms as $film)
                        <div class="film-card">
                            <div class="film-poster-container">
                                @if($film->poster)
                                    <img src="{{ Storage::url($film->poster) }}" alt="{{ $film->judul }}" class="film-poster">
                                @else
                                    <div class="film-poster-placeholder">
                                        <span class="icon">🎬</span>
                                        <span style="font-size: 0.75rem; font-weight: 500; text-transform: uppercase;">{{ $film->judul }}</span>
                                    </div>
                                @endif
                                
                                <!-- Rating Rata-rata -->
                                @php
                                    $avgRating = $film->averageRating();
                                @endphp
                                <div class="film-rating-badge">
                                    <span>⭐</span>
                                    <span>{{ $avgRating > 0 ? number_format($avgRating, 1) : '-' }}</span>
                                </div>
                            </div>

                            <div class="film-info">
                                <div class="film-genres">
                                    @forelse($film->genres as $genre)
                                        <span class="film-genre-tag">{{ $genre->nama_genre }}</span>
                                    @empty
                                        <span class="film-genre-tag" style="color: var(--muted); background: rgba(255,255,255,0.05);">Uncategorized</span>
                                    @endforelse
                                </div>
                                
                                <h4 class="film-title" title="{{ $film->judul }}">{{ $film->judul }}</h4>
                                
                                <div class="film-meta">
                                    <span>📅 {{ $film->tahun_rilis ?? 'N/A' }}</span>
                                    <span>⏱️ {{ $film->durasi ? $film->durasi . 'm' : 'N/A' }}</span>
                                </div>

                                <a href="{{ route('films.show', $film->slug) }}" class="btn btn-secondary btn-sm film-action-btn">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mb-4">
            <h4 style="color: #fff; font-size: 1.2rem; font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="font-size: 1.3rem;">🎞️</span> Semua Film
            </h4>
        </div>
    @else
        <div class="mb-4">
            <h4 style="color: #fff; font-size: 1.2rem; font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="font-size: 1.3rem;">🔍</span> Hasil Pencarian
            </h4>
        </div>
    @endif

    @if($films->count() > 0)
        <div class="film-grid">
            @foreach($films as $film)
                <div class="film-card">
                    <div class="film-poster-container">
                        @if($film->poster)
                            <img src="{{ Storage::url($film->poster) }}" alt="{{ $film->judul }}" class="film-poster">
                        @else
                            <div class="film-poster-placeholder">
                                <span class="icon">🎬</span>
                                <span style="font-size: 0.75rem; font-weight: 500; text-transform: uppercase;">{{ $film->judul }}</span>
                            </div>
                        @endif
                        
                        <!-- Rating Rata-rata -->
                        @php
                            $avgRating = $film->averageRating();
                        @endphp
                        <div class="film-rating-badge">
                            <span>⭐</span>
                            <span>{{ $avgRating > 0 ? number_format($avgRating, 1) : '-' }}</span>
                        </div>
                    </div>

                    <div class="film-info">
                        <div class="film-genres">
                            @forelse($film->genres as $genre)
                                <span class="film-genre-tag">{{ $genre->nama_genre }}</span>
                            @empty
                                <span class="film-genre-tag" style="color: var(--muted); background: rgba(255,255,255,0.05);">Uncategorized</span>
                            @endforelse
                        </div>
                        
                        <h4 class="film-title" title="{{ $film->judul }}">{{ $film->judul }}</h4>
                        
                        <div class="film-meta">
                            <span>📅 {{ $film->tahun_rilis ?? 'N/A' }}</span>
                            <span>⏱️ {{ $film->durasi ? $film->durasi . 'm' : 'N/A' }}</span>
                        </div>

                        <a href="{{ route('films.show', $film->slug) }}" class="btn btn-secondary btn-sm film-action-btn">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $films->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="icon">🎬</div>
            <h4>Tidak Ada Film Ditemukan</h4>
            <p>Cobalah mengganti kata kunci pencarian atau filter genre Anda.</p>
            @if(request('search') || request('genre'))
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm" style="margin-top: 1rem;">Tampilkan Semua Film</a>
            @endif
        </div>
    @endif
@endsection
