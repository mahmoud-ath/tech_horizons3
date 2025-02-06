document.addEventListener('DOMContentLoaded', function () {
    const articleForm = document.getElementById('article-form');
    
    if (articleForm) {
        articleForm.addEventListener('submit', function (event) {
            // Prevent the form from submitting immediately to allow for additional validation
            event.preventDefault();

            // Validate form data (you can add more complex validation here if needed)
            const title = document.getElementById('article-title').value.trim();
            const themes = Array.from(document.getElementById('article-themes').selectedOptions).map(option => option.value);
            const cover = document.getElementById('article-cover').files[0];
            const description = document.getElementById('article-description').value.trim();

            if (!title || !themes.length || !cover || !description) {
                alert("Please fill all the fields before submitting the form.");
                return;
            }

            // If the validation passes, submit the form
            articleForm.submit();
        });
    }
});
