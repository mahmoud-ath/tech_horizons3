        // Gestion des étoiles
        document.querySelectorAll('.star').forEach(star => {
            star.addEventListener('click', function () {
                document.querySelectorAll('.star').forEach(s => s.classList.remove('selected'));
                this.classList.add('selected');
            });
        });

        // Gestion des commentaires
        document.getElementById('comment-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const commentText = document.getElementById('comment-text').value;
            if (!commentText.trim()) {
                alert("Veuillez entrer un commentaire avant de soumettre !");
                return;
            }
            const commentSection = document.getElementById('comments-section');
            const newComment = document.createElement('div');
            newComment.classList.add('comment');
            newComment.innerHTML = `<p><strong>Vous :</strong> ${commentText}</p>`;
            commentSection.appendChild(newComment);
            document.getElementById('comment-text').value = '';
        });


        // Réponses aux commentaires
        document.getElementById('comments-section').addEventListener('click', function (e) {
            if (e.target.classList.contains('reply-button')) {
                const parentComment = e.target.closest('.comment');

                const replyForm = document.createElement('form');
                replyForm.classList.add('reply-form');
                replyForm.innerHTML = `
                    <textarea placeholder="Ajoutez votre réponse..." required></textarea>
                    <button type="submit" class="btn btn-common">Répondre</button>`;
                replyForm.addEventListener('submit', function (event) {
                    event.preventDefault();
                    const replyText = replyForm.querySelector('textarea').value.trim();
                    if (!replyText) {
                        alert("Veuillez entrer une réponse avant de soumettre !");
                        return;
                    }
                    const replyDiv = document.createElement('div');
                    replyDiv.classList.add('comment-reply');
                    replyDiv.innerHTML = `<p><strong>Vous :</strong> ${replyText}</p>`;
                    parentComment.appendChild(replyDiv);
                    replyForm.remove();
                });

                parentComment.appendChild(replyForm);
                e.target.remove();
            }
        });
