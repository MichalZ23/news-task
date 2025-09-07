(function(){
    const app = document.getElementById('app');
    if (!app) {
        return;
    }

    function htmlToNode(html) {
        const template = document.createElement('template');
        template.innerHTML = html.trim();

        return template.content;
    }

    async function postForm(formData) {
        const body = formData instanceof HTMLFormElement ? new FormData(formData) : formData;
        const response = await fetch('/', {
            method: 'POST',
            headers: { 'X-Requested-With': 'fetch' },
            body
        });

        return response.json();
    }

    function updateAppElement(html) {
        app.innerHTML = '';
        app.appendChild(htmlToNode(html));
        wireAll();
    }

    async function handleResponse(data, errorPanel) {
        if (data.ok) {
            if (data.redirect) {
                window.location.href = data.redirect;
            } else if (data.html) {
                updateAppElement(data.html);
            }
        } else {
            if (errorPanel) {
                errorPanel.textContent = data.error || 'Unknown Error';
                errorPanel.hidden = false;
            } else {
                alert(data.error || 'Something went wrong');
            }
        }
    }

    function wireLoginForm() {
        const form = document.getElementById('loginForm');
        if (!form) {
            return;
        }

        const errorPanel = document.getElementById('loginError');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (errorPanel) {
                errorPanel.hidden = true;
            }

            try {
                const data = await postForm(form);
                await handleResponse(data, errorPanel);
            } catch {
                if (errorPanel) {
                    errorPanel.textContent = 'Connection Error';
                    errorPanel.hidden = false;
                }
            }
        });
    }

    function wireLogoutButton() {
        const logoutButton = document.getElementById('logoutBtn');
        if (!logoutButton) {
            return;
        }

        logoutButton.addEventListener('click', async () => {
            const formData = new FormData();
            formData.append('action','logout');
            const data = await postForm(formData);
            await handleResponse(data);
        });
    }

    function wireDeleteNewsButtons() {
        const buttons = document.querySelectorAll('.delete-news-btn');
        buttons.forEach(button => {
            button.addEventListener('click', async () => {
                const newsId = button.dataset.id;
                const formData = new FormData();
                formData.append('action', 'delete_news');
                formData.append('id', newsId);

                const data = await postForm(formData);
                await handleResponse(data);
            });
        });
    }

    function wireCreateNewsForm() {
        const form = document.getElementById('createNewsForm');
        if (!form) {
            return;
        }

        const actionInput = document.getElementById('newsAction');
        const submitButton = document.getElementById('createNewsBtn');
        const cancelButton = document.getElementById('cancelEditBtn');
        const titleInput = document.getElementById('newsTitle');
        const descriptionInput = document.getElementById('newsDescription');
        const newsIdInput = document.getElementById('newsId');
        const newsFormTitle = document.getElementById('newsFormTitle');

        cancelButton.addEventListener('click', () => {
            titleInput.value = '';
            descriptionInput.value = '';
            actionInput.value = 'create_news';
            newsIdInput.value = '';
            submitButton.textContent = 'Create';
            newsFormTitle.textContent = 'Create News'
            cancelButton.hidden = true;
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const data = await postForm(form);
            await handleResponse(data);
        });
    }

    function wireEditNewsButtons() {
        const buttons = document.querySelectorAll('.edit-news-btn');
        const titleInput = document.getElementById('newsTitle');
        const descriptionInput = document.getElementById('newsDescription');
        const actionInput = document.getElementById('newsAction');
        const submitButton = document.getElementById('createNewsBtn');
        const cancelButton = document.getElementById('cancelEditBtn');
        const newsIdInput = document.getElementById('newsId');
        const newsFormTitle = document.getElementById('newsFormTitle');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                titleInput.value = button.dataset.title;
                descriptionInput.value = button.dataset.description;
                actionInput.value = 'update_news';
                newsIdInput.value = button.dataset.id;
                submitButton.textContent = 'Save';
                newsFormTitle.textContent = 'Edit News'
                cancelButton.hidden = false;
            });
        });
    }

    function wireAll() {
        wireLoginForm();
        wireLogoutButton();
        wireDeleteNewsButtons();
        wireCreateNewsForm();
        wireEditNewsButtons();
    }

    wireAll();
})();
