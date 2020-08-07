<?php

use SayHello\Theme\Package\Lazysizes;

if (empty($images = get_field('images'))) {
	if ($data['is_context_edit'] ?? false) {
		?>
		<section class="wp-block-sht-imagegallery wp-block-sht-imagegallery--empty <?php echo !empty($data['align']) ? ' align'.$data['align'] : '';?>">
			<p class=""><strong><?php echo $data['title'];?></strong>: <?php _ex('Keine Bilder ausgewählt', 'Editor block message', 'sha');?></p>
		</section>
		<?php
	}
	return;
}

$target_height = 300;
$image_size = 'medium';

$align = $data['align'];
if (!empty($data['align'])) {
	$align = 'align'.$data['align'];
}

$unique = uniqid();

?>

<!-- Grid layout origin: https://github.com/xieranmaya/blog/issues/6 #wowza -->
<section class="wp-block-sht-imagegallery <?php echo $align;?>">
	<ul class="wp-block-sht-imagegallery__images c-grid500">
		<?php foreach ($images as $image) {
			$source_image_size = $image['sizes'][$image_size] ?? null ? $image_size : 'large';
			$width = $image['sizes'][$source_image_size.'-width'] ?? $image['width'];
			$height = $image['sizes'][$source_image_size.'-height'] ?? $image['height'];
			$flex_grow = $width * 100 / $height;
			$flex_basis = $width * $target_height / $height;
			$padding_bottom = ($height / $width) * 100;
			$href = $data['is_context_edit'] ? '#' : $image['sizes']['full'] ?? $image['sizes']['gutenberg_wide'];
			?>
		<li
			class="wp-block-sht-imagegallery__entry c-grid500__item"
			style="flex-grow:<?php echo $flex_grow;?>;flex-basis:<?php echo $flex_basis;?>px;">

			<?php
			if ($data['is_context_edit']) {
				?>
				<span class="c-grid500__itemlink">
					<i class="c-grid500__uncollapse" style="padding-bottom:<?php echo $padding_bottom;?>%"></i>
					<?php
					$image = wp_get_attachment_image($image['ID'], $source_image_size, false, ['class' => 'c-grid500__image']);
					if (!empty($image)) {
						$image = '<figure class="c-grid500__figure">'.$image.'</figure>';
					}
					echo $image;
					?>
				</span>
			<?php } else {?>
				<a class="c-grid500__itemlink" href="<?php echo $href;?>" data-fancybox="gallery-<?php echo $unique;?>" data-caption="<?php echo $image['caption'] ?? $image['title'];?>">
					<i class="c-grid500__uncollapse" style="padding-bottom:<?php echo $padding_bottom;?>%"></i>
					<?php
					echo Lazysizes::getLazyImage($image['ID'], $source_image_size, 'c-grid500__figure', 'c-grid500__image');
					?>
				</a>
				<?php
			} ?>
			</li>
		<?php }?>
	</ul>
</section>
