<?php get_header(); ?>

<main class="c-main">
	<?php
	if (!empty($content_template = locate_template([
		'partials/archive-' . get_post_type() . '-' . get_post_format() . '.php',
		'partials/archive-' . get_post_type() . '.php',
		'partials/archive.php'
	]))) {
		include_once($content_template);
	}
	?>
</main>

<?php get_footer();
