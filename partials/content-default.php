<?php

$hide_title = (bool) get_post_meta(get_the_ID(), 'hide_title', true);

?><article <?php post_class('c-article c-article--' . get_post_type()); ?>>

	<?php
	if (!empty(get_the_content())) {
	?>
		<div class="c-article__contentandthumbnail">
			<?php if (!$hide_title) {
				get_template_part('partials/meta/video', get_post_type());
				get_template_part('partials/meta/thumbnail', get_post_type());
			?>
				<header class="c-article__header c-main__header">
					<h1 class="c-article__title c-article__title--<?php echo get_post_type(); ?> c-article__title--<?php echo (get_post_format() ?? 'default'); ?>"><?php the_title(); ?></h1>
				</header>
			<?php } ?>

			<div class="c-article__content">
				<?php
				the_content();
				if (get_post_format() === 'gallery') {
					get_template_part('partials/block/image-gallery', null, ['align' => 'wide']);
				}
				?>
			</div>
			<?php get_template_part('partials/meta-after-post'); ?>
		</div>
	<?php
	} elseif (!$hide_title) {
		get_template_part('partials/meta/video', get_post_type());
		get_template_part('partials/meta/thumbnail', get_post_type());
	?>
		<header class="c-article__header c-main__header">
			<h1 class="c-article__title c-article__title--<?php echo get_post_type(); ?> c-article__title--<?php echo (get_post_format() ?? 'default'); ?>"><?php the_title(); ?></h1>
		</header>
	<?php
		get_template_part('partials/meta-after-post');
	}

	get_template_part('partials/comments/template');
	?>

</article>
