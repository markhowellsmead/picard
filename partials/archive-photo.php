<section class="c-archive">

	<?php if (get_the_archive_title() !=='') {?>
		<header class="c-archive__header">
			<?php
			the_archive_title('<h1 class="c-archive__title">', '</h1>');
			if (!empty($term_description = term_description())) {
				printf(
					'<div class="c-archive__description">%s</div>',
					apply_filters('the_content', $term_description)
				);
			}

			if (is_search()) {
				get_search_form();
			}
			?>
		</header>
	<?php } ?>

	<div class="c-archive__content c-archive__content--<?php echo get_post_type();?> alignwide">
		<div class="c-grid500">
			<?php
			$target_height = 150;
			$image_size = 'large';

			if (have_posts()) {
				while (have_posts()) {
					the_post();
					if (get_post_type() == 'photo') {
						sht_theme()->getTemplatePart('partials/excerpt-grid-photo', [
							'target_height' => $target_height,
							'image_size' => $image_size
						]);
					}
				}
			}
			?>
		</div>
	</div>

	<?php
	$paginate = paginate_links([
		'mid_size' => 8
	]);

	if ('' != $paginate) {
		echo '<div class="c-pagination">';
		echo '<div class="c-pagination__content">' .$paginate. '</div>';
		echo '</div>';
	}
	?>

</section>
