@extends('admin.layouts.app')

@section('title', 'Kelola Film')
@section('breadcrumb', 'Admin / Film')

@section('topbar-actions')
    <a href="{{ route('admin.films.create') }}" class="btn btn-primary">+ Tambah Film</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Daftar Film <span style="color:var(--muted); font-weight:400">({{ $films->total() }})</span></h3>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Poster</th>
                    <th>Judul</th>
                    <th>Sutradara</th>
                    <th>Tahun</th>
                    <th>Genre</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($films as $i => $film)
                <tr>
                    <td style="color:var(--muted)">{{ $films->firstItem() + $i }}</td>
                    <td>
                        @if($film->poster)
                            <img src="{{ asset('storage/' . $film->poster) }}" class="poster-thumb" alt="{{ $film->judul }}">
                        @else
                            <div class="no-poster">🎬</div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:600">{{ $film->judul }}</div>
                        <div style="font-size:0.75rem; color:var(--muted)">{{ $film->durasi ? $film->durasi . ' menit' : '' }}</div>
                    </td>
                    <td>{{ $film->sutradara ?? '-' }}</td>
                    <td>{{ $film->tahun_rilis ?? '-' }}</td>
                    <td>
                        @foreach($film->genres as $genre)
                            <span class="badge badge-user">{{ $genre->nama_genre }}</span>
                        @endforeach
                    </td>
                    <td>
                        <div style="display:flex; gap:0.4rem;">
                            <a href="{{ route('admin.films.edit', $film) }}" class="btn btn-secondary btn-sm">✏️ Edit</a>
                            <form action="{{ route('admin.films.destroy', $film) }}" method="POST"
                                  onsubmit="return confirm('Hapus film ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; color:var(--muted); padding:3rem;">
                        Belum ada film. <a href="{{ route('admin.films.create') }}" style="color:#a78bfa">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($films->hasPages())
        <div style="padding:1rem 1.5rem;">
            {{ $films->links('pagination::simple-tailwind') }}
        </div>
    @endif
</div>
@endsection
