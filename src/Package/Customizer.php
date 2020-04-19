<?php
namespace SayHello\Theme\Package;

use WP_Customize_Manager;
use WP_Customize_Media_Control;

/**
 * Configuration for the Customizer in the admin area.
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 * @version 1.0
 */

class Customizer
{
	public $wp_customize = null;

	public function run()
	{
		if (class_exists('WP_Customize_Control')) {
			add_action('customize_register', [$this, 'customSections']);
		}
	}

	/**
	 * Adds a new section to use custom controls in the WordPress customiser
	 * @param  WP_Customize_Manager $wp_customize - WP Manager
	 *
	 * @return void
	 */
	public function customSections(WP_Customize_Manager $wp_customize)
	{
		$this->wp_customize = $wp_customize;
		if ($this->wp_customize) {
			$this->themeSettings();
		}
	}

	public function themeSettings()
	{

		$this->wp_customize->add_setting('sht_logo');
			$this->wp_customize->add_control(new WP_Customize_Media_Control($this->wp_customize, 'sht_logo', array(
				'label'      => _x('Logo', 'Field description title in Customizer', 'sht'),
				'description' => _x('Logo file.', 'Field description in Customizer', 'sht'),
				'section'    => 'title_tagline',
				'settings'   => 'sht_logo',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'absint',
				'priority' => 60
			)));
	}

	public function embedLogo()
	{
		if ((int) $logo = get_theme_mod('sht_logo', '')) {
			if (file_exists($file = get_attached_file($logo))) {
				printf(
					'<div class="c-shtlogo"><a class="c-shtlogo__link" href="%1$s">%2$s</a></div>',
					get_home_url(),
					file_get_contents($file)
				);
				return true;
			}
		}
		return false;
	}
}
