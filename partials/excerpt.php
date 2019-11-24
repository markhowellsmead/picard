<?php
use SayHello\Theme\Package\Lazysizes;

?>
<article itemscope itemtype="http://schema.org/BlogPosting" class="c-excerpt c-excerpt--<?php echo get_post_type(); ?>">

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

	<header class="c-excerpt__header">
		<h2 class="c-excerpt__title">
			<a href="<?php echo get_permalink(); ?>" itemprop="url mainEntityOfPage">
				<?php the_title(); ?>
			</a>
		</h2>
		<time class="c-excerpt__date" datetime="<?php echo get_the_date('c'); ?>"><?php printf(_x('Published on %s', 'sht'), get_the_date()); ?></time>
	</header>

	<div class="c-excerpt__content">
		<?php the_excerpt(); ?>
	</div>

</article>
