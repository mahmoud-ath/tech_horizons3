        // Scripts JavaScript personnalisés
        document.addEventListener('DOMContentLoaded', () => {
            const themeCards = document.querySelectorAll('.theme-card');

            themeCards.forEach(card => {
                card.addEventListener('click', () => {
                    alert(`Redirection vers le thème : ${card.querySelector('h3').textContent}`);
                });
            });
        });
        // Exemple de données, récupérées depuis une API ou une base de données
const articleCounts = {
    ai: 42,
    iot: 30,
    cybersecurity: 25,
    vr: 18
};

// Mise à jour des éléments correspondants dans la page
document.getElementById('ai-count').textContent = articleCounts.ai;
document.getElementById('iot-count').textContent = articleCounts.iot;
document.getElementById('cybersecurity-count').textContent = articleCounts.cybersecurity;
document.getElementById('vr-count').textContent = articleCounts.vr;

// Fonction pour afficher le score sous forme d'étoiles
function displayStarRating(score, elementId) {
    const fullStars = Math.floor(score); // Nombre d'étoiles pleines
    const halfStars = (score % 1) >= 0.5 ? 1 : 0; // Vérifier si une demi-étoile est nécessaire
    const emptyStars = 5 - fullStars - halfStars; // Calcul des étoiles vides

    let starsHTML = '';

    // Ajouter les étoiles pleines
    for (let i = 0; i < fullStars; i++) {
        starsHTML += '<span class="star full-star">★</span>';
    }

    // Ajouter la demi-étoile si nécessaire
    if (halfStars) {
        starsHTML += '<span class="star half-star">☆</span>';
    }

    // Ajouter les étoiles vides
    for (let i = 0; i < emptyStars; i++) {
        starsHTML += '<span class="star empty-star">☆</span>';
    }

    // Insérer les étoiles dans l'élément spécifié
    document.getElementById(elementId).innerHTML = starsHTML;
}

// Exemple de scores
const themeScores = {
    ai: 4.5,
    iot: 4.2,
    cybersecurity: 4.7,
    vr: 4.1
};

// Afficher les étoiles pour chaque thème
displayStarRating(themeScores.ai, 'ai-score');
displayStarRating(themeScores.iot, 'iot-score');
displayStarRating(themeScores.cybersecurity, 'cybersecurity-score');
displayStarRating(themeScores.vr, 'vr-score');


