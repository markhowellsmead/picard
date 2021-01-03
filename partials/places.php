<?php
if (!empty(get_the_terms(get_the_ID(), 'place'))) {
?>
	<section class="c-article__taxonomy c-article__taxonomy--place">
		<h2 class="c-article__metatitle c-article__metatitle--<?php echo get_post_type(); ?>"><?php _ex('Places', 'Post meta title', 'picard'); ?></h2>
		<?php the_terms(get_the_ID(), 'place', '<p class="c-article__taxonomyentries c-article__taxonomyentries--place">', ', ', '</p>'); ?>
	</section>
<?php }
