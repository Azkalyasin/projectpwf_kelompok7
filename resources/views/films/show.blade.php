@extends('layouts.user-app')

@section('title', $film->judul)
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" style="color: var(--muted); text-decoration: none;">User</a> / 
    <a href="{{ route('dashboard') }}" style="color: var(--muted); text-decoration: none;">Film</a> / 
    <span>{{ $film->judul }}</span>
@endsection

@push('styles')
<style>
    /* ── Detail Layout ── */
    .detail-grid {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
    }

    .poster-sidebar {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .detail-poster {
        width: 100%;
        aspect-ratio: 2 / 3;
        object-fit: cover;
        border-radius: 16px;
        border: 1px solid var(--border);
        box-shadow: 0 8px 16px -4px rgba(0, 0, 0, 0.4);
    }

    .detail-poster-placeholder {
        width: 100%;
        aspect-ratio: 2 / 3;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--surface), #121216);
        border-radius: 16px;
        border: 1px solid var(--border);
        color: var(--muted);
    }

    .watchlist-btn {
        width: 100%;
        padding: 0.75rem;
        justify-content: center;
        font-weight: 600;
        border-radius: 10px;
    }

    .info-main {
        display: flex;
        flex-direction: column;
    }

    .movie-header {
        border-bottom: 1px solid var(--border);
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .movie-title {
        font-size: 2.25rem;
        font-weight: 700;
        color: #fff;
        line-height: 1.2;
        margin-bottom: 0.75rem;
    }

    .movie-meta-row {
        display: flex;
        gap: 1.25rem;
        flex-wrap: wrap;
        align-items: center;
        font-size: 0.9rem;
        color: var(--muted);
    }

    .movie-genres-row {
        display: flex;
        gap: 0.4rem;
        margin-top: 0.75rem;
    }

    .rating-hero {
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 0.75rem 1.25rem;
        display: inline-flex;
        align-items: center;
        gap: 1rem;
        margin-top: 1rem;
    }

    .rating-hero .stars {
        font-size: 1.5rem;
        color: #fbbf24;
    }

    .rating-hero .value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fff;
    }

    .rating-hero .count {
        font-size: 0.8rem;
        color: var(--muted);
    }

    .section-title {
        font-size: 1.15rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 1rem;
        border-left: 3px solid var(--accent);
        padding-left: 0.75rem;
    }

    .synopsis {
        line-height: 1.6;
        color: #d1d5db;
        font-size: 0.95rem;
        margin-bottom: 2rem;
    }

    /* ── Trailer Embed ── */
    .trailer-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 ratio */
        height: 0;
        overflow: hidden;
        border-radius: 14px;
        border: 1px solid var(--border);
        background: #000;
        margin-bottom: 2.5rem;
    }

    .trailer-container iframe {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        border: 0;
    }

    /* ── Star Input ── */
    .star-rating-input {
        display: flex;
        gap: 0.4rem;
        flex-direction: row-reverse;
        justify-content: flex-end;
        margin-bottom: 0.5rem;
    }

    .star-rating-input input {
        display: none;
    }

    .star-rating-input label {
        font-size: 2rem;
        color: var(--muted);
        cursor: pointer;
        transition: color 0.15s;
    }

    .star-rating-input label:hover,
    .star-rating-input label:hover ~ label,
    .star-rating-input input:checked ~ label {
        color: #fbbf24;
    }

    /* ── Reviews ── */
    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .review-item {
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 1.25rem;
        display: flex;
        gap: 1rem;
    }

    .review-avatar {
        width: 44px; height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), var(--accent2));
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
        font-size: 1.05rem;
        overflow: hidden;
    }

    .review-avatar img {
        width: 100%; height: 100%; object-fit: cover;
    }

    .review-content {
        flex: 1;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.4rem;
    }

    .review-user-name {
        font-weight: 600;
        color: #fff;
        font-size: 0.95rem;
    }

    .review-date {
        font-size: 0.75rem;
        color: var(--muted);
    }

    .review-stars {
        color: #fbbf24;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
    }

    .review-text {
        font-size: 0.9rem;
        line-height: 1.5;
        color: #d1d5db;
    }

    /* ── Similar Films ── */
    .similar-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 1.25rem;
    }

    .similar-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s;
    }

    .similar-card:hover {
        transform: translateY(-4px);
        border-color: rgba(124,58,237,0.3);
    }

    .similar-poster {
        aspect-ratio: 2 / 3;
        object-fit: cover;
        width: 100%;
        background: var(--surface2);
    }

    .similar-info {
        padding: 0.75rem;
    }

    .similar-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: #fff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .similar-year {
        font-size: 0.75rem;
        color: var(--muted);
    }
