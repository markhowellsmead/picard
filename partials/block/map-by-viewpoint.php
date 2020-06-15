<?php

use SayHello\Theme\Package\Lazysizes;

if (empty($data['viewpoints'])) {
	return;
}

$serialized = ['relation' => 'OR'];

foreach ($data['viewpoints'] as $viewpoint_id) {
	$serialized[] = [
		'key'	 	=> 'related_viewpoint',
		'value'	  	=> '"' .$viewpoint_id. '"',
		'compare' 	=> 'LIKE',
	];
}


if (empty($photos_by_viewpoint = get_posts([
	'post_type' => 'photo',
	'posts_per_page' => -1,
	'meta_query' => [
		'relation' => 'AND',
		[
			'key' => '_thumbnail_id'
		],
		$serialized,
	]
]))) {
	return;
}

$script_enqueued = false;
$api_key = get_field('google_maps_api_key', 'theme_options');

?>

<section class="wp-block-maps-by-viewpoint <?php echo !empty($data['align']) ? ' align'.$data['align'] : '';?>">
	<ul class="wp-block-maps-by-viewpoint__entries">
		<?php foreach ($photos_by_viewpoint as $photo) {
			$thumbnail_id = get_post_thumbnail_id($photo);
			$metadata = wp_get_attachment_metadata($thumbnail_id);
			$location = get_field('location', $photo->ID);
			if (is_array($location) && isset($location['lat']) && isset($location['lng'])) {
				$location['latlng'] = implode(',', [$location['lat'], $location['lng']]);
			} else {
				if (!(is_array($metadata) && is_array($metadata['image_meta'] ?? null) && is_array($metadata['image_meta']['latitude'] ?? null) && is_array($metadata['image_meta']['longitude'] ?? null))) {
					continue;
				}
				$location = [
					'lat' => $metadata['image_meta']['latitude'],
					'lng' => $metadata['image_meta']['longitude'],
					'address' => ''
				];
				$location['latlng'] = sht_theme()->Package->Location->gpsToLatLng($location);
			}

			// $source_image_size = $metadata['sizes'][$image_size] ?? null ? $image_size : 'large';
			// $width = $metadata['sizes'][$image_size]['width'];
			// $height = $metadata['sizes'][$image_size]['height'];
			// $flex_grow = $width * 100 / $height;
			// $flex_basis = $width * $target_height / $height;
			// $padding_bottom = ($height / $width) * 100;
			// $href = get_the_permalink($photo);
			?>
		<li class="wp-block-maps-by-viewpoint__entry">
			<?php
			// if (!$script_enqueued) {
			// 	wp_enqueue_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?key='.$api_key, null, null);
			// 	$script_enqueued = true;
			// }
			printf('<a href="%s">%s</a>', get_permalink($photo->ID), get_the_title($photo->ID));
			dump([$photo->ID, get_the_title($photo->ID), get_the_date(get_option('date_format'), $photo->ID), $location['latlng']]);

			?>
		</li>
		<?php }?>
	</ul>
</section>
