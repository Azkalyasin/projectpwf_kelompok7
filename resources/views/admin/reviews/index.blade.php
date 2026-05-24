@extends('admin.layouts.app')

@section('title', 'Kelola Review')
@section('breadcrumb', 'Admin / Reviews')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Semua Review <span style="color:var(--muted); font-weight:400">({{ $reviews->total() }})</span></h3>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Film</th>
                    <th>Rating</th>
                    <th>Komentar</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $i => $review)
                <tr>
                    <td style="color:var(--muted)">{{ $reviews->firstItem() + $i }}</td>
                    <td>
                        <div style="font-weight:500">{{ $review->user->name ?? 'User dihapus' }}</div>
                        <div style="font-size:0.75rem; color:var(--muted)">{{ $review->user->email ?? '' }}</div>
                    </td>
                    <td>
                        <div style="font-weight:500">{{ $review->film->judul ?? 'Film dihapus' }}</div>
                    </td>
                    <td>
                        <span class="stars" style="font-size:0.9rem;">
                            {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                        </span>
                        <span style="font-size:0.75rem; color:var(--muted);">({{ $review->rating }}/5)</span>
                    </td>
                    <td style="max-width:250px;">
                        <span style="color:var(--muted); font-size:0.875rem;">
                            {{ $review->komentar ? Str::limit($review->komentar, 80) : '-' }}
                        </span>
                    </td>
                    <td style="color:var(--muted); white-space:nowrap;">
                        {{ $review->created_at->format('d M Y') }}
                    </td>
                    <td>
                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST"
                              onsubmit="return confirm('Hapus review ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">🗑️ Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; color:var(--muted); padding:3rem;">
                        Belum ada review
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($reviews->hasPages())
        <div style="padding:1rem 1.5rem;">{{ $reviews->links() }}</div>
    @endif
</div>
@endsection
