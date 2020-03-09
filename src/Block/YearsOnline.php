<?php

namespace SayHello\Theme\Block;

/**
 * Show how many photos there are
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class YearsOnline
{

	public function run()
	{
		add_action('init', [$this, 'registerBlocks']);
	}

	public function registerBlocks()
	{
		register_block_type('mhm/years-online', [
			'render_callback' => [$this, 'renderBlock']
		]);
	}

	public function renderBlock($attributes)
	{
		global $wpdb;
		$first_year = $wpdb->get_var("SELECT post_date FROM $wpdb->posts WHERE post_status = 'publish' ORDER BY post_date ASC");
		$years = date_i18n('Y') - date_i18n('Y', strtotime($first_year));

		return sprintf(
			'<p class="wp-block-mhm-years-online">%s</p>',
			sprintf(
				__('%s years online', 'picard'),
				'<span class="wp-block-mhm-years-online__count">'.number_format($years).'</span>'
			)
		);
	}
}
