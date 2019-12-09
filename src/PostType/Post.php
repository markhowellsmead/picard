<?php

namespace SayHello\Theme\PostType;

/**
 * Post post type
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Post
{

	public function run()
	{
		add_action('init', [$this, 'registerCustomTaxonomies']);
		add_filter('get_the_archive_title', [ $this, 'changeTheTitle' ], 20);
	}

	public function registerCustomTaxonomies()
	{
		register_taxonomy('collection', ['post'], [
			'labels' => [
				'name' => _x('Collections', 'taxonomy general name'),
				'singular_name' => _x('Collection', 'taxonomy singular name'),
				'search_items' => __('Search Collections'),
				'all_items' => __('All Collections'),
				'parent_item' => __('Parent Collection'),
				'parent_item_colon' => __('Parent Collection:'),
				'edit_item' => __('Edit Collection'),
				'update_item' => __('Update Collection'),
				'add_new_item' => __('Add New Collection'),
				'new_item_name' => __('New Collection Name'),
				'menu_name' => __('Collection'),
			],
			'hierarchical' => false,
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'collection'),
		]);

		register_taxonomy('album', ['post'], [
			'labels' => [
				'name' => _x('Albums', 'taxonomy general name'),
				'singular_name' => _x('Album', 'taxonomy singular name'),
				'search_items' => __('Search Albums'),
				'all_items' => __('All Albums'),
				'parent_item' => __('Parent Album'),
				'parent_item_colon' => __('Parent Album:'),
				'edit_item' => __('Edit Album'),
				'update_item' => __('Update Album'),
				'add_new_item' => __('Add New Album'),
				'new_item_name' => __('New Album Name'),
				'menu_name' => __('Album'),
			],
			'hierarchical' => false,
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'albums'),
		]);
	}

	public function changeTheTitle($title)
	{

		if (is_category()) {
			return '<span class="c-archive__titleprefix">'. _x('Posts from the category', 'Archive list header', 'sht').'</span> ' .single_cat_title('', false);
		}

		if (is_tag()) {
			return '<span class="c-archive__titleprefix">'. _x('Posts about', 'Archive list header', 'sht').'</span> ' .single_term_title('', false);
		}

		return $title;
	}
}
