<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A propos - Tech Horizons</title>
    <link rel="stylesheet" href="{{ asset('css/apropos.css') }}">
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
        <div class="propos">
            <h3>À propos de l'application Tech Horizons</h3>
            <p>
                Tech Horizons est une application web novatrice, spécifiquement conçue pour répondre aux besoins d'un public avide de découvertes technologiques. Axée sur la gestion d’un magazine en ligne, elle couvre un large éventail de thématiques liées aux innovations majeures de notre époque, tout en offrant une plateforme collaborative et interactive.<br><br>
                Cette application a été pensée pour simplifier l’accès aux contenus technologiques, tout en apportant une touche de personnalisation et d’intelligence. Elle permet aux utilisateurs, qu’ils soient simples curieux, amateurs passionnés ou professionnels du domaine, de s’informer, de participer activement et de contribuer à la création de contenus pertinents.<br><br>
                Tech Horizons ne se limite pas à une simple plateforme de lecture. Elle se veut être un espace de référence, un lieu où la technologie et ses enjeux éthiques, sociétaux et culturels peuvent être explorés, discutés et partagés.

                En mettant l'accent sur l'innovation, la personnalisation et la collaboration, l'application offre à ses utilisateurs la possibilité non seulement de consommer du contenu, mais aussi de devenir acteurs des transformations technologiques de demain.
                Avec une approche centrée sur l’utilisateur et une technologie de pointe, Tech Horizons ambitionne de redéfinir la manière dont les passionnés de technologie explorent et interagissent avec le savoir numérique.
            </p>
        </div>
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
