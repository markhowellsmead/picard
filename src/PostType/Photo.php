<?php

namespace SayHello\Theme\PostType;

/**
 * Photo post type
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Photo
{

	public function run()
	{
		add_filter('get_the_archive_title', [ $this, 'changeTheTitle' ], 30);
	}

	public function changeTheTitle($title)
	{

		if (is_post_type_archive('photo')) {
			return _x('Photo archives', 'Archive title', 'picard');
		}

		if (is_tax('album')) {
			return '<span class="c-archive__titleprefix">'. _x('Photo album', 'Archive list header', 'sht').'</span> ' .single_term_title('', false);
		}

		return $title;
	}
}
