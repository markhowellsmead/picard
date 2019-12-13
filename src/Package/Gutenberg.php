<?php

namespace SayHello\Theme\Package;

/**
 * Adjustments for the Gutenberg Editor
 *
 * @author Nico Martin <nico@sayhello.ch>
 */
class Gutenberg
{
	public $theme_url = '';
	public $theme_path = '';
	public $min = false;
	public $js = false;

	public function __construct()
	{
		$this->theme_url  = get_template_directory_uri();
		$this->theme_path = get_template_directory();
		if (sht_theme()->debug && is_user_logged_in()) {
			$this->min = true;
		}

		if (file_exists($this->theme_path . '/assets/gutenberg/blocks' . ($this->min ? '.min' : '') . '.js')) {
			$this->js = $this->theme_url . '/assets/gutenberg/blocks' . ($this->min ? '.min' : '') . '.js';
		}
	}

	public function run()
	{
		if (!function_exists('register_block_type')) {
			return; // Gutenberg is not active.
		}
		add_action('enqueue_block_editor_assets', [$this, 'enqueueBlockAssets']);
		add_filter('block_categories', [$this, 'blockCategories']);
		add_filter('block_editor_settings', [ $this, 'editorSettings' ]);
		add_action('after_setup_theme', [$this, 'themeSupports']);
	}

	/**
	 * Allow the Theme to use additional core features
	 * See https://github.com/SayHelloGmbH/hello-roots/wiki/Gutenberg#theme-colours for information on how to
	 * load the colours from your settings.json into Gutenberg
	 */
	public function themeSupports()
	{
		add_theme_support('align-wide');
		add_theme_support('automatic-feed-links');
		add_theme_support('custom-logo');
		add_theme_support('html5', [ 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ]);
		add_theme_support('menu');
		add_theme_support('post-thumbnails', [ 'post', 'page', 'photo' ]);
		add_theme_support('title-tag');
		add_theme_support('post-formats', [ 'image', 'gallery', 'video' ]);
		// add_theme_support('disable-custom-colors');
		add_theme_support(
			'editor-color-palette',
			[
				[
					'name'  => esc_html__('Black', 'sht'),
					'slug' => 'black',
					'color' => '#000',
				],
				[
					'name'  => esc_html__('Light gray', 'sht'),
					'slug' => 'light-gray',
					'color' => '#777',
				],
				[
					'name'  => esc_html__('Yellow', 'sht'),
					'slug' => 'yellow',
					'color' => '#ffc',
				],
				[
					'name'  => esc_html__('Blue', 'sht'),
					'slug' => 'primary',
					'color' => '#1A56B0',
				],
				[
					'name'  => esc_html__('WordPress blue', 'sht'),
					'slug' => 'wordpress-blue',
					'color' => '#0073aa',
				],
				[
					'name'  => esc_html__('White', 'sht'),
					'slug' => 'white',
					'color' => '#fff',
				]
			]
		);
	}

	/**
	 * Gutenberg enqueues a few styles within an inline STYLE block in the
	 * editor. This removes them. (The default Gutenberg implementation
	 * currently only contains a few basic typography settings.)
	 * @param  array $editor_settings The pre-defined settings
	 * @return array                  The modified settings
	 */
	public function editorSettings($editor_settings)
	{
		$editor_settings['styles'] = [];
		return $editor_settings;
	}

	public function enqueueBlockAssets()
	{
		if ($this->js) {
			wp_enqueue_script(sht_theme()->prefix . '-gutenberg-script', $this->js, ['wp-blocks', 'wp-element', 'wp-edit-post', 'lodash'], sht_theme()->version);
			$vars = json_encode(apply_filters('sht_disabled_blocks', []));
			wp_add_inline_script(sht_theme()->prefix . '-gutenberg-script', "var shtDisabledBlocks = {$vars};", 'before');
		}
	}

	public function blockCategories($categories)
	{
		return array_merge($categories, [
			[
				'slug'  => 'sht/blocks',
				'title' => __('Blocks by Say Hello', 'sha'),
			],
		]);
	}
}
