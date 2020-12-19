const pageheader = document.querySelector('.c-pageheader');

if (!!pageheader) {
	document.documentElement.style.setProperty('--masthead-height', pageheader.offsetHeight + 'px');
	window.addEventListener('resize', function () {
		document.documentElement.style.setProperty('--masthead-height', pageheader.offsetHeight + 'px');
	});
}
