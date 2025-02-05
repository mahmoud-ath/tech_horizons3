<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tech Horizons</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('images/ai.jpg') }}"
                 alt="Admin Profile" class="admin-img" id="admin-img">
        </div>
        <ul class="sidebar-menu">
            <li><a href="#dashboard" class="active">Dashboard</a></li>
            <li><a href="#manage-articles">Manage Articles</a></li>
            <li><a href="#publication">Create Article</a></li>
            <li><a href="#manage-users">Manage Users</a></li>
            <li><a href="#manage-responsible-themes">Manage Themes</a></li>
            <li><a href="#manage-numbers">Manage Numbers</a></li>
            <li><a href="#settings">Settings</a></li>
        </ul>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <div>
            <div class="header-info">
                <span>Welcome back <span id="admin-username" style="font-weight: 900;">{{ Auth::user()->name }}</span></span>
                <a href="/">
                <button id="theme-btn-header" action="{{ route('/.index') }}" >back home</button>
                </a>
                <a href="/themes">
                <button id="theme-btn-header" action="{{ route('themes.index') }}" >Themes</button>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" id="logout-btn">Logout</button>
                </form>
            </div>
        </div>

        <!-- Dashboard Section -->
        <section id="dashboard">
            <h2>Latest Statistics</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Subscribers</h3>
                    <div class="stat-content">
                        <div class="stat-item">
                            <span>Total Subscribers</span>
                            <span id="total-subscribers">{{ $totalSubscribers }}</span>
                        </div>
                        <div class="stat-item">
                            <span>Active Subscribers</span>
                            <span id="active-subscribers">{{ $activeSubscribers }}</span>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <h3>Themes</h3>
                    <div class="stat-content">
                        <div class="stat-item">
                            <span>Total Themes</span>
                            <span id="total-themes">{{ $totalThemes }}</span>
                        </div>
                        <div class="stat-item">
                            <span>Active Themes</span>
                            <span id="active-responsible-themes">{{ $activeThemes }}</span>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <h3>Numbers</h3>
                    <div class="stat-content">
                        <div class="stat-item">
                            <span>Total Numbers</span>
                            <span id="total-numbers">{{ $totalNumbers }}</span>
                        </div>
                        <div class="stat-item">
                            <span>Published Numbers</span>
                            <span id="published-numbers">{{ $publishedNumbers }}</span>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <h3>Articles</h3>
                    <div class="stat-content">
                        <div class="stat-item">
                            <span>Total Articles</span>
                            <span id="total-articles">{{ $totalArticles }}</span>
                        </div>
                        <div class="stat-item">
                            <span>Published Articles</span>
                            <span id="published-articles">{{ $publishedArticles }}</span>
                        </div>
                        <div class="stat-item">
                            <span>Pending Articles</span>
                            <span id="pending-articles">{{ $pendingArticles }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Manage Articles Section -->

<!-- Manage Articles Section -->
<section id="manage-articles">
    <h2>Manage Articles</h2>
    <div class="articles-controls">
        <label for="themeFilter">Filter by Theme:</label>
        <select id="themeFilter">
            <option value="all">All Themes</option>
            @foreach ($themes as $theme)
                <option value="{{ $theme->id }}">{{ $theme->name }}</option>
            @endforeach
        </select>

        <label for="statusFilter">Filter by Status:</label>
        <select id="statusFilter">
            <option value="all">All Statuses</option>
            <option value="published">Published</option>
            <option value="pending">Pending</option>
        </select>
    </div>

    <table class="articles-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Theme</th>
                <th>Published Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="articlesTableBody">
            @foreach ($articles as $article)
                <tr data-id="{{ $article->id }}" data-theme="{{ $article->theme->id }}" data-status="{{ $article->status }}">
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->theme->name }}</td>
                    <td>{{ $article->published_date }}</td>
                    <td class="status">{{ $article->status }}</td>
                    <td class="actions">
                        <button class="activate-btn {{ $article->status === 'published' ? 'hidden' : '' }}" data-id="{{ $article->id }}">Activate</button>
                        <button class="deactivate-btn {{ $article->status === 'pending' ? 'hidden' : '' }}" data-id="{{ $article->id }}">Deactivate</button>
                        <button class="remove-btn" data-id="{{ $article->id }}">Remove</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</section>





        <!-- Create Article Section -->

<section id="publication">
    <h2>Create Article</h2>
    <form id="create-article-form" action="{{ route('adminhome') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="article-title">Title:</label>
            <input type="text" id="article-title" name="title" placeholder="Enter the article title" required />
        </div>
        <div class="form-group">
            <label for="article-theme">Theme:</label>
            <select id="article-theme" name="theme" required>
                <option value="1">Intelligence Artificielle</option>
                <option value="2">Internet des Objets</option>
                <option value="3">Cybersécurité</option>
                <option value="4">Réalité Virtuelle</option>
            </select>
        </div>
        <div class="form-group">
            <label for="article-status">Status:</label>
            <select id="article-status" name="status" required>
                <option value="Published">Published</option>
                <option value="Pending">Pending</option>
            </select>
        </div>
        <div class="form-group">
            <label for="article-cover">Cover Image:</label>
            <input type="file" id="article-cover" name="cover_image" accept="image/*" required />
        </div>
        <div class="form-group">
            <label for="article-content">Content:</label>
            <textarea id="article-content" name="content" placeholder="Enter the article content" rows="6" required></textarea>
        </div>
        <button type="submit" id="create-article-btn">Create Article</button>
    </form>
