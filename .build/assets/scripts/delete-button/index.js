const excerpt_headers = document.querySelectorAll('html.logged-in .c-excerpt__header');

if (!!excerpt_headers.length) {
    const api_root = document
            .getElementsByTagName('head')[0]
            .querySelector('link[rel="https://api.w.org/"]')
            .getAttribute('href'),
        endpoint = `${api_root}wp/v2/posts/`;

    const clickHandler = event => {
        event.preventDefault();
        let matches = event.target
            .closest('.c-excerpt')
            .getAttribute('class')
            .match(/post-([\d]+)/);

        fetch(`${endpoint}${matches[1]}`, {
            method: 'DELETE',
            headers: {
                'X-WP-Nonce': sht_theme.nonce,
            },
        })
            .then(response => response.json())
            .then(response => {
                if (!!response.data && !!response.data.status && response.data.status !== 200) {
                    console.error(response.message);
                } else {
                    event.target.closest('.c-excerpt').remove();
                }
            })
            .catch(error => {
                console.error('Something went wrong.', error);
            });
    };

    excerpt_headers.forEach(header => {
        let button = document.createElement('button');
        button.innerHTML = 'Move this post to the trash';
        button.classList.add('o-button');
        button.addEventListener('click', clickHandler);
        header.appendChild(button);
    });
}
