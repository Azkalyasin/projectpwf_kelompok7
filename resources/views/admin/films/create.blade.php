@extends('admin.layouts.app')

@section('title', 'Tambah Film')
@section('breadcrumb', 'Admin / Film / Tambah')

@section('content')
<div class="card" style="max-width: 800px;">
    <div class="card-header">
        <h3>Tambah Film Baru</h3>
        <a href="{{ route('admin.films.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.films.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid-2">
                <div class="form-group" style="grid-column: 1/-1;">
                    <label class="form-label">Judul Film <span style="color:#f87171">*</span></label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul') }}"
                           placeholder="Contoh: Avengers: Endgame" required>
                    @error('judul') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Sutradara</label>
                    <input type="text" name="sutradara" class="form-control" value="{{ old('sutradara') }}"
                           placeholder="Nama sutradara">
                    @error('sutradara') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Tahun Rilis</label>
                    <input type="number" name="tahun_rilis" class="form-control"
                           value="{{ old('tahun_rilis') }}" min="1900" max="{{ date('Y') + 2 }}"
                           placeholder="{{ date('Y') }}">
                    @error('tahun_rilis') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Durasi (menit)</label>
                    <input type="number" name="durasi" class="form-control"
                           value="{{ old('durasi') }}" min="1" placeholder="120">
                    @error('durasi') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Link Trailer (YouTube)</label>
                    <input type="url" name="trailer" class="form-control"
                           value="{{ old('trailer') }}" placeholder="https://youtube.com/watch?v=...">
                    @error('trailer') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group" style="grid-column: 1/-1;">
                    <label class="form-label">Sinopsis</label>
                    <textarea name="sinopsis" class="form-control" rows="4"
                              placeholder="Deskripsi cerita film...">{{ old('sinopsis') }}</textarea>
                    @error('sinopsis') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Poster Film</label>
                    <input type="file" name="poster" class="form-control" accept="image/*"
                           id="posterInput" onchange="previewPoster(this)">
                    <div id="posterPreview" style="margin-top:0.75rem; display:none;">
                        <img id="previewImg" src="" alt="Preview"
                             style="width:100px; border-radius:8px; border:1px solid var(--border);">
                    </div>
                    @error('poster') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Genre</label>
                    <div style="display:flex; flex-wrap:wrap; gap:0.5rem; padding:0.75rem; background:rgba(255,255,255,0.04); border:1px solid var(--border); border-radius:10px;">
                        @foreach($genres as $genre)
                        <label style="display:flex; align-items:center; gap:0.4rem; cursor:pointer; color:var(--text); font-size:0.875rem;">
                            <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                   {{ in_array($genre->id, old('genres', [])) ? 'checked' : '' }}
                                   style="accent-color: var(--accent);">
                            {{ $genre->nama_genre }}
                        </label>
                        @endforeach
                        @if($genres->isEmpty())
                            <span style="color:var(--muted); font-size:0.875rem;">Belum ada genre. <a href="{{ route('admin.genres.index') }}" style="color:#a78bfa">Tambah genre dulu</a></span>
                        @endif
                    </div>
                    @error('genres') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="display:flex; gap:0.75rem; margin-top:0.5rem;">
                <button type="submit" class="btn btn-primary">💾 Simpan Film</button>
                <a href="{{ route('admin.films.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewPoster(input) {
    const preview = document.getElementById('posterPreview');
    const img     = document.getElementById('previewImg');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { img.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
