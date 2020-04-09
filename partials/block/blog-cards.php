<?php

if (empty($data['posts'])) {
	return;
}

if (!empty($align = $data['attributes']['align']?? $data['attributes']['align'])) {
	$align = ' align'.$align;
}

?>

<section class="wp-block-mhm-blog-cards<?php echo $align;?>">
	<div class="wp-block-mhm-blog-cards__inner">
		<header class="wp-block-mhm-blog-cards__header">
			<h2 class="wp-block-mhm-blog-cards__title"><?php _ex('Latest blog posts', 'News list default title', 'sht');?></h2>
		</header>
		<div class="wp-block-mhm-blog-cards__entrieswrap">
			<ul class="wp-block-mhm-blog-cards__entries">
				<?php foreach ($data['posts'] as $data_post) {?>
					<li class="wp-block-mhm-blog-cards__entry">
						<h3 class="wp-block-mhm-blog-cards__entrytitle wp-block-mhm-blog-cards__entrytitle">
							<a href="<?php the_permalink($data_post->ID);?>"><?php echo get_the_title($data_post->ID);?></a>
						</h3>
						<time class="wp-block-mhm-blog-cards__entrydate" datetime="<?php echo get_the_date('c', $data_post->ID); ?>"><?php printf(_x('Published on %s', 'sht'), get_the_date(null, $data_post->ID)); ?></time>
						<?php if (!empty($excerpt = get_the_excerpt($data_post->ID))) {?>
							<div class="wp-block-mhm-blog-cards__excerpt">
								<?php echo $excerpt;?>
							</div>
							<?php
						}?>
						<div class="wp-block-mhm-blog-cards__readmorewrap"><a class="wp-block-mhm-blog-cards__readmore" href="<?php the_permalink($data_post->ID);?>"><?php _ex('Read more', 'Blog card read more text', 'sht');?></a></div>
					</li>
				<?php }?>
			</ul>
		</div>
	</div>
</section>
