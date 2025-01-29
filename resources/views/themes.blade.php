<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Horizons - Thèmes</title>
    <link rel="stylesheet" href="{{ asset('css/themes.css') }}">
</head>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <h1>Tech Horizons</h1>
            </div>
            <ul class="nav-links">
                <li><a href="#">Accueil</a></li>
                <li><a href="#">Thèmes</a></li>
                <li><a href="#">À propos</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="/login" class="btn">Connexion</a></li>
            </ul>
        </nav>
    </header>

    

  <main>
    <section class="theme-container">
            <h2>Explorez nos thèmes</h2>
            <!-- Exemple de thème -->
            <div class="themes-card">  
            @foreach($themes as $theme) <!-- Opening part of foreach loop -->
                <div class="theme-card">
                    <img src="{{ asset($theme->imagepath) }}" alt="{{ $theme->name }}">
                    <h3>{{ $theme->name }}</h3>
                    <p>{{ $theme->description }}</p> 
                </div>
            @endforeach <!-- Closing part of foreach loop -->
        </section>
    </main>

    <section id="about" class="about-section">
        <h2>À propos de Tech Horizons</h2>
        <p>Tech Horizons est votre guide pour comprendre les transformations technologiques majeures et leurs implications.</p>
    </section>
  </main>

    <footer>
        <p>&copy; 2025 Tech Horizons. Tous droits réservés.</p>
    </footer>

    <script src="{{ asset('js/themes.js') }}"></script>
</body>
</html>
