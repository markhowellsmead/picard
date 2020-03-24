<?php

if (post_password_required() || is_attachment() || empty(get_field('video_ref')) || (bool) get_field('hide_thumbnail')) {
	return;
}

$video = wp_oembed_get(get_field('video_ref'));

if (!empty($video)) {
	printf(
		'<div class="c-article__video"><figure class="wp-block-embed is-type-video wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper">%s</div></figure></div>',
		$video
	);
}
