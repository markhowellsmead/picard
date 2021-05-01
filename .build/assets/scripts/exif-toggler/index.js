const toggler = document.querySelector('[data-exif-toggler]'),
    exifBox = document.querySelector('[data-exif]'),
    toggleState = !!localStorage.getItem('exif-toggler');

if (!!toggler && !!exifBox) {
    toggler.removeAttribute('disabled');
    toggler.innerHTML = !!toggleState ? toggler.dataset.labelClose : toggler.dataset.labelOpen;
    toggler.setAttribute('aria-expanded', !!toggleState);
    exifBox.setAttribute('aria-hidden', !toggleState);

    toggler.addEventListener('click', event => {
        event.target.blur();
        if (event.target.getAttribute('aria-expanded') === 'true') {
            localStorage.removeItem('exif-toggler');
            toggler.setAttribute('aria-expanded', false);
            exifBox.setAttribute('aria-hidden', true);
            toggler.innerHTML = toggler.dataset.labelOpen;
        } else {
            localStorage.setItem('exif-toggler', true);
            toggler.setAttribute('aria-expanded', true);
            exifBox.setAttribute('aria-hidden', false);
            toggler.innerHTML = toggler.dataset.labelClose;
        }
    });
}
