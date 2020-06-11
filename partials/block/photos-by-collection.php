<?php

use SayHello\Theme\Package\Lazysizes;

if (empty($collections = ($data['data']['sht_collection'] ?? []))) {
	return;
}

$number_of_posts = max(1, (int) $data['data']['sht_number_of_posts']);

if (empty($collection_posts = get_posts([
	'post_type' => 'photo',
	'posts_per_page' => $number_of_posts,
	'tax_query' => [
		[
			'taxonomy' => 'collection',
			'field'    => 'term_id',
			'terms'    => $collections,
			'operator' => 'IN',
		],
	],
	'meta_query' => [
		[
			'key' => '_thumbnail_id'
		],
	]
]))) {
	return;
}

$target_height = 500;
$image_size = 'large';

if (count($collection_posts) > 10) {
	$target_height = 400;
	$image_size = 'medium';
}

$unique = uniqid();

?>

<!-- Grid layout origin: https://github.com/xieranmaya/blog/issues/6 #wowza -->
<section class="wp-block-photos-by-collection <?php echo !empty($data['align']) ? ' align'.$data['align'] : '';?>">
	<ul class="wp-block-photos-by-collection__images c-grid500">
		<?php foreach ($collection_posts as $collection_post) {
			$thumbnail_id = get_post_thumbnail_id($collection_post);
			$metadata = wp_get_attachment_metadata($thumbnail_id);
			$source_image_size = $metadata['sizes'][$image_size] ?? null ? $image_size : 'large';
			$width = $metadata['sizes'][$image_size]['width'];
			$height = $metadata['sizes'][$image_size]['height'];
			$flex_grow = $width * 100 / $height;
			$flex_basis = $width * $target_height / $height;
			$padding_bottom = ($height / $width) * 100;
			$href = get_the_permalink($collection_post);
			?>
		<li
			class="wp-block-photos-by-collection__entry c-grid500__item"
			style="flex-grow:<?php echo $flex_grow;?>;flex-basis:<?php echo $flex_basis;?>px;">
			<?php if (!$data['is_preview']) {?>
				<a class="c-grid500__itemlink" href="<?php echo $href;?>" title="<?php echo get_the_title($collection_post);?>">
					<i class="c-grid500__uncollapse" style="padding-bottom:<?php echo $padding_bottom;?>%"></i>
					<?php echo Lazysizes::getLazyImage($thumbnail_id, $source_image_size, 'c-grid500__figure', 'c-grid500__image');?>
				</a>
			<?php } else {?>
				<span class="c-grid500__itemlink" title="<?php echo get_the_title($collection_post);?>">
					<i class="c-grid500__uncollapse" style="padding-bottom:<?php echo $padding_bottom;?>%"></i>
					<?php
					printf(
						'<figure class="c-grid500__figure">%s</figure>',
						wp_get_attachment_image($thumbnail_id, $source_image_size, false, [
							'class' => 'c-grid500__image'
						])
					);
			}?>
				</span>
			</li>
		<?php }?>
	</ul>
</section>