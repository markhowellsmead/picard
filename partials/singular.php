<?php

if (!empty($content_template = locate_template([
	'partials/content-'. get_post_type().'-'.get_post_format().'.php',
	'partials/content-'. get_post_type().'.php',
	'partials/content-default.php'
]))) {
	include_once($content_template);
}
