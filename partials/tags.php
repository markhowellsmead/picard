<?php
if (!empty(get_the_terms(get_the_ID(), 'post_tag'))) {
?>
	<h2 class="c-article__metatitle c-article__metatitle--<?php echo get_post_type(); ?>"><?php _ex('Topics', 'Post meta title', 'picard'); ?></h2>
	<?php the_terms(get_the_ID(), 'post_tag', '<p class="c-article__taxonomyentries c-article__taxonomyentries--post_tag">', ', ', '</p>'); ?>
<?php }
