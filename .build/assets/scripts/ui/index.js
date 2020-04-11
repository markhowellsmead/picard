import './_polyfill';
import './a11y';
import './anchorscroll';
import './cssvars';
import './fancybox';
import './footnotes';
import './form';
import './main';
import './menu';

window.anchorAnimateOffset = window.innerHeight / 2;
$('a[href*="#"]').anchorAnimate();
