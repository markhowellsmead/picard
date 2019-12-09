<article <?php post_class('c-article c-article--'.get_post_type().' c-article--gutenberg'); ?>>

	<div class="c-article__content">
		<?php the_content(); ?>
	</div>

<?php
if (is_array(wp_get_post_terms(get_the_ID(), 'post_tag')) && count(wp_get_post_terms(get_the_ID(), 'post_tag'))) :
	?>
	<div class="c-article__meta">
		<?php
		get_template_part('partials/tags');
		get_template_part('partials/collections');
		?>
	</div>
<?php endif;
?>

</article>
