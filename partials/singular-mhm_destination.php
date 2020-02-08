<article <?php post_class('c-article c-article--'.get_post_type()); ?>>

	<?php
	if (!empty(get_the_content())) {
		?>
		<div class="c-article__contentandthumbnail">
			<div class="c-article__content">
				<?php the_content(); ?>
			</div>
		</div>
		<?php
	}

	if (!empty(get_the_terms(get_the_ID(), 'mhm_destination_tag')) || !empty(get_the_terms(get_the_ID(), 'mhm_destination_region'))) {
		?>
	<div class="c-article__meta">
		<?php
		get_template_part('partials/mhm_destination_regions');
		get_template_part('partials/mhm_destination_tag');
		?>
	</div>
	<?php }
	get_template_part('partials/comments/template');
	?>

</article>