</style>
@endpush

@section('content')
    <div class="detail-grid">
        <!-- Sidebar: Poster & Watchlist -->
        <div class="poster-sidebar">
            @if($film->poster)
                <img src="{{ Storage::url($film->poster) }}" alt="{{ $film->judul }}" class="detail-poster">
            @else
                <div class="detail-poster-placeholder">
                    <span style="font-size: 3rem; margin-bottom: 0.5rem;">🎬</span>
                    <span style="font-size: 0.9rem; font-weight: 600; text-transform: uppercase; text-align: center; padding: 1rem;">
                        {{ $film->judul }}
                    </span>
                </div>
            @endif

            <!-- Watchlist Toggle Button -->
            <form action="{{ route('watchlist.toggle', $film->slug) }}" method="POST">
                @csrf
                @if($inWatchlist)
                    <button type="submit" class="btn btn-danger watchlist-btn">
                        🔖 Hapus dari Watchlist
                    </button>
                @else
                    <button type="submit" class="btn btn-primary watchlist-btn">
                        🔖 Tambah ke Watchlist
                    </button>
                @endif
            </form>
        </div>

        <!-- Main Info -->
        <div class="info-main">
            <div class="movie-header">
                <h1 class="movie-title">{{ $film->judul }}</h1>
                
                <div class="movie-meta-row">
                    <span>📅 {{ $film->tahun_rilis ?? 'N/A' }}</span>
                    <span>⏱️ {{ $film->durasi ? $film->durasi . ' menit' : 'N/A' }}</span>
                    <span>🎬 Sutradara: <strong>{{ $film->sutradara ?? 'N/A' }}</strong></span>
                </div>

                <div class="movie-genres-row">
                    @foreach($film->genres as $genre)
                        <span class="film-genre-tag">{{ $genre->nama_genre }}</span>
                    @endforeach
                </div>

                <!-- Rating Section -->
                <div class="rating-hero">
                    <div class="stars">
                        @php
                            $fullStars = floor($averageRating);
                            $emptyStars = 5 - $fullStars;
                        @endphp
                        {!! str_repeat('★', $fullStars) !!}{!! str_repeat('☆', $emptyStars) !!}
                    </div>
                    <div>
                        <div class="value">
                            {{ $averageRating > 0 ? number_format($averageRating, 1) : 'Belum dinilai' }}
                        </div>
                        <div class="count">{{ $reviews->count() }} Reviewer</div>
                    </div>
                </div>
            </div>

            <!-- Sinopsis -->
            <h3 class="section-title">Sinopsis</h3>
            <div class="synopsis">
                {!! nl2br(e($film->sinopsis ?? 'Sinopsis film ini belum tersedia.')) !!}
            </div>

            <!-- YouTube Trailer Embed -->
            @if($film->trailer)
                @php
                    // Parse YouTube URL to get video ID for embedding
                    $embedUrl = null;
                    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $film->trailer, $match)) {
                        $embedUrl = "https://www.youtube.com/embed/" . $match[1];
                    }
                @endphp

                @if($embedUrl)
                    <h3 class="section-title">Trailer Resmi</h3>
                    <div class="trailer-container">
                        <iframe src="{{ $embedUrl }}" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                @else
                    <h3 class="section-title">Trailer</h3>
                    <a href="{{ $film->trailer }}" target="_blank" class="btn btn-secondary" style="margin-bottom: 2rem; display: inline-flex; align-items: center; gap: 0.5rem;">
                        📺 Tonton Trailer di YouTube External ↗
                    </a>
                @endif
            @endif

            <!-- Form Tulis Review -->
            <div class="card mb-4" style="background: var(--surface2);">
                <div class="card-header" style="border-bottom: 1px solid var(--border);">
                    <h3 style="font-size: 1.1rem; color: #fff;">
                        {{ $hasReviewed ? '✏️ Perbarui Review Anda' : '⭐ Tulis Review & Rating Anda' }}
                    </h3>
                </div>
                <div class="card-body">
                    @if($hasReviewed)
                        <div class="alert alert-success" style="padding: 0.6rem 0.8rem; font-size: 0.8rem; margin-bottom: 1rem; background: rgba(245,158,11,0.1); border-color: rgba(245,158,11,0.25); color: #fcd34d;">
                            💡 Anda sudah pernah menulis review untuk film ini. Mengisi form di bawah akan memperbarui review sebelumnya.
                        </div>
                    @endif
                    <form action="{{ route('reviews.store', $film->slug) }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label class="form-label">Beri Rating Film:</label>
                            
                            <div class="star-rating-input">
                                <input type="radio" id="star5" name="rating" value="5" />
                                <label for="star5" title="5 Bintang">★</label>
                                <input type="radio" id="star4" name="rating" value="4" />
                                <label for="star4" title="4 Bintang">★</label>
                                <input type="radio" id="star3" name="rating" value="3" />
                                <label for="star3" title="3 Bintang">★</label>
                                <input type="radio" id="star2" name="rating" value="2" />
                                <label for="star2" title="2 Bintang">★</label>
                                <input type="radio" id="star1" name="rating" value="1" />
                                <label for="star1" title="1 Bintang">★</label>
                            </div>
                            @error('rating')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="komentar" class="form-label">Komentar / Review:</label>
                            <textarea name="komentar" id="komentar" rows="4" class="form-control" placeholder="Tuliskan ulasan Anda tentang film ini..."></textarea>
                            @error('komentar')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                    </form>
                </div>
            </div>

            <!-- Daftar Review -->
            <h3 class="section-title">Review & Ulasan Pengguna</h3>
            @if($reviews->count() > 0)
                <div class="reviews-list">
                    @foreach($reviews as $review)
                        <div class="review-item">
                            <div class="review-avatar">
                                @if($review->user->photo)
                                    <img src="{{ Storage::url($review->user->photo) }}" alt="Avatar">
                                @else
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                @endif
                            </div>
                            
                            <div class="review-content">
                                <div class="review-header">
                                    <div>
                                        <div class="review-user-name">
                                            {{ $review->user->name }}
                                            @if($review->user_id === auth()->id())
                                                <span class="badge badge-admin" style="font-size: 0.65rem; padding: 0.1rem 0.35rem; margin-left: 0.3rem;">Anda</span>
                                            @endif
                                        </div>
                                        <div class="review-stars">
                                            {!! str_repeat('★', $review->rating) !!}{!! str_repeat('☆', 5 - $review->rating) !!}
                                        </div>
                                    </div>
                                    
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <span class="review-date">{{ $review->created_at->diffForHumans() }}</span>
                                        @if($review->user_id === auth()->id())
                                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus review ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" style="padding: 0.2rem 0.4rem; font-size: 0.75rem;">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="review-text">
                                    {!! nl2br(e($review->komentar ?? 'Hanya memberikan rating bintang.')) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 2rem; text-align: center; color: var(--muted); font-size: 0.9rem;">
                    Belum ada ulasan untuk film ini. Jadilah yang pertama memberikan review!
                </div>
            @endif

            <!-- Similar Films -->
            @if($similarFilms->count() > 0)
                <h3 class="section-title" style="margin-top: 3rem;">Film Terkait</h3>
                <div class="similar-grid">
                    @foreach($similarFilms as $simFilm)
                        <a href="{{ route('films.show', $simFilm->slug) }}" class="similar-card">
                            @if($simFilm->poster)
                                <img src="{{ Storage::url($simFilm->poster) }}" alt="{{ $simFilm->judul }}" class="similar-poster">
                            @else
                                <div style="aspect-ratio: 2/3; display: flex; align-items: center; justify-content: center; background: var(--surface2); color: var(--muted); font-size: 1.5rem;">
                                    🎬
                                </div>
                            @endif
                            <div class="similar-info">
                                <div class="similar-title" title="{{ $simFilm->judul }}">{{ $simFilm->judul }}</div>
                                <div class="similar-year">{{ $simFilm->tahun_rilis ?? 'N/A' }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
