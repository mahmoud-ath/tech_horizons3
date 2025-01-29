const articles = [
    {
        image:"./images/ai.jpg",
        title: "Les dernières innovations en Intelligence Artificielle",
        summary: "Explorez comment l'IA transforme les différents secteurs industriels et son impact sur notre quotidien.",
        date: "2025-01-10",
        views: 120,
        link: "#"
    },
    {
        image:"./images/cyber.jpg",
        title: "La Cybersécurité : Enjeux et Perspectives",
        summary: "Analyse des menaces cybernétiques actuelles et des solutions pour les contrer efficacement.",
        date: "2025-01-08",
        views: 98,
        link: "#"
    },
    {
        image:"./images/rva.jpg",
        title: "Réalité Virtuelle et Augmentée : Une immersion sans limite",
        summary: "Découvrez comment les technologies immersives redéfinissent le divertissement et la formation.",
        date: "2025-01-05",
        views: 75,
        link: "#"
    }
];

const articlesContainer = document.getElementById('articles');

articles.forEach(article => {
   const articleElement = document.createElement('div');
   articleElement.classList.add('article');

   articleElement.innerHTML = `
     <div class="article-container">
        <div class="article-content">
           <h3>${article.title}</h3>
           <p>${article.summary}</p>
           <p>Publié le : ${article.date} | Vues : ${article.views}</p>
           <a href="${article.link}" class="read-more">Lire plus</a>
           <a href="${article.link}" class="share">Partager</a>
        </div>
        <div class="article-image">
           <img src="${article.image || './images/placeholder.png'}" alt="${article.title}">
        </div>
     </div>
    `;

articlesContainer.appendChild(articleElement);
});
