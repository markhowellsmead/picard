<section class="c-footer c-footer--single">
	<?php
	if (!empty($footer_area = get_field('sht-blockarea-footer-single', 'options'))) {
		echo apply_filters('the_content', $footer_area->post_content);
	}
	?>
</section>
