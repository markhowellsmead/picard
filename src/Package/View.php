<?php

namespace SayHello\Theme\Package;

use SayHello\Theme\Package\Lazysizes;

/**
 * View helper functions
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */

class View
{

	public function run()
	{
		add_filter('body_class', [ $this, 'customizeBodyClass' ]);
	}

	public function customizeBodyClass($classes)
	{
		if (!empty(get_field('video_ref'))) {
			$classes[] = 's-has--video';
		}
		return $classes;
	}

	public function thumbnail($size = 'post-thumbnail', $class = '')
	{
		if (post_password_required() || is_attachment() || ! has_post_thumbnail() || (bool) get_field('hide_thumbnail')) {
			return;
		}

		$image = Lazysizes::getLazyImage(get_post_thumbnail_id(), $size, 'c-postthumbnail__figure', 'c-postthumbnail__image');

		if (is_singular()) {
			return sprintf(
				'<div class="c-postthumbnail c-postthumbnail--%1$s%2$s">%3$s</div>',
				get_post_type(),
				!empty($class) ? ' '.$class : '',
				$image
			);
		} else {
			return sprintf(
				'<div class="c-postthumbnail c-postthumbnail--%1$s%2$s"><a class="c-postthumbnail__link" href="%3$s" aria-hidden="true" tabindex="-1">%4$s</a></div>',
				get_post_type(),
				!empty($class) ? ' '.$class : '',
				get_the_permalink(),
				$image
			);
		}
	}

	public function video($class = '')
	{
		if (post_password_required() || is_attachment() || empty(get_field('video_ref')) || (bool) get_field('hide_video')) {
			return;
		}

		$video = wp_oembed_get(get_field('video_ref'));

		if (!empty($video)) {
			return sprintf(
				'<div class="%1$s"><figure class="%1$s__figure wp-block-embed is-type-video wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper">%2$s</div></figure></div>',
				$class,
				$video
			);
		}
	}
}
