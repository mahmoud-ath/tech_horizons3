// Global state management
const state = {
    statistics: {
      totalSubscribers: 1500,
      activeSubscribers: 1200,
      totalThemes: 5,
      activeManagers: 4,
      totalNumbers: 10,
      publishedNumbers: 8,
      totalArticles: 50,
      publishedArticles: 40,
      pendingArticles: 10,
    },
    currentUser: {
      name: 'Admin',
      role: 'admin',
    },
    articles: [
      {
        id: 1,
        title: 'Article Title 1',
        theme: 'Technology',
        content: 'This is the content of Article 1.',
        publishedDate: '2023-10-01',
        status: 'Published',
        coverImage: '',
      },
      {
        id: 2,
        title: 'Article Title 2',
        theme: 'Science',
        content: 'This is the content of Article 2.',
        publishedDate: '2023-10-02',
        status: 'Pending',
        coverImage: '',
      },
    ],

    users: [
      { id: 1, name: 'John Doe', email: 'john@example.com', role: 'admin', status: 'Active' },
      { id: 2, name: 'Jane Smith', email: 'jane@example.com', role: 'user', status: 'Blocked' },
    ],
    numbers: [
      { id: 1, title: 'Issue 1', date: '2023-01-01', status: 'Public' },
      { id: 2, title: 'Issue 2', date: '2023-02-01', status: 'Private' },
    ],
  };

  // DOM Elements Cache
  const elements = {
    sections: document.querySelectorAll('section'),
    sidebarLinks: document.querySelectorAll('.sidebar a'),
    logoutBtn: document.getElementById('logout-btn'),
    statsElements: {
      totalSubscribers: document.getElementById('total-subscribers'),
      activeSubscribers: document.getElementById('active-subscribers'),
      totalThemes: document.getElementById('total-themes'),
      activeResponsibleThemes: document.getElementById('active-responsible-themes'),
      totalNumbers: document.getElementById('total-numbers'),
      publishedNumbers: document.getElementById('published-numbers'),
      totalArticles: document.getElementById('total-articles'),
      publishedArticles: document.getElementById('published-articles'),
      pendingArticles: document.getElementById('pending-articles'),
    },
    articlesTableBody: document.querySelector('.articles-table tbody'),
    themeFilter: document.getElementById('theme-filter'),
    statusFilter: document.getElementById('status-filter'),
    createArticleForm: document.getElementById('create-article-form'),
    usersTableBody: document.querySelector('.users-table tbody'),
    userModal: document.getElementById('user-modal'),
    userForm: document.getElementById('user-form'),
    userIdInput: document.getElementById('user-id'),
    userNameInput: document.getElementById('user-name'),
    userEmailInput: document.getElementById('user-email'),
    userStatusSelect: document.getElementById('user-status'),
    closeModalBtn: document.getElementById('close-modal-btn'),
    addUserBtn: document.getElementById('add-user-btn'),
    roleFilter: document.getElementById('role-filter'),
    userRoleInput: document.getElementById('user-role'),
    themesTableBody: document.querySelector('.themes-table tbody'),
    themeStatusFilter: document.getElementById('theme-status-filter'),
    numbersTableBody: document.querySelector('.numbers-table tbody'),
    numberStatusFilter: document.getElementById('number-status-filter'),
    addNumberBtn: document.getElementById('add-number-btn'),
  };

  // Navigation Handler
  function handleNavigation() {
    const hash = window.location.hash || '#dashboard';

    if (!elements.sections || !elements.sidebarLinks) {
        console.error('Elements are not defined correctly.');
        return;
    }

    elements.sections.forEach((section) => section.classList.remove('active'));
    elements.sidebarLinks.forEach((link) => link.classList.remove('active'));

    const currentSection = document.querySelector(hash);
    const currentLink = document.querySelector(`a[href="${hash}"]`);

    if (currentSection) currentSection.classList.add('active');
    if (currentLink) currentLink.classList.add('active');
}

