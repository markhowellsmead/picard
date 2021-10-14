import './_polyfill';
import './a11y';
import './anchorscroll';
import './cssvars';
import './fancybox';
import './footnotes';
import './form';
import './main';
import './search';
import './swiper';
import './toggler';
import './watch-pageheader';

window.anchorAnimateOffset = window.innerHeight / 2;
$('a[href*="#"]').anchorAnimate();

if (!!document.querySelector('[data-exif-toggler]')) {
    const exif_toggler_script = document.createElement('script');
    exif_toggler_script.setAttribute(
        'src',
        `${sht_theme.directory_uri}/assets/scripts/exif-toggler.min.js?version=${sht_theme.version}`
    );
    document.head.appendChild(exif_toggler_script);
}

if (
    !!document.querySelectorAll('html.logged-in .c-excerpt__header') &&
    !!document.querySelectorAll('html.logged-in .c-excerpt__header').length
) {
    const delete_button_script = document.createElement('script');
    delete_button_script.setAttribute(
        'src',
        `${sht_theme.directory_uri}/assets/scripts/delete-button.min.js?version=${sht_theme.version}`
    );
    document.head.appendChild(delete_button_script);
}

console.log(!!document.querySelector('[data-mhm-redbubble]'));

if (!!document.querySelector('[data-mhm-redbubble]')) {
    const script = document.createElement('script');
    script.setAttribute(
        'src',
        `${sht_theme.directory_uri}/assets/scripts/redbubble.min.js?version=${sht_theme.version}`
    );
    document.head.appendChild(script);
}
