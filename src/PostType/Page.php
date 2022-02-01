<?php

namespace SayHello\Theme\PostType;

/**
 * Page post type
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Page
{

	const POST_TYPE = 'page';
	const PREFIX = 'sht_page';

	public function run()
	{
		add_filter('init', [$this, 'allowExcerpt']);
	}

	public function allowExcerpt()
	{
		add_post_type_support('page', 'excerpt');
	}
}
