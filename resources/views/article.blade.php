<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Horizons - Thèmes</title>
    <link rel="stylesheet" href="{{ asset('css/article.css') }}">

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

        <main class="article-page">
            <section class="article-header">
                <h1 class="article-title">{{ $article->title }}</h1>
                <p class="article-meta">Publié le <span id="publish-date">{{ $article->created_at->format('d/m/Y') }}</span> | Par <span id="author">{{ $article->user->name }}</span></p>
            </section>

            <section class="article-content">
                <div class="image-container">
                    <img src="{{ asset($article->imagepath) }}" alt="Image de l'article" class="article-image">
                </div>
                <p id="article-body">
                    {{ $article->content }}
                </p>
            </section>

            <section class="article-actions">
                <div class="rating">
                    <span>Notez cet article :</span>
                    <div class="stars" id="rating-stars">
                        <span class="star" data-value="1">★</span>
                        <span class="star" data-value="2">★</span>
                        <span class="star" data-value="3">★</span>
                        <span class="star" data-value="4">★</span>
                        <span class="star" data-value="5">★</span>
                    </div>
                </div>
                <button id="recommend-button" class="btn">Recommander cet article</button>
            </section>

            <section class="article-comments">
                <h2>Commentaires</h2>
                <div id="comments-section">
                    <div class="comment">
                        <p><strong>Utilisateur123 :</strong> Très bon article, bien expliqué !</p>
                        <button class="reply-button">Répondre</button>
                    </div>
                    <div class="comment">
                        <p><strong>Abonné456 :</strong> J'aimerais voir plus de contenu sur ce thème.</p>
                        <button class="reply-button">Répondre</button>
                    </div>
                </div>
                <form id="comment-form">
                    <textarea id="comment-text" placeholder="Ajoutez votre commentaire..."></textarea>
                    <button type="submit" class="btn">Publier</button>
                </form>
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
    <script src="{{ asset('js/article.js') }}"></script>

</body>
</html>
