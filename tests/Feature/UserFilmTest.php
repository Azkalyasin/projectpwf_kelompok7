<?php

namespace Tests\Feature;

use App\Models\Film;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserFilmTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Film $film;
    private Genre $genre;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'role' => 'user'
        ]);

        $this->genre = Genre::create(['nama_genre' => 'Action']);

        $this->film = Film::create([
            'judul' => 'Avatar 3',
            'slug' => 'avatar-3',
            'sutradara' => 'James Cameron',
            'tahun_rilis' => 2025,
            'durasi' => 180,
        ]);
        
        $this->film->genres()->attach($this->genre->id);
    }

    public function test_user_can_browse_films(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Avatar 3');
    }

    public function test_user_can_search_films(): void
    {
        Film::create([
            'judul' => 'Inception',
            'slug' => 'inception',
            'sutradara' => 'Christopher Nolan',
            'tahun_rilis' => 2010,
        ]);

        // Search for James Cameron
        $response = $this->actingAs($this->user)
            ->get(route('dashboard', ['search' => 'Cameron']));

        $response->assertStatus(200);
        $response->assertSee('Avatar 3');
        $response->assertDontSee('Inception');
    }

    public function test_user_can_filter_films_by_genre(): void
    {
        $otherGenre = Genre::create(['nama_genre' => 'Comedy']);
        
        $comedyFilm = Film::create([
            'judul' => 'Superbad',
            'slug' => 'superbad',
            'tahun_rilis' => 2007,
        ]);
        $comedyFilm->genres()->attach($otherGenre->id);

        $response = $this->actingAs($this->user)
            ->get(route('dashboard', ['genre' => $this->genre->id]));

        $response->assertStatus(200);
        $response->assertSee('Avatar 3');
        $response->assertDontSee('Superbad');
    }

    public function test_user_can_view_film_detail(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('films.show', $this->film->slug));

        $response->assertStatus(200);
        $response->assertSee('Avatar 3');
        $response->assertSee('James Cameron');
    }

    public function test_user_can_add_review(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('reviews.store', $this->film->slug), [
                'rating' => 5,
                'komentar' => 'Film yang sangat luar biasa!'
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reviews', [
            'user_id' => $this->user->id,
            'film_id' => $this->film->id,
            'rating' => 5,
            'komentar' => 'Film yang sangat luar biasa!'
        ]);
    }

    public function test_user_can_toggle_watchlist(): void
    {
        // Add to watchlist
        $response = $this->actingAs($this->user)
            ->post(route('watchlist.toggle', $this->film->slug));

        $response->assertRedirect();
        $this->assertDatabaseHas('watchlists', [
            'user_id' => $this->user->id,
            'film_id' => $this->film->id,
        ]);

        // Remove from watchlist
        $response = $this->actingAs($this->user)
            ->post(route('watchlist.toggle', $this->film->slug));

        $response->assertRedirect();
        $this->assertDatabaseMissing('watchlists', [
            'user_id' => $this->user->id,
            'film_id' => $this->film->id,
        ]);
    }
}