window.addEventListener('load', handleNavigation);
window.addEventListener('hashchange', handleNavigation);

  // Update Statistics Display
  function updateStatistics() {
    Object.entries(state.statistics).forEach(([key, value]) => {
      const element = elements.statsElements[key];
      if (element) {
        element.textContent = value.toLocaleString();
      }
    });
  }

  // Render Themes in Table
  function renderThemes() {
    const statusFilter = elements.themeStatusFilter.value;

    const filteredThemes = state.themes.filter((theme) =>
      statusFilter === 'all' || theme.status === statusFilter
    );

    elements.themesTableBody.innerHTML = '';

    filteredThemes.forEach((theme) => {
      const row = document.createElement('tr');

      elements.themesTableBody.appendChild(row);
    });

    addThemeActions();
  }

  // Add Event Listeners for Theme Actions
  function addThemeActions() {
    document.querySelectorAll('.change-btn').forEach((button) => {
      button.addEventListener('click', () => {
        const themeId = parseInt(button.dataset.id, 10);
        changeResponsible(themeId);
      });
    });

    document.querySelectorAll('.remove-btn').forEach((button) => {
      button.addEventListener('click', () => {
        const themeId = parseInt(button.dataset.id, 10);
        removeResponsible(themeId);
      });
    });

    document.querySelectorAll('.status-toggle-btn').forEach((button) => {
      button.addEventListener('click', () => {
        const themeId = parseInt(button.dataset.id, 10);
        toggleThemeStatus(themeId);
      });
    });
  }

  // Change Responsible for Theme
  function changeResponsible(themeId) {
    const theme = state.themes.find((theme) => theme.id === themeId);
    if (theme) {
      const newResponsible = prompt('Enter the name of the new responsible user:');
      if (newResponsible) {
        theme.responsible = newResponsible;
        alert(`Responsible for theme "${theme.name}" updated to ${newResponsible}`);
        renderThemes();
      }
    }
  }

  // Remove Responsible from Theme
  function removeResponsible(themeId) {
    const theme = state.themes.find((theme) => theme.id === themeId);
    if (theme) {
      theme.responsible = 'Unassigned';
      alert(`Responsible removed for theme "${theme.name}"`);
      renderThemes();
    }
  }

  // Toggle Theme Status
  function toggleThemeStatus(themeId) {
    const theme = state.themes.find((theme) => theme.id === themeId);
    if (theme) {
      theme.status = theme.status === 'Public' ? 'Private' : 'Public';
      alert(`Status for theme "${theme.name}" changed to ${theme.status}`);
      renderThemes();
    }
  }

  // Render Articles in Table
  function renderArticles() {
    const themeFilter = elements.themeFilter.value;
    const statusFilter = elements.statusFilter.value;

    const filteredArticles = state.articles.filter((article) => {
      return (
        (themeFilter === 'all' || article.theme === themeFilter) &&
        (statusFilter === 'all' || article.status === statusFilter)
      );
    });

    elements.articlesTableBody.innerHTML = '';
    filteredArticles.forEach((article) => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${article.title}</td>
        <td>${article.theme}</td>
        <td>${article.publishedDate}</td>
        <td>${article.status}</td>
        <td class="actions">
          <button class="activate-btn ${article.status === 'Published' ? 'hidden' : ''}" data-id="${article.id}">Activate</button>
          <button class="deactivate-btn ${article.status === 'Pending' ? 'hidden' : ''}" data-id="${article.id}">Deactivate</button>
          <button class="remove-btn" data-id="${article.id}">Remove</button>
        </td>
      `;
      elements.articlesTableBody.appendChild(row);
    });

    addArticleActions();
  }

  // Add Event Listeners for Article Actions
  function addArticleActions() {
    document.querySelectorAll('.activate-btn').forEach((button) => {
      button.addEventListener('click', () => {
        const articleId = parseInt(button.dataset.id, 10);
        activateArticle(articleId);
      });
    });

    document.querySelectorAll('.deactivate-btn').forEach((button) => {
      button.addEventListener('click', () => {
        const articleId = parseInt(button.dataset.id, 10);
        deactivateArticle(articleId);
      });
    });

    document.querySelectorAll('.remove-btn').forEach((button) => {
      button.addEventListener('click', () => {
        const articleId = parseInt(button.dataset.id, 10);
        removeArticle(articleId);
      });
    });
  }

  // Activate Article
  function activateArticle(articleId) {
    const article = state.articles.find((article) => article.id === articleId);
    if (article) {
      article.status = 'Published';
      renderArticles();
      alert('Article activated successfully!');
    }
  }

  // Deactivate Article
  function deactivateArticle(articleId) {
    const article = state.articles.find((article) => article.id === articleId);
    if (article) {
      article.status = 'Pending';
      renderArticles();
      alert('Article deactivated successfully!');
    }
  }

  // Remove Article
  function removeArticle(articleId) {
    if (confirm('Are you sure you want to remove this article?')) {
      state.articles = state.articles.filter((article) => article.id !== articleId);
      renderArticles();
      alert('Article removed successfully!');
    }
  }

  // Render Users in Table
  function renderUsers() {
    const roleFilter = elements.roleFilter.value;

    const filteredUsers = state.users.filter((user) => {
      return roleFilter === 'all' || user.role === roleFilter;
    });

    elements.usersTableBody.innerHTML = '';
    filteredUsers.forEach((user) => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${user.id}</td>
        <td>${user.name}</td>
        <td>${user.email}</td>
        <td>${user.role}</td>
        <td>${user.status}</td>
        <td class="actions">
          <button class="edit-btn" data-id="${user.id}">Edit</button>
          <button class="block-btn" data-id="${user.id}">${user.status === 'Active' ? 'Block' : 'Unblock'}</button>
          <button class="delete-btn" data-id="${user.id}">Delete</button>
        </td>
      `;
      elements.usersTableBody.appendChild(row);
      elements.roleFilter?.addEventListener('change', renderUsers);

    });

    addUserActions();
  }

  // Add Event Listeners for User Actions
  function addUserActions() {
    document.querySelectorAll('.edit-btn').forEach((button) => {
      button.addEventListener('click', () => {
        const userId = parseInt(button.dataset.id, 10);
        editUser(userId);
      });
    });

    document.querySelectorAll('.block-btn').forEach((button) => {
      button.addEventListener('click', () => {
        const userId = parseInt(button.dataset.id, 10);
        toggleBlockUser(userId);
      });
    });

    document.querySelectorAll('.delete-btn').forEach((button) => {
      button.addEventListener('click', () => {
        const userId = parseInt(button.dataset.id, 10);
        deleteUser(userId);
      });
    });
  }

  // Open Modal
  function openModal(isEdit = false, user = null) {
    elements.userModal.classList.remove('hidden');
    elements.userForm.reset();

    if (isEdit && user) {
      document.getElementById('modal-title').textContent = 'Edit User';
      elements.userIdInput.value = user.id;
      elements.userNameInput.value = user.name;
      elements.userEmailInput.value = user.email;
      elements.userStatusSelect.value = user.status;
    } else {
      document.getElementById('modal-title').textContent = 'Add User';
    }
  }

  // Close Modal
  function closeModal() {
    elements.userModal.classList.add('hidden');
  }

  // Save User
  function saveUser(event) {
    event.preventDefault();

    const id = elements.userIdInput.value
      ? parseInt(elements.userIdInput.value, 10)
      : (state.users.length > 0 ? Math.max(...state.users.map(user => user.id)) + 1 : 1);
    const name = elements.userNameInput.value;
    const email = elements.userEmailInput.value;
    const role = elements.userRoleInput.value;
    const status = elements.userStatusSelect.value;

    if (elements.userIdInput.value) {
      const userIndex = state.users.findIndex((user) => user.id === id);
      if (userIndex > -1) {
        state.users[userIndex] = { id, name, email, role, status };
      }
    } else {
      state.users.push({ id, name, email, role, status });
    }

    renderUsers();
    closeModal();
  }

  // Edit User
  function editUser(userId) {
    const user = state.users.find((user) => user.id === userId);
    if (user) {
      openModal(true, user);
    }
  }

  // Block/Unblock User
  function toggleBlockUser(userId) {
    const user = state.users.find((user) => user.id === userId);
    if (user) {
      user.status = user.status === 'Active' ? 'Blocked' : 'Active';
      renderUsers();
    }
  }

  // Delete User
  function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
      state.users = state.users.filter((user) => user.id !== userId);
      renderUsers();
    }
  }

  // Initialize Manage Users
  elements.addUserBtn.addEventListener('click', () => openModal());
  elements.closeModalBtn.addEventListener('click', closeModal);
  elements.userForm.addEventListener('submit', saveUser);

  // Initialize Application
  document.addEventListener('DOMContentLoaded', () => {
    handleNavigation();
    updateStatistics();
    renderArticles();
    renderUsers();
    renderThemes();

    window.addEventListener('hashchange', handleNavigation);

    elements.themeFilter?.addEventListener('change', renderArticles);
    elements.statusFilter?.addEventListener('change', renderArticles);
    elements.themeStatusFilter?.addEventListener('change', renderThemes);
  });



  // Render Numbers in Table
  function renderNumbers() {
    const statusFilter = elements.numberStatusFilter.value;

    const filteredNumbers = state.numbers.filter((number) =>
      statusFilter === 'all' || number.status === statusFilter
    );

    elements.numbersTableBody.innerHTML = '';

    filteredNumbers.forEach((number) => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${number.id}</td>
        <td>${number.title}</td>
        <td>${number.date}</td>
        <td>${number.status}</td>
        <td class="actions">
          <button class="publish-btn" data-id="${number.id}">Make Public</button>
          <button class="private-btn" data-id="${number.id}">Make Private</button>
          <button class="remove-btn" data-id="${number.id}">Remove</button>
        </td>
      `;
      elements.numbersTableBody.appendChild(row);
    });

    addNumberActions();
  }

  // Add Event Listeners for Number Actions
  function addNumberActions() {
    document.querySelectorAll('.publish-btn').forEach((button) => {
      button.addEventListener('click', () => {
        const numberId = parseInt(button.dataset.id, 10);
        changeNumberStatus(numberId, 'Public');
      });
    });

    document.querySelectorAll('.private-btn').forEach((button) => {
      button.addEventListener('click', () => {
        const numberId = parseInt(button.dataset.id, 10);
        changeNumberStatus(numberId, 'Private');
      });
    });

    document.querySelectorAll('.remove-btn').forEach((button) => {
      button.addEventListener('click', () => {
        const numberId = parseInt(button.dataset.id, 10);
        removeNumber(numberId);
      });
    });
  }

  // Change Number Status
  function changeNumberStatus(numberId, status) {
    const number = state.numbers.find((num) => num.id === numberId);
    if (number) {
      number.status = status;
      alert(`Number "${number.title}" is now ${status}`);
      renderNumbers();
    }
  }

  // Remove Number
  function removeNumber(numberId) {
    if (confirm('Are you sure you want to remove this number?')) {
      state.numbers = state.numbers.filter((num) => num.id !== numberId);
      renderNumbers();
      alert('Number removed successfully!');
    }
  }

  // Add New Number
  function addNumber() {
    const newId = state.numbers.length > 0 ? Math.max(...state.numbers.map((num) => num.id)) + 1 : 1;
    const title = prompt('Enter the title of the new number:');
    const date = prompt('Enter the publication date (YYYY-MM-DD):');

    if (title && date) {
      state.numbers.push({ id: newId, title, date, status: 'Private' });
      renderNumbers();
      alert('New number added successfully!');
    }
  }

  // Initialize Manage Numbers
  elements.numberStatusFilter.addEventListener('change', renderNumbers);
  elements.addNumberBtn.addEventListener('click', addNumber);

  // Initialize Application
  document.addEventListener('DOMContentLoaded', () => {
    handleNavigation();
    updateStatistics();
    renderArticles();
    renderUsers();
    renderThemes();
    renderNumbers();

    window.addEventListener('hashchange', handleNavigation);

    elements.themeFilter?.addEventListener('change', renderArticles);
    elements.statusFilter?.addEventListener('change', renderArticles);
    elements.themeStatusFilter?.addEventListener('change', renderThemes);
  });
  document.getElementById("settings-form").addEventListener("submit", function (event) {
    event.preventDefault();

    const newUsername = document.getElementById('username').value;
    const newPassword = document.getElementById('password').value;
    const imageInput = document.getElementById('profile-image');
    const formData = new FormData();

    formData.append('_token', document.querySelector('input[name="_token"]').value);
    formData.append('username', newUsername);
    if (newPassword) {
      formData.append('password', newPassword);
    }
    if (imageInput.files.length > 0) {
      formData.append('profile-image', imageInput.files[0]);
    }

    fetch('/update-settings', {
      method: 'POST',
      body: formData,
    })
      .then(response => response.json())
      .then(data => {
        // Update the UI
        document.getElementById('current-username').textContent = data.username;

        if (data.profile_image) {
          document.querySelector('.admin-img').src = `/storage/${data.profile_image}`;
        }

        alert('Settings updated successfully!');
      })
      .catch(error => {
        console.error('Error updating settings:', error);
        alert('Failed to update settings.');
      });
  });

  // button of the header

  // Handle logout
  document.getElementById("logout-btn").addEventListener("click", function () {
    // Logout logic (e.g., redirect to login page)
    alert("Logged out successfully!");
    // Redirect to login page (example)
    window.location.href = "login.html";
  });

  document.getElementById("back-home-btn").addEventListener("click", function() {
    window.location.href = "/"; // Replace with your homepage URL
  });
  document.getElementById("theme-btn-header").addEventListener("click", function() {
    window.location.href = "/themes"; // Replace with your homepage URL
  });
