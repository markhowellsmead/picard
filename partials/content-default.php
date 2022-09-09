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
					<div class="c-article__topmeta">
						<?php
						if (!empty($categories = get_the_category())) {
							$out = [];
							foreach ($categories as $category) {
								if ((int) $category->term_id !== (int) get_option('default_category')) {
									$out[] = sprintf(
										'<a href="%s" class="c-categories__entry" title="%s">%s</a>',
										get_category_link($category->term_id),
										sprintf(_x('More posts in the category “%s”', '', 'picard'), esc_html($category->name)),
										esc_html($category->name)
									);
								}
							}
							if (!empty($out)) {
						?>
								<nav class="c-categories">
									<div class="c-categories__entries"><?php echo implode(', ', $out); ?></div>
								</nav>
						<?php
							}
						}
						?>
						<time class="c-article__date" datetime="<?php echo get_the_date('c'); ?>">Published <?php echo get_the_date(); ?></time>
					</div>
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
