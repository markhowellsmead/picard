<?php

namespace SayHello\Theme\Block;

/**
 * Image gallery with ACF field
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class ImageGallery
{

	public function run()
	{
		add_action('acf/init', [$this, 'registerBlocks']);
	}

	public function registerBlocks()
	{
		if (function_exists('acf_register_block_type')) {
			// Block using ACF fields
			acf_register_block_type([
				'name' => 'image-gallery',
				'category' => 'layout',
				'icon' => 'format-gallery',
				'keywords' => [
					_x('Gallery', 'Gutenberg block keyword', 'sha'),
					_x('Image gallery', 'Gutenberg block keyword', 'sha'),
					_x('Image', 'Gutenberg block keyword', 'sha')
				],
				'post_types' => ['post', 'page', 'mhm-viewpoint'],
				'supports' => [
					'align' => ['wide', 'full']
				],
				'title' => _x('SHT image gallery', 'Block title', 'sha'),
				'description' => __('An image gallery which fills the available space with the selected images.', 'Block description', 'sha'),
				'render_callback' => function ($block, $content = '', $is_preview = false) {
					sht_theme()->getTemplatePart('partials/block/image-gallery', $block);
				},
			]);
		}
	}
}
