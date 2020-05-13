/**
 * https://github.com/markhowellsmead/helpers/wiki/Swiper
 */

import * as settings from '../../../../assets/settings.json';

(function ($) {
	$(document).ready(function () {
		new Swiper('.b-home-carousel .swiper-container--activateplease', {
			centeredSlides: true,
			loop: true,
			speed: 1000,
			navigation: {
				nextEl: '.b-home-carousel .swiper-button-next',
				prevEl: '.b-home-carousel .swiper-button-prev'
			},
			slidesPerView: 1,
			spaceBetween: 0,
			breakpoints: {
				768: {
					slidesPerView: 2,
					spaceBetween: 0
				},
				1440: {
					slidesPerView: 2.5,
					spaceBetween: 32
				}
			}
		});
	});
})(jQuery);
