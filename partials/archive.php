<section class="c-archive">

	<?php if (get_the_archive_title() !== '') { ?>
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

	<div class="c-archive__content">
		<?php
		if (have_posts()) {
			while (have_posts()) {
				the_post();
				if (!empty($template = locate_template([
					'partials/excerpt-' . get_post_type() . '-' . get_post_format() . '.php',
					'partials/excerpt-' . get_post_type() . '.php',
					'partials/excerpt.php'
				]))) {
					include $template;
				}
			}
		}
		?>
	</div>

	<?php
	$paginate = paginate_links([
		'mid_size' => 8
	]);
	if ('' != $paginate) {
		echo '<div class="c-pagination">';
		echo '<div class="c-pagination__content">' . $paginate . '</div>';
		echo '</div>';
	}
	?>

</section>
