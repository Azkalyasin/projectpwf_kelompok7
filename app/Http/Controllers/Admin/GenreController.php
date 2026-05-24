<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::withCount('films')->orderBy('nama_genre')->paginate(15);
        return view('admin.genres.index', compact('genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_genre' => 'required|string|max:100|unique:genres,nama_genre',
        ]);

        Genre::create($request->only('nama_genre'));
        return redirect()->route('admin.genres.index')->with('success', 'Genre berhasil ditambahkan!');
    }

    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'nama_genre' => 'required|string|max:100|unique:genres,nama_genre,' . $genre->id,
        ]);

        $genre->update($request->only('nama_genre'));
        return redirect()->route('admin.genres.index')->with('success', 'Genre berhasil diupdate!');
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return redirect()->route('admin.genres.index')->with('success', 'Genre berhasil dihapus!');
    }
}
