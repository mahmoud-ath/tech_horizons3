<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/user.css') }}"></head>
<body>
<!-- Sidebar -->
<div class="sidebar">
        <div class="sidebar-header">
        <img id="admin-img" src="{{ asset('storage/profiles/' . auth()->user()->user_image) }}" alt="Profil" width="100">
        </div>
        <ul class="sidebar-menu">
        <li><a href="{{ route('user.dashboarduser') }}" data-section="dashboard" class="menu-link active">Dashboard</a></li>
            <li><a href="{{ route('user.subscription') }}" data-section="subscription" class="menu-link">Subscription</a></li>
            <li><a href="{{ route('user.myArticle') }}" data-section="my-articles" class="menu-link">My Article</a></li>
            <li><a href="{{ route('user.browsing-history') }}" data-section="browsing-history" class="menu-link">Browsing History</a></li>
            <li><a href="{{ route('user.proposearticle') }}" data-section="propose-article" class="menu-link">Propose Article</a></li>
            <li><a href="{{ route('user.settings') }}" data-section="settings" class="menu-link">Settings</a></li>
        </ul>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <div class="header-info">
            <span>Welcome back, 
             <span id="admin-username" style="font-weight: 900;">{{ auth()->user()->name }}</span> </span>
            
<button id="theme-btn-header" action="{{ route('themes.index') }}" >Themes</button>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" id="logout-btn">Logout</button>
            </form>
        </div>


        <!-- Sections -->
        <section id="browsing-history">
            <h1>Historique de Navigation</h1>

            <div class="filters">
                <label for="filter-keyword">Filtrer par titre:</label>
                <input type="text" id="filter-keyword" placeholder="Entrez un mot-clé...">

                <label for="filter-themes">Filtrer par Thème:</label>
                <select id="filter-themes">
                    <option value="">Tous les thèmes</option>
                    <option value="theme1">Thème 1</option>
                    <option value="theme2">Thème 2</option>
                    <option value="theme3">Thème 3</option>
                </select>

                <label for="filter-status">Filtrer par Statut:</label>
                <select id="filter-status">
                    <option value="">Tous les statuts</option>
                    <option value="En cours">En cours</option>
                    <option value="Refus">Refus</option>
                    <option value="Retenu">Retenu</option>
                    <option value="Publié">Publié</option>
                </select>

                <label for="filter-date">Filtrer par Date:</label>
                <select id="filter-date">
                    <option value="">Toutes les Dates</option>
                    <option value="today">Aujourd'hui</option>
                    <option value="yesterday">Hier</option>
                    <option value="last-week">La Semaine Dernière</option>
                    <option value="last-month">Le Mois Dernier</option>
                </select>
            </div>

            <table class="history-table">
                <thead>
                    <tr>
                        <th>Titre de l'Article</th>
                        <th>Thèmes</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody id="history-list">
                    <!-- History articles will be displayed here -->
                </tbody>
            </table>
        </section>




    </div>
    <script src="{{ asset('js/user.js') }}"></script>
    <script>
        function toggleSubscription(theme) {
            fetch('/admin/toggle-subscription', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({theme: theme})
            }).then(response => response.json()).then(data => {
                // Handle the response here
            });
        }
    </script>
</body>
</html>
