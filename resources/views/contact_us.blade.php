<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Tech Horizons</title>
    <link rel="stylesheet" href="{{ asset('css/contact_us.css') }}">
</head>
<body>
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
        <section class="contact-info">
            <h2>Contact Information</h2>
            <p>Si vous avez des questions, des commentaires ou des demandes de renseignements, n’hésitez pas à nous contacter via ce qui suit :</p>
            <ul>
                <li>Email: <a href="mailto:contact@techhorizons.ma">contact@techhorizons.ma</a></li>
                <li>Téléphone: <a href="tel:+212500000000">+212 500 000 000</a></li>
                <li>Addresse: Tech Horizons Maroc<br>
                    Avenue des Technologies,<br>
                    Quartier Innovation,<br>
                    Casablanca 20200,<br>
                    Maroc </li>
            </ul>
        </section>

        <section class="contact-form">
            <h2>Envoyez-nous un message</h2>
            <form action="/submit-contact" method="POST">
                <label for="name">Votre nom:</label>
                <input type="text" id="name" name="name" placeholder="Entrer votre nom" required>

                <label for="email">Votre Email:</label>
                <input type="email" id="email" name="email" placeholder="Entrer votre email" required>

                <label for="subject">Sujet:</label>
                <input type="text" id="subject" name="subject" placeholder="Entrer le Sujet" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" placeholder="Ecrire le message ici" required></textarea>

                <button type="submit">Envoyer</button>
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
</body>
</html>
