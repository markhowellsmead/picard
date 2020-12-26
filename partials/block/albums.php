<?php

use SayHello\Theme\Package\Lazysizes;

$align = '';
if (!empty($args['attributes']['align'])) {
	$align = ' align' . $args['attributes']['align'];
}

if (empty($args['albums'])) {
	return;
}
?>

<div class="wp-block-mhm-albums <?php echo $align; ?>">
	<ul class="wp-block-mhm-albums__entries">
		<?php

		$albums = [];
		foreach ($args['albums'] as $album) {
			$photos = get_posts(array(
				'post_type' => 'photo',
				'numberposts' => 1,
				'orderby'     => 'date',
				'order'       => 'DESC',
				'tax_query' => [[
					'taxonomy' => 'album',
					'field' => 'term_id',
					'terms' => $album->term_id,
				]]
			));

			if (!empty($photos)) {
				$albums[strtotime($photos[0]->post_date)] = $album;
			}
		}

		krsort($albums);

		foreach ($albums as $album) {

			$photos = get_posts(array(
				'post_type' => 'photo',
				'numberposts' => 1,
				'orderby'     => 'date',
				'order'       => 'DESC',
				'tax_query' => [[
					'taxonomy' => 'album',
					'field' => 'term_id',
					'terms' => $album->term_id,
				]]
			));

			$thumbnail = Lazysizes::getLazyImage(get_post_thumbnail_id($photos[0]), 'card', 'wp-block-mhm-albums__figure', 'wp-block-mhm-albums__image') . '</a>';

			if (!empty($thumbnail_object = get_field('thumbnail', 'term_' . $album->term_id))) {
				$thumbnail = Lazysizes::getLazyImage($thumbnail_object['ID'], 'card', 'wp-block-mhm-albums__figure', 'wp-block-mhm-albums__image') . '</a>';
			}

			printf(
				'<li class="%s"><a href="%s">%s%s</a>%s%s</li>',
				'wp-block-mhm-albums__entry',
				get_term_link($album->term_id, 'album'),
				$thumbnail,
				'<h3 class="wp-block-mhm-albums__entrytitle"><a href="' . get_term_link($album->term_id, 'album') . '">' . $album->name . '</a></h3>',
				'<time class="wp-block-mhm-albums__entrydate">' . sprintf(_x('Latest photo added on %s', '', 'picard'), date(get_option('date_format'), strtotime($photos[0]->post_date))) . '</time>',
				'' //!empty($album->description) ? '<div class="wp-block-mhm-albums__entrydescription">' . $album->description . '</div>' : ''
			);
		}
		?>
	</ul>
</div>
