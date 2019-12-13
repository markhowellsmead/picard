<?php
if (!empty(get_the_terms(get_the_ID(), 'collection'))) {
	?>
<section class="c-article__taxonomy c-article__taxonomy--collection">
	<h2 class="c-article__metatitle"><?php _ex('Photo collections', 'Post meta title', 'picard');?></h2>
	<?php
		the_terms(get_the_ID(), 'collection', '<p class="c-article__taxonomyentries c-article__taxonomyentries--collection">', ', ', '</p>');
}?>
</section>
