<article itemscope itemtype="http://schema.org/BlogPosting" <?php post_class('c-excerpt'); ?>>

	<?php

	$image = '';

	if (has_post_thumbnail()) {
		$imageAspect = pt_must_use_get_instance()->Package->Media->thumbnailAspect();
		switch ($imageAspect) {
			case 'tall':
				$image_size = 'list_view_tall';
				break;
			case 'square':
				$image_size = 'list_view_tall';
				break;
			default:
				$image_size = 'list_view';
				break;
		}
		$image = sprintf(
			'<a class="c-excerpt__imagelink" href="%s">%s</a>',
			get_permalink(),
			'<figure class="c-excerpt__thumbnailfigure">' . wp_get_attachment_image(get_post_thumbnail_id(), $image_size, false, ['class' => 'c-excerpt__thumbnailimage']) . '</figure>'
		);
	}

	if (empty($image) && !empty(get_field('video_ref'))) {
		if (!empty($image = pt_must_use_get_instance()->Package->Media->getVideoThumbnail(get_field('video_ref')))) {
			$image = sprintf(
				'<figure class="c-excerpt__thumbnailfigure c-excerpt__thumbnailfigure--video"><a class="c-excerpt__imagelink" href="%s"><img class="c-excerpt__thumbnailimage" alt="%s" src="%s"></a></figure>',
				get_permalink(),
				get_the_title(),
				$image
			);
		}
	}

	if (!empty($image)) {
		printf(
			'<div class="c-excerpt__thumbnail c-excerpt__thumbnail--%s">%s</div>',
			get_post_type(),
			$image
		);
	}


	?>

	<div class="c-excerpt__content">

		<header class="c-excerpt__header">
			<h2 class="c-excerpt__title">
				<a href="<?php echo get_permalink(); ?>" itemprop="url mainEntityOfPage">
					<?php the_title(); ?>
				</a>
			</h2>
			<div class="c-excerpt__topmeta">
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
						<nav class="c-excerpt__categories c-categories">
							<div class="c-categories__entries"><?php echo implode(', ', $out); ?></div>
						</nav>
				<?php
					}
				}
				?>
				<time class="c-excerpt__date" datetime="<?php echo get_the_date('c'); ?>">Published <?php echo get_the_date(); ?></time>
			</div>
		</header>

		<?php
		the_excerpt();

		switch (get_post_type()) {
			case 'photo':
				printf('<a class="c-excerpt__link" href="%s">%s</a>', get_permalink(), _x('View larger', 'Excerpt link text', 'picard'));
				break;
				break;
			default:
				switch (get_post_format()) {
					case 'gallery':
						printf('<a class="c-excerpt__link" href="%s">%s</a>', get_permalink(), _x('View gallery', 'Excerpt link text', 'picard'));
						break;
					case 'image':
						printf('<a class="c-excerpt__link" href="%s">%s</a>', get_permalink(), _x('View larger', 'Excerpt link text', 'picard'));
						break;
					case 'video':
						printf('<a class="c-excerpt__link" href="%s">%s</a>', get_permalink(), _x('Watch video', 'Excerpt link text', 'picard'));
						break;
					default:
						printf('<a class="c-excerpt__link" href="%s">%s</a>', get_permalink(), _x('Read more', 'Excerpt link text', 'picard'));
						break;
				}
				break;
		}
		?>
	</div>

</article>
