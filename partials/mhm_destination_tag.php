<?php
if (!empty(get_the_terms(get_the_ID(), 'mhm_destination_tag'))) {
	?>
<section class="c-article__taxonomy c-article__taxonomy--mhm_destination_tag">
	<h2 class="c-article__metatitle"><?php _ex('Subjects', 'Post meta title', 'picard');?></h2>
	<?php the_terms(get_the_ID(), 'mhm_destination_tag', '<p class="c-article__taxonomyentries c-article__taxonomyentries--mhm_destination_tag">', ', ', '</p>');?>
</section>
<?php }
