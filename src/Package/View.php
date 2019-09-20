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

	public function thumbnail($size = 'post-thumbnail')
	{

		if (post_password_required() || is_attachment() || ! has_post_thumbnail() || !(bool) get_field('show_thumbnail')) {
			return;
		}

		$image = Lazysizes::getLazyImage(get_post_thumbnail_id(), $size, 'c-postthumbnail__image');

		if (is_singular()) {
			return sprintf(
				'<figure class="c-postthumbnail c-postthumbnail--%1$s">%2$s</figure>',
				get_post_type(),
				$image
			);
		} else {
			return sprintf(
				'<figure class="c-postthumbnail c-postthumbnail--%1$s"><a class="c-postthumbnail__link" href="%2$s" aria-hidden="true" tabindex="-1">%3$s</a></figure>',
				get_post_type(),
				get_the_permalink(),
				$image
			);
		}
	}
}
