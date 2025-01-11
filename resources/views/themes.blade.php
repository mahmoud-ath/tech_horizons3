<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Horizons - Thèmes</title>
    <link rel="stylesheet" href="{{ asset('css/themes.css') }}">
</head>
<body>
    <header>
        <h1>Tech Horizons</h1>
        <p>Explorez les innovations technologiques</p>
    </header>

    <nav>
        <a href="#">Accueil</a>
        <a href="#">Thèmes</a>
        <a href="#">À propos</a>
        <a href="#">Contact</a>
    </nav>

    <main>
        <section class="theme-container">
            <!-- Exemple de thème -->
            @foreach($themes as $theme) <!-- Opening part of foreach loop -->
                <div class="theme-card">
                    <img src="{{ asset($theme->imagepath) }}" alt="{{ $theme->name }}">
                    <h3>{{ $theme->name }}</h3>
                    <p>{{ $theme->description }}</p> 
                </div>
            @endforeach <!-- Closing part of foreach loop -->
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Tech Horizons. Tous droits réservés.</p>
    </footer>

    <script src="{{ asset('js/themes.js') }}"></script>
</body>
</html>
