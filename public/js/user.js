// Initialize the dashboard when the DOM is fully loaded
document.addEventListener("DOMContentLoaded", function () {
    initializeDashboard();
    setupEventListeners();
});

// Function to initialize the dashboard
function initializeDashboard() {
    // Fetch data passed from Laravel Blade
    const articles = JSON.parse(document.getElementById('articles-data').textContent);
    const userSubscriptions = JSON.parse(document.getElementById('subscriptions-data').textContent);
    const magazineIssues = JSON.parse(document.getElementById('magazine-issues-data').textContent);

    // Display recommended articles and magazine issues
    displayRecommendedArticles(articles, userSubscriptions);
    displayMagazineIssues(magazineIssues);
}

// Function to set up event listeners
function setupEventListeners() {
    // Sidebar navigation
    document.querySelectorAll('.menu-link').forEach(link => {
        link.addEventListener('click', handleSidebarNavigation);
    });

       

    // Subscription button
    const saveSubscriptionBtn = document.getElementById('save-subscription-btn');
    if (saveSubscriptionBtn) {
        saveSubscriptionBtn.addEventListener('click', handleSubscriptionSave);
    }

   

    // Filter browsing history
    document.getElementById('filter-keyword')?.addEventListener('input', filterHistory);
    document.getElementById('filter-themes')?.addEventListener('change', filterHistory);
    document.getElementById('filter-status')?.addEventListener('change', filterHistory);
    document.getElementById('filter-date')?.addEventListener('change', filterHistory);

    // Logout button
    const logoutBtn = document.getElementById('logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', handleLogout);
    }

    // Theme button
    const themeBtn = document.getElementById('theme-btn-user');
    if (themeBtn) {
        themeBtn.addEventListener('click', handleThemeButtonClick);
    }
}

// Function to handle sidebar navigation
function handleSidebarNavigation(event) {
    event.preventDefault();

    // Get the target section
    const targetSection = event.target.getAttribute('data-section');

    // Hide all sections
    document.querySelectorAll('section').forEach(section => {
        section.classList.remove('active');
    });

    // Show the target section
    document.getElementById(targetSection)?.classList.add('active');

    // Update active class on sidebar links
    document.querySelectorAll('.menu-link').forEach(item => {
        item.classList.remove('active');
    });
    event.target.classList.add('active');
}








// Function to handle subscription save
function handleSubscriptionSave() {
    // Get the status of the theme checkboxes
    const theme1 = document.getElementById('theme1').checked;
    const theme2 = document.getElementById('theme2').checked;
    const theme3 = document.getElementById('theme3').checked;

    // Process the selected themes
    let selectedThemes = [];
    if (theme1) selectedThemes.push('Theme 1');
    if (theme2) selectedThemes.push('Theme 2');
    if (theme3) selectedThemes.push('Theme 3');

    // Display the selected themes (replace with actual logic for saving the subscription)
    alert('Subscribed to: ' + selectedThemes.join(', '));
}

// Function to display an article in the table
function displayArticle(article) {
    const tableBody = document.getElementById('articles-list');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>${article.title}</td>
        <td>${article.themes.join(', ')}</td>
        <td>${article.status}</td>
    `;
    tableBody.appendChild(row);
}

// Function to filter browsing history
function filterHistory() {
    const keyword = document.getElementById('filter-keyword').value.toLowerCase();
    const selectedTheme = document.getElementById('filter-themes').value;
    const selectedStatus = document.getElementById('filter-status').value;
    const selectedDate = document.getElementById('filter-date').value;

    const filteredHistory = browsingHistory.filter(article => {
        const matchesKeyword = article.title.toLowerCase().includes(keyword);
        const matchesTheme = selectedTheme ? article.themes.includes(selectedTheme) : true;
        const matchesStatus = selectedStatus ? article.status === selectedStatus : true;
        const matchesDate = filterByDate(selectedDate).includes(article);

        return matchesKeyword && matchesTheme && matchesStatus && matchesDate;
    });

    displayHistory(filteredHistory);
}

// Function to display browsing history
function displayHistory(filteredHistory) {
    const tableBody = document.getElementById('history-list');
    tableBody.innerHTML = ''; // Clear the existing list

    filteredHistory.forEach(article => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${article.title}</td>
            <td>${article.themes.join(', ')}</td>
            <td>${article.status}</td>
            <td>${formatDate(article.date)}</td>
        `;
        tableBody.appendChild(row);
    });
}

// Function to format date
function formatDate(date) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(date).toLocaleDateString('fr-FR', options);
}

// Function to filter by date
function filterByDate(dateFilter) {
    const today = new Date();
    const startOfWeek = new Date(today);
    startOfWeek.setDate(today.getDate() - today.getDay()); // Start of the current week
    const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1); // Start of the current month
    const oneDay = 24 * 60 * 60 * 1000;

    return browsingHistory.filter(article => {
        const articleDate = new Date(article.date);

        switch (dateFilter) {
            case 'today':
                return articleDate.toDateString() === today.toDateString();
            case 'yesterday':
                const yesterday = new Date(today - oneDay);
                return articleDate.toDateString() === yesterday.toDateString();
            case 'last-week':
                return articleDate >= startOfWeek && articleDate < today;
            case 'last-month':
                return articleDate >= startOfMonth && articleDate < today;
            default:
                return true; // No date filter applied
        }
    });
}

// Function to handle logout
function handleLogout() {
    alert('Logged out successfully!');
    window.location.href = "{{ route('login') }}";
}

// Function to handle theme button click
function handleThemeButtonClick() {
    window.location.href = "{{ route('themes.index') }}";
}