@extends('layouts.user-app')

@section('title', 'Watchlist Saya')
@section('breadcrumb', 'User / Koleksi / Watchlist')

@push('styles')
<style>
    .watchlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .watchlist-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s, border-color 0.2s;
    }

    .watchlist-card:hover {
        transform: translateY(-4px);
        border-color: rgba(124, 58, 237, 0.4);
    }

    .poster-container {
        position: relative;
        aspect-ratio: 2 / 3;
        width: 100%;
        background: var(--surface2);
    }

    .poster-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .poster-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--surface2);
        color: var(--muted);
        font-size: 1.5rem;
    }

    .card-info {
        padding: 1.1rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .genres {
        display: flex;
        gap: 0.3rem;
        flex-wrap: wrap;
        margin-bottom: 0.5rem;
    }

    .genre-tag {
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #a78bfa;
        background: rgba(124, 58, 237, 0.12);
        padding: 0.15rem 0.45rem;
        border-radius: 4px;
    }

    .movie-title {
        font-size: 1rem;
        font-weight: 600;
        color: #fff;
        line-height: 1.35;
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .meta {
        font-size: 0.75rem;
        color: var(--muted);
        margin-bottom: 1rem;
    }

    .actions {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-top: auto;
    }

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
        margin-bottom: 1.5rem;
    }
</style>
@endpush

@section('content')
    <div style="margin-bottom: 1.5rem;">
        <h3 style="font-size: 1.25rem; font-weight: 600; color: #fff;">Daftar Film yang Ingin Ditonton</h3>
        <p style="color: var(--muted); font-size: 0.9rem;">Simpan dan kelola film-film favorit Anda yang berencana untuk ditonton.</p>
    </div>

    @if($watchlists->count() > 0)
        <div class="watchlist-grid">
            @foreach($watchlists as $watchlist)
                @php $film = $watchlist->film; @endphp
                <div class="watchlist-card">
                    <div class="poster-container">
                        @if($film->poster)
                            <img src="{{ Storage::url($film->poster) }}" alt="{{ $film->judul }}" class="poster-img">
                        @else
                            <div class="poster-placeholder">🎬</div>
                        @endif
                        
                        @php
                            $avgRating = $film->averageRating();
                        @endphp
                        <div style="position: absolute; top: 0.75rem; right: 0.75rem; background: rgba(15,15,19,0.85); backdrop-filter: blur(8px); border: 1px solid var(--border); padding: 0.3rem 0.5rem; border-radius: 8px; font-size: 0.7rem; font-weight: 700; color: #fbbf24; display: flex; align-items: center; gap: 0.25rem;">
                            <span>⭐</span>
                            <span>{{ $avgRating > 0 ? number_format($avgRating, 1) : '-' }}</span>
                        </div>
                    </div>

                    <div class="card-info">
                        <div class="genres">
                            @foreach($film->genres as $genre)
                                <span class="genre-tag">{{ $genre->nama_genre }}</span>
                            @endforeach
                        </div>
                        
                        <h4 class="movie-title" title="{{ $film->judul }}">{{ $film->judul }}</h4>
                        
                        <div class="meta">
                            <span>📅 {{ $film->tahun_rilis ?? 'N/A' }}</span> &bull; 
                            <span>⏱️ {{ $film->durasi ? $film->durasi . 'm' : 'N/A' }}</span>
                        </div>

                        <div class="actions">
                            <a href="{{ route('films.show', $film->slug) }}" class="btn btn-secondary btn-sm" style="justify-content: center; width: 100%;">
                                Detail Film
                            </a>
                            <form action="{{ route('watchlist.toggle', $film->slug) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" style="justify-content: center; width: 100%;">
                                    🗑️ Hapus dari Watchlist
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="icon">📑</div>
            <h4>Watchlist Anda Kosong</h4>
            <p>Anda belum menambahkan film apa pun ke daftar watchlist Anda.</p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary">Cari Film Menarik</a>
        </div>
    @endif
@endsection
