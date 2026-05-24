@extends('layouts.user-app')

@section('title', 'Review Saya')
@section('breadcrumb', 'User / Koleksi / Review Saya')

@push('styles')
<style>
    .reviews-grid {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .my-review-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 1.5rem;
        display: flex;
        gap: 1.5rem;
    }

    @media (max-width: 640px) {
        .my-review-card {
            flex-direction: column;
            gap: 1rem;
        }
    }

    .movie-poster-sm {
        width: 100px;
        aspect-ratio: 2 / 3;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border);
        flex-shrink: 0;
    }

    .movie-poster-placeholder-sm {
        width: 100px;
        aspect-ratio: 2 / 3;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--surface2);
        color: var(--muted);
        border-radius: 8px;
        border: 1px solid var(--border);
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .review-body-section {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .movie-link {
        font-size: 1.15rem;
        font-weight: 600;
        color: #fff;
        text-decoration: none;
        transition: color 0.15s;
    }

    .movie-link:hover {
        color: var(--accent);
    }

    .rating-stars {
        color: #fbbf24;
        font-size: 0.9rem;
        margin: 0.35rem 0;
    }

    .comment-text {
        color: #d1d5db;
        font-size: 0.925rem;
        line-height: 1.5;
        margin-top: 0.5rem;
        margin-bottom: 1rem;
    }

    .meta-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        font-size: 0.775rem;
        color: var(--muted);
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
        <h3 style="font-size: 1.25rem; font-weight: 600; color: #fff;">Daftar Review & Ulasan Anda</h3>
        <p style="color: var(--muted); font-size: 0.9rem;">Kelola riwayat ulasan film yang telah Anda berikan rating dan komentar.</p>
    </div>

    @if($reviews->count() > 0)
        <div class="reviews-grid">
            @foreach($reviews as $review)
                @php $film = $review->film; @endphp
                <div class="my-review-card">
                    @if($film->poster)
                        <img src="{{ Storage::url($film->poster) }}" alt="{{ $film->judul }}" class="movie-poster-sm">
                    @else
                        <div class="movie-poster-placeholder-sm">🎬</div>
                    @endif

                    <div class="review-body-section">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.5rem;">
                            <div>
                                <a href="{{ route('films.show', $film->slug) }}" class="movie-link">
                                    {{ $film->judul }}
                                </a>
                                <div class="rating-stars">
                                    {!! str_repeat('★', $review->rating) !!}{!! str_repeat('☆', 5 - $review->rating) !!}
                                    <span style="color: var(--muted); font-size: 0.8rem; margin-left: 0.3rem;">({{ $review->rating }}/5)</span>
                                </div>
                            </div>
                            
                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus review ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    🗑️ Hapus Ulasan
                                </button>
                            </form>
                        </div>

                        <div class="comment-text">
                            {!! nl2br(e($review->komentar ?? 'Hanya memberikan rating bintang.')) !!}
                        </div>

                        <div class="meta-footer">
                            <span>📅 Ditulis pada {{ $review->created_at->format('d M Y, H:i') }} ({{ $review->created_at->diffForHumans() }})</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="icon">⭐</div>
            <h4>Belum Ada Review</h4>
            <p>Anda belum menulis review atau memberikan rating untuk film apa pun.</p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary">Tulis Review Pertama Anda</a>
        </div>
    @endif
@endsection
