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
            <li><a href="#dashboard" data-section="dashboard" class="menu-link active">Dashboard</a></li>
            <li><a href="#subscription" data-section="subscription" class="menu-link">Subscription</a></li>
            <li><a href="#myArticle" data-section="my-articles" class="menu-link">My Article</a></li>
            <li><a href="#browsing-history" data-section="browsing-history" class="menu-link">Browsing History</a></li>
            <li><a href="#propose-article" data-section="propose-article" class="menu-link">Propose Article</a></li>
            <li><a href="#settings" data-section="settings" class="menu-link">Settings</a></li>
        </ul>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <div class="header-info">
            <span>Welcome back, @if(isset($user))
            <span id="admin-username" style="font-weight: 900;">{{ Auth::user()->username ?? 'Guest' }}</span>
@else
    <span id="admin-username" style="font-weight: 900;">Guest</span>
@endif </span>
            <button id="theme-btn-user" >Themes</button>
            <button id="logout-btn">Logout</button>
        </div>

        <!-- Sections -->
        <section id="dashboard" class="active">
            <h1>Tableau de Bord</h1>

            <div class="content-container">
                <!-- Recommended Articles Section (Left) -->
                <div id="recommended-articles">
                    <h2>Articles Recommandés</h2>
                    <div id="articles-list">
                    @if(isset($recommendedArticles) && count($recommendedArticles) > 0)
                    @foreach($recommendedArticles as $article)
                        <p>{{ $article->title }}</p>
                     @endforeach
                 @else
                   <p>Aucun article recommandé pour le moment.</p>
                 @endif

                    </div>
                </div>

                <!-- Magazine Issues Section (Right) -->
                <div id="">
                    <h2>Numéros du Magazine</h2>
                    <div class="magazine-issues">
                        <div id="issues-list">
                        @if(isset($magazineIssues) && count($magazineIssues) > 0)
                        @foreach($magazineIssues as $issue)
                            <p>{{ $issue->title }}</p>
                        @endforeach
                       @else
                           <p>Aucun numéro de magazine disponible.</p>
                                @endif

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="subscription">
            <h1>Subscription</h1>
            <p>Manage your subscription and billing details.</p>

            <table class="subscription-table">
    <thead>
        <tr>
            <th>Thème</th>
            <th>Statut</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @if(isset($themes) && $themes->count() > 0)
    @foreach($themes as $theme)
        <tr>
            <td>{{ $theme->name }}</td>
            <td id="status-{{ $theme->id }}">
                @if($theme->status) Subscribed @else Not Subscribed @endif
            </td>
            <td>
                <button class="subscribe-btn" id="subscribe-{{ $theme->id }}" onclick="toggleSubscription('{{ $theme->id }}')">
                    @if($theme->status) Unsubscribe @else Subscribe @endif
                </button>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="3">Aucun thème disponible.</td>
    </tr>
@endif

    </tbody>
</table>

            <button id="save-subscription-btn" class="settings-submit-btn">Save Changes</button>
        </section>

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
        

        <section id="settings" class="settings-section">
            <h2 class="settings-title">Settings</h2>
            <form id="settings-form" class="settings-form">
              <div class="settings-form-group">
                <label for="username" class="settings-label">Username:</label>
                <input type="text" id="username" class="settings-input" placeholder="Enter new username" required />
              </div>
              <div class="settings-form-group">
                <label for="password" class="settings-label">New Password:</label>
                <input type="password" id="password" class="settings-input" placeholder="Enter new password" />
              </div>
              <div class="settings-form-group">
                <label for="profile-image" class="settings-label">Profile Image:</label>
                <input type="file" id="profile-image" class="settings-file-input" accept="image/*" />
              </div>
              <button type="submit" id="save-settings-btn" class="settings-submit-btn">Save Changes</button>
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
