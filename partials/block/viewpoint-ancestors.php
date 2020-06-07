<?php

use SayHello\Theme\Package\Lazysizes;

if (empty($data['posts'])) {
	return;
}

if (!empty($align = $data['attributes']['align']?? $data['attributes']['align'])) {
	$align = ' align'.$align;
}

?>

<section class="wp-block-mhm-viewpoint-ancestors<?php echo $align;?>">
	<?php
	$ancestor_links = [];
	foreach ($data['posts'] as $ancestor) {
		$ancestor_links[] = sprintf(
			'<a class="wp-block-mhm-viewpoint-ancestors__ancestor-link" href="%s">%s</a>',
			get_the_permalink($ancestor),
			get_the_title($ancestor)
		);
	}
	printf(
		'<p class="wp-block-mhm-viewpoint-ancestors__ancestors">This viewpoint is in the following %s: %s</p>',
		count($ancestor_links) > 1 ? 'areas' : 'area',
		implode(', ', $ancestor_links)
	);
	?>
</section>
