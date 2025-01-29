<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/user.css') }}"></head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
        <img src="{{ asset($user->user_image ?? 'images/default-profile.png') }}" alt="User Profile" class="user-img" id="user-img" />
        </div>
        <ul class="sidebar-menu">
        <li><a href="{{ route('user.dashboarduser') }}" data-section="dashboard" class="menu-link active">Dashboard</a></li>
            <li><a href="{{ route('user.subscription') }}" data-section="subscription" class="menu-link">Subscription</a></li>
            <li><a href="{{ route('user.myArticle') }}" data-section="my-articles" class="menu-link">My Article</a></li>
            <li><a href="{{ route('user.browsing-history') }}" data-section="browsing-history" class="menu-link">Browsing History</a></li>
            <li><a href="{{ route('user.propose-article') }}" data-section="propose-article" class="menu-link">Propose Article</a></li>
            <li><a href="{{ route('user.settings') }}" data-section="settings" class="menu-link">Settings</a></li>
        </ul>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <div class="header-info">
            <span>Welcome back, @if(isset($user))
            <span id="admin-username" style="font-weight: 900;">{{ Auth::user()->username ?? 'Guest' }}</span>
@else
    <span id="admin-username" style="font-weight: 900;">{{ Auth::user()->name }}</span>
@endif </span>
<button id="theme-btn-header" action="{{ route('themes.index') }}" >Themes</button>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" id="logout-btn">Logout</button>
            </form>
        </div>

        <section id="propose-article">
            <h1>Propose un Article</h1>
            <form id="article-form">
                <div class="form-group">
                    <label for="article-title">Titre de l'article</label>
                    <input type="text" id="article-title" name="article-title" placeholder="Titre de l'article" required>
                </div>

                <div class="form-group">
                    <label for="article-themes">Thèmes de l'article</label>
                    <select id="article-themes" name="article-themes" multiple required>
                        <option value="theme1">Thème 1</option>
                        <option value="theme2">Thème 2</option>
                        <option value="theme3">Thème 3</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="article-cover">Image de couverture</label>
                    <input type="file" id="article-cover" name="article-cover" accept="image/*" required>
                </div>

                <div class="form-group">
                    <label for="article-description">Description de l'article</label>
                    <textarea id="article-description" name="article-description" rows="4" placeholder="Description de l'article" required></textarea>
                </div>

                <button type="submit" id="submit-article-btn">Proposer l'article</button>
            </form>
        </section>


    </div>
    <script src="{{ asset('js/admin.js') }}"></script>
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
