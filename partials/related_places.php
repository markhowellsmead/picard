<?php
if (!is_array($related_places = get_post_meta(get_the_ID(), 'related_place', true)) || empty($related_places)) {
	return;
}

?>
<section class="c-article__taxonomy c-article__taxonomy--related_place">
	<h2 class="c-article__metatitle c-article__metatitle--<?php echo get_post_type(); ?>"><?php _ex('Location', 'Post meta title', 'picard'); ?></h2>
	<?php

	$related_place_array = [];
	foreach ($related_places as $related_place_id) {
		$related_place_array[] = sprintf(
			'<a class="c-article__taxonomyentry-link" href="%1$s">%2$s</a>',
			get_permalink($related_place_id),
			get_the_title($related_place_id)
		);
	}

	printf(
		'<p class="c-article__taxonomyentries c-article__taxonomyentries--related_places">%s</p>',
		implode(', ', $related_place_array)
	); ?>
</section>
