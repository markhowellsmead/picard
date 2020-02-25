<article <?php post_class('c-article c-article--'.get_post_type()); ?>>

	<?php if (!(bool) get_field('hide_title')) : ?>
		<header class="c-article__header c-main__header">
			<h1 class="c-article__title"><?php the_title(); ?></h1>
			<?php
			if (has_post_thumbnail()) {
				$thumbnail_meta = wp_get_attachment_metadata(get_post_thumbnail_id());
				if (is_array($thumbnail_meta['image_meta']) && isset($thumbnail_meta['image_meta']['created_timestamp']) && $thumbnail_meta['image_meta']['created_timestamp'] > 0) {
					printf(
						'<time class="c-article__date c-article__date--captured" datetime="%1$s">%2$s</time>',
						date_i18n('c', $thumbnail_meta['image_meta']['created_timestamp']),
						sprintf(_x('Photographed on %s', 'date', 'picard'), date_i18n('dS F Y', $thumbnail_meta['image_meta']['created_timestamp']))
					);
				}
			}
			?>
			<time class="c-article__date" datetime="<?php echo get_the_date('c'); ?>"><?php printf(_x('Published on %s', 'sht'), get_the_date()); ?></time>
		</header>
		<?php

		get_template_part('partials/meta/video', get_post_type());
		get_template_part('partials/meta/thumbnail', get_post_type());
	endif; ?>

	<?php
	if (!empty(get_the_content())) {
		?>
		<div class="c-article__contentandthumbnail">
			<div class="c-article__content">
				<?php the_content(); ?>
			</div>
		</div>
		<?php
	}

	if (!empty(get_the_terms(get_the_ID(), 'post_tag')) || !empty(get_the_terms(get_the_ID(), 'collection'))) {
		?>
	<div class="c-article__meta">
		<?php
		get_template_part('partials/tags');
		get_template_part('partials/collections');
		get_template_part('partials/related_destinations');
		?>
	</div>
	<?php }
	get_template_part('partials/comments/template');
	?>

</article>
