<?php

use SayHello\Theme\Package\NavWalker;

do_action('sht_before_footer');
?>
<section class="c-page__section" id="footer">
	<footer class="c-footer" role="contentinfo">
		<?php
		wp_nav_menu(
			[
				'theme_location' => 'footer',
				'container'      => 'nav',
				'container_class' => 'c-menu c-menu--footer',
				'menu_id'        => 'footer-menu',
				'menu_class'     => 'c-menu c-menu--footer',
			]
		);
		?>
	</footer>
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
