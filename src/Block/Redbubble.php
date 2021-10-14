<?php

namespace SayHello\Theme\Block;

/**
 * Insert and load Redbubble widget
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Redbubble
{

	public function run()
	{
		add_action('init', [$this, 'registerBlocks']);
	}

	public function registerBlocks()
	{
		register_block_type('mhm/redbubble', [
			'render_callback' => [$this, 'renderBlock']
		]);
	}

	public function renderBlock()
	{
		if (sht_theme()->Package->Gutenberg->isContextEdit()) {
			return '<div class="c-message c-message--info">The Redbubble widget will be output here on the website</div>';
		}
		return '<div class="wp-block-mhm-redbubble" data-mhm-redbubble><div><div id="rb-xzfcxvzx"></div></div></div>';
	}
}
