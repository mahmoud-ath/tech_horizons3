<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/announces.css') }}">
</head>


<body>
         <!-- HEADER Section -->
         <header>
            <nav class="navbar">
                <div class="logo">
                    <a href="/"><img src="{{ asset('images/whaite.png') }}" alt="Logo"></a>
                    <h1 href="/">Tech Horizons</h1>
                </div>
                <div class="search-bar">
                    <input type="search" placeholder="Rechercher...">
                    <button type="submit"><img src="{{ asset('images/icons8-search-24.png') }}" alt="Search"></button>
                </div>
                <ul class="nav-links">
                    <li><a href="/" class="more">Accueil</a></li>
                    <li><a href="/themes" class="more">Thèmes</a></li>
                    <li><a href="/register" class="btn">Créer un compte</a></li>
                    <li><a href="/login" class="more">Se connecter</a></li>
                </ul>
            </nav>
        </header>

    <main>
        <h2>Annonces des Articles Publiés</h2>
        <p class="inf">Découvrez les derniers articles publiés sur Tech Horizons</p>
        <section id="articles">
            @foreach ($articles as $article)
                <div class="article-item">
                    <div class="article-container">
                        <div class="article-content">
                            <h3 class="article-title"><a href="{{ url('/themes/' . $themeId . '/articles/' . $article->id) }}">{{ $article->title }}</a></h3>
                            <p class="article-meta">Publié le {{ \Carbon\Carbon::parse($article->published_date)->format('d/m/Y') }} | Par {{ $article->user->name }}</p>
                            <p>{{ Str::limit($article->content, 150) }}</p>
                            <p>Vues : {{ $article->views }}</p>
                            <a href="{{ url('/themes/' . $themeId . '/articles/' . $article->id) }}" class="read-more">Lire plus</a>
                            <a href="{{ url('/themes/' . $themeId . '/articles/' . $article->id) }}" class="share">Partager</a>
                        </div>
                        <div class="article-image">
                            <a href="{{ url('/themes/' . $themeId . '/articles/' . $article->id) }}">
                            <img src="{{ asset($article->imagepath) }}" alt="Image de l'article" class="article-image"  >
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>
    </main>
 <!-- FOOTER Section -->
 <footer>
    <div class="footer-container">
        <!-- Section Navigation -->
        <div class="footer-section">
            <h2>Tech Horizons</h2>
            <p>Tech Horizons est votre guide pour comprendre les transformations technologiques majeures et leurs implications.</p>
        </div>
        <div class="footer-section">
            <h4>Navigation</h4>
            <ul>
                <li><a href="/">Accueil</a></li>
                <li><a href="/themes">Thèmes</a></li>
                <li><a href="/a_propos">À propos</a></li>
            </ul>
        </div>
        <!-- Section Catégories -->
        <div class="footer-section">
            <h4>Support</h4>
            <ul>
                <li><a href="/contact_us">Contact Us</a></li>
            </ul>
        </div>
        <!-- Section Réseaux sociaux -->
        <div class="footer-section">
            <h4>Suivez-nous</h4>
            <div class="social-icons">
                <a href="#"><img src="{{ asset('images/icons8-facebook-50.png') }}" alt="Facebook"></a>
                <a href="#"><img src="{{ asset('images/icons8-twitter-50.png') }}" alt="Twitter"></a>
                <a href="#"><img src="{{ asset('images/icons8-instagram-50.png') }}" alt="Instagram"></a>
                <a href="#"><img src="{{ asset('images/icons8-tiktok-50.png') }}" alt="Tiktok"></a>
            </div>
        </div>
    </div>
    <!-- Bas du footer -->
    <div class="footer-bottom">
        <p>© 2025 Tech Horizons. All rights reserved.</p>
        <p><a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
    </div>
</footer>
</body>
</html>
