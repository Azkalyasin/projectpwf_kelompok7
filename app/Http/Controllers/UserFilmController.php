<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\Request;

class UserFilmController extends Controller
{
    public function index(Request $request)
    {
        $query = Film::with(['genres', 'reviews']);

        // Search Film
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('sutradara', 'like', "%{$search}%");
            });
        }

        // Filter Genre
        if ($request->filled('genre')) {
            $genreId = $request->genre;
            $query->whereHas('genres', function ($q) use ($genreId) {
                $q->where('genres.id', $genreId);
            });
        }

        $films = $query->latest()->paginate(12)->withQueryString();
        $genres = Genre::orderBy('nama_genre')->get();

        // User stats for dashboard
        $watchlistCount = auth()->user()->watchlists()->count();
        $reviewCount = auth()->user()->reviews()->count();

        return view('dashboard', compact('films', 'genres', 'watchlistCount', 'reviewCount'));
    }

    public function show(Film $film)
    {
        $film->load('genres');
        $reviews = $film->reviews()->with('user')->latest()->get();
        $averageRating = $film->averageRating();
        
        $hasReviewed = $film->reviews()->where('user_id', auth()->id())->exists();
        $inWatchlist = auth()->user()->watchlists()->where('film_id', $film->id)->exists();

        // Get similar films sharing the same genres
        $genreIds = $film->genres->pluck('id')->toArray();
        $similarFilms = Film::where('id', '!=', $film->id)
            ->whereHas('genres', function ($q) use ($genreIds) {
                $q->whereIn('genres.id', $genreIds);
            })
            ->take(4)
            ->get();

        return view('films.show', compact('film', 'reviews', 'averageRating', 'hasReviewed', 'inWatchlist', 'similarFilms'));
    }
}
