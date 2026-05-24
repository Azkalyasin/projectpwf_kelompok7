@extends('admin.layouts.app')

@section('title', 'Kelola Genre')
@section('breadcrumb', 'Admin / Genre')

@section('content')
<div style="display:grid; grid-template-columns: 320px 1fr; gap:1.25rem; align-items:start;">

    {{-- Form Tambah Genre --}}
    <div class="card">
        <div class="card-header"><h3>+ Tambah Genre</h3></div>
        <div class="card-body">
            <form action="{{ route('admin.genres.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama Genre</label>
                    <input type="text" name="nama_genre" class="form-control"
                           value="{{ old('nama_genre') }}" placeholder="Contoh: Action, Romance..." required>
                    @error('nama_genre') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;">Tambah Genre</button>
            </form>
        </div>
    </div>

    {{-- Daftar Genre --}}
    <div class="card">
        <div class="card-header">
            <h3>Daftar Genre <span style="color:var(--muted); font-weight:400">({{ $genres->total() }})</span></h3>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Genre</th>
                        <th>Jumlah Film</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($genres as $i => $genre)
                    <tr>
                        <td style="color:var(--muted)">{{ $genres->firstItem() + $i }}</td>
                        <td>
                            <form id="editForm{{ $genre->id }}" action="{{ route('admin.genres.update', $genre) }}" method="POST" style="display:none;">
                                @csrf @method('PUT')
                                <div style="display:flex; gap:0.5rem;">
                                    <input type="text" name="nama_genre" class="form-control"
                                           value="{{ $genre->nama_genre }}" style="padding:0.4rem 0.6rem; font-size:0.85rem;">
                                    <button type="submit" class="btn btn-primary btn-sm">✓</button>
                                    <button type="button" onclick="toggleEdit({{ $genre->id }})" class="btn btn-secondary btn-sm">✕</button>
                                </div>
                            </form>
                            <span id="genreName{{ $genre->id }}">{{ $genre->nama_genre }}</span>
                        </td>
                        <td><span class="badge badge-user">{{ $genre->films_count }} film</span></td>
                        <td>
                            <div style="display:flex; gap:0.4rem;">
                                <button onclick="toggleEdit({{ $genre->id }})" class="btn btn-warning btn-sm">✏️</button>
                                <form action="{{ route('admin.genres.destroy', $genre) }}" method="POST"
                                      onsubmit="return confirm('Hapus genre {{ $genre->nama_genre }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center; color:var(--muted); padding:2rem;">
                            Belum ada genre
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($genres->hasPages())
            <div style="padding:1rem 1.5rem;">{{ $genres->links() }}</div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function toggleEdit(id) {
    const form = document.getElementById('editForm' + id);
    const name = document.getElementById('genreName' + id);
    const isHidden = form.style.display === 'none';
    form.style.display = isHidden ? 'block' : 'none';
    name.style.display = isHidden ? 'none' : 'inline';
}
</script>
@endpush
@endsection
