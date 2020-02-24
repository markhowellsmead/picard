<?php
if (!is_array($related_destinations = get_post_meta(get_the_ID(), 'related_destinations', true)) || empty($related_destinations)) {
	return;
}

?>
<section class="c-article__taxonomy c-article__taxonomy--related_destinations">
	<h2 class="c-article__metatitle"><?php _ex('Destinations', 'Post meta title', 'picard');?></h2>
	<?php

	$related_destination_array = [];
	foreach ($related_destinations as $related_destination_id) {
		$related_destination_array[] = sprintf(
			'<a class="c-article__taxonomyentry-link" href="%1$s">%2$s</a>',
			get_permalink($related_destination_id),
			get_the_title($related_destination_id)
		);
	}

	printf(
		'<p class="c-article__taxonomyentries c-article__taxonomyentries--related_destinations">%s</p>',
		implode(', ', $related_destination_array)
	);?>
</section>