</section>
        </section>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
        $(document).ready(function() {
            // Handle form submission
            $('#create-article-form').on('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('adminhome') }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Append new article to the table
                        $('#articles-body').append(`
                            <tr>
                                <td>${response.title}</td>
                                <td>${response.theme.name}</td>
                                <td>${response.published_date}</td>
                                <td>${response.status}</td>
                                <td><!-- Actions --></td>
                            </tr>
                        `);
                        // Clear the form
                        $('#create-article-form')[0].reset();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
        </script>


        <!-- Manage Users Section -->
        <section id="manage-users">
            <h2>Manage Users</h2>
            <div class="users-controls">
                <label for="role-filter">Filter by Role:</label>
                <select id="role-filter" name="role">
                    <option value="all">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                    <option value="responsible-themes">Responsible Themes</option>
                </select>
                <button id="add-user-btn">Add User</button>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->usertype }}</td>
                        <td>{{ $user->email_verified_at ? 'Active' : 'Blocked' }}</td>
                        <td class="actions">
                            <button class="edit-btn" data-id="{{ $user->id }}">Edit</button>
                            <form method="POST" action="{{ route('admin.users.toggle', $user->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="block-btn">
                                    {{ $user->email_verified_at ? 'Block' : 'Unblock' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Add/Edit User Modal -->
            <div class="modal hidden" id="user-modal">
                <div class="modal-content">
                    <h3 id="modal-title">Add User</h3>
                    <form id="user-form" method="POST" action="{{ route('adminhome') }}">
                        @csrf
                        <input type="hidden" id="user-id" name="id">
                        <div class="form-group">
                            <label for="user-name">Name:</label>
                            <input type="text" id="user-name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="user-email">Email:</label>
                            <input type="email" id="user-email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="user-role">Role:</label>
                            <select id="user-role" name="usertype" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                                <option value="responsible-themes">Responsible Themes</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="user-status">Status:</label>
                            <select id="user-status" name="status" required>
                                <option value="Active">Active</option>
                                <option value="Blocked">Blocked</option>
                            </select>
                        </div>
                        <button type="submit">Save</button>
                        <button type="button" id="close-modal-btn">Cancel</button>
                    </form>
                </div>
            </div>
        </section>



    <!-- Manage Themes Section -->
    <section id="manage-responsible-themes">
        <h2>Manage Themes</h2>
        <div class="themes-controls">
            <label for="theme-status-filter">Filter by Status:</label>
            <select id="theme-status-filter" name="status">
                <option value="all">All Statuses</option>
                <option value="Public">Public</option>
                <option value="Private">Private</option>
            </select>
        </div>

        <table class="themes-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Responsible</th>
                    <th>Articles Count</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                @if(!empty($themes))
                @foreach($themes as $theme)
                <tr>
                    <td>{{ $theme->name }}</td>
                    <td>{{ $theme->user->name }}</td>
                    <td>{{ $theme->articles_count }}</td>
                    <td>{{ $theme->status }}</td>
                </tr>
            @endforeach
                @else
                    <p>No themes found.</p>
                @endif

            </tbody>
        </table>
    </section>

    <!-- Manage Numbers Section -->
    <section id="manage-issues">
        <h2>Manage Issues</h2>
        <div class="issues-controls">
            <label for="issue-status-filter">Filter by Status:</label>
            <select id="issue-status-filter" name="status">
                <option value="all">All Statuses</option>
                <option value="Open">Open</option>
                <option value="Closed">Closed</option>
            </select>
            <button id="add-issue-btn">Add Issue</button>
        </div>

        <table class="issues-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Publication Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($issues as $issue)
                    <tr>
                        <td>{{ $issue->id }}</td>
                        <td>{{ $issue->name }}</td>
                        <td><img src="{{ asset($issue->imagepath) }}" alt="{{ $issue->name }}" width="50"></td>
                        <td>{{ $issue->publication_date }}</td>
                        <td>{{ $issue->status }}</td>
                        <td class="actions">
                            <button class="open-btn" data-id="{{ $issue->id }}">Reopen</button>
                            <button class="close-btn" data-id="{{ $issue->id }}">Close</button>
                            <button class="remove-btn" data-id="{{ $issue->id }}">Remove</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>


    <!-- Settings Section -->

    <section id="settings">
        <h2>Settings</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form id="settings-form" action="{{ route('admin.updateSettings') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="user_name">Username:</label>
                <input type="text" name="user_name" id="user_name" placeholder="Enter new username" required value="{{ auth()->user()->user_name }}" />
            </div>
            <div class="form-group">
                <label for="password">New Password:</label>
                <input type="password" name="password" id="password" placeholder="Enter new password" />
            </div>
            <div class="form-group">
                <label for="profile-image">Profile Image:</label>
                <input type="file" name="profile_image" id="profile-image" accept="image/*" />
            </div>
            <button type="submit" id="save-settings-btn">Save Changes</button>
        </form>
    </section>




    <script src="{{ asset('js/admin.js') }}"></script>
    <script src="{{ asset('js/adminarticle.js') }}"></script>
</body>
</html>
