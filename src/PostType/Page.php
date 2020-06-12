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
		add_filter('init', [$this, 'allowExcerpt' ]);
		add_action('init', [$this, 'registerMetaFields']);
	}

	public function allowExcerpt()
	{
		add_post_type_support('page', 'excerpt');
	}

	public function registerMetaFields()
	{
		register_post_meta(self::POST_TYPE, 'hide_title', [
			'show_in_rest' => true,
			'single' => true,
			'type' => 'boolean',
			'auth_callback' => function () {
				return current_user_can('edit_posts');
			}
		]);
	}
}
