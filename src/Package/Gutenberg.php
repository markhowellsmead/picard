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

	public function __construct()
	{
		$this->theme_url  = get_template_directory_uri();
		$this->theme_path = get_template_directory();
		if (sht_theme()->debug && is_user_logged_in()) {
			$this->min = true;
		}
	}

	public function run()
	{
		if (!function_exists('register_block_type')) {
			return; // Gutenberg is not active.
		}
		add_action('after_setup_theme', [$this, 'themeSupports']);
		add_action('init', [$this, 'addBlockPatternCategory']);
	}

	/**
	 * Allow the Theme to use additional core features
	 * See https://github.com/SayHelloGmbH/hello-roots/wiki/Gutenberg#theme-colours for information on how to
	 * load the colours from your settings.json into Gutenberg
	 */
	public function themeSupports()
	{
		remove_theme_support('core-block-patterns');
		add_theme_support('align-wide');
		add_theme_support('automatic-feed-links');
		add_theme_support('custom-logo');
		add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption']);
		add_theme_support('menu');
		add_theme_support('post-thumbnails', ['post', 'page', 'photo']);
		add_theme_support('title-tag');
		add_theme_support('post-formats', ['image', 'gallery', 'video']);
		// add_theme_support('disable-custom-colors');
		$path = trailingslashit(get_template_directory()) . 'assets/settings.json';
		if (!is_file($path)) {
			return false;
		}

		$settings = file_get_contents($path);

		if (is_string($settings) && !empty($settings)) {
			$settings = json_decode($settings, true);
			if (isset($settings['gutenberg_colors'])) {
				$colors = [];

				foreach ($settings['gutenberg_colors'] as $color_key => $color) {
					foreach ($color as $variation_key => $variation) {
						$colors[] = [
							'name' => $variation_key === 'base' ? ucfirst($color_key) : implode(' ', [ucfirst($color_key), $variation_key]),
							'slug' => $variation_key === 'base' ? $color_key : implode(' ', [$color_key, $variation_key]),
							'color' => $color[$variation_key]
						];
					}
				}

				if (!empty($colors)) {
					add_theme_support('editor-color-palette', $colors);
				}
			}
		}
		add_theme_support('editor-gradient-presets', [
			[
				'name'     => __('Bottom shadow', 'picard'),
				'gradient' => 'linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0) 75%,rgba(0,0,0,1) 100%)',
				'slug'     => 'bottom-black-shadow'
			]
		]);
	}

	public function addBlockPatternCategory()
	{
		if (function_exists('register_block_pattern_category')) {
			register_block_pattern_category('picard', ['label' => __('Permanent Tourist Picard', 'sht')]);
		}
	}
}
