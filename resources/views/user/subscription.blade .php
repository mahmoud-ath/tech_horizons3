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
            <li><a href="{{ route('user.browsing-history') }}" data-section="propose-article" class="menu-link">Propose Article</a></li>
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
