<?php
if (!is_array($related_viewpoints = get_post_meta(get_the_ID(), 'related_viewpoint', true)) || empty($related_viewpoints)) {
	return;
}

?>
<section class="c-article__taxonomy c-article__taxonomy--related_viewpoint">
	<h2 class="c-article__metatitle"><?php _ex('Location', 'Post meta title', 'picard');?></h2>
	<?php

	$related_viewpoint_array = [];
	foreach ($related_viewpoints as $related_viewpoint_id) {
		$related_viewpoint_array[] = sprintf(
			'<a class="c-article__taxonomyentry-link" href="%1$s">%2$s</a>',
			get_permalink($related_viewpoint_id),
			get_the_title($related_viewpoint_id)
		);
	}

	printf(
		'<p class="c-article__taxonomyentries c-article__taxonomyentries--related_viewpoints">%s</p>',
		implode(', ', $related_viewpoint_array)
	);?>
</section>
