        // Scripts JavaScript personnalisés
        document.addEventListener('DOMContentLoaded', () => {
            const themeCards = document.querySelectorAll('.theme-card');

            themeCards.forEach(card => {
                card.addEventListener('click', () => {
                    alert(`Redirection vers le thème : ${card.querySelector('h3').textContent}`);
                });
            });
        });