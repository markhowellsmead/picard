<?php

use SayHello\Theme\Package\Lazysizes;

if (empty($data['posts'])) {
	return;
}

if (!empty($align = $data['attributes']['align']?? $data['attributes']['align'])) {
	$align = ' align'.$align;
}

?>

<section class="c-fourcards wp-block-mhm-blog-cards<?php echo $align;?>">
	<div class="c-fourcards__inner wp-block-mhm-blog-cards__inner">
		<header class="c-fourcards__header wp-block-mhm-blog-cards__header">
			<h2 class="c-fourcards__title wp-block-mhm-blog-cards__title"><?php _ex('Latest blog posts', 'News list default title', 'sht');?></h2>
		</header>
		<div class="c-fourcards__entrieswrap wp-block-mhm-blog-cards__entrieswrap">
			<ul class="c-fourcards__entries wp-block-mhm-blog-cards__entries">
				<?php foreach ($data['posts'] as $data_post) {
					if (has_post_thumbnail($data_post)) {
						$thumbnail = '<a class="c-fourcards__figurelink wp-block-mhm-blog-cards__figurelink" href="'.get_the_permalink($data_post->ID).'">'.Lazysizes::getLazyImage(get_post_thumbnail_id($data_post), 'card', 'c-fourcards__figure wp-block-mhm-blog-cards__figure', 'c-fourcards__image wp-block-mhm-blog-cards__image').'</a>';
					} elseif (!empty($video_url = get_field('video_ref', $data_post->ID))) {
						$thumbnail = sht_theme()->Package->Media->getVideoThumbnail($video_url);
						if (!empty($thumbnail)) {
							$thumbnail = sprintf(
								'<a class="c-fourcards__figurelink wp-block-mhm-blog-cards__figurelink" href="%s"><figure class="c-fourcards__figure wp-block-mhm-blog-cards__figure"><img alt="%s" class="c-fourcards__image wp-block-mhm-blog-cards__image" src="%s"></figure></a>',
								get_the_permalink($data_post->ID),
								get_the_title($data_post->ID),
								$thumbnail
							);
						}
					} else {
						$thumbnail = '<div class="c-fourcards__figure wp-block-mhm-blog-cards__figure c-fourcards__figure--empty wp-block-mhm-blog-cards__figure--empty"></div>';
					}
					?>
					<li class="c-fourcards__entry wp-block-mhm-blog-cards__entry">
						<?php echo $thumbnail; ?>
						<h3 class="c-fourcards__entrytitle wp-block-mhm-blog-cards__entrytitle">
							<a href="<?php the_permalink($data_post->ID);?>"><?php echo get_the_title($data_post->ID);?></a>
						</h3>
						<?php
						if (!empty($ancestors = get_post_ancestors($data_post))) {
							$ancestor_links = [];
							foreach ($ancestors as $ancestor) {
								$ancestor_links[] = sprintf(
									'<a class="c-fourcards__ancestor-link wp-block-mhm-blog-cards__ancestor-link" href="%s">%s</a>',
									get_the_permalink($ancestor),
									get_the_title($ancestor)
								);
							}
							printf(
								'<p class="c-fourcards__ancestors wp-block-mhm-blog-cards__ancestors">%s</p>',
								implode(', ', $ancestor_links)
							);
						}
						?>
						<time class="c-fourcards__entrydate wp-block-mhm-blog-cards__entrydate" datetime="<?php echo get_the_date('c', $data_post->ID); ?>"><?php printf(_x('Published on %s', 'sht'), get_the_date('', $data_post->ID)); ?></time>
						<?php if (!empty($excerpt = get_the_excerpt($data_post->ID))) {?>
							<div class="c-fourcards__excerpt wp-block-mhm-blog-cards__excerpt">
								<?php echo $excerpt;?>
							</div>
							<?php
						}?>
						<div class="c-fourcards__readmorewrap wp-block-mhm-blog-cards__readmorewrap"><a class="c-fourcards__readmore wp-block-mhm-blog-cards__readmore" href="<?php the_permalink($data_post->ID);?>"><?php _ex('Read more', 'Blog card read more text', 'sht');?></a></div>
					</li>
				<?php }?>
			</ul>
		</div>
	</div>
</section>
