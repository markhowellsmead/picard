<?php

namespace SayHello\Theme\Package;

/**
 * Everything to do with images, videos etc
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Media
{

	public function run()
	{
		add_action('after_setup_theme', [ $this, 'addImageSizes' ]);
		add_filter('image_size_names_choose', [$this, 'selectableImageSizes']);
		add_filter('body_class', [ $this, 'thumbnailAspectCSS' ]);
	}

	public function addImageSizes()
	{
		add_image_size('gutenberg_wide', 1280, 9999);
		add_image_size('gutenberg_full', 2560, 9999);
	}

	public function selectableImageSizes($sizes)
	{
		$sizes['gutenberg_wide'] = __('Gutenberg wide', 'sht');
		$sizes['gutenberg_full'] = __('Gutenberg full', 'sht');
		return $sizes;
	}

	public function thumbnailAspectCSS($css_classes)
	{
		if (!has_post_thumbnail()) {
			return $css_classes;
		}

		$image_src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'post-thumbnail');

		if (is_array($image_src)) {
			$aspect = $image_src[1] / $image_src[2];
			if ($aspect > 1.75) {
				$css_classes[] = 'o-body--widethumbnail';
			} elseif ($aspect == 1) {
				$css_classes[] = 'o-body--squarethumbnail';
			} elseif ($aspect < 1) {
				$css_classes[] = 'o-body--tallthumbnail';
			}
		}
		return $css_classes;
	}
}
