<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Watchlist;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    public function index()
    {
        $watchlists = auth()->user()->watchlists()->with('film.genres')->latest()->get();
        return view('watchlist.index', compact('watchlists'));
    }

    public function toggle(Request $request, Film $film)
    {
        $watchlist = Watchlist::where('user_id', auth()->id())
            ->where('film_id', $film->id)
            ->first();

        if ($watchlist) {
            $watchlist->delete();
            $message = 'Film dihapus dari Watchlist!';
        } else {
            Watchlist::create([
                'user_id' => auth()->id(),
                'film_id' => $film->id,
                'status' => 'plan',
            ]);
            $message = 'Film ditambahkan ke Watchlist!';
        }

        return redirect()->back()->with('success', $message);
    }
}
