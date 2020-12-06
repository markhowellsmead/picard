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
