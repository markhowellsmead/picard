<?php

namespace SayHello\Theme\Package;

use WP_CLI;

/**
 * CLI stuff
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class CLI
{

	public function run()
	{
		if (class_exists('WP_CLI')) {
			WP_CLI::add_command('mhm photo topost', 'SayHello\Theme\CLI\PhotoToPost');
			WP_CLI::add_command('mhm collection totag', 'SayHello\Theme\CLI\CollectionToTag');
		}
	}
}
