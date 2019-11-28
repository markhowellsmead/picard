<?php
use SayHello\Theme\Package\Lazysizes;

?>
<article itemscope itemtype="http://schema.org/BlogPosting" <?php post_class('c-excerpt');?>">

	<?php

	if (has_post_thumbnail()) {
		$image = Lazysizes::getLazyImage(get_post_thumbnail_id(), 'list_view', 'c-excerpt__thumbnailfigure', 'c-excerpt__thumbnailimage');
		if (!empty($image)) {
			printf(
				'<div class="c-excerpt__thumbnail c-excerpt__thumbnail--%s"><a href="%s">%s</a></div>',
				get_post_type(),
				get_permalink(),
				$image
			);
		}
	}
	?>

	<div class="c-excerpt__content">

		<header class="c-excerpt__header">
			<h2 class="c-excerpt__title">
				<a href="<?php echo get_permalink(); ?>" itemprop="url mainEntityOfPage">
					<?php the_title(); ?>
				</a>
			</h2>
			<time class="c-excerpt__date" datetime="<?php echo get_the_date('c'); ?>"><?php printf(_x('Published on %s', 'sht'), get_the_date()); ?></time>
		</header>

		<?php
		the_excerpt();

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
		?>
	</div>

</article>
