@extends('admin.layouts.app')

@section('title', 'Edit Film')
@section('breadcrumb', 'Admin / Film / Edit')

@section('content')
<div class="card" style="max-width: 800px;">
    <div class="card-header">
        <h3>Edit Film: {{ $film->judul }}</h3>
        <a href="{{ route('admin.films.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.films.update', $film) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="grid-2">
                <div class="form-group" style="grid-column: 1/-1;">
                    <label class="form-label">Judul Film <span style="color:#f87171">*</span></label>
                    <input type="text" name="judul" class="form-control"
                           value="{{ old('judul', $film->judul) }}" required>
                    @error('judul') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Sutradara</label>
                    <input type="text" name="sutradara" class="form-control"
                           value="{{ old('sutradara', $film->sutradara) }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Tahun Rilis</label>
                    <input type="number" name="tahun_rilis" class="form-control"
                           value="{{ old('tahun_rilis', $film->tahun_rilis) }}" min="1900">
                </div>

                <div class="form-group">
                    <label class="form-label">Durasi (menit)</label>
                    <input type="number" name="durasi" class="form-control"
                           value="{{ old('durasi', $film->durasi) }}" min="1">
                </div>

                <div class="form-group">
                    <label class="form-label">Link Trailer</label>
                    <input type="url" name="trailer" class="form-control"
                           value="{{ old('trailer', $film->trailer) }}">
                </div>

                <div class="form-group" style="grid-column: 1/-1;">
                    <label class="form-label">Sinopsis</label>
                    <textarea name="sinopsis" class="form-control" rows="4">{{ old('sinopsis', $film->sinopsis) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Poster Film</label>
                    @if($film->poster)
                        <div style="margin-bottom:0.75rem;">
                            <img src="{{ asset('storage/' . $film->poster) }}" alt="Poster"
                                 style="width:80px; border-radius:8px; border:1px solid var(--border);">
                            <div style="font-size:0.75rem; color:var(--muted); margin-top:0.3rem;">Poster saat ini</div>
                        </div>
                    @endif
                    <input type="file" name="poster" class="form-control" accept="image/*"
                           id="posterInput" onchange="previewPoster(this)">
                    <div id="posterPreview" style="margin-top:0.75rem; display:none;">
                        <img id="previewImg" src="" alt="Preview"
                             style="width:80px; border-radius:8px; border:1px solid var(--border);">
                        <div style="font-size:0.75rem; color:var(--muted); margin-top:0.3rem;">Preview baru</div>
                    </div>
                    @error('poster') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Genre</label>
                    <div style="display:flex; flex-wrap:wrap; gap:0.5rem; padding:0.75rem; background:rgba(255,255,255,0.04); border:1px solid var(--border); border-radius:10px;">
                        @foreach($genres as $genre)
                        <label style="display:flex; align-items:center; gap:0.4rem; cursor:pointer; color:var(--text); font-size:0.875rem;">
                            <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                   {{ in_array($genre->id, old('genres', $selectedGenres)) ? 'checked' : '' }}
                                   style="accent-color: var(--accent);">
                            {{ $genre->nama_genre }}
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div style="display:flex; gap:0.75rem; margin-top:0.5rem;">
                <button type="submit" class="btn btn-primary">💾 Update Film</button>
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
