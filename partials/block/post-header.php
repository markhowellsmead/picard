<?php

$alignment = $data['attributes']['alignment'];
$title = get_the_title();
$excerpt = get_the_excerpt();

if (pt_must_use_get_instance()->Package->Gutenberg->isContextEdit()) {
	$title = $data['attributes']['post_title'];
	$excerpt = $data['attributes']['post_excerpt'];
}

?><section class="wp-block-sht-post-header has-text-align-<?php echo $alignment; ?>">
	<div class="wp-block-sht-post-header__inner">
		<header class="wp-block-sht-post-header__header">
			<h1 class="wp-block-sht-post-header__title"><?php echo $title; ?></h1>
		</header>
		<?php if (!empty($excerpt)) { ?>
			<div class="wp-block-sht-post-header__excerpt"><?php echo $excerpt; ?></div>
		<?php } elseif (pt_must_use_get_instance()->Package->Gutenberg->isContextEdit()) { ?>
			<mark class="wp-block-sht-post-header__excerptempty"><?php _ex('Add an excerpt using the global "Excerpt" field. (Optional.)', 'Helptext', 'picard'); ?></mark>
		<?php } ?>
	</div>
</section>
