<?php

use SayHello\Theme\Package\Lazysizes;

if (empty($images = get_field('images'))) {
	return;
}

$target_height = 500;
$image_size = 'large';

if (count($images) > 10) {
	$target_height = 400;
	$image_size = 'medium';
}

$unique = uniqid();

?>

<!-- Grid layout origin: https://github.com/xieranmaya/blog/issues/6 #wowza -->
<section class="wp-block-sht-imagegallery <?php echo !empty($data['align']) ? ' align'.$data['align'] : '';?>">
	<ul class="wp-block-sht-imagegallery__images c-grid500">
		<?php foreach ($images as $image) {
			$source_image_size = $image['sizes'][$image_size] ?? null ? $image_size : 'medium';
			?>
		<li
			class="wp-block-sht-imagegallery__entry c-grid500__item"
			style="flex-grow:<?php echo ($image['sizes'][$source_image_size.'-width'] * 100) / ($image['sizes'][$source_image_size.'-height']);?>px;flex-basis:<?php echo ($image['sizes'][$source_image_size.'-width'] * $target_height) / $image['sizes'][$source_image_size.'-height'];?>px;">
				<a class="c-grid500__itemlink" href="<?php echo $image['sizes']['block_full'];?>" data-fancybox="gallery-<?php echo $unique;?>" data-caption="<?php echo $image['caption'] ?? $image['title'];?>">
					<i class="c-grid500__uncollapse" style="padding-bottom:<?php echo $image['sizes'][$source_image_size.'-height'] / $image['sizes'][$source_image_size.'-width'] * 100;?>%"></i>
					<?php echo Lazysizes::getLazyImage($image['ID'], $source_image_size, 'c-grid500__figure', 'c-grid500__image');?>
				</a>
			</li>
		<?php }?>
	</ul>
</section>
