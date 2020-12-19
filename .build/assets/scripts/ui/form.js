const cren_subscribe_to_comment = document.querySelectorAll('[name="cren_subscribe_to_comment"]'),
	cren_subscribe_to_comment_click = function (event) {
		if (event.target.checked) {
			event.target.closest('label').classList.add('is--checked');
		} else {
			event.target.closest('label').classList.remove('is--checked');
		}
	};

cren_subscribe_to_comment.forEach(element => {
	element.addEventListener('click', cren_subscribe_to_comment_click);
});
