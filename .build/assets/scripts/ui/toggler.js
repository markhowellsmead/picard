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
	};

	controllers.forEach(controller => {
		controller.addEventListener('click', clickHandler);
		controller.setAttribute('aria-expanded', 'false');
	});

})();