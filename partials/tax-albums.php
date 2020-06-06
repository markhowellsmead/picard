<?php
if (!empty(get_the_terms(get_the_ID(), 'album'))) {
	?>
<section class="c-article__taxonomy c-article__taxonomy--album">
	<h2 class="c-article__metatitle"><?php _ex('Albums', 'Post meta title', 'picard');?></h2>
	<?php the_terms(get_the_ID(), 'album', '<p class="c-article__taxonomyentries c-article__taxonomyentries--album">', ', ', '</p>');?>
</section>
<?php }
