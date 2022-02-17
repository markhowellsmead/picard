<?php

namespace SayHello\Theme\Package;

/**
 * Everything to do with menus and site navigation
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Navigation
{

	private $menus;

	public function __construct()
	{
		$this->menus = [
			'primary' => _x('Primary', 'Menu navigation label', 'sht'),
			'mobile' => _x('Mobile', 'Menu navigation label', 'sht')
		];
	}

	public function run()
	{
		if (count($this->menus)) {
			add_action('after_setup_theme', [$this, 'themeSupport']);
		}
	}

	public function themeSupport()
	{
		add_theme_support('menu');
		register_nav_menus($this->menus);
	}
}
