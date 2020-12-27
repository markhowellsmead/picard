<?php

use SayHello\Theme\Package\Lazysizes;

$align = '';
if (!empty($args['attributes']['align'])) {
	$align = ' align' . $args['attributes']['align'];
}

if (empty($args['pages'])) {
	return;
}
?>

<div class="wp-block-mhm-subpages <?php echo $align; ?>">
	<ul class="wp-block-mhm-subpages__entries">
		<?php

		foreach ($args['pages'] as $page) {
			$thumbnail = '<div class="wp-block-mhm-subpages__figure wp-block-mhm-subpages__figure--empty"><a href="' . get_permalink($page->ID) . '"></a></div>';

			if (has_post_thumbnail($page->ID)) {
				$thumbnail = '<a href="' . get_permalink($page->ID) . '">' . Lazysizes::getLazyImage(get_post_thumbnail_id($page->ID), 'card', 'wp-block-mhm-subpages__figure', 'wp-block-mhm-subpages__image') . '</a>';
			}

			printf(
				'<li class="%s"><a href="%s">%s%s</a>%s%s</li>',
				'wp-block-mhm-subpages__entry',
				get_permalink($page->ID),
				$thumbnail,
				'<h3 class="wp-block-mhm-subpages__entrytitle"><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></h3>',
				'<time class="wp-block-mhm-subpages__entrydate">' . sprintf(_x('Last updated on %s', '', 'picard'), date(get_option('date_format'), strtotime($page->post_date))) . '</time>',
				'' //!empty($album->description) ? '<div class="wp-block-mhm-subpages__entrydescription">' . $album->description . '</div>' : ''
			);
		}
		?>
	</ul>
</div>
