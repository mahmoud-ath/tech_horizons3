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



        <section id="my-articles">
            <h1>Mes Articles</h1>
            <table class="my-articles-table">
                <thead>
                    <tr>
                        <th>Titre de l'Article</th>
                        <th>Thèmes</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody id="articles-list">
                    <!-- Articles will be listed here -->
                </tbody>
            </table>
        </section>



    </div>
    <script src="{{ asset('js/user.js') }}"></script>
    
</body>
</html>
