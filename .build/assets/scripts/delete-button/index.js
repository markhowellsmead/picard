const excerpt_headers = document.querySelectorAll('html.logged-in .c-excerpt__header');

if (!!excerpt_headers.length) {
    const clickHandler = event => {
        event.preventDefault();
        let matches = event.target
            .closest('.c-excerpt')
            .getAttribute('class')
            .match(/post-([\d]+)/);
        console.log(matches[1]);
    };

    excerpt_headers.forEach(header => {
        let button = document.createElement('button');
        button.innerHTML = 'Move this post to the trash';
        button.classList.add('o-button');
        button.addEventListener('click', clickHandler);
        header.appendChild(button);
    });
}
