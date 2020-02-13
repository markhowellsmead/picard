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
		add_filter('get_the_archive_title', [ $this, 'changeTheTitle' ], 20);
	}

	public function changeTheTitle($title)
	{

		if (is_category()) {
			return '<span class="c-archive__titleprefix">'. _x('Posts from the category', 'Archive list header', 'sht').'</span> ' .single_cat_title('', false);
		}

		if (is_tag()) {
			return '<span class="c-archive__titleprefix">'. _x('Posts about', 'Archive list header', 'sht').'</span> ' .single_term_title('', false);
		}

		if (is_tax('collection')) {
			return '<span class="c-archive__titleprefix">'. _x('Photos from the collection', 'Archive list header', 'sht').'</span> ' .single_term_title('', false);
		}

		if (is_search()) {
			if ($GLOBALS['wp_query']->found_posts > 0) {
				return '<span class="c-archive__titleprefix">'. sprintf(
					_nx('%s search result for', '%s search results for', $GLOBALS['wp_query']->found_posts, 'Archive list header', 'sht'),
					$GLOBALS['wp_query']->found_posts
				).'</span> '. get_search_query();
			} else {
				return '<span class="c-archive__titleprefix">'. sprintf(
					_x('No search results for', 'Archive list header', 'sht'),
					$GLOBALS['wp_query']->found_posts
				).'</span> ' .get_search_query();
			}
		}

		return $title;
	}
}
