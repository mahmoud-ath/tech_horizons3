// Global state management
const state = {
     users: [],

    currentUser: {
      name: 'Admin',
      role: 'admin',
    },



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
    issuesTableBody: document.querySelector('.issues-table tbody'),
    issuestatusFilter: document.getElementById('issue-status-filter'),
    addissuesBtn: document.getElementById('add-issue-btn'),
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
  
  // Render Users in Table
 // State


  // Fetch and Render Users in Table
  async function fetchUsers() {
    const response = await fetch('/api/users'); // Adjust the API endpoint as needed
    const users = await response.json();
    state.users = users;
    renderUsers();
  }

  // Render Users in Table
  function renderUsers() {
    const roleFilter = document.getElementById('role-filter').value;
    const usersTableBody = document.querySelector('.users-table tbody');

    const filteredUsers = state.users.filter((user) => {
      return roleFilter === 'all' || user.usertype === roleFilter;
    });

    usersTableBody.innerHTML = '';
    filteredUsers.forEach((user) => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${user.id}</td>
        <td>${user.name}</td>
        <td>${user.email}</td>
        <td>${user.usertype}</td>
        <td>${user.email_verified_at ? 'Active' : 'Blocked'}</td>
        <td class="actions">
          <button class="edit-btn" data-id="${user.id}">Edit</button>
          <button class="block-btn" data-id="${user.id}">${user.email_verified_at ? 'Block' : 'Unblock'}</button>
          <button class="delete-btn" data-id="${user.id}">Delete</button>
        </td>
      `;
      usersTableBody.appendChild(row);
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
      button.addEventListener('click', async () => {
        const userId = parseInt(button.dataset.id, 10);
        await toggleBlockUser(userId);
        fetchUsers();
      });
    });

    document.querySelectorAll('.delete-btn').forEach((button) => {
      button.addEventListener('click', async () => {
        const userId = parseInt(button.dataset.id, 10);
        await deleteUser(userId);
        fetchUsers();
      });
    });
  }

  // Open Modal
  function openModal(isEdit = false, user = null) {
    const userModal = document.getElementById('user-modal');
    const userForm = document.getElementById('user-form');
    userModal.classList.remove('hidden');
    userForm.reset();

    if (isEdit && user) {
      document.getElementById('modal-title').textContent = 'Edit User';
      document.getElementById('user-id').value = user.id;
      document.getElementById('user-name').value = user.name;
      document.getElementById('user-email').value = user.email;
      document.getElementById('user-role').value = user.usertype;
      document.getElementById('user-status').value = user.email_verified_at ? 'Active' : 'Blocked';
    } else {
      document.getElementById('modal-title').textContent = 'Add User';
    }
  }

  // Close Modal
  function closeModal() {
    const userModal = document.getElementById('user-modal');
    userModal.classList.add('hidden');
  }

  // Save User
  async function saveUser(event) {
    event.preventDefault();

    const userIdInput = document.getElementById('user-id');
    const userNameInput = document.getElementById('user-name');
    const userEmailInput = document.getElementById('user-email');
    const userRoleInput = document.getElementById('user-role');
    const userStatusSelect = document.getElementById('user-status');

    const id = userIdInput.value ? parseInt(userIdInput.value, 10) : null;
    const name = userNameInput.value;
    const email = userEmailInput.value;
    const usertype = userRoleInput.value;
    const email_verified_at = userStatusSelect.value === 'Active' ? new Date().toISOString() : null;

    const user = { id, name, email, usertype, email_verified_at };
    const method = id ? 'PUT' : 'POST';
    const endpoint = id ? `/api/users/${id}` : '/api/users';

    await fetch(endpoint, {
      method,
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(user),
    });

    fetchUsers();
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
  async function toggleBlockUser(userId) {
    const user = state.users.find((user) => user.id === userId);
    if (user) {
      user.email_verified_at = user.email_verified_at ? null : new Date().toISOString();
      await fetch(`/api/users/${userId}/toggle-block`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(user),
      });
    }
  }

  // Delete User
  async function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
      await fetch(`/api/users/${userId}`, {
        method: 'DELETE',
      });
    }
  }

  // Initialize Manage Users
  document.getElementById('add-user-btn').addEventListener('click', () => openModal());
  document.getElementById('close-modal-btn').addEventListener('click', closeModal);
  document.getElementById('user-form').addEventListener('submit', saveUser);

  document.addEventListener('DOMContentLoaded', function () {
    const issueStatusFilter = document.getElementById('issue-status-filter');
    const addIssueBtn = document.getElementById('add-issue-btn');
    const issuesTableBody = document.querySelector('.issues-table tbody');

    // Fetch and render issues
    function fetchIssues() {
        fetch('/issues')
            .then(response => response.json())
            .then(issues => {
                renderIssues(issues);
            });
    }

    // Render issues in the table
    function renderIssues(issues) {
        issuesTableBody.innerHTML = '';
        issues.forEach(issue => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${issue.id}</td>
                <td>${issue.name}</td>
                <td><img src="${issue.imagepath}" alt="${issue.name}" width="50"></td>
                <td>${issue.publication_date}</td>
                <td>${issue.status}</td>
                <td class="actions">
                    <button class="open-btn" data-id="${issue.id}">Reopen</button>
                    <button class="close-btn" data-id="${issue.id}">Close</button>
                    <button class="remove-btn" data-id="${issue.id}">Remove</button>
                </td>
            `;
            issuesTableBody.appendChild(row);
        });

        addIssueActions();
    }

    // Add event listeners for issue actions
    function addIssueActions() {
        document.querySelectorAll('.open-btn').forEach(button => {
            button.addEventListener('click', () => {
                const issueId = button.dataset.id;
                updateIssueStatus(issueId, 'Open');
            });
        });

        document.querySelectorAll('.close-btn').forEach(button => {
            button.addEventListener('click', () => {
                const issueId = button.dataset.id;
                updateIssueStatus(issueId, 'Closed');
            });
        });

        document.querySelectorAll('.remove-btn').forEach(button => {
            button.addEventListener('click', () => {
                const issueId = button.dataset.id;
                removeIssue(issueId);
            });
        });
    }

    // Update issue status
    function updateIssueStatus(issueId, status) {
        fetch(`/issues/${issueId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ status }),
        })
        .then(response => response.json())
        .then(updatedIssue => {
            fetchIssues();
        });
    }

    // Remove issue
    function removeIssue(issueId) {
        fetch(`/issues/${issueId}`, {
            method: 'DELETE',
        })
        .then(() => {
            fetchIssues();
        });
    }

    // Add new issue
    addIssueBtn.addEventListener('click', () => {
        const name = prompt('Enter the name of the new issue:');
        const publicationDate = prompt('Enter the publication date (YYYY-MM-DD):');
        const status = prompt('Enter the status (Open/Closed):');

        if (name && publicationDate && status) {
            fetch('/issues', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ name, publication_date: publicationDate, status }),
            })
            .then(response => response.json())
            .then(newIssue => {
                fetchIssues();
            });
        }
    });

    // Initial fetch
    fetchIssues();
});

  // Initialize Application
  document.addEventListener('DOMContentLoaded', () => {
    handleNavigation();
    updateStatistics();
    renderArticles();
    renderUsers();
    renderThemes();
    renderIssues();

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
