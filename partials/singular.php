<article <?php post_class('c-article'); ?>>

	<?php if (!(bool) get_field('hide_title')) : ?>
		<header class="c-content__header">
			<h1 class="c-content__title"><?php the_title(); ?></h1>
		</header>
	<?php endif; ?>

	<?php
	echo sht_theme()->Package->View->thumbnail('large', 'c-article__thumbnail');
	echo sht_theme()->Package->View->video('c-article__video');
	?>

	<div class="c-content__content">
		<?php the_content(); ?>
	</div>

</article>
