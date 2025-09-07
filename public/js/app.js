(function(){
    const app = document.getElementById('app');

    if (!app) return;

    function htmlToNode(html) {
        const template = document.createElement('template');
        template.innerHTML = html.trim();
        return template.content;
    }

    async function postForm(formData){
        let body;
        if (formData instanceof HTMLFormElement) {
            body = new FormData(formData);
        } else {
            body = formData;
        }

        const response = await fetch('/', {
            method:'POST',
            headers: { 'X-Requested-With':'fetch' },
            body
        });

        return response.json();
    }

    function wireLoginForm(){
        const form = document.getElementById('loginForm');
        if (!form) return;

        const errorPanel = document.getElementById('loginError');

        form.addEventListener('submit', async (e)=> {
            e.preventDefault();
            errorPanel.hidden = true;

            try {
                const data = await postForm(form);
                if (data.ok) {
                    app.innerHTML = '';
                    app.appendChild(htmlToNode(data.html));
                    wireAllDynamicButtons();
                } else {
                    errorPanel.textContent = data.error || 'Unknown Error';
                    errorPanel.hidden = false;
                }
            } catch {
                errorPanel.textContent='Connection Error';
                errorPanel.hidden = false;
            }
        });
    }

    function wireLogoutButton(){
        const logoutButton = document.getElementById('logoutBtn');
        if (!logoutButton) return;

        logoutButton.addEventListener('click', async ()=> {
            const formData = new FormData();
            formData.append('action','logout');
            const data = await postForm(formData);

            if (data.ok) {
                app.innerHTML = '';
                app.appendChild(htmlToNode(data.html));
                wireLoginForm();
            }
        });
    }

    function wireDeleteNewsButtons(){
        const buttons = document.querySelectorAll('.delete-news-btn');
        buttons.forEach(button => {
            button.addEventListener('click', async ()=>{
                const newsId = button.dataset.id;
                const formData = new FormData();
                formData.append('action', 'delete_news');
                formData.append('id', newsId);

                const data = await postForm(formData);

                if (data.ok){
                    if (data.redirect){
                        window.location.href = data.redirect;
                    } else {
                        app.innerHTML = '';
                        app.appendChild(htmlToNode(data.html));
                        wireAllDynamicButtons();
                    }
                } else {
                    alert(data.error || 'Something went wrong');
                }
            });
        });
    }

    function wireCreateNewsForm(){
        const form = document.getElementById('createNewsForm');
        if (!form) return;

        const actionInput = document.getElementById('newsAction');
        const submitButton = document.getElementById('createNewsBtn');
        const cancelButton = document.getElementById('cancelEditBtn');
        const titleInput = document.getElementById('newsTitle');
        const descriptionInput = document.getElementById('newsDescription');
        const newsIdInput = document.getElementById('newsId');

        cancelButton.addEventListener('click', ()=>{
            titleInput.value = '';
            descriptionInput.value = '';
            actionInput.value = 'create_news';
            newsIdInput.value = '';
            submitButton.textContent = 'Create';
            cancelButton.hidden = true;
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const data = await postForm(form);
            if (data.ok){
                if (data.redirect){
                    window.location.href = data.redirect;
                } else {
                    app.innerHTML = '';
                    app.appendChild(htmlToNode(data.html));
                    wireAllDynamicButtons();
                }
            } else {
                alert(data.error || 'Something went wrong.');
            }
        });
    }

    function wireEditNewsButtons(){
        const buttons = document.querySelectorAll('.edit-news-btn');
        const titleInput = document.getElementById('newsTitle');
        const descriptionInput = document.getElementById('newsDescription');
        const actionInput = document.getElementById('newsAction');
        const submitButton = document.getElementById('createNewsBtn');
        const cancelButton = document.getElementById('cancelEditBtn');
        const newsIdInput = document.getElementById('newsId');

        buttons.forEach(button=> {
            button.addEventListener('click', ()=>{
                titleInput.value = button.dataset.title;
                descriptionInput.value = button.dataset.description;
                actionInput.value = 'update_news';
                newsIdInput.value = button.dataset.id;
                submitButton.textContent = 'Save';
                cancelButton.hidden = false;
            });
        });
    }

    function wireAllDynamicButtons(){
        wireLogoutButton();
        wireDeleteNewsButtons();
        wireCreateNewsForm();
        wireEditNewsButtons();
    }

    wireLoginForm();
    wireAllDynamicButtons();
})();
