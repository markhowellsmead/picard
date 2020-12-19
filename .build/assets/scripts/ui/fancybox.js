require('@fancyapps/fancybox');

(function ($) {
	$("a[href$='.jpg']:not([target]):not([download]), a[href$='.png']:not([target]):not([download]), a[href$='.gif']:not([target]):not([download]), a[href$='.svg']:not([target]):not([download])").fancybox({
		transitionIn: 'elastic',
		transitionOut: 'elastic',
		speedIn: 600,
		speedOut: 200,
		overlayShow: false,
	});
})(jQuery);
