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

$map_locations = [];

foreach ($photos_by_viewpoint as $photo) {
	$thumbnail_id = get_post_thumbnail_id($photo);
	$metadata = wp_get_attachment_metadata($thumbnail_id);
	$location = get_field('location', $photo->ID);
	if (is_array($location) && isset($location['lat']) && isset($location['lng'])) {
		$location['latlng'] = ['lat' => $location['lat'], 'lng' => $location['lng']];
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

	$map_locations[] = [
		'ID' => $photo->ID,
		'title' => get_the_title($photo->ID),
		'link' => get_permalink($photo->ID),
		'location' => $location['latlng']
		// 'location' => ['lat' => $partner->meta['map_location']['lat'], 'lng' => $partner->meta['map_location']['lng']]
	];

	// $source_image_size = $metadata['sizes'][$image_size] ?? null ? $image_size : 'large';
	// $width = $metadata['sizes'][$image_size]['width'];
	// $height = $metadata['sizes'][$image_size]['height'];
	// $flex_grow = $width * 100 / $height;
	// $flex_basis = $width * $target_height / $height;
	// $padding_bottom = ($height / $width) * 100;
	// $href = get_the_permalink($photo);

	// printf('<a href="%s">%s</a>', get_permalink($photo->ID), get_the_title($photo->ID));
}

if (empty($map_locations)) {
	return;
}

$script_enqueued = false;
$api_key = get_field('google_maps_api_key', 'theme_options');

?>

<section class="wp-block-mhm-map-by-viewpoint<?php echo !empty($data['align']) ? ' align'.$data['align'] : '';?>" data-map-block>
		<div class="wp-block-mhm-map-by-viewpoint__map" data-map data-map-data="<?php echo htmlspecialchars(json_encode($map_locations), ENT_QUOTES, 'UTF-8');?>"></div>
</section>
