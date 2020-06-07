<article <?php post_class('c-article c-article--'.get_post_type()); ?>>

	<?php
	if (!empty(get_the_content())) {
		?>
		<div class="c-article__content">
			<?php the_content(); ?>
		</div>
		<?php
	}

	get_template_part('partials/comments/template');
	?>

</article>
