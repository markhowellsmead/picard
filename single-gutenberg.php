<?php
/**
 * Template Name: Full Gutenberg
 * Template Post Type: post
 * No header
 */

 get_header();
?>
 <main class="c-main">
	<?php
	if (have_posts()) {
		while (have_posts()) {
			the_post();
			get_template_part('partials/singular', get_post_type().'-gutenberg');
		}
	} else {
		get_template_part('partials/singular', 'none');
	}
	?>
 </main>
	<?php
	get_footer();
