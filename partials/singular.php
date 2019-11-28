<article <?php post_class('c-article'); ?>>

	<?php if (!(bool) get_field('hide_title')) : ?>
		<header class="c-article__header">
			<h1 class="c-article__title"><?php the_title(); ?></h1>
			<time class="c-article__date" datetime="<?php echo get_the_date('c'); ?>"><?php printf(_x('Published on %s', 'sht'), get_the_date()); ?></time>
		</header>

		<?php
		get_template_part('partials/meta/video', get_post_type());
		get_template_part('partials/meta/thumbnail', get_post_type());
	endif; ?>

	<div class="c-article__content">
		<?php the_content(); ?>
	</div>

<?php
if (is_array(wp_get_post_terms(get_the_ID(), 'post_tag')) && count(wp_get_post_terms(get_the_ID(), 'post_tag'))) :
	?>
	<div class="c-article__meta">
		<?php
		get_template_part('partials/tags');
		?>
	</div>
<?php endif;
?>

</article>
