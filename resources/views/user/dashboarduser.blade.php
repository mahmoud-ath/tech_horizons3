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
            <li><a href="{{ route('user.proposearticle') }}" data-section="propose-article" class="menu-link">Propose Article</a></li>
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
                       
                        @endif

                        </div>
                    </div>
                </div>
            </div>
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
    
        const articles = json.parse($recommendedArticles);
        const userSubscriptions = json.parse($subscriptions);
        const magazineIssues = json.parse($magazineIssues);

        function displayRecommendedArticles() {
            const recommendedArticles = articles.filter(article =>
                article.themes.some(theme => userSubscriptions.includes(theme))
            );

            const articlesList = document.getElementById('articles-list');
            articlesList.innerHTML = ''; // Clear existing list

            recommendedArticles.forEach(article => {
                const articleElement = document.createElement('div');
                articleElement.classList.add('recommended-article');
                articleElement.innerHTML = `
                    <div>
                        <h3>${article.title}</h3>
                        <p><strong>Thèmes:</strong> ${article.themes.join(', ')}</p>
                        <p><strong>Status:</strong> ${article.status}</p>
                        <p><strong>Date:</strong> ${new Date(article.date).toLocaleDateString('fr-FR')}</p>
                    </div>
                    <img src="${article.img}" alt="${article.title}">
                `;
                articlesList.appendChild(articleElement);
            });
        }

        function displayMagazineIssues() {
            const issuesList = document.getElementById('issues-list');
            issuesList.innerHTML = ''; // Clear existing list

            magazineIssues.forEach(issue => {
                const issueElement = document.createElement('div');
                issueElement.classList.add('magazine-issue');
                issueElement.innerHTML = `
                    <img src="${issue.img}" alt="Magazine Issue ${issue.issueNumber}">
                    <h3>${issue.title}</h3>
                    <p>${issue.description}</p>
                `;
                issuesList.appendChild(issueElement);
            });
        }

        function initializeDashboard() {
            displayRecommendedArticles();
            displayMagazineIssues();
        }

        // Initialize dashboard
        initializeDashboard();
    </script>
</body>
</html>
