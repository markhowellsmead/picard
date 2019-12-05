<?php

use SayHello\Theme\Package\Lazysizes;

if (post_password_required() || is_attachment() || ! has_post_thumbnail() || (bool) get_field('hide_thumbnail') || !empty(get_field('video_ref'))) {
	return;
}

$image = Lazysizes::getLazyImage(get_post_thumbnail_id(), 'full', 'c-article__thumbnailfigure', 'c-article__thumbnailimage');

if (is_singular()) {
	if (!is_page_template('single-gutenberg')) {
		printf(
			'<div class="c-article__thumbnail c-article__thumbnail--%1$s%2$s%3$s">%4$s</div>',
			get_post_type(),
			!empty($class) ? ' '.$class : '',
			get_post_format() === 'image' ? ' alignwide' : '',
			$image
		);
	}
} else {
	var_dump(get_field('video_ref'));
	if (!empty(get_field('video_ref'))) {
		if (!empty($video_image = sht_theme()->Package->Media->getVideoThumbnail(get_field('video_ref')))) {
			$image = $video_image;
		}
	}

	printf(
		'<div class="c-article__thumbnail c-article__thumbnail--%1$s%2$s"><a class="c-article__thumbnaillink" href="%3$s" aria-hidden="true" tabindex="-1">%4$s</a></div>',
		get_post_type(),
		!empty($class) ? ' '.$class : '',
		get_the_permalink(),
		$image
	);
}
