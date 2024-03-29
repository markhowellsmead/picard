<?php

namespace SayHello\Theme;

/**
 * Theme class which gets loaded in functions.php.
 * Defines the Starting point of the Theme and registers Packages.
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Theme
{

	/**
	 * the instance of the object, used for singelton check
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Theme name
	 *
	 * @var string
	 */
	public $name = '';

	/**
	 * Theme version
	 *
	 * @var string
	 */
	public $version = '';

	/**
	 * Theme prefix
	 *
	 * @var string
	 */
	public $prefix = '';

	/**
	 * Error message
	 *
	 * @var string
	 */
	public $error = '';

	/**
	 * Debug mode
	 *
	 * @var bool
	 */
	public $debug = false;

	private $theme;

	public function __construct()
	{
		$this->theme = wp_get_theme();
	}

	public function run()
	{
		$this->loadClasses(
			[
				\SayHello\Theme\Package\Assets::class,
				\SayHello\Theme\Package\BodyClass::class,
				\SayHello\Theme\Package\Customizer::class,
				\SayHello\Theme\Package\Gutenberg::class,
				\SayHello\Theme\Package\Language::class,
				\SayHello\Theme\Package\Navigation::class,
				\SayHello\Theme\Package\Oembed::class,
				\SayHello\Theme\Package\ThemeOptions::class,
			]
		);

		add_action('after_setup_theme', [$this, 'addNavigations']);
		add_action('after_setup_theme', [$this, 'addThemeSupports']);
		add_action('after_setup_theme', [$this, 'contentWidth']);

		$this->cleanHead();
	}

	/**
	 * Creates an instance if one isn't already available,
	 * then return the current instance.
	 *
	 * @return object       The class instance.
	 */
	public static function getInstance()
	{
		if (!isset(self::$instance) && !(self::$instance instanceof Theme)) {
			self::$instance = new Theme;

			self::$instance->name    = self::$instance->theme->name;
			self::$instance->version = self::$instance->theme->version;
			self::$instance->prefix  = 'sht';
			self::$instance->error   = __('An unexpected error occured.', 'sht');
			self::$instance->debug   = true;

			if (!isset($_SERVER['HTTP_HOST']) || strpos($_SERVER['HTTP_HOST'], '.hello') === false && !in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
				self::$instance->debug = false;
			}
		}

		return self::$instance;
	}

	/**
	 * Loads and initializes the provided classes.
	 *
	 * @param $classes
	 */
	private function loadClasses($classes)
	{
		foreach ($classes as $class) {
			$class_parts = explode('\\', $class);
			$class_short = end($class_parts);
			$class_set   = $class_parts[count($class_parts) - 2];

			if (!isset(sht_theme()->{$class_set}) || !is_object(sht_theme()->{$class_set})) {
				sht_theme()->{$class_set} = new \stdClass();
			}

			if (property_exists(sht_theme()->{$class_set}, $class_short)) {
				wp_die(sprintf(__('A problem has ocurred in the Theme. Only one PHP class named “%1$s” may be assigned to the “%2$s” object in the Theme.', 'sht'), $class_short, $class_set), 500);
			}

			sht_theme()->{$class_set}->{$class_short} = new $class();

			if (method_exists(sht_theme()->{$class_set}->{$class_short}, 'run')) {
				sht_theme()->{$class_set}->{$class_short}->run();
			}
		}
	}

	/**
	 * Set the content width based on the theme's design and stylesheet
	 */
	public function contentWidth()
	{
		$GLOBALS['content_width'] = apply_filters('sht/content_width', 1280);
	}

	/**
	 * Allow the Theme to use additional core features
	 */
	public function addThemeSupports()
	{
		add_theme_support('automatic-feed-links');
		add_theme_support(
			'custom-logo',
			[
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			]
		);
		add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption']);
		add_theme_support('menu');
		add_theme_support('post-thumbnails', ['post', 'mhm-viewpoint']);
		add_theme_support('title-tag');
	}

	/**
	 * Add navigations
	 */
	public function addNavigations()
	{
		register_nav_menus(
			[
				'primary' => __('Primary Menu', 'sha'),
				'footer'  => __('Footer Menu', 'sha'),
			]
		);
	}

	public function cleanHead()
	{
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('wp_print_styles', 'print_emoji_styles');
	}


	public function getTemplatePart(string $file_path, ...$arguments)
	{
		$data = [];

		// Array containing possible paths to the template part
		$parts = (array) $file_path;

		if (is_array($arguments)) {
			// Find an array in $attributes and use it as $data in the
			// included template part
			foreach ($arguments as $attribute) {
				if (is_array($attribute) || $attribute instanceof WP_Post) {
					$data = $attribute;
					break;
				}
			}

			// If the first function attribute after $file_path is a string,
			// prepend the alternative (e.g. post type) name to the paths array
			// e.g. [partials/excerpt-customposttype, partials/excerpt]
			if (is_string($arguments[0] ?? null)) {
				array_unshift($parts, $file_path . '-' . $arguments[0]);
			}
		}

		// Make sure that each possible file path is suffixed with .php
		if (!empty($parts)) {
			foreach ($parts as &$file) {
				if (false === strpos($file, '.php')) {
					$file .= '.php';
				}
			}
			if (!empty($template = locate_template($parts))) {
				require(locate_template($parts));
			}
		}
	}
}
