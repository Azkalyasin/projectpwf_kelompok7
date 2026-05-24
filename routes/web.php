<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FilmController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReviewController;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\UserFilmController;
use App\Http\Controllers\UserReviewController;
use App\Http\Controllers\WatchlistController;

// ─── User Routes (Breeze) ─────────────────────────────────────
Route::get('/dashboard', [UserFilmController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Detail Film
    Route::get('/films/{film:slug}', [UserFilmController::class, 'show'])->name('films.show');

    // Review & Rating
    Route::post('/films/{film:slug}/reviews', [UserReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [UserReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('/my-reviews', [UserReviewController::class, 'myReviews'])->name('reviews.my-reviews');

    // Watchlist
    Route::get('/watchlist', [WatchlistController::class, 'index'])->name('watchlist.index');
    Route::post('/films/{film:slug}/watchlist', [WatchlistController::class, 'toggle'])->name('watchlist.toggle');
});

// ─── Admin Routes ─────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('films', FilmController::class)->except(['show']);
        
        Route::get('genres', [GenreController::class, 'index'])->name('genres.index');
        Route::post('genres', [GenreController::class, 'store'])->name('genres.store');
        Route::put('genres/{genre}', [GenreController::class, 'update'])->name('genres.update');
        Route::delete('genres/{genre}', [GenreController::class, 'destroy'])->name('genres.destroy');

        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::patch('users/{user}/toggle-role', [UserController::class, 'toggleRole'])->name('users.toggle-role');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    });
});

require __DIR__.'/auth.php';
