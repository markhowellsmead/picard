<?php

$thumbnail_meta = [];
$image_meta = [];

if (get_post_format() === 'image' && has_post_thumbnail()) {
	$thumbnail_meta = wp_get_attachment_metadata(get_post_thumbnail_id());
	$image_meta = $thumbnail_meta['image_meta'] ?? [];
}

?><div class="c-article__meta">
	<div class="c-article__metagroup">
		<h2 class="c-article__metatitle c-article__metatitle--<?php echo get_post_type(); ?>"><?php _ex('Published', 'Post meta title', 'picard'); ?></h2>
		<p class=""><?php echo get_the_date(); ?></p>

		<?php
		if (!empty(get_the_terms(get_the_ID(), 'post_tag'))) {
		?>
			<h2 class="c-article__metatitle c-article__metatitle--<?php echo get_post_type(); ?>"><?php _ex('Topics', 'Post meta title', 'picard'); ?></h2>
			<?php the_terms(get_the_ID(), 'post_tag', '<p>', ', ', '</p>'); ?>
			<?php
		}

		if (is_array($image_meta) && !empty($image_meta)) {
			$gps = sht_theme()->Package->Media->calculateGPS($image_meta);
			if ($gps['GPSCalculatedDecimal'] ?? false) {
			?>
				<h2 class="c-article__metatitle c-article__metatitle--<?php echo get_post_type(); ?>"><?php _ex('Location', 'Post meta title', 'picard'); ?></h2>
				<p><a href="https://google.com/maps?q=<?php echo $gps['GPSCalculatedDecimal']; ?>" title="View in Google Maps"><?php echo $gps['GPSCalculatedDecimal']; ?></a></p>
		<?php
			}
		}

		?>

	</div>

	<div class="c-exifbox" data-exif>
		<div class="c-exifbox__content c-article__metagroup">
			<?php if (get_post_format() === 'image' && has_post_thumbnail()) {
				$camera = sht_theme()->Package->Media->getCameraDescriptors($image_meta['camera'] ?? '');
				if (is_array($image_meta) && isset($image_meta['created_timestamp']) && $image_meta['created_timestamp'] > 0) {
			?> <h2 class="c-article__metatitle c-article__metatitle--<?php echo get_post_type(); ?>"><?php _ex('Photographed on', 'Post meta title', 'picard'); ?></h2>
					<time class="c-article__date c-article__date--captured" datetime="<?php echo date_i18n('c', $image_meta['created_timestamp']); ?>">
						<?php echo date_i18n('jS F Y', $image_meta['created_timestamp']); ?>
					</time>
				<?php }

				if (!empty($camera)) {
				?>
					<h2 class="c-article__metatitle c-article__metatitle--<?php echo get_post_type(); ?>"><?php _ex('Camera', 'Post meta title', 'picard'); ?></h2>
					<p><?php echo $camera['camera']; ?></p>
			<?php }
			} ?>



			<?php
			if (get_post_format() === 'image' && $image_meta) {
				if ($image_meta['shutter_speed'] ?? false) {
			?>
					<h2 class="c-article__metatitle c-article__metatitle--<?php echo get_post_type(); ?>"><?php _ex('Shutter speed', 'Post meta title', 'picard'); ?></h2>
					<p><?php echo sht_theme()->Package->Media->convertShutterSpeed($image_meta['shutter_speed']); ?></p>
				<?php
				}

				if ($image_meta['aperture'] ?? null) {
				?>
					<h2 class="c-article__metatitle c-article__metatitle--<?php echo get_post_type(); ?>"><?php _ex('Aperture', 'Post meta title', 'picard'); ?></h2>
					<p><?php echo "f/{$image_meta['aperture']}"; ?></p>
				<?php
				}

				if ($image_meta['iso'] ?? null) {
				?>
					<h2 class="c-article__metatitle c-article__metatitle--<?php echo get_post_type(); ?>"><?php _ex('ISO', 'Post meta title', 'picard'); ?></h2>
					<p><?php echo $image_meta['iso']; ?></p>
				<?php

				}

				if ($image_meta['focal_length'] ?? null) {
				?>
					<h2 class="c-article__metatitle c-article__metatitle--<?php echo get_post_type(); ?>"><?php _ex('Focal length', 'Post meta title', 'picard'); ?></h2>
					<p><?php echo "{$image_meta['focal_length']}mm"; ?></p>
			<?php
				}
			}
			?>
		</div>
		<button class="c-exifbox__toggler o-button o-button--plain o-button--compact" disabled data-exif-toggler data-label-open="<?php _ex('Show photographic (EXIF) data', 'Button text', 'picard'); ?>" data-label-close="<?php _ex('Hide photographic (EXIF) data', 'Button text', 'picard'); ?>" />
	</div>

</div>

<?php
get_template_part('partials/related_destinations');
?>
</div>
