<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Film extends Model
{
    protected $fillable = [
        'judul',
        'slug',
        'poster',
        'trailer',
        'sinopsis',
        'tahun_rilis',
        'durasi',
        'sutradara',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($film) {
            if (empty($film->slug)) {
                $film->slug = Str::slug($film->judul);
            }
        });

        static::updating(function ($film) {
            $film->slug = Str::slug($film->judul);
        });
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'film_genre');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
}
