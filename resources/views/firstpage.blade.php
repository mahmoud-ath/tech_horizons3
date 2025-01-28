<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Horizons</title>
    <link rel="stylesheet" href="{{ asset('css/page.css') }}">
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

    <!-- Main Section -->
    <section class="main">
        <div class="img"> <img src="{{ asset('images/Object.png') }}" style="flex: 1;
            background-repeat: no-repeat;
            background-size:80% ;
            background-position: center;
            height: 100%; " ; /></div>
        <div class="content">
            <h1>Welcome to Tech Horizon</h1>
            <p>Exploring the future of technology and innovation.</p>
            <button href="/register">join us</button>
        </div>
    </section>

    <!-- Magazine Section -->
    <section class="mg">
        <h2>Our Magazine Editions</h2>
        <section class="magazine-section">
            @foreach($issues as $issue)
                <div class="magazine-card">
                    <div class="card-image">
                        <img src="{{ asset($issue->imagepath) }}" alt="{{ $issue->name }}" style="background-size: cover;
    height: 300px;  " ;>
                    </div>
                    <div class="card-content">
                        <p>{{ $issue->name }}</p>
                        <button>Read more</button>
                    </div>
                </div>
            @endforeach
        </section>
    </section>

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
