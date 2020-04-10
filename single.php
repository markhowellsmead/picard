<?php

get_header();
?>
<main class="c-main">
	<?php
	if (have_posts()) {
		while (have_posts()) {
			the_post();
			get_template_part('partials/singular', get_post_type());
		}
	} else {
		get_template_part('partials/singular', 'none');
	}
	?>
</main>

<section class="c-footer--single">
	<?php
	if (!empty($footer_area = get_field('sht-blockarea-footer-single', 'options'))) {
		echo apply_filters('the_content', $footer_area->post_content);
	}
	?>
</section>

<?php
get_footer();
