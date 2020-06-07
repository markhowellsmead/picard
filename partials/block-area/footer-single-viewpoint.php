<section class="c-footer c-footer--single c-footer--single-viewpoint">
	<?php
	if (!empty($footer_area = get_field('sht-blockarea-footer-viewpoint-single', 'options'))) {
		echo apply_filters('the_content', $footer_area->post_content);
	}
	?>
</section>
