<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Review;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_film'   => Film::count(),
            'total_genre'  => Genre::count(),
            'total_user'   => User::where('role', 'user')->count(),
            'total_review' => Review::count(),
        ];

        $latestFilms   = Film::latest()->take(5)->get();
        $latestReviews = Review::with(['user', 'film'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestFilms', 'latestReviews'));
    }
}
