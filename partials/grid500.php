<?php

$entries = $args['post_ids'] ?? [];
$image_size = $args['image_size'] ?? 'post-thumbnail';
$target_height = $args['target_height'] ?? '400';

if (empty($entries)) {
	return;
}

?>

<!-- Grid layout origin: https://github.com/xieranmaya/blog/issues/6 #wowza -->
<section class="wp-block-photos-by-collection <?php echo $align; ?>">
	<div class="wp-block-photos-by-collection__images c-grid500">
		<div class="c-grid500__inner">
			<?php foreach ($entries as $entry) {
				$thumbnail_id = get_post_thumbnail_id($entry);

				if (!$thumbnail_id) {
					continue;
				}

				$metadata = wp_get_attachment_metadata($thumbnail_id);

				if (empty($metadata)) {
					continue;
				}

				$source_image_size = $metadata['sizes'][$image_size] ?? null ? $image_size : 'large';
				$width = $metadata['sizes'][$image_size]['width'] ?? $metadata['width'];
				$height = $metadata['sizes'][$image_size]['height'] ?? $metadata['height'];
				$flex_grow = $width * 100 / $height;
				$flex_basis = $width * $target_height / $height;
				$padding_bottom = ($height / $width) * 100;
				$href = get_the_permalink($entry);
				$fancybox_href = wp_get_attachment_image_url($thumbnail_id, 'gutenberg_full');
			?>
				<div class="wp-block-photos-by-collection__entry c-grid500__item" style="flex-grow:<?php echo $flex_grow; ?>;flex-basis:<?php echo $flex_basis; ?>px;">
					<a class="c-grid500__itemlink" href="<?php echo $href; ?>" title="<?php echo get_the_title($entry); ?>" data-fancybox="image" data-caption="<?php echo get_the_title($entry); ?>" data-srcset="<?php echo $fancybox_href; ?>">
						<i class="c-grid500__uncollapse" style="padding-bottom:<?php echo $padding_bottom; ?>%"></i>
						<?php
						$image = wp_get_attachment_image($thumbnail_id, $source_image_size, false, ['class' => 'c-grid500__image']);
						echo '<figure class="c-grid500__figure">' . $image . '</figure>';
						if ((bool) get_field('sht_show_captions')) {
							printf('<figcaption class="c-grid500__caption">%s</figcaption>', get_the_title($entry));
						}
						?>
					</a>
				</div>
			<?php } ?>
		</div>
	</div>
</section>
