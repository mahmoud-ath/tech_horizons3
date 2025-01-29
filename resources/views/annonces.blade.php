<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annonces des Articles Publiés - Tech Horizons</title>
    <link rel="stylesheet" href="{{ asset('css/announces.css') }}">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="#"><img src="{{ asset('images/whaite.png') }}"></a>
                <h1>Tech Horizons</h1>
            </div>
            <div class="search-bar">
                <input type="search" placeholder="Rechercher...">
                <button type="submit"><img src="{{ asset('images/icons8-search-24.png') }}"></button>
            </div>
            <ul class="nav-links">
                <li><a href="#">Accueil</a></li>
                <li><a href="#">Thèmes</a></li>
                <li><a href="/mes-articles">Mes articles</a></li>
                <li><a href="/deconnexion">Se déconnecter</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Annonces des Articles Publiés</h2>
        <p class="inf">Découvrez les derniers articles publiés sur Tech Horizons</p>
        <div id="image-container" class="image-section">
            <!-- L'image sera insérée ici par JavaScript -->
        </div>
        <section id="articles">
            @foreach ($articles as $article)
                <article class="article-item">
                    <h3 class="article-title"><a href="{{ url('/themes/' . $themeId . '/articles/' . $article->id) }}">{{ $article->title }}</a></h3>
                    <p class="article-meta">Publié le {{ $article->published_date->format('d/m/Y') }} | Par {{ $article->user->name }}</p>
                    <div class="article-content">
                        <div class="image-container">
                            <img src="{{ asset($article->imagepath) }}" alt="Image de l'article" class="article-image">
                        </div>
                        <p>{{ Str::limit($article->content, 150) }}</p>
                    </div>
                </article>
            @endforeach
        </section>

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
                        <li><a href="#">Accueil</a></li>
                        <li><a href="#">Thèmes</a></li>
                        <li><a href="#">À propos</a></li>
                    </ul>
                </div>

                <!-- Section Catégories -->
                <div class="footer-section">
                    <h4>Support</h4>
                    <ul>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">FAQ</a></li>
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
    </main>
    <script src="{{ asset('js/announces.js') }}"></script>

</body>
</html>

