@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Admin / Dashboard')

@section('content')

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(124,58,237,0.15);">🎞️</div>
        <div class="stat-info">
            <div class="value">{{ $stats['total_film'] }}</div>
            <div class="label">Total Film</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(236,72,153,0.15);">🏷️</div>
        <div class="stat-info">
            <div class="value">{{ $stats['total_genre'] }}</div>
            <div class="label">Total Genre</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(16,185,129,0.15);">👥</div>
        <div class="stat-info">
            <div class="value">{{ $stats['total_user'] }}</div>
            <div class="label">Total User</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(245,158,11,0.15);">💬</div>
        <div class="stat-info">
            <div class="value">{{ $stats['total_review'] }}</div>
            <div class="label">Total Review</div>
        </div>
    </div>
</div>

<div class="grid-2" style="gap: 1.25rem;">

    {{-- Film Terbaru --}}
    <div class="card">
        <div class="card-header">
            <h3>🎞️ Film Terbaru</h3>
            <a href="{{ route('admin.films.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Tahun</th>
                        <th>Genre</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestFilms as $film)
                    <tr>
                        <td>{{ $film->judul }}</td>
                        <td>{{ $film->tahun_rilis ?? '-' }}</td>
                        <td>
                            @foreach($film->genres->take(2) as $genre)
                                <span class="badge badge-user">{{ $genre->nama_genre }}</span>
                            @endforeach
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align:center; color: var(--muted); padding: 2rem;">
                            Belum ada film
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Review Terbaru --}}
    <div class="card">
        <div class="card-header">
            <h3>💬 Review Terbaru</h3>
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Film</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestReviews as $review)
                    <tr>
                        <td>{{ $review->user->name ?? '-' }}</td>
                        <td>{{ Str::limit($review->film->judul ?? '-', 20) }}</td>
                        <td class="stars">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align:center; color: var(--muted); padding: 2rem;">
                            Belum ada review
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
