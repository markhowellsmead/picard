import { c, color, theme, is_mobile } from './modules/settings.js';
import '@sayhellogmbh/maybe-set-link-target';

(function ($) {
	$(function () {
		$('a').maybeSetLinkTarget();
	});
})(jQuery);