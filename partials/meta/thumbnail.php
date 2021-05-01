<?php

if (post_password_required() || is_attachment() || !has_post_thumbnail() || (bool) get_field('hide_thumbnail') || !empty(get_field('video_ref'))) {
	return;
}

$imageAspect = sht_theme()->Package->Media->thumbnailAspect();
$image_width = '';

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
		$image_size = 'gutenberg_wide';
		$block_width = 'alignwide';
		break;
}

$image = '<figure class="c-article__thumbnailfigure">' . wp_get_attachment_image(get_post_thumbnail_id(), $image_size, false, ['class' => 'c-article__thumbnailimage']) . '</figure>';

if (is_singular()) {
	if (!is_page_template('single-gutenberg')) {
		printf(
			'<div class="c-article__postmedia c-article__postmedia--%1$s c-article__thumbnail c-article__thumbnail--%1$s%2$s %4$s">%3$s</div>',
			get_post_type(),
			!empty($class) ? ' ' . $class : '',
			$image,
			$block_width
		);
	}
} else {
	if (!empty(get_field('video_ref'))) {
		if (!empty($video_image = sht_theme()->Package->Media->getVideoThumbnail(get_field('video_ref')))) {
			$image = $video_image;
		}
	}

	printf(
		'<div class="c-article__thumbnail c-article__thumbnail--%1$s%2$s"><a class="c-article__thumbnaillink" href="%3$s" aria-hidden="true" tabindex="-1">%4$s</a></div>',
		get_post_type(),
		!empty($class) ? ' ' . $class : '',
		get_the_permalink(),
		$image
	);
}
