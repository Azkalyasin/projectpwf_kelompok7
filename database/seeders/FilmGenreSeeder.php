<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FilmGenreSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Genres
        $genresData = [
            'Action',
            'Comedy',
            'Drama',
            'Sci-Fi',
            'Horror',
            'Romance',
            'Thriller',
            'Fantasy',
            'Adventure',
            'Anime'
        ];

        $genres = [];
        foreach ($genresData as $name) {
            $genres[$name] = Genre::firstOrCreate(['nama_genre' => $name]);
        }

        // 2. Create Films with related Genres and Trailer links
        $filmsData = [
            [
                'judul' => 'The Dark Knight',
                'sutradara' => 'Christopher Nolan',
                'tahun_rilis' => 2008,
                'durasi' => 152,
                'trailer' => 'https://www.youtube.com/watch?v=EXeTwQWrcwY',
                'sinopsis' => 'Ketika ancaman yang dikenal sebagai Joker mengacaukan ketertiban di Gotham, Batman harus menerima salah satu tes psikologis dan fisik terbesar dari kemampuannya untuk melawan ketidakadilan.',
                'genres' => ['Action', 'Drama', 'Thriller']
            ],
            [
                'judul' => 'Inception',
                'sutradara' => 'Christopher Nolan',
                'tahun_rilis' => 2010,
                'durasi' => 148,
                'trailer' => 'https://www.youtube.com/watch?v=YoHD9XEInc0',
                'sinopsis' => 'Seorang pencuri yang mencuri rahasia perusahaan melalui penggunaan teknologi berbagi mimpi, diberikan tugas sebaliknya: menanamkan ide ke dalam pikiran seorang C.E.O.',
                'genres' => ['Action', 'Sci-Fi', 'Adventure']
            ],
            [
                'judul' => 'Interstellar',
                'sutradara' => 'Christopher Nolan',
                'tahun_rilis' => 2014,
                'durasi' => 169,
                'trailer' => 'https://www.youtube.com/watch?v=zSWdZAibxsI',
                'sinopsis' => 'Sebuah tim penjelajah melakukan perjalanan melalui lubang cacing di luar angkasa dalam upaya untuk memastikan kelangsungan hidup umat manusia.',
                'genres' => ['Drama', 'Sci-Fi', 'Adventure']
            ],
            [
                'judul' => 'Parasite',
                'sutradara' => 'Bong Joon Ho',
                'tahun_rilis' => 2019,
                'durasi' => 132,
                'trailer' => 'https://www.youtube.com/watch?v=5xH0HfJHsaY',
                'sinopsis' => 'Keserakahan dan diskriminasi kelas mengancam hubungan simbiosis yang baru terbentuk antara keluarga Park yang kaya raya dan klan Kim yang miskin.',
                'genres' => ['Drama', 'Thriller']
            ],
            [
                'judul' => 'Spirited Away',
                'sutradara' => 'Hayao Miyazaki',
                'tahun_rilis' => 2001,
                'durasi' => 125,
                'trailer' => 'https://www.youtube.com/watch?v=ByXuk9QqQkk',
                'sinopsis' => 'Selama kepindahan keluarganya ke pinggiran kota, seorang gadis berusia 10 tahun yang cemberut mengembara ke dunia yang diperintah oleh para dewa, penyihir, dan roh, di mana manusia diubah menjadi binatang buas.',
                'genres' => ['Fantasy', 'Anime', 'Adventure']
            ],
            [
                'judul' => 'The Conjuring',
                'sutradara' => 'James Wan',
                'tahun_rilis' => 2013,
                'durasi' => 112,
                'trailer' => 'https://www.youtube.com/watch?v=k10ETZ41q5o',
                'sinopsis' => 'Penyelidik paranormal Ed dan Lorraine Warren bekerja untuk membantu keluarga yang diteror oleh kehadiran gelap di rumah pertanian mereka.',
                'genres' => ['Horror', 'Thriller']
            ],
            [
                'judul' => 'La La Land',
                'sutradara' => 'Damien Chazelle',
                'tahun_rilis' => 2016,
                'durasi' => 128,
                'trailer' => 'https://www.youtube.com/watch?v=0pdqf4P9MB8',
                'sinopsis' => 'Saat menavigasi karir mereka di Los Angeles, seorang pianis jazz dan seorang aktris jatuh cinta sambil mencoba mendamaikan aspirasi masa depan mereka.',
                'genres' => ['Romance', 'Drama', 'Comedy']
            ],
            [
                'judul' => 'Your Name',
                'sutradara' => 'Makoto Shinkai',
                'tahun_rilis' => 2016,
                'durasi' => 106,
                'trailer' => 'https://www.youtube.com/watch?v=a2GujJZfALL',
                'sinopsis' => 'Dua orang asing mendapati diri mereka terhubung secara aneh setelah menyadari bahwa tubuh mereka tertukar secara misterius.',
                'genres' => ['Romance', 'Drama', 'Fantasy', 'Anime']
            ],
            [
                'judul' => 'Avengers: Endgame',
                'sutradara' => 'Anthony Russo, Joe Russo',
                'tahun_rilis' => 2019,
                'durasi' => 181,
                'trailer' => 'https://www.youtube.com/watch?v=TcMBFSGVi1c',
                'sinopsis' => 'Setelah peristiwa dahsyat dari Avengers: Infinity War, alam semesta hancur. Dengan bantuan sekutu yang tersisa, Avengers berkumpul sekali lagi untuk membalikkan tindakan Thanos dan memulihkan keseimbangan alam semesta.',
                'genres' => ['Action', 'Sci-Fi', 'Adventure', 'Fantasy']
            ]
        ];

        foreach ($filmsData as $data) {
            $film = Film::firstOrCreate(
                ['judul' => $data['judul']],
                [
                    'slug' => Str::slug($data['judul']),
                    'sutradara' => $data['sutradara'],
                    'tahun_rilis' => $data['tahun_rilis'],
                    'durasi' => $data['durasi'],
                    'trailer' => $data['trailer'],
                    'sinopsis' => $data['sinopsis'],
                ]
            );

            // Sync related genres
            $genreIds = [];
            foreach ($data['genres'] as $genreName) {
                if (isset($genres[$genreName])) {
                    $genreIds[] = $genres[$genreName]->id;
                }
            }
            $film->genres()->sync($genreIds);
        }
    }
}
