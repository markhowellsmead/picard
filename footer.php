<section class="c-footer">
	<?php
	if (!empty($footer_area = get_field('sht-blockarea-footer', 'options'))) {
		echo apply_filters('the_content', $footer_area->post_content);
	}
	?>
</section>

<div class="c-nav--mobile" id="mobile-menu" aria-hidden="true">
	<?php
	wp_nav_menu(
		[
			'theme_location' => 'mobile',
			'container'      => 'nav',
			'container_class' => 'c-menu c-menu--mobile',
			'menu_class'     => 'c-menu c-menu--mobile',
		]
	);
	?>
</div>

<?php wp_footer(); ?>
</body>
</html>
