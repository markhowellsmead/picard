(function () {
	var footnote_links = document.querySelectorAll('a[href^="#footnote"]'),
		footnotes_block = document.querySelectorAll('.wp-block-mhm-footnotes'),
		i;

	if(!footnote_links.length || !footnotes_block.length) {
		return;
	}

	for(i = 0; i < footnote_links.length; ++i) {
		if(!document.querySelector(footnote_links[i].hash)) {
			continue;
		}

		var footnote = document.querySelector(footnote_links[i].hash);

		if(footnote && !footnote.querySelector('.b-footnote__uplink')) {
			var uplink = document.createElement('a');
			uplink.setAttribute('class', 'wp-block-mhm-footnote__uplink');
			uplink.setAttribute('href', footnote_links[i].hash.replace('#footnote', '#footnotesource'));
			uplink.appendChild(document.createTextNode('⤴'));
			footnote.appendChild(uplink);
		}
	}
})();
