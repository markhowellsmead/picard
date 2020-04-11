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
		add_theme_support('post-formats', [ 'gallery', 'video' ]);
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
					'name'  => esc_html__('Gray', 'sht'),
					'slug' => 'light-gray',
					'color' => '#777',
				],
				[
					'name'  => esc_html__('Mid gray', 'sht'),
					'slug' => 'mid-gray',
					'color' => '#aaa',
				],
				[
					'name'  => esc_html__('Light gray', 'sht'),
					'slug' => 'lighter-gray',
					'color' => '#ccc',
				],
				[
					'name'  => esc_html__('Extra light gray', 'sht'),
					'slug' => 'xlight-gray',
					'color' => '#f0f0f0',
				],
				[
					'name'  => esc_html__('Extra-extra light gray', 'sht'),
					'slug' => 'xxlight-gray',
					'color' => '#f9f9f9',
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
		add_theme_support('editor-gradient-presets', [
			[
				'name'     => __('Bottom shadow', 'picard'),
				'gradient' => 'linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0) 75%,rgba(0,0,0,1) 100%)',
				'slug'     => 'bottom-black-shadow'
			]
		]);
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
			$script_asset_path = get_template_directory().'/assets/gutenberg/blocks.asset.php';
			$script_asset = file_exists($script_asset_path) ? require($script_asset_path) : ['dependencies' => [], 'version' => sht_theme()->version];
			wp_enqueue_script(
				sht_theme()->prefix . '-gutenberg-script',
				$this->js,
				$script_asset['dependencies'],
				$script_asset['version']
			);
			$vars = json_encode(apply_filters('sht_disabled_blocks', []));
			wp_add_inline_script(sht_theme()->prefix . '-gutenberg-script', "var shtDisabledBlocks = {$vars};", 'before');
			wp_set_script_translations(sht_theme()->prefix . '-gutenberg-script', 'sht', get_template_directory() . '/languages');
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

	public function isContextEdit()
	{
		return array_key_exists('context', $_GET) && $_GET['context'] === 'edit';
	}
}
