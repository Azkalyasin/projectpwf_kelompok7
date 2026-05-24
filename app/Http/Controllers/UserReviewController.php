<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Review;
use Illuminate\Http\Request;

class UserReviewController extends Controller
{
    public function store(Request $request, Film $film)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        Review::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'film_id' => $film->id,
            ],
            [
                'rating' => $validated['rating'],
                'komentar' => $validated['komentar'],
            ]
        );

        return redirect()->back()->with('success', 'Review Anda berhasil disimpan!');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki hak untuk menghapus review ini.');
        }

        $review->delete();

        return redirect()->back()->with('success', 'Review berhasil dihapus!');
    }

    public function myReviews()
    {
        $reviews = auth()->user()->reviews()->with('film.genres')->latest()->get();
        return view('reviews.index', compact('reviews'));
    }
}
