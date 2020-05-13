<?php

namespace SayHello\Theme\Block;

class HomeCarousel
{

	public function run()
	{
		add_action('acf/init', [$this, 'registerBlocks']);
	}

	public function registerBlocks()
	{
		if (function_exists('acf_register_block_type')) {
			acf_register_block_type([
				'name' => 'mhm/home-carousel',
				'category' => 'layout',
				'icon' => 'images-alt2',
				'keywords' => [
					_x('Slider', 'Gutenberg block keyword', 'sha'),
					_x('Swiper', 'Gutenberg block keyword', 'sha'),
					_x('Carousel', 'Gutenberg block keyword', 'sha')
				],
				'post_types' => ['post', 'page'],
				'supports' => [
					'align' => ['wide', 'full']
				],
				'title' => _x('Home page carousel', 'Block title', 'sha'),
				'description' => __('An image carousel featuring selected, optionally linked images.', 'Block description', 'sha'),
				'render_callback' => function ($block, $content = '', $is_preview = false) {
					$block['entries'] = get_field('entries');
					sht_theme()->getTemplatePart('partials/block/home-carousel', $block);
				},
			]);
		}
	}
}
