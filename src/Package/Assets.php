<?php

namespace SayHello\Theme\Package;

/**
 * Assets (CSS, JavaScript etc)
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Assets
{

	public $font_version = '1.0';
	public $theme_url = '';
	public $theme_path = '';

	public function __construct()
	{
		$this->font_version = sht_theme()->version;
		$this->theme_url    = get_template_directory_uri();
		$this->theme_path   = get_template_directory();
	}

	public function run()
	{
		add_action('wp_enqueue_scripts', [$this, 'registerAssets']);
		add_action('admin_enqueue_scripts', [$this, 'registerAdminAssets']);
		add_action('admin_init', [$this, 'editorStyle']);
		add_action('wp_head', [$this, 'loadFonts']);
		add_action('admin_head', [$this, 'loadFonts']);
	}

	public function registerAssets()
	{

		if (!is_user_logged_in()) {
			wp_deregister_style('dashicons');
		}

		/**
		 * CSS
		 */
		$deps = ['wp-block-library'];
		wp_enqueue_style('fancybox', $this->theme_url . '/assets/plugins/fancybox/jquery.fancybox.min.css', [], '3.4.0');
		$deps[] = 'fancybox';

		wp_enqueue_style('swiper', $this->theme_url . '/assets/plugins/swiper/swiper.min.css', [], '5.3.8');
		$deps[] = 'swiper';

		wp_enqueue_style(sht_theme()->prefix . '-style', $this->theme_url . '/assets/styles/ui' . (sht_theme()->debug ? '' : '.min') . '.css', $deps, filemtime($this->theme_path . '/assets/styles/ui' . (sht_theme()->debug ? '' : '.min') . '.css'));

		/**
		 * Javascript
		 */
		$deps = [];
		wp_deregister_script('jquery');
		wp_enqueue_script('jquery', $this->theme_url . '/assets/scripts/jquery-3.2.1.min.js', [], '3.2.1', false);
		$deps[] = 'jquery';

		if (file_exists($this->theme_path . '/assets/scripts/modernizr/ui-modernizr.min.js')) {
			wp_enqueue_script('ui-modernizr', $this->theme_url . '/assets/scripts/modernizr/ui-modernizr.min.js', [], filemtime($this->theme_path . '/assets/scripts/modernizr/ui-modernizr.min.js'), true);
			$deps[] = 'ui-modernizr';
		}

		wp_enqueue_script('swiper', $this->theme_url . '/assets/plugins/swiper/swiper.min.js', ['jquery'], '5.3.8', true);
		$deps[] = 'swiper';

		wp_enqueue_script('fancybox', $this->theme_url . '/assets/plugins/fancybox/jquery.fancybox.min.js', ['jquery'], '3.4.0', true);
		$deps[] = 'fancybox';

		wp_enqueue_script(sht_theme()->prefix . '-script', $this->theme_url . '/assets/scripts/ui' . (sht_theme()->debug ? '' : '.min') . '.js', $deps, filemtime($this->theme_path . '/assets/scripts/ui' . (sht_theme()->debug ? '' : '.min') . '.js'), true);
		wp_localize_script(sht_theme()->prefix . '-script', 'sht_theme', [
			'directory_uri' => get_template_directory_uri(),
			'version' => sht_theme()->version,
			'nonce' => wp_create_nonce('wp_rest')
		]);

		/**
		 * Footer JS
		 */
		$defaults = [
			'GeneralError' => sht_theme()->error,
			'AjaxURL'      => admin_url('admin-ajax.php'),
			'homeurl'      => get_home_url(),
			'templateurl'  => get_template_directory_uri(),
		];

		$vars = json_encode(apply_filters('sht_footer_js', $defaults));
		wp_add_inline_script(sht_theme()->prefix . '-script', "var ThemeJSVars = {$vars};", 'before');
	}

	public function registerAdminAssets()
	{

		if (file_exists($this->theme_path . '/assets/scripts/modernizr/admin-modernizr.min.js')) {
			wp_enqueue_script(sht_theme()->prefix . '-admin-script', $this->theme_url . '/assets/scripts/modernizr/admin-modernizr.min.js', [], filemtime($this->theme_path . '/assets/scripts/modernizr/admin-modernizr.min.js'), true);
		}

		wp_enqueue_style(sht_theme()->prefix . '-admin-editor-style', $this->theme_url . '/assets/styles/admin-editor' . (sht_theme()->debug ? '' : '.min') . '.css', ['wp-edit-blocks'], filemtime($this->theme_path . '/assets/styles/admin-editor' . (sht_theme()->debug ? '' : '.min') . '.css'));
		wp_enqueue_style(sht_theme()->prefix . '-admin-style', $this->theme_url . '/assets/styles/admin' . (sht_theme()->debug ? '' : '.min') . '.css', [sht_theme()->prefix . '-admin-editor-style', 'wp-edit-blocks'], filemtime($this->theme_path . '/assets/styles/admin' . (sht_theme()->debug ? '' : '.min') . '.css'));
	}

	public function editorStyle()
	{
		if (file_exists($this->theme_path . '/assets/styles/admin-editor' . (sht_theme()->debug ? '' : '.min') . '.css')) {
			add_editor_style($this->theme_url . '/assets/styles/admin-editor' . (sht_theme()->debug ? '' : '.min') . '.css');
		}
	}

	public function loadFonts()
	{
		printf(
			'<link rel="preconnect" href="%1$s" crossorigin />
			<link rel="preload" as="style" href="%2$s&display=swap" />
			<link rel="stylesheet" href="%2$s&display=swap" media="print" onload="this.media=\'all\'" />
			<link rel="stylesheet" href="%3$s&display=swap" media="print" onload="this.media=\'all\'" />
			<noscript><link rel="stylesheet" href="%2$s&display=swap" /><link rel="stylesheet" href="%3$s&display=swap" /></noscript>',
			'https://fonts.gstatic.com',
			'https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700',
			'https://fonts.googleapis.com/css2?family=Oswald:wght@400'
		);
	}

	/**
	 * This function returns the settings value from assets/settings.js
	 *
	 * @since 0.1.0
	 *
	 * @param string $setting settings key
	 *
	 * @return string | bool
	 */
	public function getSetting($setting)
	{
		$path = trailingslashit(get_template_directory()) . 'assets/settings.json';
		if (!is_file($path)) {
			return false;
		}

		$settings = json_decode(file_get_contents($path), true);
		if (!array_key_exists($setting, $settings)) {
			return false;
		}

		return $settings[$setting];
	}
}
