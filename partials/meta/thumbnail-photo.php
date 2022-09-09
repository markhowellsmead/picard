<?php

use PT\MustUse\Package\Lazysizes;

if (post_password_required() || is_attachment() || !has_post_thumbnail() || (bool) get_field('hide_thumbnail') || !empty(get_field('video_ref'))) {
	return;
}

$imageAspect = pt_must_use_get_instance()->Package->Media->thumbnailAspect();

$block_width = 'regular';

switch ($imageAspect) {
	case 'xwide':
		$image_size = 'full';
		$block_width = 'alignxwide';
		break;
	case 'tall':
		$image_size = 'gutenberg_wide';
		$block_width = 'tall';
		break;
	case '169':
		$image_size = 'gutenberg_wide';
		$block_width = 'filmic';
		break;
	case 'square':
		$image_size = 'large';
		$block_width = 'square';
		break;
	default:
		$image_size = 'large';
		break;
}

$image = Lazysizes::getLazyImage(get_post_thumbnail_id(), $image_size, 'c-article__thumbnailfigure c-article__thumbnailfigure--' . $block_width, 'c-article__thumbnailimage c-article__thumbnailimage--' . $block_width);

if (is_singular()) {
	if (!is_page_template('single-gutenberg')) {
		printf(
			'<div class="c-article__postmedia c-article__postmedia--%1$s c-article__thumbnail c-article__thumbnail--%1$s%2$s%3$s">%4$s</div>',
			get_post_type(),
			!empty($class) ? ' ' . $class : '',
			' ' . $block_width,
			$image
		);
	}
} else {
	printf(
		'<div class="c-article__thumbnail c-article__thumbnail--%1$s%2$s"><a class="c-article__thumbnaillink" href="%3$s" aria-hidden="true" tabindex="-1">%4$s</a></div>',
		get_post_type(),
		!empty($class) ? ' ' . $class : '',
		get_the_permalink(),
		$image
	);
}
