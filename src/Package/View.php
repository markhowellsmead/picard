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
}
