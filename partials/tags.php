<?php
if (!empty(get_the_terms(get_the_ID(), 'post_tag'))) {
	?>
<section class="c-article__taxonomy c-article__taxonomy--post_tag">
	<h2 class="c-article__metatitle"><?php _ex('Topics', 'Post meta title', 'picard');?></h2>
	<?php
		the_terms(get_the_ID(), 'post_tag', '<ul class="c-article__taxonomyentries c-article__taxonomyentries--post_tag"><li class="c-article__taxonomyentry c-article__taxonomyentry--post_tag">', '</li><li class="c-article__taxonomyentry c-article__taxonomyentry--post_tag">', '</li></ul>');
}?>
</section>
