<?php
use SayHello\Theme\Package\Lazysizes;

if (!isset($data['image_size'])) {
	$data['image_size'] = 'medium';
}

if (!has_post_thumbnail()) {
	return;
}

$image = '';

$image_width_height = sht_theme()->Package->Media->thumbnailSize($data['image_size']);
$flex_grow = $image_width_height['width']  * 100 / $image_width_height['height'];
$flex_basis = $image_width_height['width']  * $data['target_height'] / $image_width_height['height'];
$padding_bottom = ($image_width_height['height'] / $image_width_height['width'] ) * 100;

?>

<article class="c-grid500__item" style="flex-grow:<?php echo $flex_grow;?>;flex-basis:<?php echo $flex_basis;?>px;">
	<a class="c-grid500__itemlink" href="<?php the_permalink();?>" title="<?php the_title();?>">
		<i class="c-grid500__uncollapse" style="padding-bottom:<?php echo $padding_bottom;?>%"></i>
		<?php echo Lazysizes::getLazyImage(get_post_thumbnail_id(), $data['image_size'], 'c-grid500__figure', 'c-grid500__image');?>
	</a>
</article>
