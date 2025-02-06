<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        <section id="settings" class="settings-section">
    <h2 class="settings-title">Settings</h2>
    <form id="settings-form" class="settings-form" method="POST" action="{{ route('user.settings.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="settings-form-group">
        <label for="username" class="settings-label">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" class="settings-input" placeholder="Entrez votre nouveau nom" required value="{{ auth()->user()->name }}" />
    </div>

    <div class="settings-form-group">
        <label for="password" class="settings-label">Nouveau mot de passe :</label>
        <input type="password" name="password" id="password" class="settings-input" placeholder="Entrez un nouveau mot de passe" />
    </div>

    <div class="settings-form-group">
        <label for="user_image" class="settings-label">Image de profil :</label>
        <input type="file" name="user_image" id="user_image" class="settings-file-input" accept="image/*" />
    </div>

    <button type="submit" class="settings-submit-btn">Enregistrer les modifications</button>
</form>

</section>


    </div>
   <!-- <script src="{{ asset('js/user.js') }}"></script> -->
    <script src="{{ asset('js/userSetting.js') }}"></script>

   
</body>
</html>
