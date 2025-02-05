
document.addEventListener("DOMContentLoaded", function () {
    const themeFilter = document.getElementById("themeFilter");
    const statusFilter = document.getElementById("statusFilter");
    const articlesTableBody = document.getElementById("articlesTableBody");

    function renderArticles() {
        const theme = themeFilter.value;
        const status = statusFilter.value;

        fetch('/articles/filter', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ theme: theme, status: status })
        })
        .then(response => response.json())
        .then(data => {
            articlesTableBody.innerHTML = '';
            data.articles.forEach(article => {
                const row = document.createElement('tr');
                row.dataset.id = article.id;
                row.innerHTML = `
                    <td>${article.title}</td>
                    <td>${article.theme}</td>
                    <td>${article.published_date}</td>
                    <td class="status">${article.status}</td>
                    <td class="actions">
                        <button class="activate-btn ${article.status === 'Published' ? 'hidden' : ''}" data-id="${article.id}">Activate</button>
                        <button class="deactivate-btn ${article.status === 'Pending' ? 'hidden' : ''}" data-id="${article.id}">Deactivate</button>
                        <button class="remove-btn" data-id="${article.id}">Remove</button>
                    </td>
                `;
                articlesTableBody.appendChild(row);
            });

            addArticleActions();
        });
    }

    themeFilter.addEventListener("change", renderArticles);
    statusFilter.addEventListener("change", renderArticles);
});

document.addEventListener("DOMContentLoaded", function () {
      function updateArticleStatus(articleId, newStatus) {
          fetch('/articles/update', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
              },
              body: JSON.stringify({ id: articleId, status: newStatus })
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  const row = document.querySelector(`tr[data-id='${articleId}']`);
                  row.querySelector(".status").textContent = newStatus;
                  row.querySelector(".activate-btn").classList.toggle("hidden", newStatus === "Published");
                  row.querySelector(".deactivate-btn").classList.toggle("hidden", newStatus === "Pending");
              } else {
                  alert("Erreur lors de la mise à jour.");
              }
          });
      }

      function removeArticle(articleId) {
          if (!confirm("Are you sure you want to remove this article?")) return;

          fetch('/articles/delete', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
              },
              body: JSON.stringify({ id: articleId })
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  document.querySelector(`tr[data-id='${articleId}']`).remove();
              } else {
                  alert("Erreur lors de la suppression.");
              }
          });
      }

      document.querySelectorAll(".activate-btn").forEach(button => {
          button.addEventListener("click", () => updateArticleStatus(button.dataset.id, "Published"));
      });

      document.querySelectorAll(".deactivate-btn").forEach(button => {
          button.addEventListener("click", () => updateArticleStatus(button.dataset.id, "Pending"));
      });

      document.querySelectorAll(".remove-btn").forEach(button => {
          button.addEventListener("click", () => removeArticle(button.dataset.id));
      });
  });

  