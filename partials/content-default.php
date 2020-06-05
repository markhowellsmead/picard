<article <?php post_class('c-article c-article--'.get_post_type()); ?>>

	<?php if (!(bool) get_field('hide_title')) : ?>
		<header class="c-article__header c-main__header">
			<h1 class="c-article__title c-article__title--<?php echo get_post_type();?> c-article__title--<?php echo (get_post_format() ?? 'default');?>"><?php the_title(); ?></h1>
			<time class="c-article__date" datetime="<?php echo get_the_date('c'); ?>"><?php printf(_x('Published on %s', 'sht'), get_the_date()); ?></time>
		</header>
	<?php endif; ?>
	<?php
	if (!empty(get_the_content())) {
		?>
		<div class="c-article__contentandthumbnail">
			<?php if (!(bool) get_field('hide_title')) : ?>
				<?php
				get_template_part('partials/meta/video', get_post_type());
				get_template_part('partials/meta/thumbnail', get_post_type());
			endif; ?>

			<div class="c-article__content">
				<?php the_content(); ?>
			</div>
		</div>
		<?php
	} elseif (!(bool) get_field('hide_title')) {
		get_template_part('partials/meta/video', get_post_type());
		get_template_part('partials/meta/thumbnail', get_post_type());
	}

	if (!empty(get_the_terms(get_the_ID(), 'post_tag')) || !empty(get_the_terms(get_the_ID(), 'collection'))) {
		?>
	<div class="c-article__meta">
		<?php
		get_template_part('partials/tags');
		get_template_part('partials/collections');
		?>
	</div>
	<?php }
	get_template_part('partials/comments/template');
	?>

</article>
