<article <?php post_class('c-article c-article--'.get_post_type().' c-article--gutenberg'); ?>>

	<div class="c-article__content">
		<?php
		the_content();
		get_template_part('partials/functions/like');
		?>
	</div>

</article>
