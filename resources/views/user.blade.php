<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="{{ $user->profile_image }}" alt="Admin Profile" class="admin-img" id="admin-img" />
            <span>{{ $user->username }}</span>
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
            <span>Welcome back, <span id="admin-username" style="font-weight: 900;">{{ $user->username }}</span></span>
            <button id="theme-btn-user">Themes</button>
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
                        @foreach($recommendedArticles as $article)
                            <p>{{ $article->title }}</p>
                        @endforeach
                    </div>
                </div>

                <!-- Magazine Issues Section (Right) -->
                <div id="">
                    <h2>Numéros du Magazine</h2>
                    <div class="magazine-issues">
                        <div id="issues-list">
                            @foreach($magazineIssues as $issue)
                                <p>{{ $issue->title }}</p>
                            @endforeach
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
                        <th>Theme Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptions as $subscription)
                        <tr>
                            <td>{{ $subscription->theme }}</td>
                            <td id="status-{{ $subscription->theme }}">@if($subscription->is_active) Subscribed @else Not Subscribed @endif</td>
                            <td>
                                <button class="subscribe-btn" id="subscribe-{{ $subscription->theme }}" onclick="toggleSubscription('{{ $subscription->theme }}')">
                                    @if($subscription->is_active) Unsubscribe @else Subscribe @endif
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button id="save-subscription-btn" class="settings-submit-btn">Save Changes</button>
        </section>

        <!-- Other sections remain unchanged -->

    </div>

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
