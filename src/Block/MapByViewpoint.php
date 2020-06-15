<?php

namespace SayHello\Theme\Block;

use WP_Post;

/**
 * Map from linked photos (link via Viewpoint)
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class MapByViewpoint
{

	public function run()
	{
		add_action('acf/init', [$this, 'registerBlocks']);
		add_action('acf/init', [$this, 'registerFields']);
	}

	public function registerBlocks()
	{
		if (function_exists('acf_register_block_type')) {
			// Block using ACF fields
			acf_register_block_type([
				'name' => 'map-by-viewpoint',
				'category' => 'common',
				'icon' => 'format-gallery',
				'keywords' => [
					_x('Map', 'Gutenberg block keyword', 'sha'),
					_x('Photos', 'Gutenberg block keyword', 'sha'),
					_x('Viewpoint', 'Gutenberg block keyword', 'sha')
				],
				'post_types' => ['post', 'page', 'mhm-viewpoint'],
				'supports' => [
					'align' => ['wide', 'full']
				],
				'title' => _x('Map of photos by viewpoint', 'Block title', 'sha'),
				'description' => __('An map view containing photos from a viewpoint.', 'Block description', 'sha'),
				'render_callback' => function ($block, $content = '', $is_preview = false) {
					$block['is_preview'] = $is_preview;
					$block['viewpoints'] = get_field('sht_viewpoint', $block['ID']);
					if (!empty($block['viewpoints'])) {
						if ($block['viewpoints'][0] instanceof WP_Post) {
							foreach ($block['viewpoints'] as &$viewpoint) {
								$viewpoint = $viewpoint->ID;
							}
						}
						sht_theme()->getTemplatePart('partials/block/map-by-viewpoint', $block);
					}
				},
			]);
		}
	}

	public function registerFields()
	{
		if (function_exists('acf_add_local_field_group')) :
			acf_add_local_field_group([
				'key' => 'group_posts_by_viewpoint',
				'title' => 'Block - Map By Viewpoint',
				'fields' => [
					[
						'key' => 'sht_viewpoint',
						'label' => 'Viewpoint',
						'name' => 'sht_viewpoint',
						'type' => 'post_object',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'post_type' => [
							0 => 'mhm-viewpoint',
						],
						'taxonomy' => '',
						'allow_null' => 0,
						'multiple' => 1,
						'return_format' => 'object',
						'ui' => 1,
					]
				],
				'location' => [
					[
						[
							'param' => 'block',
							'operator' => '==',
							'value' => 'acf/map-by-viewpoint',
						],
					],
				],
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
			]);
		endif;
	}
}
