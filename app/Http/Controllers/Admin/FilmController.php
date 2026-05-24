<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FilmController extends Controller
{
    public function index()
    {
        $films = Film::with('genres')->latest()->paginate(10);
        return view('admin.films.index', compact('films'));
    }

    public function create()
    {
        $genres = Genre::orderBy('nama_genre')->get();
        return view('admin.films.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'       => 'required|string|max:255',
            'poster'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'trailer'     => 'nullable|url|max:255',
            'sinopsis'    => 'nullable|string',
            'tahun_rilis' => 'nullable|integer|min:1900|max:' . (date('Y') + 2),
            'durasi'      => 'nullable|integer|min:1',
            'sutradara'   => 'nullable|string|max:255',
            'genres'      => 'nullable|array',
            'genres.*'    => 'exists:genres,id',
        ]);

        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $validated['slug'] = Str::slug($validated['judul']);

        $film = Film::create($validated);

        if (!empty($validated['genres'])) {
            $film->genres()->sync($validated['genres']);
        }

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil ditambahkan!');
    }

    public function edit(Film $film)
    {
        $genres         = Genre::orderBy('nama_genre')->get();
        $selectedGenres = $film->genres->pluck('id')->toArray();
        return view('admin.films.edit', compact('film', 'genres', 'selectedGenres'));
    }

    public function update(Request $request, Film $film)
    {
        $validated = $request->validate([
            'judul'       => 'required|string|max:255',
            'poster'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'trailer'     => 'nullable|url|max:255',
            'sinopsis'    => 'nullable|string',
            'tahun_rilis' => 'nullable|integer|min:1900|max:' . (date('Y') + 2),
            'durasi'      => 'nullable|integer|min:1',
            'sutradara'   => 'nullable|string|max:255',
            'genres'      => 'nullable|array',
            'genres.*'    => 'exists:genres,id',
        ]);

        if ($request->hasFile('poster')) {
            // Hapus poster lama
            if ($film->poster) {
                Storage::disk('public')->delete($film->poster);
            }
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $film->update($validated);
        $film->genres()->sync($validated['genres'] ?? []);

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil diupdate!');
    }

    public function destroy(Film $film)
    {
        if ($film->poster) {
            Storage::disk('public')->delete($film->poster);
        }
        $film->delete();
        return redirect()->route('admin.films.index')->with('success', 'Film berhasil dihapus!');
    }
}
