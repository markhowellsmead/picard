<article class="c_article">

	<?php if (!(bool) get_field('hide_title')) : ?>
		<header class="c-content__header">
			<h1 class="c-content__title"><?php the_title(); ?></h1>
		</header>
	<?php endif; ?>

	<div class="c-content__content">
		<?php
			echo sht_theme()->Package->View->thumbnail('large');
			the_content();
		?>
	</div>

</article>
