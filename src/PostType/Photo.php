<?php

namespace SayHello\Theme\PostType;

/**
 * Photo post type
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Photo
{

	const POST_TYPE = 'photo';
	const PREFIX = 'sht_photo';

	public function run()
	{
		add_filter('get_the_archive_title', [ $this, 'changeTheTitle' ], 30);
		add_action('pre_get_posts', [$this, 'postsPerAlbumPage']);
		add_action('init', [$this, 'registerMetaFields']);
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

	public function postsPerAlbumPage($query)
	{
		if (!is_admin() && $query->is_main_query() && is_tax('album')) {
			$query->set('posts_per_page', 64);
			return;
		}
	}

	public function registerMetaFields()
	{
		// register_post_meta(self::POST_TYPE, 'hide_title', [
		// 	'show_in_rest' => true,
		// 	'single' => true,
		// 	'type' => 'boolean',
		// 	'auth_callback' => function () {
		// 		return current_user_can('edit_posts');
		// 	}
		// ]);
	}
}
