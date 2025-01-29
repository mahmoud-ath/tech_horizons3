// Handle sidebar navigation and section switching
document.querySelectorAll('.menu-link').forEach(link => {
    link.addEventListener('click', (event) => {
        event.preventDefault();

        // Get the target section
        const targetSection = link.getAttribute('data-section');

        // Hide all sections
        document.querySelectorAll('section').forEach(section => {
            section.classList.remove('active');
        });

        // Show the target section
        document.getElementById(targetSection).classList.add('active');

        // Update active class on sidebar links
        document.querySelectorAll('.menu-link').forEach(item => {
            item.classList.remove('active');
        });
        link.classList.add('active');
    });
});

document.getElementById("settings-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission
    
    // Get the new username and profile image
    const newUsername = document.getElementById("username").value;
    const profileImage = document.getElementById("profile-image").files[0];
    
    // Update the username
    if (newUsername) {
      document.getElementById("admin-username").textContent = newUsername;
    }
  
    // Update the profile image if one is selected
    if (profileImage) {
      const reader = new FileReader();
      
      reader.onload = function(e) {
        document.getElementById("admin-img").src = e.target.result;
        
      }
      
      reader.readAsDataURL(profileImage);
    }
  });
  
  document.getElementById("settings-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission
    
    // Get the new username and profile image
    const newUsername = document.getElementById("username").value;
    const profileImage = document.getElementById("profile-image").files[0];
    
    // Update the username
    if (newUsername) {
      document.getElementById("admin-username").textContent = newUsername;
    }
  
    // Update the profile image if one is selected
    if (profileImage) {
      const reader = new FileReader();
      
      reader.onload = function(e) {
        document.getElementById("admin-img").src = e.target.result;
      }
      
      reader.readAsDataURL(profileImage);
    }
});

document.getElementById("save-subscription-btn").addEventListener("click", function() {
    // Get the status of the theme checkboxes
    const theme1 = document.getElementById("theme1").checked;
    const theme2 = document.getElementById("theme2").checked;
    const theme3 = document.getElementById("theme3").checked;
    
    // Process the selected themes (You can replace this with actual subscription logic)
    let selectedThemes = [];
    if (theme1) selectedThemes.push("Theme 1");
    if (theme2) selectedThemes.push("Theme 2");
    if (theme3) selectedThemes.push("Theme 3");

    // Display the selected themes (this can be replaced with actual logic for saving the subscription)
    alert("Subscribed to: " + selectedThemes.join(", "));
});


// subscriptions
function toggleSubscription(theme) {
    const statusElement = document.getElementById(`status-${theme}`);
    const button = document.getElementById(`subscribe-${theme}`);

    if (statusElement.textContent === "Not Subscribed") {
        // Subscribe to the theme
        statusElement.textContent = "Subscribed";
        button.textContent = "Unsubscribe";
        button.classList.add('unsubscribe');
    } else {
        // Unsubscribe from the theme
        statusElement.textContent = "Not Subscribed";
        button.textContent = "Subscribe";
        button.classList.remove('unsubscribe');
    }
}

document.getElementById("save-subscription-btn").addEventListener("click", function() {
    // You can add logic here to save the changes, for example:
    // Send the current status of each theme to a backend or save it locally.
    
    let subscriptionStatus = {
        theme1: document.getElementById("status-theme1").textContent,
        theme2: document.getElementById("status-theme2").textContent,
        theme3: document.getElementById("status-theme3").textContent
    };

    alert("Subscription Status: " + JSON.stringify(subscriptionStatus));
});
// Function to handle article submission
document.getElementById('article-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Get form data
    const title = document.getElementById('article-title').value;
    const themes = Array.from(document.getElementById('article-themes').selectedOptions).map(option => option.value);
    const cover = document.getElementById('article-cover').files[0];
    const description = document.getElementById('article-description').value;

    // Create a new article object
    const newArticle = {
        title: title,
        themes: themes,
        cover: cover ? URL.createObjectURL(cover) : null,
        description: description,
        status: "En cours"
    };

    // Add the new article to the list (display it in the table)
    displayArticle(newArticle);

    // Reset the form
    document.getElementById('article-form').reset();
});

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

// Sample data for browsing history with date field (format: YYYY-MM-DD)
const browsingHistory = [
    { title: 'Article 1', themes: ['theme1'], status: 'Publié', date: '2025-01-28' },
    { title: 'Article 2', themes: ['theme2'], status: 'En cours', date: '2025-01-27' },
    { title: 'Article 3', themes: ['theme1', 'theme3'], status: 'Retenu', date: '2025-01-21' },
    { title: 'Article 4', themes: ['theme3'], status: 'Refus', date: '2025-01-05' },
];

// Function to format date in a readable format
function formatDate(date) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(date).toLocaleDateString('fr-FR', options);
}

// Function to filter the browsing history by date
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

// Function to filter history based on user input
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

// Initialize the page with full browsing history
displayHistory(browsingHistory);

// Add event listeners to filters
document.getElementById('filter-keyword').addEventListener('input', filterHistory);
document.getElementById('filter-themes').addEventListener('change', filterHistory);
document.getElementById('filter-status').addEventListener('change', filterHistory);
document.getElementById('filter-date').addEventListener('change', filterHistory);


// dashbord 
// Sample data for articles (with themes and subscription info)
const articles = [
    { title: 'Article 1', themes: ['theme1'], status: 'Publié', date: '2025-01-28', img: 'article1.jpg' },
    { title: 'Article 2', themes: ['theme2'], status: 'En cours', date: '2025-01-27', img: 'article1.jpg' },
    { title: 'Article 3', themes: ['theme1', 'theme3'], status: 'Retenu', date: '2025-01-21', img: 'article1.jpg' },
    { title: 'Article 4', themes: ['theme2'], status: 'Refus', date: '2025-01-05', img: 'article1.jpg' },
];

// Sample data for magazine issues
const magazineIssues = [
    { issueNumber: 1, title: 'Numéro 1 - Janvier 2025', description: 'Le premier numéro du mois de janvier.', img: 'magazine1.jpg' },
    { issueNumber: 2, title: 'Numéro 2 - Février 2025', description: 'Le second numéro pour février.', img: 'magazine1.jpg' },
    { issueNumber: 3, title: 'Numéro 3 - Mars 2025', description: 'Mars, un mois plein de nouveautés.', img: 'magazine1.jpg' },
];

// Sample user subscription data
const userSubscriptions = ['theme1', 'theme2']; // User is subscribed to theme1 and theme2

// Function to display recommended articles based on user subscriptions
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

// Function to display all magazine issues in a grid layout
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

// Initialize the dashboard with the relevant sections
function initializeDashboard() {
    displayRecommendedArticles();
    displayMagazineIssues();
}

// Initialize dashboard on page load
window.onload = initializeDashboard;


// Handle logout
document.getElementById("logout-btn").addEventListener("click", function () {
    // Logout logic (e.g., redirect to login page)
    alert("Logged out successfully!");
    // Redirect to login page (example)
    window.location.href = "login.html";
  });
  
  
  document.getElementById("theme-btn-user").addEventListener("click", function() {
    window.location.href = "/themes"; // Replace with your homepage URL
  });