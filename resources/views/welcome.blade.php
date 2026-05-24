<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FilmKu - Platform Review Film Terbaik</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0f0f13;
            --surface: #18181f;
            --surface-hover: #1f1f28;
            --primary: #7c3aed;
            --primary-hover: #6d28d9;
            --secondary: #ec4899;
            --text: #f9fafb;
            --muted: #9ca3af;
            --border: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Navbar */
        nav {
            padding: 1.5rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(15, 15, 19, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            z-index: 1000;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: var(--text);
        }

        .logo-icon {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.8rem;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-links a {
            color: var(--text);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .btn {
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-outline {
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.05);
        }

        .btn-outline:hover {
            border-color: var(--primary);
            background: rgba(124, 58, 237, 0.1);
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border: 1px solid var(--primary);
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(124, 58, 237, 0.4);
        }

        /* Hero Section */
        .hero {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 8rem 5% 4rem;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(124, 58, 237, 0.15) 0%, rgba(15, 15, 19, 0) 70%);
            z-index: -1;
            pointer-events: none;
        }

        .hero-content {
            max-width: 800px;
        }

        .badge {
            background: rgba(236, 72, 153, 0.1);
            color: var(--secondary);
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(236, 72, 153, 0.2);
            letter-spacing: 0.5px;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            letter-spacing: -1px;
        }

        .hero h1 span {
            background: linear-gradient(to right, #a78bfa, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 1.25rem;
            color: var(--muted);
            margin-bottom: 2.5rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .hero-actions .btn {
            padding: 0.8rem 2rem;
            font-size: 1.05rem;
        }

        /* Features */
        .features {
            padding: 4rem 5% 6rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem;
            text-align: left;
            transition: transform 0.3s ease, border-color 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: rgba(124, 58, 237, 0.5);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            display: inline-block;
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .feature-desc {
            color: var(--muted);
            font-size: 0.95rem;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 2rem;
            border-top: 1px solid var(--border);
            color: var(--muted);
            font-size: 0.9rem;
            margin-top: auto;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.8rem;
            }
            .hero p {
                font-size: 1.1rem;
            }
            .nav-links {
                display: none;
            }
            .nav-mobile-btn {
                display: block !important;
            }
        }

        .nav-mobile-btn {
            display: none;
        }
    </style>
</head>
<body>

    <nav>
        <a href="{{ url('/') }}" class="logo">
            <span class="logo-icon">🎬</span> FilmKu
        </a>
        <div class="nav-links">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Ke Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Daftar Sekarang</a>
                    @endif
                @endauth
            @endif
        </div>
        
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-primary nav-mobile-btn">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary nav-mobile-btn">Masuk</a>
            @endauth
        @endif
    </nav>

    <main class="hero">
        <div class="hero-content">
            <div class="badge">🚀 Platform Review Film No.1</div>
            <h1>Temukan & Bagikan<br><span>Film Favoritmu</span></h1>
            <p>Jelajahi ribuan ulasan film, berikan ratingmu sendiri, dan simpan film yang ingin kamu tonton ke dalam watchlist secara mudah di FilmKu.</p>
            
            <div class="hero-actions">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Mulai Jelajahi</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary">Mulai Sekarang - Gratis!</a>
                        <a href="{{ route('login') }}" class="btn btn-outline">Sudah punya akun?</a>
                    @endauth
                @endif
            </div>
        </div>
    </main>

    <section class="features">
        <div class="feature-card">
            <div class="feature-icon">⭐</div>
            <h3 class="feature-title">Rating & Ulasan</h3>
            <p class="feature-desc">Berikan pendapat jujurmu dan baca ulasan dari penikmat film lainnya sebelum kamu menonton.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🔥</div>
            <h3 class="feature-title">Trending Film</h3>
            <p class="feature-desc">Selalu update dengan film-film terbaru dan terpopuler yang sedang ramai diperbincangkan saat ini.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📑</div>
            <h3 class="feature-title">Personal Watchlist</h3>
            <p class="feature-desc">Simpan daftar film yang ingin kamu tonton kapan saja di tempat yang rapi dan terorganisir.</p>
        </div>
    </section>

    <footer>
        <p>&copy; {{ date('Y') }} FilmKu. Dibuat untuk pecinta film.</p>
    </footer>

</body>
</html>
