import * as settings from '../../../../assets/settings.json';

(function () {

	var controllers = document.querySelectorAll('[aria-controls]');

	if (!controllers) {
		return;
	}

	var clickHandler = function () {
		let target = document.querySelector('#' + this.getAttribute('aria-controls'));
		this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') == 'true' ? 'false' : 'true');
		target.setAttribute('aria-hidden', this.getAttribute('aria-expanded') == 'true' ? 'false' : 'true');

		if (this.getAttribute('data-opensinline') !== 'true') {
			if (this.getAttribute('aria-expanded') == 'true') {
				document.documentElement.classList.add('s-menuopen');
			} else {
				document.documentElement.classList.remove('s-menuopen');
			}
		}

		if (this.getAttribute('aria-controls') == 'masthead-searchform') {
			if (target.getAttribute('aria-hidden') == 'true') {
				document.documentElement.classList.remove('s-searchopen');
			} else {
				document.documentElement.classList.add('s-searchopen');
			}
		}

		if (window.innerWidth >= settings.default.theme_breakpoints.laptop && target.getAttribute('aria-hidden') == 'false' && target.querySelector('input[type="search"]')) {
			target.querySelector('input[type="search"]').focus();
		}
	};

	controllers.forEach(controller => {
		controller.addEventListener('click', clickHandler);
		controller.setAttribute('aria-expanded', 'false');
	});

})();
