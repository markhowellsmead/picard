<section class="c-footer c-footer--single c-footer--single-place">
	<?php
	if (!empty($footer_area = get_field('sht-blockarea-footer-place-single', 'options'))) {
		echo apply_filters('the_content', $footer_area->post_content);
	}
	?>
</section>
